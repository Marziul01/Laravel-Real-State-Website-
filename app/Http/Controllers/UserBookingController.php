<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\PaymentMethod;
use App\Models\Property;
use Illuminate\Http\Request;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Country;
use App\Services\MetaConversionApiService;

class UserBookingController extends Controller
{
    public static function booking(Request $request){
        $propertyId = $request->query('property_id');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $bookingType = $request->query('booking_type');
        if($propertyId == null){
            return redirect(route('home'))->with('errors' , 'Please choose a porperty booking!');
        }
        $property = Property::find($propertyId);
        // ✅ Fetch all bookings for this propertys
        $bookings = Booking::where('property_id', $propertyId)
            ->get(['start_date', 'end_date']);

        // ✅ Prepare all booked dates (to disable in date picker)
        $bookedDates = [];
        
        foreach ($bookings as $booking) {
            // Generate each date between start_date and end_date (inclusive)
            $period = new DatePeriod(
                new DateTime($booking->start_date),
                new DateInterval('P1D'),
                (new DateTime($booking->end_date))->modify('+1 day')
            );

            foreach ($period as $date) {
                $bookedDates[] = $date->format('Y-m-d');
            }
        }
        return view('frontend.property.booking',[
            'property' => $property,
            'bookedDates' => $bookedDates,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coupons' => Coupon::all(),
            'payments' => PaymentMethod::all(),
            'countries' => Country::all(),
            'bookingType' => $bookingType,
        ]);
    }


    public function applyCoupon(Request $request){
        $coupon = Coupon::where('code', $request->code)->first();

        if(!$coupon){
            return response()->json(['valid'=>false,'message'=>'Invalid coupon code']);
        }

        $now = date('Y-m-d');
        if($coupon->start_date > $now || ($coupon->expire_date && $coupon->expire_date < $now)){
            return response()->json(['valid'=>false,'message'=>'Coupon not valid today']);
        }

        if($coupon->max_uses && $coupon->bookings()->count() >= $coupon->max_uses){
            return response()->json(['valid'=>false,'message'=>'Coupon usage limit reached']);
        }

        if($coupon->max_user_uses && $coupon->bookings()->where('user_id', auth()->id())->count() >= $coupon->max_user_uses){
            return response()->json(['valid'=>false,'message'=>'You have already used this coupon']);
        }

        $discounted_price = $request->total_price;
        if($coupon->discount_type == 'percent'){
            $discounted_price = $request->total_price * (100 - $coupon->discount)/100;
        }else{
            $discounted_price = max(0, $request->total_price - $coupon->discount);
        }

        return response()->json([
            'valid'=>true,
            'message'=>'Coupon applied successfully!',
            'discounted_price'=>$discounted_price,
            'coupon_id'=>$coupon->id
        ]);
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'address' => 'required|string|max:255',
            'total_guests' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_price' => 'required|numeric|gt:0',
            'discounted_price' => 'nullable|numeric|gt:0',
            'coupon_id' => 'nullable|exists:coupons,id',
            'payment_method' => 'required|exists:payment_methods,id',
            'transaction_id' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $paymentMethod = \App\Models\PaymentMethod::find($request->payment_method);
        $paymentType = $paymentMethod->payment_method_type;

        // Payment-specific checks
        if ($paymentType === 'mobile_banking' && !$request->transaction_id) {
            return response()->json(['status'=>'error','message'=>'Transaction ID is required for mobile banking.'], 422);
        }
        if ($paymentType === 'bank') {
            if (!$request->bank_account_number) return response()->json(['status'=>'error','message'=>'Bank account number is required.'], 422);
            if (!$request->bank_account_name) return response()->json(['status'=>'error','message'=>'Bank account name is required.'], 422);
        }

        $transactionId = $paymentType === 'mobile_banking' ? $request->transaction_id : null;
        $bankAccountNumber = $paymentType === 'bank' ? $request->bank_account_number : null;
        $bankAccountName = $paymentType === 'bank' ? $request->bank_account_name : null;

        // Check overlapping bookings
        $booked = Booking::where('property_id', $request->property_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function($q) use ($request) {
                        $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })->first();

        if ($booked) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry! This property is already booked for your selected date range.'
            ], 422);
        }


        try {
            $booking = new Booking();
            $booking->user_id = auth()->id();
            $booking->property_id = $request->property_id;
            $booking->name = $request->name;
            $booking->phone = $request->phone;
            $booking->email = $request->email;
            $booking->address = $request->address;
            $booking->booking_type = $request->booking_type;
            $booking->start_date = $request->start_date;
            $booking->end_date = $request->end_date;
            $booking->total = $request->total_price;
            $booking->discount = $request->total_price - $request->discounted_price;
            $booking->coupon_id = $request->coupon_id;
            $booking->grand_total = $request->discounted_price ?? $request->total_price;
            $booking->total_guests = $request->total_guests;
            $booking->payment_id = $request->payment_method;
            $booking->transaction_id = $transactionId;
            $booking->bank_account_number = $bankAccountNumber;
            $booking->bank_account_name = $bankAccountName;
            $booking->payment_status = 1;
            $booking->status = 1;
            $booking->notes = $request->notes;
            $booking->save();

            try {
                Mail::to($request->email)->send(new InvoiceMail($booking));
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send invoice email.',
                    'error' => $e->getMessage()
                ], 500);
            }

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Booking order has been created';
            $notification->notification_for = 'Property Booking';
            $notification->item_id = $booking->id;
            $notification->save();

            
            MetaConversionApiService::sendEvent('Purchase', [
                'value' => $booking->grand_total,
                'currency' => 'BDT',
                'content_name' => $booking->property->name,
                'content_id' => $booking->property_id,
                'order_id' => $booking->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Booking successfully created!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}

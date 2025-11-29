<?php

namespace App\Http\Controllers;

use App\Mail\BookingCancelledMail;
use App\Mail\BookingConfirmedMail;
use App\Mail\BookingVisitedMail;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use DateTime;
use DatePeriod;
use DateInterval;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Models\Notification;

class AdminBookingController extends Controller
{
    public static function bookingPending(Request $request){
        if(auth()->user()->adminAccess->booking == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $bookings = Booking::where('status', 1)
                ->with(['property', 'coupon', 'payment', 'user'])
                ->orderByDesc('created_at');

            return DataTables::of($bookings)
                ->addIndexColumn() // Serial Number

                ->addColumn('property', function ($row) {
                    $img = $row->property->featured_image
                        ? asset($row->property->featured_image)
                        : asset('images/no-image.jpg');

                    $name = $row->property->name ?? 'N/A';
                    

                    return '<div class="d-flex align-items-center text-decoration-none">
                                <img src="' . $img . '" alt="' . e($name) . '" width="60" height="45" class="rounded me-2" style="object-fit: cover;">
                                <span>' . e($name) . '</span>
                            </div>';
                })

                ->addColumn('booking_name', function ($row) {
                    return e($row->user->name ?? 'N/A');
                })

                ->addColumn('time', function ($row) {
                    $start = Carbon::parse($row->start_date)->format('d M, Y');
                    $end = Carbon::parse($row->end_date)->format('d M, Y');
                    return "$start -to- $end";
                })

                ->addColumn('guests', function ($row) {
                    return e($row->total_guests);
                })

                ->addColumn('phone', function ($row) {
                    return e($row->user->phone ?? 'N/A');
                })

                ->addColumn('discount', function ($row) {
                    return '৳ ' . number_format($row->discount ,2);
                })

                ->addColumn('price', function ($row) {
                    return '৳ ' . number_format($row->grand_total, 2);
                })

                ->addColumn('action', function ($row) {
                    return view('admin.booking._actions', compact('row'))->render();
                })

                ->rawColumns(['property', 'action'])
                ->make(true);
        }

        return view('admin.booking.pending',[
            'bookings' => Booking::where('status' ,1 )->get(), 
        ]);
    }

    public static function bookingActive(Request $request){
        if(auth()->user()->adminAccess->booking == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $bookings = Booking::where('status', 2)
                ->with(['property', 'coupon', 'payment', 'user'])
                ->orderByDesc('created_at');

            return DataTables::of($bookings)
                ->addIndexColumn() // Serial Number

                ->addColumn('property', function ($row) {
                    $img = $row->property->featured_image
                        ? asset($row->property->featured_image)
                        : asset('images/no-image.jpg');

                    $name = $row->property->name ?? 'N/A';
                    

                    return '<div class="d-flex align-items-center text-decoration-none">
                                <img src="' . $img . '" alt="' . e($name) . '" width="60" height="45" class="rounded me-2" style="object-fit: cover;">
                                <span>' . e($name) . '</span>
                            </div>';
                })

                ->addColumn('booking_name', function ($row) {
                    return e($row->user->name ?? 'N/A');
                })

                ->addColumn('time', function ($row) {
                    $start = Carbon::parse($row->start_date)->format('d M, Y');
                    $end = Carbon::parse($row->end_date)->format('d M, Y');
                    return "$start -to- $end";
                })

                ->addColumn('guests', function ($row) {
                    return e($row->total_guests);
                })

                ->addColumn('phone', function ($row) {
                    return e($row->user->phone ?? 'N/A');
                })

                ->addColumn('discount', function ($row) {
                    return '৳ ' . number_format($row->discount ,2);
                })

                ->addColumn('price', function ($row) {
                    return '৳ ' . number_format($row->grand_total, 2);
                })

                ->addColumn('action', function ($row) {
                    return view('admin.booking._actions', compact('row'))->render();
                })

                ->rawColumns(['property', 'action'])
                ->make(true);
        }

        return view('admin.booking.active',[
            'bookings' => Booking::where('status' ,2 )->get(),
        ]);
    }

    public static function bookingVisit(Request $request){
        if(auth()->user()->adminAccess->booking == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $bookings = Booking::where('status', 3)
                ->with(['property', 'coupon', 'payment', 'user'])
                ->orderByDesc('created_at');

            return DataTables::of($bookings)
                ->addIndexColumn() // Serial Number

                ->addColumn('property', function ($row) {
                    $img = $row->property->featured_image
                        ? asset($row->property->featured_image)
                        : asset('images/no-image.jpg');

                    $name = $row->property->name ?? 'N/A';
                    

                    return '<div class="d-flex align-items-center text-decoration-none">
                                <img src="' . $img . '" alt="' . e($name) . '" width="60" height="45" class="rounded me-2" style="object-fit: cover;">
                                <span>' . e($name) . '</span>
                            </div>';
                })

                ->addColumn('booking_name', function ($row) {
                    return e($row->user->name ?? 'N/A');
                })

                ->addColumn('time', function ($row) {
                    $start = Carbon::parse($row->start_date)->format('d M, Y');
                    $end = Carbon::parse($row->end_date)->format('d M, Y');
                    return "$start -to- $end";
                })

                ->addColumn('guests', function ($row) {
                    return e($row->total_guests);
                })

                ->addColumn('phone', function ($row) {
                    return e($row->user->phone ?? 'N/A');
                })

                ->addColumn('discount', function ($row) {
                    return '৳ ' . number_format($row->discount ,2);
                })

                ->addColumn('price', function ($row) {
                    return '৳ ' . number_format($row->grand_total, 2);
                })

                ->addColumn('action', function ($row) {
                    return view('admin.booking._actions', compact('row'))->render();
                })

                ->rawColumns(['property', 'action'])
                ->make(true);
        }

        return view('admin.booking.visit',[
            'bookings' => Booking::where('status' ,3 )->get(),
        ]);
    }

    public static function bookingCancel(Request $request){
        if(auth()->user()->adminAccess->booking == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $bookings = Booking::where('status', 4)
                ->with(['property', 'coupon', 'payment', 'user'])
                ->orderByDesc('created_at');

            return DataTables::of($bookings)
                ->addIndexColumn() // Serial Number

                ->addColumn('property', function ($row) {
                    $img = $row->property->featured_image
                        ? asset($row->property->featured_image)
                        : asset('images/no-image.jpg');

                    $name = $row->property->name ?? 'N/A';
                    

                    return '<div class="d-flex align-items-center text-decoration-none">
                                <img src="' . $img . '" alt="' . e($name) . '" width="60" height="45" class="rounded me-2" style="object-fit: cover;">
                                <span>' . e($name) . '</span>
                            </div>';
                })

                ->addColumn('booking_name', function ($row) {
                    return e($row->user->name ?? 'N/A');
                })

                ->addColumn('time', function ($row) {
                    $start = Carbon::parse($row->start_date)->format('d M, Y');
                    $end = Carbon::parse($row->end_date)->format('d M, Y');
                    return "$start -to- $end";
                })

                ->addColumn('guests', function ($row) {
                    return e($row->total_guests);
                })

                ->addColumn('phone', function ($row) {
                    return e($row->user->phone ?? 'N/A');
                })

                ->addColumn('discount', function ($row) {
                    return '৳ ' . number_format($row->discount ,2);
                })

                ->addColumn('price', function ($row) {
                    return '৳ ' . number_format($row->grand_total, 2);
                })

                ->addColumn('action', function ($row) {
                    return view('admin.booking._actions', compact('row'))->render();
                })

                ->rawColumns(['property', 'action'])
                ->make(true);
        }

        return view('admin.booking.canceled',[
            'bookings' => Booking::where('status' ,4 )->get(),
        ]);
    }

    public function creates()
    {
        if(auth()->user()->adminAccess->booking != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        $properties = Property::where('type','rent')->get();
        $users = User::where('role',1)->get();
        $payments = PaymentMethod::all();
        return view('admin.booking.create',[
            'properties' => $properties,
            'users' => $users,
            'payments' => $payments,
        ]);
    }

    public function getBookedDates($propertyId)
{
    $bookedDates = Booking::where('property_id', $propertyId)
        ->whereIn('status', [1, 2]) // Pending or Confirmed
        ->pluck('start_date', 'end_date')
        ->map(function($start, $end) {
            $period = new DatePeriod(
                new DateTime($start),
                new DateInterval('P1D'),
                (new DateTime($end))->modify('+1 day')
            );
            return collect(iterator_to_array($period))->map(fn($date) => $date->format('Y-m-d'));
        })
        ->flatten()
        ->values();

    $property = Property::find($propertyId, ['rent_start', 'price', 'weekly_price', 'monthly_price']);

    return response()->json([
        'bookedDates' => $bookedDates,
        'rent_start' => $property->rent_start ?? now()->format('Y-m-d'),
        'price'         => $property->price ?? 0,
        'weekly_price'  => $property->weekly_price ?? 0,
        'monthly_price' => $property->monthly_price ?? 0,
    ]);
}


    public function show($id)
    {
        $booking = Booking::with(['property', 'coupon', 'payment', 'user'])->findOrFail($id);

        $start = \Carbon\Carbon::parse($booking->start_date);
        $end   = \Carbon\Carbon::parse($booking->end_date);

        $duration_text = '';

        if ($booking->booking_type === 'per-night') {
            $nights = $start->diffInDays($end);
            $duration_text = $nights . ' Night' . ($nights > 1 ? 's' : '');
        } 
        elseif ($booking->booking_type === 'weekly') {
            $weeks = $start->diffInWeeks($end);
            $duration_text = $weeks . ' Week' . ($weeks > 1 ? 's' : '');
        } 
        elseif ($booking->booking_type === 'monthly') {
            $months = ceil($start->diffInMonths($end, false)); // round up to full months
            $duration_text = $months . ' Month' . ($months > 1 ? 's' : '');
        }

        return response()->json([
            'booking' => $booking,
            // Dates
            'start_date' => $start->format('M d, Y'),
            'end_date' => $end->format('M d, Y'),

            // Check-in / check-out formatted
            'check_in' => $booking->property->check_in 
                            ? \Carbon\Carbon::parse($booking->property->check_in)->format('g:i A')
                            : null,
            'check_out' => $booking->property->check_out 
                            ? \Carbon\Carbon::parse($booking->property->check_out)->format('g:i A')
                            : null,

            // Duration
            'duration' => $duration_text,
        ]);
    }

    public function confirm($id)
    {
        if(auth()->user()->adminAccess->booking != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $booking = Booking::findOrFail($id);
        $booking->payment_status = 2; 
        $booking->status = 2;
        $booking->save();

        try{
        Mail::to($booking->email)->send(new BookingConfirmedMail($booking));
        } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send confirmed email.',
                    'error' => $e->getMessage()
                ], 500);
            }

        $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Booking status has been updated to confirmed';
            $notification->notification_for = 'Property Booking';
            $notification->item_id = $booking->id;
            $notification->save();

        return response()->json(['success' => true]);
    }

    public function cancel($id)
    {
        if(auth()->user()->adminAccess->booking != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $booking = Booking::findOrFail($id);
        $booking->payment_status = 3; // confirmed
        $booking->status = 4; // cancelled
        $booking->save();

        try{
        Mail::to($booking->email)->send(new BookingCancelledMail($booking));
        } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send cancelled email.',
                    'error' => $e->getMessage()
                ], 500);
            }
        $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Booking status has been updated to canceled';
            $notification->notification_for = 'Property Booking';
            $notification->item_id = $booking->id;
            $notification->save();

        return response()->json(['success' => true]);
    }

    public function visitedBooking($id)
    {
        if(auth()->user()->adminAccess->booking != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $booking = Booking::findOrFail($id);
        $booking->payment_status = 2; // confirmed
        $booking->status = 3; // cancelled
        $booking->save();

        try{
        Mail::to($booking->email)->send(new BookingVisitedMail($booking));
        } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send visited email.',
                    'error' => $e->getMessage()
                ], 500);
            }

        $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Booking status has been updated to visited';
            $notification->notification_for = 'Property Booking';
            $notification->item_id = $booking->id;
            $notification->save();

        return response()->json(['success' => true]);
    }

    public function pendingBooking($id)
    {
        if(auth()->user()->adminAccess->booking != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $booking = Booking::findOrFail($id);
        $booking->payment_status = 1; // confirmed
        $booking->status = 1; // cancelled
        $booking->save();

        $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Booking status has been updated back to pending';
            $notification->notification_for = 'Property Booking';
            $notification->item_id = $booking->id;
            $notification->save();

        return response()->json(['success' => true]);
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

    public function store(Request $request)
    {
        if(auth()->user()->adminAccess->booking != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'payment_method' => 'required|exists:payment_methods,id',
            'total_guests' => 'nullable|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'coupon_id' => 'nullable|exists:coupons,id',
            'transaction_id' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

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

        DB::beginTransaction();

        try {
            // ✅ Step 1: Handle User
            $userId = $request->user_id;
            // ✅ Validate if email or phone already exists
            
            if (!$userId) {
                $exists = User::where('email', $request->email)
                    ->orWhere('phone', $request->phone)
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'A user with this email or phone number already exists.'
                    ], 422);
                }
                // Create a new user if not provided
                $randomPassword = Str::random(8);

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'password' => bcrypt($randomPassword),
                    'role_type' => 'User',
                ]);

                $userId = $user->id;
            }

            // ✅ Step 2: Create Booking
            $booking = new Booking();
            $booking->user_id = $userId;
            $booking->property_id = $request->property_id;
            $booking->name = $request->name;
            $booking->email = $request->email;
            $booking->phone = $request->phone;
            $booking->address = $request->address;
            $booking->booking_type = $request->booking_type;
            $booking->start_date = $request->start_date;
            $booking->end_date = $request->end_date;
            $booking->total = $request->total;
            $booking->discount = $request->total - $request->grand_total;
            $booking->coupon_id = $request->coupon_id ?? null;
            $booking->grand_total = $request->grand_total;
            $booking->total_guests = $request->total_guests ?? 1;
            $booking->payment_id = $request->payment_method;
            $booking->transaction_id = $request->transaction_id ?? null;
            $booking->bank_account_number = $request->bank_account_number ?? null;
            $booking->bank_account_name = $request->bank_account_name ?? null;
            $booking->payment_status = 1;
            $booking->status = 1;
            $booking->notes = $request->notes;
            $booking->save();

            // ✅ Step 3: Send Invoice Email (keep exactly same)
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

            // ✅ Step 4: Create Notification
            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Booking order has been created';
            $notification->notification_for = 'Property Booking';
            $notification->item_id = $booking->id;
            $notification->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Booking created successfully.',
                'booking_id' => $booking->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Booking creation failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while creating booking.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public static function editing($id)
    {
        if(auth()->user()->adminAccess->booking != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        // dd('hello');
        $properties = Property::where('type','rent')->get();
        $users = User::where('role',1)->get();
        $payments = PaymentMethod::all();
        return view('admin.booking.edit',[
            'properties' => $properties,
            'users' => $users,
            'payments' => $payments,
            'booking' => Booking::find($id),
        ]);
    }

    public function update(Request $request, $id)
{
    if(auth()->user()->adminAccess->booking != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'total' => 'required|numeric|min:0',
        'grand_total' => 'required|numeric|min:0',
        'payment_method' => 'required|exists:payment_methods,id',
        'total_guests' => 'nullable|integer|min:1',
        'discount' => 'nullable|numeric|min:0',
        'coupon_id' => 'nullable|exists:coupons,id',
        'transaction_id' => 'nullable|string|max:255',
        'bank_account_number' => 'nullable|string|max:255',
        'bank_account_name' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
    ]);

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

    DB::beginTransaction();

    try {
        $booking = Booking::findOrFail($id);

        // --- Step 1: Handle User ---
        $userId = $request->user_id;

        if (!$userId) {
            $exists = User::where('email', $request->email)
                    ->orWhere('phone', $request->phone)
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'A user with this email or phone number already exists.'
                    ], 422);
                }
            // Create a new user if not provided
            $randomPassword = Str::random(8);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => bcrypt($randomPassword),
                'role' => 0,
            ]);

            $userId = $user->id;
        }

        // --- Step 2: Update Booking ---
        $booking->user_id = $userId;
        $booking->property_id = $request->property_id;
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->phone = $request->phone;
        $booking->address = $request->address;
        $booking->booking_type = $request->booking_type;
        $booking->start_date = $request->start_date;
        $booking->end_date = $request->end_date;
        $booking->total = $request->total;
        $booking->discount = $request->total - $request->grand_total;
        $booking->coupon_id = $request->coupon_id ?? null;
        $booking->grand_total = $request->grand_total;
        $booking->total_guests = $request->total_guests ?? 1;
        $booking->payment_id = $request->payment_method;
        $booking->transaction_id = $request->transaction_id ?? null;
        $booking->bank_account_number = $request->bank_account_number ?? null;
        $booking->bank_account_name = $request->bank_account_name ?? null;
        $booking->payment_status = 1; // assuming payment is confirmed
        $booking->status = 1; // assuming active
        $booking->notes = $request->notes;
        $booking->save();

        // --- Step 3: Send Invoice Email (exactly same as store) ---
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

        // --- Step 4: Notification ---
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = 'Booking order has been updated';
        $notification->notification_for = 'Property Booking';
        $notification->item_id = $booking->id;
        $notification->save();

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Booking updated successfully.',
            'booking_id' => $booking->id
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Booking update failed: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong while updating booking.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function delete($id)
    {
        if(auth()->user()->adminAccess->booking != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $booking = Booking::findOrFail($id);
        $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = $booking->property->name. ' Property Booking order has been deleted . Booked by User ' .$booking->user->name ;
            $notification->notification_for = 'Property Booking';
            $notification->save();
        $booking->delete();

        return back()->with('success','Booking order has been deleted');
    }

}

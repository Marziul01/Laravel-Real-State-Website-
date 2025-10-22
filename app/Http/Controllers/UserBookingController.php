<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use DateTime;
use DatePeriod;
use DateInterval;

class UserBookingController extends Controller
{
    public static function booking(Request $request){
        $propertyId = $request->query('property_id');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
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
        ]);
    }
}

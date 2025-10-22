<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;

class HomePropertyController extends Controller
{
    public static function viewRentProperty(Request $request, $slug)
    {
        $property = Property::where('slug', $slug)->firstOrFail();

        // ✅ Fetch all bookings for this property
        $bookings = Booking::where('property_id', $property->id)
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

        return view('frontend.property.viewRent', [
            'property' => $property,
            'bookedDates' => $bookedDates,
        ]);
    }

    public static function viewBuyProperty(Request $request , $slug){
        $property = Property::where('slug' , $slug)->first();
        return view('frontend.property.viewBuy' ,[
            'property' => $property,
        ]);
    }

}

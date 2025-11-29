<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Country;
use App\Models\Property;
use App\Models\Review;
use App\Models\SiteSetting;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $properties = Property::where('status', 1 )->get();
        $reviews = Review::where('property_id', $property->id)->where('status' , 2)->get();
        return view('frontend.property.viewRent', [
            'property' => $property,
            'bookedDates' => $bookedDates,
            'countries' => Country::all(),
            'properties' => $properties,
            'reviews' => $reviews,
        ]);
    }

    public static function viewBuyProperty(Request $request , $slug){
        $property = Property::where('slug' , $slug)->first();
        $properties = Property::where('status', 1 )->get();
        return view('frontend.property.viewBuy' ,[
            'property' => $property,
            'countries' => Country::all(),
            'properties' => $properties,
        ]);
    }

    public function printProperty($id)
    {
        $property = Property::with(['images', 'features', 'amenities', 'realtor', 'propertyType', 'propertyarea', 'state'])->findOrFail($id);
        $settings = SiteSetting::find(1);
        // Optional: company logo
        $companyLogo = public_path($settings->site_logo);

        $pdf = Pdf::loadView('emails.print_pdf', compact('property', 'companyLogo'));
        
        return $pdf->stream('Property-' . $property->id . '.pdf'); // opens in browser
    }

}

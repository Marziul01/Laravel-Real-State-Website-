<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ALL TIME BOOKING SUM
        $allTimeBooking = Booking::where('status' , 3)->sum('grand_total');

        // THIS YEAR BOOKING SUM
        $thisYearBooking = Booking::where('status' , 3)->whereYear('created_at', now()->year)
            ->sum('grand_total');

        // THIS MONTH BOOKING SUM
        $thisMonthBooking = Booking::where('status' , 3)->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('grand_total');

        // COUNTS BASED ON STATUS
        $pendingBookings = Booking::where('status', 1)->count();
        $visitedBookings = Booking::where('status', 3)->count();
        $cancelledBookings = Booking::where('status', 4)->count();

        // PROPERTIES
        $rentProperties = Property::where('type', 'rent')->count();
        $buyProperties = Property::where('type', 'sell')->count();

        $bookings = Booking::where('status', 1)->get();

        return view('admin.dashboard.dashboard',[
            'allTimeBooking'    => $allTimeBooking,
            'thisYearBooking'   => $thisYearBooking,
            'thisMonthBooking'  => $thisMonthBooking,
            'pendingBookings'   => $pendingBookings,
            'visitedBookings'   => $visitedBookings,
            'cancelledBookings' => $cancelledBookings,
            'rentProperties'    => $rentProperties,
            'buyProperties'     => $buyProperties,
            'bookings' => $bookings,
        ]);
    }
}

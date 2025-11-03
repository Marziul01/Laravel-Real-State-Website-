<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;
use App\Models\Country;
use App\Models\Notification;
use App\Models\Review;

class UserDashboardController extends Controller
{
    public static function dashboard(){
        // Fetch bookings of user
        $bookings = Booking::where('user_id', auth()->id() )
            ->with('property')
            ->orderByRaw("CASE WHEN status = 1 THEN 0 ELSE 1 END") // Pending first
            ->orderBy('start_date', 'desc')
            ->get();

         // Stats
        $totalBookings = $bookings->count();
        $pendingBookings = $bookings->where('status', 1)->count();
        $visitedBookings = $bookings->where('status', 2)->count();

        return view('frontend.dashboard.dashboard',[
            'bookings' => $bookings,
            'totalBookings' => $totalBookings,
            'pendingBookings' => $pendingBookings,
            'visitedBookings' => $visitedBookings,
            'countries' => Country::all(),
        ]);
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|confirmed|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully'
        ]);
    }

    // Submit Review
    public function submitReview(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Create Review
        $review = Review::create([
            'user_id' => auth()->id(),
            'property_id' => $booking->property_id,
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Property review has been created';
            $notification->notification_for = 'Property Review';
            $notification->item_id = $review->id;
            $notification->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Review submitted successfully'
        ]);
    }
}

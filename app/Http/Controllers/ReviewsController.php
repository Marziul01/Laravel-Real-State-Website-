<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReviewsController extends Controller
{
    public static function reviews() {
        return view('admin.pages.review',[
           'reviews' => Review::all(), 
           'services' => Service::all(),
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $reviews = Review::with(['property', 'service', 'user'])
                ->latest()
                ->get();

            return DataTables::of($reviews)
                ->addIndexColumn()

                // 🏡 Review For Column
                ->addColumn('review_for', function ($row) {
                    if ($row->property_id && $row->property) {
                        return 'Property: ' . e($row->property->name) . ' - #' . e($row->booking_id);
                    } elseif ($row->service_id && $row->service) {
                        return 'Service: ' . e($row->service->name);
                    } else {
                        return 'N/A';
                    }
                })

                // 👤 Reviewer Name Column
                ->addColumn('reviewer_name', function ($row) {
                    if ($row->user_id && $row->user) {
                        return e($row->user->name);
                    } else {
                        return e($row->name);
                    }
                })

                // ⭐ Rating Column
                ->addColumn('rating_display', function ($row) {
                    return str_repeat('⭐', $row->rating);
                })

                // 📜 Comment Column
                ->addColumn('comment_display', function ($row) {
                    return e($row->comment);
                })

                // ✅ Status Column
                ->addColumn('status_display', function ($row) {
                    $statusBadge = $row->status == '2' 
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-secondary">Inactive</span>';
                    return $statusBadge;
                })

                // ⚙️ Action Buttons
                ->addColumn('action', function ($row) {
                    $deleteRoute = route('admin.reviews.delete', $row->id);
                    $csrf = csrf_field();

                    return '
                        <button class="btn btn-sm btn-warning editReviewBtn" data-id="' . $row->id . '">
                            <i class="fa fa-edit"></i>
                        </button>

                        <form action="' . $deleteRoute . '" method="POST" class="d-inline delete-confirm-form">
                            ' . $csrf . '
                            <button type="submit" class="btn btn-sm btn-danger delete-confirm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    ';
                })

                ->rawColumns(['rating_display', 'status_display', 'action'])
                ->make(true);
        }
    }


    public function store(Request $request)
    {
        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'service_id'        => 'required|exists:services,id',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'        => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            // ================ SAVE SERVICE =================
            $Review = Review::create([
                'name'        => $validated['name'],
                'service_id'        => $validated['service_id'],
                'rating'   => $validated['rating'] ?? null,
                'comment'        => $validated['comment'] ?? null,
                'status'        => 2,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Service Review created .';
            $notification->notification_for = 'Review';
            $notification->item_id = $Review->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'New Service Review added successfully!',
                'data'    => $Review
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while saving service!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $Review = Review::findOrFail($id);
        return response()->json($Review);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'service_id'        => 'required|exists:services,id',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'        => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            $review->update([
                'name' => $request->name,
                'service_id' => $request->service_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => $request->status ?? 2,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Review details updated.';
            $notification->notification_for = 'Review';
            $notification->item_id = $review->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Review Details updated successfully!',
                'data'    => $review
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating service!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function delete($id)
        {
            $Review = Review::findOrFail($id);
            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = ' Review has been deleted .';
            $notification->notification_for = 'Review';
            $notification->item_id = $Review->id;
            $notification->save();
            $Review->delete();

            return back()->with('success','A Review has been deleted');
        }
}

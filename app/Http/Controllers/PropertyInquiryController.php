<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PropertyInquiryController extends Controller
{
    public static function rentPropertyInquiry(Request $request)
    {
        if(auth()->user()->adminAccess->property_inquiries == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $inquiries = Inquiry::with(['property' => function ($q) {
                $q->where('type', 'rent'); // ✅ property.type = 'rent'
            }])
            ->whereHas('property', function ($q) {
                $q->where('type', 'rent'); // ✅ Only include inquiries whose property is rent
            })
            ->orderByDesc('created_at');

            return DataTables::of($inquiries)
                ->addIndexColumn() // SL No.
                
                ->addColumn('property', function ($row) {
                    if (!$row->property) return 'N/A';
                    $img = $row->property->featured_image
                        ? asset($row->property->featured_image)
                        : asset('images/no-image.jpg');
                    $name = $row->property->name ?? 'N/A';

                    return '<div class="d-flex align-items-center">
                                <img src="' . $img . '" alt="' . e($name) . '" width="60" height="45" class="rounded me-2" style="object-fit: cover;">
                                <span>' . e($name) . '</span>
                            </div>';
                })

                ->addColumn('name', fn($row) => e($row->name))
                ->addColumn('phone', fn($row) => e($row->phone))
                ->addColumn('demands', function ($row) {
                    $demands = explode(',', $row->demands);
                    return collect($demands)->map(fn($d) => '<span class="badge bg-primary me-1">' . e(trim($d)) . '</span>')->implode(' ');
                })

                ->addColumn('message', function ($row) {
                    return  e(Str::limit($row->message, 60)) ;
                })

                ->addColumn('status', function ($row) {
                    $badge = match ($row->status) {
                        1 => '<span class="badge bg-warning">Pending</span>',
                        2 => '<span class="badge bg-success">Replied</span>',
                        default => '<span class="badge bg-secondary">Closed</span>',
                    };
                    return $badge;
                })

                ->addColumn('action', function ($row) {
                    return view('admin.inquiry._actions', compact('row'))->render();
                })

                ->rawColumns(['property', 'demands', 'status', 'action'])
                ->make(true);
        }

        return view('admin.inquiry.rent');
    }

    public static function sellPropertyInquiry(Request $request)
    {
        if(auth()->user()->adminAccess->property_inquiries == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $inquiries = Inquiry::with(['property' => function ($q) {
                $q->where('type', 'sell'); // ✅ property.type = 'rent'
            }])
            ->whereHas('property', function ($q) {
                $q->where('type', 'sell'); // ✅ Only include inquiries whose property is rent
            })
            ->orderByDesc('created_at');

            return DataTables::of($inquiries)
                ->addIndexColumn() // SL No.
                
                ->addColumn('property', function ($row) {
                    if (!$row->property) return 'N/A';
                    $img = $row->property->featured_image
                        ? asset($row->property->featured_image)
                        : asset('images/no-image.jpg');
                    $name = $row->property->name ?? 'N/A';

                    return '<div class="d-flex align-items-center">
                                <img src="' . $img . '" alt="' . e($name) . '" width="60" height="45" class="rounded me-2" style="object-fit: cover;">
                                <span>' . e($name) . '</span>
                            </div>';
                })

                ->addColumn('name', fn($row) => e($row->name))
                ->addColumn('phone', fn($row) => e($row->phone))
                ->addColumn('demands', function ($row) {
                    $demands = explode(',', $row->demands);
                    return collect($demands)->map(fn($d) => '<span class="badge bg-primary me-1">' . e(trim($d)) . '</span>')->implode(' ');
                })

                ->addColumn('message', function ($row) {
                    return  e(Str::limit($row->message, 60)) ;
                })

                ->addColumn('status', function ($row) {
                    $badge = match ($row->status) {
                        1 => '<span class="badge bg-warning">Pending</span>',
                        2 => '<span class="badge bg-success">Replied</span>',
                        default => '<span class="badge bg-secondary">Closed</span>',
                    };
                    return $badge;
                })

                ->addColumn('action', function ($row) {
                    return view('admin.inquiry._actions', compact('row'))->render();
                })

                ->rawColumns(['property', 'demands', 'status', 'action'])
                ->make(true);
        }

        return view('admin.inquiry.buy');
    }

    public function show(Request $request)
    {
        $inquiry = Inquiry::with('property')->findOrFail($request->id);

        return response()->json([
            'inquiry' => [
                'id' => $inquiry->id,
                'name' => $inquiry->name,
                'phone' => $inquiry->phone,
                'email' => $inquiry->email,
                'country_name' => optional($inquiry->country)->name ?? 'N/A',
                'schedule_date' => $inquiry->schedule_date,
                'schedule_time' => $inquiry->schedule_time,
                'demands' => $inquiry->demands,
                'message' => $inquiry->message,
                'status' => $inquiry->status == 2 ? 'Replied' : 'Pending',
            ],
            'property' => [
                'name' => $inquiry->property->name ?? 'N/A',
                'image' => asset($inquiry->property->featured_image ?? 'default.jpg')
            ]
        ]);
    }

    public function updateStatus(Request $request)
    {
        if(auth()->user()->adminAccess->property_inquiries != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $inquiry = Inquiry::findOrFail($request->id);
        $inquiry->status = 2;
        $inquiry->save();
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = $inquiry->property->name. ' Property Inquiry has been replied .';
        $notification->notification_for = 'Property Inquiry';
        $notification->item_id = $inquiry->id;
        $notification->save();
        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        if(auth()->user()->adminAccess->property_inquiries != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $Inquiry = Inquiry::findOrFail($id);
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = $Inquiry->property->name. ' Property Inquiry has been deleted .';
        $notification->notification_for = 'Property Inquiry';
        $notification->item_id = $Inquiry->id;
        $notification->save();
        $Inquiry->delete();

        return back()->with('success','Booking Inquiry has been deleted');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Notification;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ServiceInquiryController extends Controller
{
    public static function servicesInquiry(Request $request)
    {
        if(auth()->user()->adminAccess->services == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $inquiries = Contact::orderByDesc('created_at');

            return DataTables::of($inquiries)
                ->addIndexColumn() // SL No.

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
                    return view('admin.service._actions', compact('row'))->render();
                })

                ->rawColumns(['property', 'demands', 'status', 'action'])
                ->make(true);
        }

        return view('admin.service.inquiry');
    }

    public function show(Request $request)
    {
        $inquiry = Contact::findOrFail($request->id);

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
            ]
        ]);
    }

    public function updateStatus(Request $request)
    {
        if(auth()->user()->adminAccess->services != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $inquiry = Contact::findOrFail($request->id);
        $inquiry->status = 2;
        $inquiry->save();
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = 'Service Inquiry has been replied .';
        $notification->notification_for = 'Service Inquiry';
        $notification->item_id = $inquiry->id;
        $notification->save();
        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        if(auth()->user()->adminAccess->services != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $Inquiry = Contact::findOrFail($id);
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message ='Service Inquiry has been deleted .';
        $notification->notification_for = 'Service Inquiry';
        $notification->item_id = $Inquiry->id;
        $notification->save();
        $Inquiry->delete();

        return back()->with('success','A Service Inquiry has been deleted');
    }
}

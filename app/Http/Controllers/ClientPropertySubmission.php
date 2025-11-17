<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ClientPropertySubmission extends Controller
{
    public static function rentSubmission(Request $request)
    {
        if(auth()->user()->adminAccess->property_submissions == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $inquiries = Client::where('type', 'rent')->orderByDesc('created_at'); // ✅ property.type = 'rent'

            return DataTables::of($inquiries)
                ->addIndexColumn() // SL No.

                ->addColumn('name', fn($row) => e($row->name))
                ->addColumn('phone', fn($row) => e($row->phone))
                ->addColumn('address', fn($row) => e($row->property_address))
                ->addColumn('space', fn($row) => e($row->property_space))
                ->addColumn('bedrooms', fn($row) => e($row->property_bedrooms))
                ->addColumn('estimated_price', fn($row) => e($row->property_estimated_price))
                ->addColumn('status', function ($row) {
                    $badge = match ($row->status) {
                        1 => '<span class="badge bg-warning">Pending</span>',
                        2 => '<span class="badge bg-success">Confirmed</span>',
                        3 => '<span class="badge bg-danger">Cancelled</span>',
                        default => '<span class="badge bg-secondary">Closed</span>',
                    };
                    return $badge;
                })

                ->addColumn('action', function ($row) {
                    return view('admin.client._actions', compact('row'))->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.client.rent');
    }

    public static function sellSubmission(Request $request)
    {
        if(auth()->user()->adminAccess->property_submissions == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $inquiries = Client::where('type', 'sell')->orderByDesc('created_at');

            return DataTables::of($inquiries)
                ->addIndexColumn() // SL No.
                
                ->addColumn('name', fn($row) => e($row->name))
                ->addColumn('phone', fn($row) => e($row->phone))
                ->addColumn('address', fn($row) => e($row->property_address))
                ->addColumn('space', fn($row) => e($row->property_space))
                ->addColumn('bedrooms', fn($row) => e($row->property_bedrooms))
                ->addColumn('estimated_price', fn($row) => e($row->property_estimated_price))
                ->addColumn('status', function ($row) {
                    $badge = match ($row->status) {
                        1 => '<span class="badge bg-warning">Pending</span>',
                        2 => '<span class="badge bg-success">Confirmed</span>',
                        3 => '<span class="badge bg-danger">Cancelled</span>',
                        default => '<span class="badge bg-secondary">Closed</span>',
                    };
                    return $badge;
                })

                ->addColumn('action', function ($row) {
                    return view('admin.client._actions', compact('row'))->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.client.buy');
    }

    public function show(Request $request)
    {
        $inquiry = Client::findOrFail($request->id);

        return response()->json([
            'inquiry' => [
                'id' => $inquiry->id,
                'name' => $inquiry->name,
                'phone' => $inquiry->phone,
                'email' => $inquiry->email,
                'address' => $inquiry->property_address ?? 'N/A',
                'property_bedrooms' => $inquiry->property_bedrooms,
                'property_estimated_price' => $inquiry->property_estimated_price,
                'property_space' => $inquiry->property_space,
                'property_images' => $inquiry->property_images,
                'status' => $inquiry->status,
            ]
        ]);
    }

    public function updateStatus(Request $request)
    {
        if(auth()->user()->adminAccess->property_submissions != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $inquiry = Client::findOrFail($request->id);
        $inquiry->status = $request->status;
        $inquiry->save();
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = $inquiry->name. 'Client Property Submission status updated .';
        $notification->notification_for = 'Client Submission';
        $notification->item_id = $inquiry->id;
        $notification->save();
        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        if(auth()->user()->adminAccess->property_submissions != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $Inquiry = Client::findOrFail($id);
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = $Inquiry->name. 'Client Property Submission has been deleted .';
        $notification->notification_for = 'Client Submission';
        $notification->item_id = $Inquiry->id;
        $notification->save();
        $Inquiry->delete();

        return back()->with('success','Client Property Submission has been deleted');
    }

    public static function clients(Request $request){
        if(auth()->user()->adminAccess->property_submissions == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.client.client');
    }

    public function getClients(Request $request)
    {
        if ($request->ajax()) {
            // ✅ Get all entries with status = 2
            $clients = Client::where('status', 2)
                ->select('name', 'phone', 'email', 'type')
                ->get()
                ->groupBy(function ($item) {
                    // Group by unique client
                    return strtolower($item->name) . '|' . $item->phone . '|' . strtolower($item->email);
                })
                ->map(function ($group) {
                    $first = $group->first();
                    return [
                        'name'  => $first->name,
                        'phone' => $first->phone,
                        'email' => $first->email,
                        'rent_properties' => $group->where('type', 'rent')->count(),
                        'buy_properties'  => $group->where('type', 'buy')->count(),
                    ];
                })
                ->values();

            return DataTables::of($clients)
                ->addIndexColumn()
                ->make(true);
        }
    }
}

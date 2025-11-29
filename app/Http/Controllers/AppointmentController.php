<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentConfirmedUserMail;
use App\Mail\AppointmentTeamMail;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public static function appointments(Request $request)
    {
        if(auth()->user()->adminAccess->teams == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        if ($request->ajax()) {
            $appointments = Appointment::with('team' , 'country')
            ->orderByDesc('created_at');

            return DataTables::of($appointments)
                ->addIndexColumn() // SL No.
                
                ->addColumn('team', function ($row) {
                    if (!$row->team) return 'N/A';
                    $name = $row->team->name;
                    $position = $row->team->position ?? 'N/A';

                    return '<div class="d-flex align-items-center">
                                <h5>' . e($name) . '</h5>
                                <p> ( ' . e($position) . ' )</p>
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
                        2 => '<span class="badge bg-success">Confirmed</span>',
                        default => '<span class="badge bg-secondary">Closed</span>',
                    };
                    return $badge;
                })

                ->addColumn('action', function ($row) {
                    return view('admin.team._actions', compact('row'))->render();
                })

                ->rawColumns(['team', 'demands', 'status', 'action'])
                ->make(true);
        }

        return view('admin.team.appointments');
    }

    public function show(Request $request)
    {
        $appointment = Appointment::with('team' , 'country')->findOrFail($request->id);

        return response()->json([
            'appointment' => [
                'id' => $appointment->id,
                'name' => $appointment->name,
                'phone' => $appointment->phone,
                'email' => $appointment->email,
                'country_name' => optional($appointment->country)->name ?? 'N/A',
                'schedule_date' => $appointment->schedule_date,
                'schedule_time' => $appointment->schedule_time,
                'demands' => $appointment->demands,
                'message' => $appointment->message,
                'status' => $appointment->status == 2 ? 'Confirmed' : 'Pending',
            ],
            'team' => [
                'name' => $appointment->team->name ?? 'N/A',
                'position' => $appointment->team->position ?? 'N/A',
            ]
        ]);
    }

    public function updateStatus(Request $request)
    {
        if(auth()->user()->adminAccess->teams != 3){
            return response()->json(['error' => 'Access Denied!'], 403);
        }

        $appointment = Appointment::findOrFail($request->id);

        // Save new date/time if provided
        if ($request->new_date) {
            $appointment->schedule_date = $request->new_date;
        }
        if ($request->new_time) {
            $appointment->schedule_time = $request->new_time;
        }

        $appointment->status = 2;
        $appointment->save();

        // Send Email to Appointment Requester
        Mail::to($appointment->email)->send(
            new AppointmentConfirmedUserMail($appointment)
        );

        // Send Email to Team Member
        Mail::to($appointment->team->email)->send(
            new AppointmentTeamMail($appointment)
        );

        // Create notification
        Notification::create([
            'user_id' => auth()->id(),
            'message' => 'Appointment Confirmed for ' . $appointment->team->name,
            'notification_for' => 'Appointment',
            'item_id' => $appointment->id
        ]);

        return response()->json(['success' => true]);
    }


    public function delete($id)
    {
        if(auth()->user()->adminAccess->teams != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $appointment = Appointment::findOrFail($id);
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = $appointment->team->name. ' Appointment Request has been deleted .';
        $notification->notification_for = 'Appointment';
        $notification->item_id = $appointment->id;
        $notification->save();
        $appointment->delete();

        return back()->with('success','A Appointment request has been deleted');
    }
}

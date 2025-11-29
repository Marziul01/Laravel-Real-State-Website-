<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Notification;

class TeamController extends Controller
{
    public static function teams() {
        if(auth()->user()->adminAccess->teams == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.pages.Team',[
           'teams' => Team::all(), 
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $services = Team::latest()->get();

            return DataTables::of($services)
                ->addIndexColumn()
                
                ->addColumn('file_display', function($row){
                    return '<img src="'.asset($row->photo).'" width="60" class="rounded">';
                })
                ->addColumn('action', function($row) {
                    $deleteRoute = route('admin.teams.delete', $row->id);
                    $csrf = csrf_field();
                    if (auth()->user()->adminAccess->teams === 3)
                    return '
                        <button class="btn btn-sm btn-warning editServiceBtn" data-id="' . $row->id . '">
                            <i class="fa fa-edit"></i>
                        </button>

                        <form action="' . $deleteRoute . '" method="POST" class="d-inline delete-confirm-form">
                            ' . $csrf . '
                            <button type="submit" class="btn btn-sm btn-danger deleteInquiryBtn delete-confirm">
                                Delete
                            </button>
                        </form>
                    ';
                    else
                        return 'N/A';
                })
                ->rawColumns(['file_display','action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        if(auth()->user()->adminAccess->teams != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'position'        => 'required|string|max:255',
            'email'   => 'nullable|string|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'bio' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            $filePath = null;

            // ================ FILE UPLOAD =================
            if ($request->hasFile('image')) {
                $ext = $request->file('image')->getClientOriginalExtension();
                $filename = $request->name . rand().'.' . $ext;
                $path = public_path("admin-assets/teams");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('image')->move($path, $filename);
                $filePath = "admin-assets/teams/{$filename}";
            }

            // ================ SAVE SERVICE =================
            $service = Team::create([
                'name'        => $validated['name'],
                'position'        => $validated['position'],
                'email'   => $validated['email'] ?? null,
                'phone'        => $validated['phone'] ?? null,
                'bio' => $validated['bio'],
                'photo'       => $filePath,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Team member created .';
            $notification->notification_for = 'Team';
            $notification->item_id = $service->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'New Team Member added successfully!',
                'data'    => $service
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
        $Team = Team::findOrFail($id);
        return response()->json($Team);
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->adminAccess->teams != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $Team = Team::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'position'        => 'required|string|max:255',
            'email'   => 'nullable|string|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'bio' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            $filePath = $Team->photo; // Keep existing file unless replaced

            if ($request->hasFile('image')) {
                if ($Team->photo && file_exists(public_path($Team->photo))) {
                    unlink(public_path($Team->photo));
                }
                $ext = $request->file('image')->getClientOriginalExtension();
                $filename = $request->name . rand().'.' . $ext;
                $path = public_path("admin-assets/teams");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('image')->move($path, $filename);
                $filePath = "admin-assets/teams/{$filename}";
            }

            $Team->update([
                'name'        => $validated['name'],
                'position'        => $validated['position'],
                'email'   => $validated['email'] ?? null,
                'phone'        => $validated['phone'] ?? null,
                'bio' => $validated['bio'],
                'photo'       => $filePath,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Team Member details updated.';
            $notification->notification_for = 'Team';
            $notification->item_id = $Team->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Team Memeber updated successfully!',
                'data'    => $Team
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
            if(auth()->user()->adminAccess->teams != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
            $Team = Team::findOrFail($id);

            if ($Team->photo && file_exists(public_path($Team->photo))) {
                unlink(public_path($Team->photo));
            }

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = $Team->name. ' Member has been deleted .';
            $notification->notification_for = 'Services';
            $notification->item_id = $Team->id;
            $notification->save();
            $Team->delete();

            return back()->with('success','A Team Member has been deleted');
        }
}

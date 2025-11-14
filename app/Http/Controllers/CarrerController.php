<?php

namespace App\Http\Controllers;

use App\Models\Carrer;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CarrerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.carrers',[
           'carrers' => Carrer::all(), 
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $services = Carrer::latest()->get();

            return DataTables::of($services)
                ->addIndexColumn()
                
                ->addColumn('file_display', function($row){
                    return '<img src="'.asset($row->image).'" width="60" class="rounded">';
                })
                ->addColumn('action', function($row) {
                    $deleteRoute = route('careers.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <button class="btn btn-sm btn-warning editServiceBtn" data-id="' . $row->id . '">
                            <i class="fa fa-edit"></i>
                        </button>

                        <form action="' . $deleteRoute . '" method="POST" class="d-inline delete-confirm-form">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="submit" class="btn btn-sm btn-danger deleteInquiryBtn delete-confirm">
                                Delete
                            </button>
                        </form>
                    ';
                })

                ->rawColumns(['file_display','action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'description'        => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                $filename = $request->title . rand().'.' . $ext;
                $path = public_path("admin-assets/Carrer");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('image')->move($path, $filename);
                $filePath = "admin-assets/Carrer/{$filename}";
            }

            

            // ================ SAVE SERVICE =================
            $Carrer = Carrer::create([
                'title'        => $validated['title'],
                'location'        => $request->location,
                'description'   => $validated['description'] ?? null,
                'image'       => $filePath,
                'salary'        => $request->salary,
                'type'        => $request->type,
                'position'        => $request->position,
                'deadline'        => $request->deadline,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Job Circular created .';
            $notification->notification_for = 'Carrer';
            $notification->item_id = $Carrer->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'New Job Circular added successfully!',
                'data'    => $Carrer
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while saving service!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Carrer = Carrer::findOrFail($id);
        return response()->json($Carrer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Carrer = Carrer::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'description'        => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {

            $filePath = $Carrer->image; // Keep existing file unless replaced

            if ($request->hasFile('image')) {
                if ($Carrer->image && file_exists(public_path($Carrer->image))) {
                    unlink(public_path($Carrer->image));
                }
                $ext = $request->file('image')->getClientOriginalExtension();
                $filename = $request->title . rand().'.' . $ext;
                $path = public_path("admin-assets/Carrer");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('image')->move($path, $filename);
                $filePath = "admin-assets/Carrer/{$filename}";
            }

            

            $Carrer->update([
                'title'        => $validated['title'],
                'location'        => $request->location,
                'description'   => $validated['description'] ?? null,
                'image'       => $filePath,
                'salary'        => $request->salary,
                'type'        => $request->type,
                'position'        => $request->position,
                'deadline'        => $request->deadline,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Job Circular updated.';
            $notification->notification_for = 'Carrer';
            $notification->item_id = $Carrer->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Job Circular updated successfully!',
                'data'    => $Carrer
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating service!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Carrer = Carrer::findOrFail($id);

            if ($Carrer->image && file_exists(public_path($Carrer->image))) {
                unlink(public_path($Carrer->image));
            }
            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = $Carrer->name. ' Job Post has been deleted .';
            $notification->notification_for = 'Carrer';
            $notification->item_id = $Carrer->id;
            $notification->save();
            $Carrer->delete();

            return back()->with('success','A Job Post has been deleted');
    }
}

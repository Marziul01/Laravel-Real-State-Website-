<?php

namespace App\Http\Controllers;

use App\Models\HomePage;
use App\Models\Notification;
use App\Models\Property;
use App\Models\Slider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PagesController extends Controller
{
     public static function homepage() {
        if(auth()->user()->adminAccess->pages_management == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.pages.homepage',[
           'sliders' => Slider::all(), 
           'homepage' => HomePage::first(),
           'properties' => Property::all(),
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $sliders = Slider::with(['property'])
                ->latest()
                ->get();

            return DataTables::of($sliders)
                ->addIndexColumn()

                // 🏡 Review For Column
                ->addColumn('property', function ($row) {
                    return 'Property: ' . e($row->property->name);
                })

                ->addColumn('file_display', function($row){
                    return '<img src="'.asset($row->image).'" width="60" class="rounded">';
                })

                // ⚙️ Action Buttons
                ->addColumn('action', function ($row) {
                    $deleteRoute = route('admin.homeslider.delete', $row->id);
                    $csrf = csrf_field();
                    if (auth()->user()->adminAccess->pages_management === 3)
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
                    else
                        return 'N/A';
                })

                ->rawColumns(['property', 'file_display', 'action'])
                ->make(true);
        }
    }


    public function store(Request $request)
    {
        if(auth()->user()->adminAccess->pages_management != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'desc'        => 'required|string',
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'property_id'        => 'required|exists:properties,id',
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
                $path = public_path("admin-assets/sliders");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('image')->move($path, $filename);
                $filePath = "admin-assets/sliders/{$filename}";
            }

            // ================ SAVE SERVICE =================
            $Slider = Slider::create([
                'title'        => $validated['title'],
                'description'        => $validated['desc'],
                'property_id'   => $validated['property_id'] ?? null,
                'title'        => $validated['title'] ?? null,
                'image' => $filePath,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Slider created .';
            $notification->notification_for = 'Slider';
            $notification->item_id = $Slider->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'New Slider added successfully!',
                'data'    => $Slider
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
        $Slider = Slider::findOrFail($id);
        return response()->json($Slider);
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->adminAccess->pages_management != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $Slider = Slider::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'desc'        => 'required|string',
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'property_id'        => 'required|exists:properties,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {

            $filePath = $Slider->image; // Keep existing file unless replaced

            if ($request->hasFile('image')) {

                // ✅ Delete old file if exists
                if ($Slider->image && file_exists(public_path($Slider->image))) {
                    unlink(public_path($Slider->image));
                }

                // ✅ Upload new file
                $ext = $request->file('image')->getClientOriginalExtension();
                $filename = $request->title . rand() . '.' . $ext;
                $path = public_path("admin-assets/sliders");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('image')->move($path, $filename);
                $filePath = "admin-assets/sliders/{$filename}";
            }


            $Slider->update([
                'title'        => $validated['title'],
                'description'        => $validated['desc'],
                'property_id'   => $validated['property_id'] ?? null,
                'title'        => $validated['title'] ?? null,
                'image' => $filePath,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Slider updated.';
            $notification->notification_for = 'Slider';
            $notification->item_id = $Slider->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Slider updated successfully!',
                'data'    => $Slider
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
            if(auth()->user()->adminAccess->pages_management != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
            $Slider = Slider::findOrFail($id);

            if ($Slider->image && file_exists(public_path($Slider->image))) {
                unlink(public_path($Slider->image));
            }

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = ' Slider has been deleted .';
            $notification->notification_for = 'Slider';
            $notification->item_id = $Slider->id;
            $notification->save();
            $Slider->delete();

            return back()->with('success','A Slider has been deleted');
        }

        public function homeupdate(Request $request)
        {
            if(auth()->user()->adminAccess->pages_management != 3){
                return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
            }
            $request->validate([
                'image' => 'nullable|image|max:2048',
            ]);

            $home = HomePage::firstOrNew(['id' => 1]);

            // ✅ Handle image upload & delete old
            if ($request->hasFile('image')) {
                if ($home->image && file_exists(public_path($home->image))) {
                    unlink(public_path($home->image));
                }

                $ext = $request->file('image')->getClientOriginalExtension();
                $filename = 'home_image_' . time() . '.' . $ext;
                $path = public_path('admin-assets/home');
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('image')->move($path, $filename);
                $home->image = "admin-assets/home/{$filename}";
            }

            // ✅ Handle 5 result columns
            for ($i = 1; $i <= 5; $i++) {
                $field = "result_{$i}";
                if ($request->has($field)) {
                    $home->$field = $request->$field;
                }
            }

            $home->save();

            return response()->json([
                'success' => true,
                'message' => 'Home page data updated successfully!',
            ]);
        }

}

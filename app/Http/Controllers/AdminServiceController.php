<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    public static function services() {
        if(auth()->user()->adminAccess->services == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.pages.services',[
           'services' => Service::all(), 
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $services = Service::latest()->get();

            return DataTables::of($services)
                ->addIndexColumn()
                ->addColumn('icon', function($row){

                    // If icon type is "image"
                    if ($row->icon_type === 'image' && !empty($row->icon_image)) {
                        return '<img src="'.asset($row->icon_image).'" 
                                    style="width:30px;height:30px;object-fit:contain;">';
                    }

                    // If icon type is "picker"
                    if (!empty($row->icon)) {
                        return '<i class="'.$row->icon.' fa-lg text-primary"></i>';
                    }

                    // Default fallback
                    return '<span class="text-muted">No Icon</span>';
                })
                ->addColumn('type', function($row){
                    $types = explode(',', $row->type);
                    return collect($types)->map(fn($t) => '<span class="badge bg-info me-1">'.$t.'</span>')->implode(' ');
                })
                ->addColumn('file_display', function($row){
                    if ($row->file_type === 'Image' && $row->file)
                        return '<img src="'.asset($row->file).'" width="60" class="rounded">';
                    elseif ($row->file_type === 'Video File' && $row->file)
                        return '<video width="100" height="60" controls><source src="'.asset($row->file).'" type="video/mp4"></video>';
                    elseif ($row->file_type === 'Video Link')
                        return '<a href="'.$row->file.'" target="_blank" class="text-primary">View Link</a>';
                    else
                        return 'N/A';
                })
                ->addColumn('action', function($row) {
                    $deleteRoute = route('admin.services.delete', $row->id);
                    $csrf = csrf_field();
                    if (auth()->user()->adminAccess->services === 3)
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
                ->rawColumns(['icon','type','file_display','action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        if(auth()->user()->adminAccess->services != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'type'        => 'required|array',
            'type.*'      => 'string',
            'name'        => 'required|string|max:255',
            'file_type'   => 'required|string|in:Image,Video File,Video Link',
            'file'        => 'nullable',
            'description' => 'nullable|string',
            'icon_type'   => 'required|in:picker,image',
            'icon'        => 'required_if:icon_type,picker|string|nullable',
            'icon_image'  => 'required_if:icon_type,image|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $filePath1 = null;
            // ================ FILE UPLOAD =================
            if (in_array($validated['file_type'], ['Image', 'Video File']) && $request->hasFile('file')) {
                $ext = $request->file('file')->getClientOriginalExtension();
                $filename = uniqid('service_') . '.' . $ext;
                $folder = $validated['file_type'] === 'Image' ? 'images' : 'videos';
                $path = public_path("admin-assets/services/{$folder}");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('file')->move($path, $filename);
                $filePath = "admin-assets/services/{$folder}/{$filename}";
            } elseif ($validated['file_type'] === 'Video Link') {
                $filePath = $request->file;
            }

            if ($request->icon_type == 'image' && $request->hasFile('icon_image')) {
                $ext1 = $request->file('icon_image')->getClientOriginalExtension();
                $filename1 = uniqid('service_icon_') . '.' . $ext1;
                $path1 = public_path("admin-assets/services/icon");
                if (!file_exists($path1)) mkdir($path1, 0777, true);
                $request->file('icon_image')->move($path1, $filename1);
                $filePath1 = "admin-assets/services/icon/{$filename1}";
            }

            // ================ UNIQUE SLUG =================
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $count = 1;
            while (Service::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            // ================ SAVE SERVICE =================
            $service = Service::create([
                'type'        => implode(',', $validated['type']),
                'name'        => $validated['name'],
                'slug'        => $slug,               // ✅ Save unique slug
                'icon'        => $validated['icon'],
                'file_type'   => $validated['file_type'],
                'file'        => $filePath,
                'description' => $validated['description'] ?? null,
                'icon_type'   => $validated['icon_type'],
                'icon_image'   => $filePath1,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Service created .';
            $notification->notification_for = 'Services';
            $notification->item_id = $service->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Service added successfully!',
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
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->adminAccess->services != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $service = Service::findOrFail($id);

        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'type'        => 'required|array',
            'type.*'      => 'string',
            'name'        => 'required|string|max:255',
            'file_type'   => 'required|string|in:Image,Video File,Video Link',
            'file'        => 'nullable',
            'description' => 'nullable|string',
            'icon_type'   => 'required|in:picker,image',
            'icon'        => 'required_if:icon_type,picker|string|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            $filePath = $service->file; // Keep existing file unless replaced
            $filePath1 = $service->icon_image;
            // ================ FILE UPLOAD =================
            if (in_array($validated['file_type'], ['Image', 'Video File']) && $request->hasFile('file')) {
                if ($service->file && file_exists(public_path($service->file))) {
                    unlink(public_path($service->file));
                }
                $ext = $request->file('file')->getClientOriginalExtension();
                $filename = uniqid('service_') . '.' . $ext;
                $folder = $validated['file_type'] === 'Image' ? 'images' : 'videos';
                $path = public_path("admin-assets/services/{$folder}");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('file')->move($path, $filename);
                $filePath = "admin-assets/services/{$folder}/{$filename}";
            } elseif ($validated['file_type'] === 'Video Link') {
                $filePath = $request->file;
            }

            if ($request->icon_type == 'image' && $request->hasFile('icon_image')) {
                if ($service->icon_image && file_exists(public_path($service->icon_image))) {
                    unlink(public_path($service->icon_image));
                }
                $ext1 = $request->file('icon_image')->getClientOriginalExtension();
                $filename1 = uniqid('service_icon_') . '.' . $ext1;
                $path1 = public_path("admin-assets/services/icon");
                if (!file_exists($path1)) mkdir($path1, 0777, true);
                $request->file('icon_image')->move($path1, $filename1);
                $filePath1 = "admin-assets/services/icon/{$filename1}";
            }

            // ================ UNIQUE SLUG (IF NAME CHANGED) =================
            if ($service->name !== $validated['name']) {
                $baseSlug = Str::slug($validated['name']);
                $slug = $baseSlug;
                $count = 1;
                while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            }

            // ================ UPDATE SERVICE =================
            $service->update([
                'type'        => implode(',', $validated['type']),
                'name'        => $validated['name'],
                'slug'        => $validated['slug'] ?? $service->slug,
                'icon'        => $validated['icon'],
                'file_type'   => $validated['file_type'],
                'file'        => $filePath,
                'description' => $validated['description'] ?? null,
                'icon_type'   => $validated['icon_type'],
                'icon_image'   => $filePath1,
            ]);

            // ================ NOTIFICATION =================
            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Service updated.';
            $notification->notification_for = 'Services';
            $notification->item_id = $service->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully!',
                'data'    => $service
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
            if(auth()->user()->adminAccess->services != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
            $Service = Service::findOrFail($id);

            if ($Service->file && file_exists(public_path($Service->file))) {
                unlink(public_path($Service->file));
            }

            if ($Service->icon_image && file_exists(public_path($Service->icon_image))) {
                unlink(public_path($Service->icon_image));
            }

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = $Service->name. ' Service has been deleted .';
            $notification->notification_for = 'Services';
            $notification->item_id = $Service->id;
            $notification->save();
            $Service->delete();

            return back()->with('success','A Service has been deleted');
        }

}

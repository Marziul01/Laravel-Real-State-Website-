<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    public static function services() {
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
                    return '<i class="'.$row->icon.' fa-lg text-primary"></i>';
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
                ->addColumn('action', function($row){
                    return '
                        <button class="btn btn-sm btn-warning editServiceBtn" data-id="'.$row->id.'"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger deleteServiceBtn" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>
                    ';
                })
                ->rawColumns(['icon','type','file_display','action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'type'        => 'required|array',
            'type.*'      => 'string',
            'name'        => 'required|string|max:255',
            'icon'        => 'required|string|max:255',
            'file_type'   => 'required|string|in:Image,Video File,Video Link',
            'file'        => 'nullable',
            'description' => 'nullable|string',
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
            ]);

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
}

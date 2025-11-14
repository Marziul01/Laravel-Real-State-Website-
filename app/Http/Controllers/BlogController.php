<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    
    public function index()
    {
        return view('admin.pages.blog',[
           'blogs' => Blog::all(), 
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $services = Blog::latest()->get();

            return DataTables::of($services)
                ->addIndexColumn()
                
                ->addColumn('file_display', function($row){
                    return '<img src="'.asset($row->image).'" width="60" class="rounded">';
                })
                ->addColumn('action', function($row) {
                    $deleteRoute = route('blogs.destroy', $row->id);
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
            'content'        => 'required|string',
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {

            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $count = 1;

            while (Blog::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $filePath = null;

            // ================ FILE UPLOAD =================
            if ($request->hasFile('image')) {
                $ext = $request->file('image')->getClientOriginalExtension();
                $filename = $slug . rand().'.' . $ext;
                $path = public_path("admin-assets/blogs");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('image')->move($path, $filename);
                $filePath = "admin-assets/blogs/{$filename}";
            }

            

            // ================ SAVE SERVICE =================
            $Blog = Blog::create([
                'title'        => $validated['title'],
                'slug'        => $slug,
                'content'   => $validated['content'] ?? null,
                'image'       => $filePath,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Blog created .';
            $notification->notification_for = 'Blog';
            $notification->item_id = $Blog->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'New Blog added successfully!',
                'data'    => $Blog
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
        $Blog = Blog::findOrFail($id);
        return response()->json($Blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Blog = Blog::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'content'        => 'required|string',
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

            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $count = 1;
            while (Blog::where('slug', $slug)->where('id', '!=', $Blog->id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }


            $filePath = $Blog->image; // Keep existing file unless replaced

            if ($request->hasFile('image')) {
                if ($Blog->image && file_exists(public_path($Blog->image))) {
                    unlink(public_path($Blog->image));
                }
                $ext = $request->file('image')->getClientOriginalExtension();
                $filename = $slug . rand().'.' . $ext;
                $path = public_path("admin-assets/teams");
                if (!file_exists($path)) mkdir($path, 0777, true);
                $request->file('image')->move($path, $filename);
                $filePath = "admin-assets/teams/{$filename}";
            }

            

            $Blog->update([
                'title'        => $validated['title'],
                'slug'        => $slug,
                'content'   => $validated['content'] ?? null,
                'image'       => $filePath,
            ]);

            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'Blog updated.';
            $notification->notification_for = 'Blog';
            $notification->item_id = $Blog->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Blog updated successfully!',
                'data'    => $Blog
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
        $Blog = Blog::findOrFail($id);

            if ($Blog->image && file_exists(public_path($Blog->image))) {
                unlink(public_path($Blog->image));
            }
            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = $Blog->name. ' Blog has been deleted .';
            $notification->notification_for = 'Blog';
            $notification->item_id = $Blog->id;
            $notification->save();
            $Blog->delete();

            return back()->with('success','A Blog has been deleted');
    }
}

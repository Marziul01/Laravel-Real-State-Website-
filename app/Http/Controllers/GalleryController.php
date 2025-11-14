<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::latest()->get(); // show saved images
        return view('admin.pages.gallery', compact('images'));
    }

    public function store(Request $request)
    {
        // Accept 'images[]' multiple files
        $files = $request->file('images');
        if (!$files || !count($files)) {
            return response()->json(['status' => 'error', 'message' => 'No images uploaded.'], 422);
        }

        $rules = ['images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048']; // 2MB max each
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status'=>'error','errors'=>$validator->errors()], 422);
        }

        $saved = [];

        $destFolder = public_path('admin-assets/images/gallery');
        if (!File::exists($destFolder)) {
            File::makeDirectory($destFolder, 0755, true);
        }

        foreach ($files as $file) {
            $orig = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $name = pathinfo($orig, PATHINFO_FILENAME);
            $filename = Str::slug($name) . '-' . time() . '-' . Str::random(6) . '.' . $ext;

            try {
                $file->move($destFolder, $filename);
                $relativePath = 'admin-assets/images/gallery/' . $filename;

                $gallery = Gallery::create([
                    'image' => $relativePath,
                ]);

                $saved[] = [
                    'id' => $gallery->id,
                    'image' => asset($relativePath),
                    'relative' => $relativePath,
                ];
            } catch (\Exception $e) {
                // If fail for one file, continue but report in response (you can improve rollback if desired).
            }
        }

        return response()->json(['status'=>'success','message'=>'Images uploaded successfully.','data'=>$saved]);
    }

    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        if (!$gallery) {
            return response()->json(['status'=>'error','message'=>'Image not found.'], 404);
        }

        $filePath = public_path($gallery->image);
        if (File::exists($filePath)) {
            try {
                File::delete($filePath);
            } catch (\Exception $e) {
                // ignore - still try to delete DB row
            }
        }

        $gallery->delete();

        return response()->json(['status'=>'success','message'=>'Image deleted.']);
    }
}

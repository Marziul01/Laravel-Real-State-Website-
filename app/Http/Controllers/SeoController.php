<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Property;
use App\Models\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function edit()
    {
        if(auth()->user()->adminAccess->seo == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        $setting = Seo::first();
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        if(auth()->user()->adminAccess->seo != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $request->validate([
            'gtm_id' => 'nullable|string',
            'meta_pixel_id' => 'nullable|string',
            'ga4_id' => 'nullable|string',
            'meta_access_token' => 'nullable|string',
            'meta_test_event_code' => 'nullable|string',
        ]);

        Seo::first()->update($request->only('gtm_id', 'meta_pixel_id', 'ga4_id', 'meta_access_token', 'meta_test_event_code'));

        return response()->json([
            'success' => true,
            'message' => 'SEO settings updated successfully.'
        ]);
    }

    public function sitemap()
    {
        $rents = Property::where('type' , 'rent' )->get();
        $sells =  Property::where('type' , 'sell' )->get();
 
        $blogs = Blog::all();

        return response()->view('sitemap', compact('rents', 'blogs' , 'sells'))
            ->header('Content-Type', 'text/xml');
    }
}

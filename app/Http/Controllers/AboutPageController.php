<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public static function aboutPage(){
        return view('admin.pages.about-page',[
            'about' => AboutPage::first(),
        ]);
    }

    public function update(Request $request)
    {
        $about = AboutPage::firstOrNew(['id' => 1]);

        $validated = $request->validate([
            'about_content' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Save image if uploaded
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('about_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin-assets/img/about'), $filename);
            $validated['image'] = 'admin-assets/img/about/' . $filename;
        }

        // ✅ Start with validated data
        $data = $validated;

        // ✅ Loop through why_buy & why_sell fields
        for ($i = 1; $i <= 9; $i++) {
            $buyIcon = $request->input("why_buy_{$i}_icon");
            $buyName = $request->input("why_buy_{$i}_name");
            $data["why_buy_{$i}"] = ($buyIcon || $buyName) ? "{$buyIcon},{$buyName}" : null;

            $sellIcon = $request->input("why_sell_{$i}_icon");
            $sellName = $request->input("why_sell_{$i}_name");
            $data["why_sell_{$i}"] = ($sellIcon || $sellName) ? "{$sellIcon},{$sellName}" : null;
        }

        // ✅ Save all fields
        $about->fill($data)->save();

        return response()->json([
            'success' => true,
            'message' => 'About page updated successfully!',
        ]);
    }

}

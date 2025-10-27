<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\District;
use App\Models\Property;
use App\Models\PropertyAmenitie;
use App\Models\PropertyFeature;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\State;
use App\Models\Upazila;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $properties = Property::where('type' , 'rent')->with(['propertyType','images', 'features' , 'amenities', 'country' ,'propertyarea','state'])->orderByDesc('created_at');

            return DataTables::of($properties)
                ->addIndexColumn() // Sl column
                ->addColumn('image', function ($row) {
                    $firstImage = $row->featured_image ?? 'default.jpg';
                    return '<img src="'.asset($firstImage).'" width="60" height="60" class="rounded">';
                })
                ->addColumn('property_type', function ($row) {
                    return $row->propertyType->property_type ?? 'Not Assigned';
                })
                ->editColumn('price', function ($row) {
                    return number_format($row->price, 2);
                })
                ->addColumn('location', function ($row) {
                    if ($row->country_id == 19) {
                        $district = District::find($row->state_id);
                        return "{$row->propertyarea->name}, {$district->name}, {$row->country->name}";
                    }

                    return "{$row->city}, {$row->state->name}, {$row->country->name}";
                })
                ->editColumn('rent_start', function ($row) {
                    return $row->rent_start ? Carbon::parse($row->rent_start)->format('d M, Y') : '-';
                })
                ->addColumn('action', function ($row) {
                    return view('admin.property._actions', compact('row'))->render();
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('admin.property.rent',[
            'property' => Property::where('type' , 'rent')->get(),
            'property_types' => PropertyType::all(),
        ]);
    }

    public function sell(Request $request)
    {

        if ($request->ajax()) {
            $properties = Property::where('type' , 'sell')->with(['propertyType','images', 'features' , 'amenities', 'country' ,'propertyarea','state'])->orderByDesc('created_at');

            return DataTables::of($properties)
                ->addIndexColumn() // Sl column
                ->addColumn('image', function ($row) {
                    $firstImage = $row->featured_image ?? 'default.jpg';
                    return '<img src="'.asset($firstImage).'" width="60" height="60" class="rounded">';
                })
                ->addColumn('property_type', function ($row) {
                    return $row->propertyType->property_type ?? 'Not Assigned';
                })
                ->editColumn('price', function ($row) {
                    return number_format($row->price, 2);
                })
                ->addColumn('location', function ($row) {
                    if ($row->country_id == 19) {
                        $district = District::find($row->state_id);
                        return "{$row->propertyarea->name}, {$district->name}, {$row->country->name}";
                    }

                    return "{$row->city}, {$row->state->name}, {$row->country->name}";
                })
                ->addColumn('action', function ($row) {
                    return view('admin.property._actions', compact('row'))->render();
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('admin.property.sell',[
            'property' => Property::where('type' , 'sell')->get(),
            'property_types' => PropertyType::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.property.create',[
            'propertyTypes' => PropertyType::all(),
            'countries' => Country::where('status' , 1)->get(),
            'realtors' => User::where('role_type', 'Realtor' )->get(),
        ]);
    }

    public function sellcreate()
    {
        return view('admin.property.sellcreate',[
            'propertyTypes' => PropertyType::all(),
            'countries' => Country::where('status' , 1)->get(),
            'realtors' => User::where('role_type', 'Realtor' )->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // ✅ Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'rent_start' => 'nullable|date',
                'featured_image' => 'nullable|file|mimes:jpg,jpeg,png,webp,avif|max:4096',
                'gallery_images.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,avif|max:4096',
                'feature_keys' => 'nullable|array',
                'feature_values' => 'nullable|array',
                'amenities' => 'nullable|array',
                'country_id' => 'required|integer',
                'state_id' => 'nullable|integer',
                'district_id' => 'nullable|integer',
                'upazilla_id' => 'nullable|integer',
                'property_type_id' => 'required',
            ]);

            // ✅ Generate unique slug
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $count = 1;

            while (Property::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            // ✅ Create property
            $property = new Property();
            $property->name = $validated['name'];
            $property->slug = $slug;
            $property->description = $validated['description'] ?? null;
            $property->price = $validated['price'];
            $property->rent_start = $validated['rent_start'];
            $property->country_id = $request->country_id;
            if($request->district_id){
                $property->state_id = $request->district_id;
                $property->property_area_id = $request->upazilla_id;
            }else{
                $property->state_id = $request->state_id;
                $property->property_area_id = $request->state_id;
            }
            $property->space = $request->space;
            $property->parking_space = $request->parking_space;
            $property->bedrooms = $request->bedrooms;
            $property->bathrooms = $request->bathrooms;
            $property->decoration = $request->decoration;
            $property->check_in = $request->check_in;
            $property->check_out = $request->check_out;
            $property->city = $request->city;
            $property->road = $request->road;
            $property->house = $request->house;
            $property->property_type_id = $request->property_type_id;
            $property->type = $request->type;
            $property->realtor_id = $request->realtor_id;
            if ($request->filled('property_listing')) {
                $property->property_listing = implode(',', $request->property_listing);
            }

            $property->save();

            $propertySlug = $property->slug;

            // --- Featured Image ---
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');

                // Get extension
                $ext = $file->getClientOriginalExtension();

                // Create unique filename using slug
                $filename = $propertySlug . '-featured.' . $ext;

                // Save to public folder
                $file->move(public_path('admin-assets/img/properties'), $filename);

                // Save path to DB
                $property->featured_image = 'admin-assets/img/properties/' . $filename;
                $property->save();
            }

            // --- Gallery Images ---
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $index => $image) {

                    $ext = $image->getClientOriginalExtension();

                    // Create unique filename using slug + index
                    $filename = $propertySlug . '-gallery-' . ($index+1) . '.' . $ext;

                    // Save to public folder
                    $image->move(public_path('admin-assets/img/properties'), $filename);

                    // Save path to DB
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image' => 'admin-assets/img/properties/' . $filename,
                    ]);
                }
            }

            // ✅ Features (store in `features` table)
            if ($request->filled('feature_keys') && $request->filled('feature_values')) {
                foreach ($request->feature_keys as $index => $key) {
                    $value = $request->feature_values[$index] ?? null;
                    if (!empty($key) && !empty($value)) {
                        PropertyFeature::create([
                            'property_id' => $property->id,
                            'feature_keys' => $key,
                            'feature_values' => $value,
                        ]);
                    }
                }
            }

            // ✅ Amenities (store in `amenities` table)
            if ($request->filled('amenities')) {
                foreach ($request->amenities as $amenityName) {
                    if (!empty($amenityName)) {
                        PropertyAmenitie::create([
                            'property_id' => $property->id,
                            'amenities' => $amenityName,
                        ]);
                    }
                }
            }

            // ✅ Success response
            return response()->json([
                'success' => true,
                'message' => 'Property created successfully!',
                'redirect' => route('property.index'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save property: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.property.edit',[
            'property' => Property::find($id),
            'propertyTypes' => PropertyType::all(),
            'countries' => Country::where('status' , 1)->get(),
            'realtors' => User::where('role_type', 'Realtor' )->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            $property = Property::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'featured_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif',
                'gallery_images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif',
                'price' => 'required|numeric',
                'rent_start' => 'nullable|date',
                'space' => 'nullable|numeric',
                'parking_space' => 'nullable|numeric',
                'bedrooms' => 'nullable|integer',
                'bathrooms' => 'nullable|integer',
                'decoration' => 'nullable|string',
                'country_id' => 'required|integer',
                'state_id' => 'nullable|integer',
                'district_id' => 'nullable|integer',
                'upazilla_id' => 'nullable|integer',
                'city' => 'nullable|string',
                'road' => 'nullable|string',
                'house' => 'nullable|string',
                'property_type_id' => 'required|integer',
                'property_listing' => 'nullable|array',
                'property_listing.*' => 'string',
                'feature_keys' => 'nullable|array',
                'feature_values' => 'nullable|array',
                'amenities' => 'nullable|array',
            ]);

            if ($property->name !== $validated['name']) {
                // Generate unique slug only if name changed
                $baseSlug = Str::slug($validated['name']);
                $slug = $baseSlug;
                $count = 1;

                while (Property::where('slug', $slug)->where('id', '!=', $property->id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
            }else{
                $slug = $property->slug;
            }

            // 🏠 Update main property fields
            $property->update([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'rent_start' => $request->rent_start,
                'space' => $request->space,
                'parking_space' => $request->parking_space,
                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'decoration' => $request->decoration,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'country_id' => $request->country_id,
                'state_id' => $request->district_id ?: $request->state_id, // district if country=19
                'property_area_id' => $request->upazilla_id ?: $request->state_id,
                'city' => $request->city,
                'road' => $request->road,
                'house' => $request->house,
                'property_type_id' => $request->property_type_id,
                'property_listing' => $request->property_listing ? implode(',', $request->property_listing) : null,
            ]);

            $propertySlug = $property->slug;

            // ✅ Featured image upload
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');

                // Get extension
                $ext = $file->getClientOriginalExtension();

                // Create unique filename using slug
                $filename = $propertySlug . '-featured.' . $ext;

                // Save to public folder
                $file->move(public_path('admin-assets/img/properties'), $filename);

                // Save path to DB
                $property->featured_image = 'admin-assets/img/properties/' . $filename;
                $property->save();
            }

            // --- Gallery Images ---
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $index => $image) {

                    $ext = $image->getClientOriginalExtension();

                    // Create unique filename using slug + index
                    $filename = $propertySlug . '-gallery-' . ($index+1) . '.' . $ext;

                    // Save to public folder
                    $image->move(public_path('admin-assets/img/properties'), $filename);

                    // Save path to DB
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image' => 'admin-assets/img/properties/' . $filename,
                    ]);
                }
            }

            // =======================
            // Features
            // =======================
            $featureKeys = $request->feature_keys ?? [];
            $featureValues = $request->feature_values ?? [];

            // Delete all previous features and re-insert
            $property->features()->delete();

            foreach ($featureKeys as $index => $key) {
                if (!empty($key) && !empty($featureValues[$index])) {
                    $property->features()->create([
                        'feature_keys' => $key,
                        'feature_values' => $featureValues[$index],
                    ]);
                }
            }

            // =======================
            // Amenities
            // =======================
            $amenities = $request->amenities ?? [];

            // Delete previous amenities and re-insert
            $property->amenities()->delete();

            foreach ($amenities as $amenity) {
                if (!empty($amenity)) {
                    $property->amenities()->create([
                        'amenities' => $amenity,
                    ]);
                }
            }

            // ✅ Success response
            return response()->json([
                'success' => true,
                'message' => 'Property updated successfully!',
                'redirect' => route('property.index'),
                'property_type' => $property->type,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update property: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        // ✅ Delete featured image if exists
        if ($property->featured_image && Storage::disk('public')->exists($property->featured_image)) {
            Storage::disk('public')->delete($property->featured_image);
        }

        // ✅ Delete gallery images (from folder + DB)
        if ($property->images && $property->images->count() > 0) {
            foreach ($property->images as $image) {
                if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
        }

        // ✅ Delete features (each record)
        if ($property->features && $property->features->count() > 0) {
            foreach ($property->features as $feature) {
                $feature->delete();
            }
        }

        // ✅ Delete amenities (each record)
        if ($property->amenities && $property->amenities->count() > 0) {
            foreach ($property->amenities as $amenity) {
                $amenity->delete();
            }
        }

        // ✅ Delete property
        $property->delete();

        return back()->with('success', 'Property deleted successfully.');
    }


    public function getStates(Request $request)
    {
        $countryId = $request->country_id;
        $states = State::where('country_id', $countryId)->get(['id', 'name']);

        if ($states->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No states found.']);
        }

        return response()->json(['success' => true, 'data' => $states]);
    }

    public function getDistricts(Request $request)
    {
        $countryId = $request->country_id;
        $districts = District::where('country_id', $countryId)->get(['id', 'name']);

        if ($districts->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No districts found.']);
        }

        return response()->json(['success' => true, 'data' => $districts]);
    }

    public function getUpazillas(Request $request)
    {
        $districtId = $request->district_id;
        $upazillas = Upazila::where('district_id', $districtId)->get(['id', 'name']);

        if ($upazillas->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No upazillas found.']);
        }

        return response()->json(['success' => true, 'data' => $upazillas]);
    }

    public function deleteGalleryImage($id)
    {
        try {
            $image = PropertyImage::findOrFail($id); // use findOrFail to throw exception if not found
            Storage::disk('public')->delete($image->image); // delete file
            $image->delete(); // delete record
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the error to debug
            \Log::error("Gallery Image Delete Error: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }


}

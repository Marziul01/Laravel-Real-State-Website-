<?php

namespace App\Http\Controllers;

use App\Mail\ContactReceived;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Notification;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Client;
use App\Mail\ClientPropertyMail;

class FormController extends Controller
{
    public static function propertyInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'required|email',
            'country_id' => 'required|string',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required',
            'demands' => 'required|array',
            'message' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $Contact = Contact::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'country_id' => $validated['country_id'],
            'schedule_date' => $validated['schedule_date'],
            'schedule_time' => $validated['schedule_time'],
            'demands' => implode(',', $validated['demands']),
            'message' => $validated['message'],
        ]);

        $settings = SiteSetting::find(1);
        $adminEmail = $settings->site_email ?? 'admin@example.com';

        try {
            Mail::to($adminEmail)->send(new ContactReceived($Contact));
            Log::info("Inquiry email sent to admin: {$adminEmail}");
        } catch (\Exception $e) {
            Log::error("Inquiry email failed: " . $e->getMessage());
        }

        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = 'New Inquiry has been created';
        $notification->notification_for = 'Contact Inquiry';
        $notification->item_id = $Contact->id;
        $notification->save();

        return response()->json(['status' => 'success', 'message' => 'Inquiry sent successfully!']);
    }

    public static function sendyourproperty( Request $request){
        return view('frontend.property.sendyourproperty',[
            'countries' => Country::all(),
            'request' => $request,
        ]);
    }

    public static function clientProperties(Request $request){
        // 🔹 1. Validate request
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:100',
            'property_address' => 'required|string|max:255',
            'property_space' => 'required|numeric|min:1',
            'property_bedrooms' => 'required|integer|min:0',
            'property_estimated_price' => 'required|numeric|min:0',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB each
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // 🔹 2. Handle gallery images upload
        $imagePaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $ext = $file->getClientOriginalExtension();
                $filename = uniqid('property_') . '.' . $ext;

                $file->move(public_path('admin-assets/img/clients/properties'), $filename);

                $imagePaths[] = 'admin-assets/img/clients/properties/' . $filename;
            }
        }

        // 🔹 3. Save all data in Client model
        $client = new Client();
        $client->type = $validated['type'];
        $client->name = $validated['name'];
        $client->phone = $validated['phone'];
        $client->email = $validated['email'];
        $client->property_address = $validated['property_address'];
        $client->property_space = $validated['property_space'];
        $client->property_bedrooms = $validated['property_bedrooms'];
        $client->property_estimated_price = $validated['property_estimated_price'];
        $client->property_images = implode(',', $imagePaths);
        $client->save();

        // 🔹 Send email to admin
        $settings = SiteSetting::find(1);
        $adminEmail = $settings->site_email ?? 'admin@example.com';

        try {
            Mail::to($adminEmail)->send(new ClientPropertyMail($client));
            Log::info("✅ Client property email sent to admin: {$adminEmail}");
        } catch (\Exception $e) {
            Log::error("❌ Failed to send client property email: " . $e->getMessage());
        }

        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = 'New Client has been submited property';
        $notification->notification_for = 'Client Property';
        $notification->item_id = $client->id;
        $notification->save();

        Log::info("✅ New client inquiry saved (ID: {$client->id})");

        // 🔹 4. Return JSON success
        return response()->json([
            'status' => 'success',
            'message' => 'Your property inquiry has been submitted successfully!'
        ]);
    }
}

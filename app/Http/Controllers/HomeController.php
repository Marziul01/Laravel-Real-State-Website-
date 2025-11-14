<?php

namespace App\Http\Controllers;

use App\Mail\InquiryReceived;
use App\Models\AboutPage;
use App\Models\AgentPage;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Carrer;
use App\Models\Country;
use App\Models\District;
use App\Models\Gallery;
use App\Models\HomePage;
use App\Models\Inquiry;
use App\Models\Notification;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Review;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\State;
use App\Models\Team;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Sabberworm\CSS\Settings;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public static function index(){
        $properties = Property::where('status', 1 )->get();
        // ✅ Get dynamic min & max values from existing properties
        $minPrice = $properties->min('price') ?? 0;
        $maxPrice = $properties->max('price') ?? 1000;

        $minBedrooms = $properties->min('bedrooms') ?? 0;
        $maxBedrooms = $properties->max('bedrooms') ?? 5;

        $minBathrooms = $properties->min('bathrooms') ?? 0;
        $maxBathrooms = $properties->max('bathrooms') ?? 5;
        return view('frontend.home.home' , [
            'properties' => $properties,
            'districts' => District::all(),
            'property_categories' => PropertyType::all(),
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'minBedrooms' => $minBedrooms,
            'maxBedrooms' => $maxBedrooms,
            'minBathrooms' => $minBathrooms,
            'maxBathrooms' => $maxBathrooms,
            'countries' => Country::all(),
            'services' => Service::all(),
            'sliders' => Slider::all(),
            'homepage' => HomePage::first(),
            'teams' => Team::all(),
            'reviews' => Review::all(),
         ]);
    }

    public function showInvoice($id)
    {
        $booking = Booking::findOrFail($id);

        // ✅ Use the same Blade view used for the email invoice
        $pdf = Pdf::loadView('emails.invoice_pdf', compact('booking'));

        // ✅ Stream the PDF in a new tab instead of downloading
        return $pdf->stream('Invoice-' . $booking->id . '.pdf');
    }

    public function propertyInquiry(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'required|email',
            'country_id' => 'required|string',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required',
            'demands' => 'required|array',
            'message' => 'required|string|max:500',
        ]);

        $inquiry = Inquiry::create([
            'property_id' => $property->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'country_id' => $validated['country_id'],
            'schedule_date' => $validated['schedule_date'],
            'schedule_time' => $validated['schedule_time'],
            'demands' => implode(',', $validated['demands']),
            'message' => $validated['message'],
        ]);

        // ✅ Get admin email
        $settings = SiteSetting::find(1);
        $adminEmail = $settings->site_email ?? 'admin@example.com';

        // ✅ Send email immediately, log if fails
        try {
            Mail::to($adminEmail)->send(new InquiryReceived($inquiry));
            
            Log::info("Inquiry email sent to admin: {$adminEmail}");
        } catch (\Exception $e) {
            Log::error("Inquiry email failed: " . $e->getMessage());
        }

        $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = 'New Property Inquiry has been created';
            $notification->notification_for = 'Property Inquiry';
            $notification->item_id = $inquiry->id;
            $notification->save();

        return response()->json(['status' => 'success', 'message' => 'Inquiry sent successfully!']);
    }

    public static function rent(Request $request){

        $filters = $request;
        
        $query = Property::where('status', 1);

        // ✅ If "type=rent" is passed in the URL, filter for only rent properties
        if ($request->type === 'rent') {
            $query->where('type', 'rent');
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->property_type_id) {
            $query->where('property_type_id', $request->property_type_id);
        }

        if ($request->min_price && $request->max_price) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        if ($request->bedrooms) {
            $query->where('bedrooms', $request->bedrooms);
        }

        if ($request->type === 'rent' && $request->rent_date_range) {
            [$start, $end] = explode(' to ', str_replace(' - ', ' to ', $request->rent_date_range));

            $query->where('rent_start', '<=', $start) // ✅ must be available to rent by this date
                ->whereDoesntHave('bookings', function($q) use ($start, $end) {
                    $q->where(function($sub) use ($start, $end) {
                        $sub->whereBetween('start_date', [$start, $end])
                            ->orWhereBetween('end_date', [$start, $end])
                            ->orWhere(function($inner) use ($start, $end) {
                                $inner->where('start_date', '<', $start)
                                        ->where('end_date', '>', $end);
                            });
                    });
                });
        }

        if ($request->country_id) {
            $query->where('country_id', $request->country_id);

            if ($request->country_id == 19) {
                // 🇧🇩 Bangladesh-specific filtering
                if ($request->district_id) {
                    $query->where('state_id', $request->district_id);
                }

                if ($request->upazila_id) {
                    $query->where('property_area_id', $request->upazila_id);
                }

                if ($request->city) {
                    $query->where('city', 'like', "%{$request->city}%");
                }

            } else {
                // 🌍 Other countries
                if ($request->state_id) {
                    $query->where('state_id', $request->state_id);
                }

                if ($request->city) {
                    $query->where('city', 'like', "%{$request->city}%");
                }
            }
        }

        $properties = $query->latest()->paginate(25);

        $lowestPrice  = Property::min('price') ?? 0;
        $highestPrice = Property::max('price') ?? 1000000;
        $countries = Country::where('status',1)->get();

        return view('frontend.property.properties',[
            'properties' => $properties,
            'lowestPrice' => $lowestPrice,
            'highestPrice' => $highestPrice,
            'countries' => $countries,
            'request' => $request,
        ]);
    }

    public function filter(Request $request)
    {
        $query = Property::query();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->property_type_id) {
            $query->where('property_type_id', $request->property_type_id);
        }

        if ($request->min_price && $request->max_price) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        if ($request->bedrooms) {
            $query->where('bedrooms', $request->bedrooms);
        }

        if ($request->bathrooms) {
            $query->where('bathrooms', $request->bathrooms);
        }

        if ($request->parking_space) {
            $query->where('parking_space', $request->parking_space);
        }

        // ✅ Date filter only for rent type
        if ($request->type === 'rent' && $request->rent_date_range) {
            [$start, $end] = explode(' to ', str_replace(' - ', ' to ', $request->rent_date_range));

            $query->where('rent_start', '<=', $start) // ✅ must be available to rent by this date
                ->whereDoesntHave('bookings', function($q) use ($start, $end) {
                    $q->where(function($sub) use ($start, $end) {
                        $sub->whereBetween('start_date', [$start, $end])
                            ->orWhereBetween('end_date', [$start, $end])
                            ->orWhere(function($inner) use ($start, $end) {
                                $inner->where('start_date', '<', $start)
                                        ->where('end_date', '>', $end);
                            });
                    });
                });
        }

        // ✅ Order by
        if ($request->order === 'low_high') {
            $query->orderBy('price', 'asc');
        } elseif ($request->order === 'high_low') {
            $query->orderBy('price', 'desc');
        }

        if ($request->country_id) {
            $query->where('country_id', $request->country_id);

            if ($request->country_id == 19) {
                // 🇧🇩 Bangladesh-specific filtering
                if ($request->district_id) {
                    $query->where('state_id', $request->district_id);
                }

                if ($request->upazila_id) {
                    $query->where('property_area_id', $request->upazila_id);
                }

                if ($request->city) {
                    $query->where('city', 'like', "%{$request->city}%");
                }

            } else {
                // 🌍 Other countries
                if ($request->state_id) {
                    $query->where('state_id', $request->state_id);
                }

                if ($request->city) {
                    $query->where('city', 'like', "%{$request->city}%");
                }
            }
        }


        $properties = $query->where('status' , 1)->paginate($request->per_page ?? 25);

        return view('frontend.property.property_list', compact('properties'))->render();
    }

    public function getDistricts()
    {
        return response()->json(District::orderBy('name')->get());
    }

    public function getUpazilas($districtId)
    {
        return response()->json(Upazila::where('district_id', $districtId)->orderBy('name')->get());
    }

    public function getStates($countryId)
    {
        return response()->json(State::where('country_id', $countryId)->orderBy('name')->get());
    }

    public function getCitiesByUpazila($upazilaId)
    {
        // ✅ Get all cities from properties where property_area_id = selected upazila
        $cities = Property::where('property_area_id', $upazilaId)
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city');

        return response()->json($cities);
    }

    public function getCitiesByState($stateId)
    {
        // ✅ Get all cities from properties where state_id = selected state
        $cities = Property::where('state_id', $stateId)
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city');

        return response()->json($cities);
    }

    public function services(Request $request, $slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();

        return view('frontend.services.service_details', [
            'service' => $service,
            'countries' => Country::all(),
        ]);
    }

    public function service()
    {
        $services = Service::all();

        return view('frontend.services.service', [
            'services' => $services,
            'countries' => Country::all(),
        ]);
    }

    public function about()
    {
        $services = Service::all();
        $about = AboutPage::first();
        return view('frontend.pages.about', [
            'services' => $services,
            'countries' => Country::all(),
            'about' => $about,
            'teams' => Team::all(),
        ]);
    }

    public static function contact()
    {
        $services = Service::all();
        return view('frontend.pages.contact', [
            'services' => $services,
            'countries' => Country::all(),
        ]);
    }

    public function blog()
    {
        $blogs = Blog::latest()->paginate(12);
        $services = Service::all();
        return view('frontend.blogs.blog', [
            'blogs' => $blogs,
            'countries' => Country::all(),
            'services' => $services,
        ]);
    }

    public function blogDetails(Request $request,  $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $services = Service::all();
        $relatedPosts = Blog::where('id', '!=', $blog->id)
        // ->where(function($q) use ($blog) {
        //     foreach (explode(',', $blog->tags) as $tag) {
        //         $q->orWhere('tags', 'like', '%' . trim($tag) . '%');
        //     }
        // })
        ->take(4)->get();
        return view('frontend.blogs.blog_details', [
            'blog' => $blog,
            'countries' => Country::all(),
            'services' => $services,
            'relatedPosts' => $relatedPosts,
        ]);
    }


    public function carrer()
    {
        $services = Service::all();
        $careers = Carrer::latest()->paginate(10);
        $countries = Country::all();
        return view('frontend.pages.careers', compact('careers','services','countries'));
    }

    public function carrershow($id)
    {
        $services = Service::all();
        $career = Carrer::findOrFail($id);
        $countries = Country::all();
        return view('frontend.pages.career-details', compact('career','services','countries'));
    }

    public function gallery()
    {
        $services = Service::all();
        $galleryImages = Gallery::latest()->get();
        return view('frontend.pages.gallery', [
            'countries' => Country::all(),
            'services' => $services,
            'galleryImages' => $galleryImages,
        ]);
    }

    public function Agents()
    {
        $services = Service::all();
        
        return view('frontend.pages.agents', [
            'countries' => Country::all(),
            'services' => $services,
            'agentpage' => AgentPage::first(),
        ]);
    }

    public function documentServices()
    {
        $docunment = Service::where('type', 'LIKE', '%Property Document Services%')->get();
        $services = Service::all();
        return view('frontend.pages.document_services', [
            'countries' => Country::all(),
            'services' => $services,
            'docunments' => $docunment,
        ]);
    }
}

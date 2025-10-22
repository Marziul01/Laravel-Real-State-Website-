@extends('frontend.master')

@section('title')
{{ $property->name }}
@endsection

@section('description')
{{ $property->description }}
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Property > {{ $property->name }} </p>
        </div>
    </div>
    <div class="container propertyView">
        
        <div class="row py-3 ">
            <div class="col-md-8">
                <h3 class="mb-3">{{ $property->name }}</h3>
                <div class="property-tags mb-4">
                    <span class="tag">{{ $property->propertyType->property_type }}</span>
                    @if ($property->property_listing)
                        @foreach (explode(',', $property->property_listing) as $listing)
                            <span class="tag">{{ trim($listing) }}</span>
                        @endforeach
                    @endif
                </div>
                <div class="property-info mb-4">
                    @if($property->space)
                        <div class="tag">
                            <i class="fa-regular fa-house"></i>
                            Property Space : SFT {{ $property->space }}
                        </div>
                    @endif

                    @if($property->country_id == 19 && ($property->city || $property->propertyarea))
                        <div class="tag">
                            <i class="fa-solid fa-location-dot"></i>
                            Property Area : {{ $property->city . ', ' . $property->propertyarea->name }}
                        </div>
                    @elseif($property->country_id != 19 && ($property->city || $property->state))
                        <div class="tag">
                            <i class="fa-solid fa-location-dot"></i>
                            Property Area : {{ $property->city . ', ' . $property->state->name }}
                        </div>
                    @endif

                    @if($property->bedrooms)
                        <div class="tag">
                            <i class="fa-solid fa-bed"></i>
                            Bedrooms : {{ $property->bedrooms }}
                        </div>
                    @endif

                    @if($property->bathrooms)
                        <div class="tag">
                            <i class="fa-solid fa-sink"></i>
                            Bathrooms : {{ $property->bathrooms }}
                        </div>
                    @endif

                    @if($property->parking_space)
                        <div class="tag">
                            <i class="fa-solid fa-car"></i>
                            Parking Space : {{ $property->parking_space }}
                        </div>
                    @endif

                    @if($property->decoration)
                        <div class="tag">
                            @if ($property->decoration == 'Full Furnished')
                                <i class="fa-solid fa-couch"></i>
                                Decoration : {{ $property->decoration }}
                            @else
                                <i class="fa-solid fa-paint-roller"></i>
                                Decoration : {{ $property->decoration }}
                            @endif
                        </div>
                    @endif

                </div>
                <div class="swiper mySwiper mb-3">
                    <div class="swiper-wrapper">
                        @if ($property->featured_image)
                            <div class="swiper-slide">
                                <img class="slider-img" src="{{ asset($property->featured_image) }}" alt="">
                            </div>
                        @endif
                        @if ($property->images->isNotEmpty())
                            @foreach ($property->images as $images )
                                <div class="swiper-slide">
                                    <img class="slider-img" src="{{ asset($images->image) }}" alt="">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <hr>
                <div class="py-4">
                    <h4 class="mb-3">Discription :</h4>
                    {{ $property->description }}
                </div>
                <hr>
                <div class="py-4">
                    <h4 class="mb-3">Property Features :</h4>
                    <div class="grid-container">
                        @if ($property->features)
                            @foreach ($property->features as $feature )
                                <p class="mb-1"><strong> {{ $feature->feature_keys }} : </strong> {{ $feature->feature_values }} </p>
                            @endforeach
                        @endif
                    </div>
                </div>
                <hr>
                <div class="py-4">
                    <h4 class="mb-3">Amenities :</h4>
                    <div class="grid-container">
                        @if ($property->amenities)
                            @foreach ($property->amenities as $amenity )
                                <p class="mb-1"><i class="fa-solid fa-check-double"></i> {{ $amenity->amenities }} </p>
                            @endforeach
                        @endif
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-4">
                    <div>
                        <h5>
                            <i class="fa-solid fa-wallet"></i> Price : <span id="pricePerNight">{{ $property->price }}</span> BDT <sup> (per night)</sup>
                        </h5>
                        <div>
                            <a href="" class="btn btn-primary"><i class="fa-solid fa-envelope"></i> Property Inquiry</a>
                            <a href="" class="btn btn-primary" onclick="print()"><i class="fa-solid fa-print"></i></a>
                        </div>
                        <form id="rentProperty" class="mt-3">
                            @csrf
                            <div class="mb-3">
                                <input type="text" id="rentDateRange" class="form-control" placeholder="Select Booking Dates" readonly>
                            </div>
                            <h6 class="mt-2">
                                Total Price: <span id="totalPrice">0</span> BDT
                            </h6>
                            <button type="submit" class="btn btn-primary w-100 " {{ Auth::check() ? ' ' : 'disabled' }}>
                                <i class="fa-regular fa-calendar-check"></i> {{ Auth::check() ? 'Book Now ' : 'Please Login to Rent !' }}
                            </button>
                        </form>
                    </div>
                    <hr>
                    <div>
                        <p>Property Location :</p>
                        @php
                            use App\Models\District;

                            if ($property->country_id == 19) {
                                $district = District::where('id', $property->property_area_id)->first();
                                $address = $property->road . ', ' . $property->city . ', ' . ($property->propertyarea->name ?? '') . ', ' . ($district->name ?? '') . ', ' . ($property->country->name ?? '');
                            } else {
                                $address = $property->road . ', ' . $property->city . ', ' . ($property->state->name ?? '') . ', ' . ($property->country->name ?? '');
                            }
                        @endphp

                        <iframe
                            width="100%"
                            height="400"
                            style="border:0"
                            loading="lazy"
                            allowfullscreen
                            src="https://www.google.com/maps?q={{ urlencode($address ?? 'Dhaka, Bangladesh') }}&output=embed">
                        </iframe>

                    </div>
                    <hr>
                    <div>
                        <p>Realtor :</p>
                        <div class="row border m-0 rounded p-3">
                            <div class="col-md-4">
                                <img src="{{ asset('admin-assets/img/assets/1746548373_681a369536d71.png') }}" style="width: 100% ;" alt="">
                            </div>
                            <div class="col-md-8">
                                <h4>{{ $property->realtor->name }}</h4>
                                <p class="mb-1">Email : {{ $property->realtor->email }}</p>
                                <p class="mb-1">Phone : {{ $property->realtor->mobile }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customJs')
<script>
        const swiper = new Swiper(".mySwiper", {
            loop: true,
            effect: "slide", // or "fade" for a smoother dissolve effect
            speed: 1500, // 1.5 seconds for smooth sliding
            autoplay: {
              delay: 5000, // 5 seconds before changing slides
              disableOnInteraction: false,
            },
            // autoplay: false,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const pricePerNight = parseFloat(document.getElementById('pricePerNight').innerText);
    const totalPriceEl = document.getElementById('totalPrice');
    const dateInput = document.getElementById('rentDateRange');

    // 📅 Fetch booked dates from backend (you’ll return them as array)
    const bookedDates = @json($bookedDates); // Example: ["2025-10-25", "2025-10-26", "2025-11-01"]
    const bookingStartDate = "{{ $property->rent_start }}"; // e.g. "2025-10-23"

    // ✅ Initialize Flatpickr
    flatpickr("#rentDateRange", {
        mode: "range",
        minDate: bookingStartDate,
        dateFormat: "Y-m-d",
        disable: bookedDates,
        onChange: function(selectedDates) {
            if (selectedDates.length === 2) {
                const diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // nights
                const total = diffDays * pricePerNight;
                totalPriceEl.innerText = total.toLocaleString();
            } else {
                totalPriceEl.innerText = 0;
            }
        }
    });

    // 🧾 Optional: Prevent form submission for now
    document.getElementById('rentProperty').addEventListener('submit', function(e) {
        e.preventDefault();
        const dateRange = dateInput.value;
        if (!dateRange) {
            toastr.error('Please select booking dates');
            return;
        }
        toastr.success('Booking form ready to submit!');
        // You can now send via AJAX if needed
    });
});
</script>
@endsection
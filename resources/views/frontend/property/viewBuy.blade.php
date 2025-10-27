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
            <div class="col-md-8 d-flex flex-column">
                <h3 class="mb-3 order-1">{{ $property->name }}</h3>
                <div class="property-tags mb-4 order-2">
                    <span class="tag">{{ $property->propertyType->property_type }}</span>
                    @if ($property->property_listing)
                        @foreach (explode(',', $property->property_listing) as $listing)
                            <span class="tag">{{ trim($listing) }}</span>
                        @endforeach
                    @endif
                </div>
                <div class="mb-4 d-block d-md-none order-3">
                        <h5>
                            <i class="fa-solid fa-wallet"></i> Price : <span id="pricePerNight">{{ $property->price }}</span> BDT
                        </h5>
                        <div>
                            <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                                <i class="fa-solid fa-envelope"></i> Property Inquiry
                            </a>
                            <a href="{{ route('property.print', $property->id) }}" target="_blank" class="btn btn-primary">
                                <i class="fa-solid fa-print"></i>
                            </a>
                        </div>
                    </div>
                <div class="property-info viewProperty mb-4 order-4 order-md-3">
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
                <div class="swiper mySwiper viewProperty mb-3 order-3 order-md-4">
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
                <hr class="order-5">
                <div class="py-4 order-6">
                    <h4 class="mb-3">Discription :</h4>
                    {{ $property->description }}
                </div>
                <hr class="order-7">
                <div class="py-4 order-8">
                    <h4 class="mb-3">Property Features :</h4>
                    <div class="grid-container">
                        @if ($property->features)
                            @foreach ($property->features as $feature )
                                <p class="mb-1"><strong> {{ $feature->feature_keys }} : </strong> {{ $feature->feature_values }} </p>
                            @endforeach
                        @endif
                    </div>
                </div>
                <hr class="order-9">
                <div class="py-4 order-10">
                    <h4 class="mb-3">Amenities :</h4>
                    <div class="grid-container">
                        @if ($property->amenities)
                            @foreach ($property->amenities as $amenity )
                                <p class="mb-1"><i class="fa-solid fa-check-double"></i> {{ $amenity->amenities }} </p>
                            @endforeach
                        @endif
                    </div>
                </div>
                {{-- <hr> --}}
            </div>
            <div class="col-md-4">
                <div class="border rounded p-4">
                    <div class="d-none d-md-block">
                        <h5>
                            <i class="fa-solid fa-wallet"></i> Price : <span id="pricePerNight">{{ $property->price }}</span> BDT
                        </h5>
                        <div>
                            <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                                <i class="fa-solid fa-envelope"></i> Property Inquiry
                            </a>
                            <a href="{{ route('property.print', $property->id) }}" target="_blank" class="btn btn-primary">
                                <i class="fa-solid fa-print"></i>
                            </a>
                        </div>
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
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header bg-dark text-white rounded-top-4">
                <h5 class="modal-title" id="inquiryModalLabel">Product Inquiry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light p-4">
                <!-- Property Info -->
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset($property->featured_image) }}" alt="Product" class="rounded me-3" style="width:100px; height:80px; object-fit:cover;">
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $property->name }}</h6>
                    </div>
                </div>

                <!-- Inquiry Form -->
                <form id="inquiryForm" class=" position-relative" action="{{ route('property.inquiries', $property->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Your Name" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input id="phoneInquiry" type="tel" name="phone" class="form-control" placeholder="e.g. +880..." required>
                            <small id="phoneErrorInquiry" class="text-danger"></small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Your Email Address" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Living Country</label>
                            <select name="country_id" class="form-select" required>
                                <option value="">Select Your Living Country</option>
                                @if ($countries->isNotEmpty())
                                    @foreach ($countries as $country )
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Set Your Schedule (BD Time)</label>
                            <input type="date" name="schedule_date" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Preferred Time</label>
                            <input type="time" name="schedule_time" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Select Multiple Demands</label>
                            <select name="demands[]" class="form-select" id="demands" multiple required>
                                <option value="Buy">Buy</option>
                                <option value="Rent">Rent</option>
                                <option value="Investment">Investment</option>
                                <option value="Consultation">Consultation</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Your Message</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Go ahead, we are listening..." required></textarea>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">Send Inquiry</button>
                    </div>
                    <div id="formLoaderbooking" class="form-loader d-none">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('customJs')
<script>
        const swiper = new Swiper(".mySwiper", {
            loop: false,
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
document.addEventListener('DOMContentLoaded', function () {
    // ✅ Initialize Select2
    $('#inquiryModal').on('shown.bs.modal', function() {
        $('#demands').select2({
            dropdownParent: $('#inquiryModal'),
            width: '100%',
            placeholder: "Select Multiple Demands",
            allowClear: true
        });
    });

    // ✅ Initialize intl-tel-input for phone field
    const phoneInput = document.querySelector("#phoneInquiry");
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "bd",
        preferredCountries: ["bd", "in", "us", "gb"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });

    // ✅ Handle form submit via AJAX
    $('#inquiryForm').on('submit', function (e) {
        e.preventDefault();

        const phoneError = document.querySelector('#phoneErrorInquiry');
        phoneError.textContent = '';

        // ✅ Validate phone number
        if (!iti.isValidNumber()) {
            phoneError.textContent = 'Please enter a valid phone number.';
            return;
        }

        // ✅ Prepare data
        const formData = new FormData(this);
        formData.set('phone', iti.getNumber()); // replace raw phone with full intl format

        const actionUrl = $(this).attr('action');

        const loader = document.getElementById('formLoaderbooking');
        loader.classList.remove('d-none');
        // ✅ Send AJAX request
        fetch(actionUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            loader.classList.add('d-none');
            if (data.status === 'success') {
                toastr.success(data.message);
                $('#inquiryForm')[0].reset();
                $('#demands').val(null).trigger('change');
                const modal = bootstrap.Modal.getInstance(document.getElementById('inquiryModal'));
                modal.hide();
            } else {
                toastr.error(data.message || 'Something went wrong.');
            }
        })
        .catch(() => {
            loader.classList.add('d-none');
            toastr.error('An error occurred. Please try again.');
        });
    });
});
</script>
@endsection
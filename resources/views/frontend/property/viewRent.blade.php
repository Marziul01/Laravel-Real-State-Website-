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

                <div class="rent-section property-pricings mb-3 d-block d-md-none order-4">

                    <ul class="nav nav-tabs mb-3 border-0" id="bookingTabs">

                        {{-- Per Night Tab --}}
                        @if ($property->price)
                            <li class="nav-item">
                                <button class="nav-link active" data-type="per-night" data-bs-toggle="tab"
                                    data-bs-target="#perNightTab1">
                                    Per Night
                                </button>
                            </li>
                        @endif

                        {{-- Weekly Tab --}}
                        @if ($property->weekly_price)
                            <li class="nav-item">
                                <button class="nav-link {{ !$property->price && $property->weekly_price ? 'active' : '' }}"
                                    data-type="weekly" data-bs-toggle="tab" data-bs-target="#weeklyTab1">
                                    Weekly
                                </button>
                            </li>
                        @endif

                        {{-- Monthly Tab --}}
                        @if ($property->monthly_price)
                            <li class="nav-item">
                                <button
                                    class="nav-link {{ !$property->price && !$property->weekly_price && $property->monthly_price ? 'active' : '' }}"
                                    data-type="monthly" data-bs-toggle="tab" data-bs-target="#monthlyTab1">
                                    Monthly
                                </button>
                            </li>
                        @endif

                    </ul>


                    <div class="tab-content">
                        @if ($property->price)
                            <!-- PER NIGHT -->
                            <div class="tab-pane fade show active" id="perNightTab1">
                                <h5>
                                    <i class="fa-solid fa-wallet"></i>
                                    Price: <span class="pricePerNight">{{ $property->price }}</span> BDT
                                    <sup>(per night)</sup>
                                </h5>

                                <div class="rentProperty mt-3">
                                    <input type="text" class="rentDateRange form-control"
                                        placeholder="Select Booking Dates" readonly>

                                    <h6 class="mt-2">Total Price: <span class="totalPrice">0</span> BDT</h6>

                                    <input type="hidden" class="bookingType" value="per-night">

                                    <a href="#"
                                        class="rentSubmitBtn btn btn-primary w-100 {{ Auth::check() ? '' : 'disabled' }}">
                                        <i class="fa-regular fa-calendar-check"></i>
                                        {{ Auth::check() ? 'Book Now' : 'Please Login to Rent !' }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Weekly Tab --}}
                        @if ($property->weekly_price)
                            <div class="tab-pane fade" id="weeklyTab1">
                                <h5>
                                    <i class="fa-solid fa-wallet"></i>
                                    Weekly Price: <span class="priceWeekly">{{ $property->weekly_price }}</span> BDT
                                    <sup>(per week)</sup>
                                </h5>

                                <div class="rentProperty mt-3">
                                    <input type="text" class="weeklyDateRange form-control"
                                        placeholder="Select Weekly Booking" readonly>
                                    <div class="weeklyError text-danger small mt-1"></div>
                                    <h6 class="mt-2">Total Price: <span class="totalWeeklyPrice">0</span> BDT</h6>

                                    <input type="hidden" class="bookingType" value="weekly">
                                    

                                    <a href="#"
                                        class="rentSubmitBtnWeekly btn btn-primary w-100 {{ Auth::check() ? '' : 'disabled' }}">
                                        <i class="fa-regular fa-calendar-check"></i>
                                        {{ Auth::check() ? 'Book Weekly' : 'Please Login to Rent !' }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Monthly Tab --}}
                        @if ($property->monthly_price)
                            <div class="tab-pane fade" id="monthlyTab1">
                                <h5>
                                    <i class="fa-solid fa-wallet"></i>
                                    Monthly Price: <span class="priceMonthly">{{ $property->monthly_price }}</span> BDT
                                    <sup>(per month)</sup>
                                </h5>

                                <div class="rentProperty mt-3">
                                    <input type="text" class="monthlyDateRange form-control"
                                        placeholder="Select Monthly Booking" readonly>
                                    <div class="monthlyError text-danger small mt-1"></div>
                                    <h6 class="mt-2">Total Price: <span class="totalMonthlyPrice">0</span> BDT</h6>

                                    <input type="hidden" class="bookingType" value="monthly">
                                    

                                    <a href="#"
                                        class="rentSubmitBtnMonthly btn btn-primary w-100 {{ Auth::check() ? '' : 'disabled' }}">
                                        <i class="fa-regular fa-calendar-check"></i>
                                        {{ Auth::check() ? 'Book Monthly' : 'Please Login to Rent !' }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- <div class="rent-section mb-4 ">
                    <h5>
                        <i class="fa-solid fa-wallet"></i>
                        Price : <span class="pricePerNight">{{ $property->price }}</span> BDT
                        <sup>(per night)</sup>
                    </h5>

                    <div>
                        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#inquiryModal">
                            <i class="fa-solid fa-envelope"></i> Property Inquiry
                        </a>
                        <a href="{{ route('property.print', $property->id) }}" target="_blank" class="btn btn-primary">
                            <i class="fa-solid fa-print"></i>
                        </a>
                    </div>

                    <div class="rentProperty mt-3">
                        <div class="mb-3">
                            <input type="text" class="rentDateRange form-control" placeholder="Select Booking Dates"
                                readonly>
                        </div>

                        <h6 class="mt-2">
                            Total Price: <span class="totalPrice">0</span> BDT
                        </h6>

                        <a href="#" class="rentSubmitBtn btn btn-primary w-100 {{ Auth::check() ? '' : 'disabled' }}">
                            <i class="fa-regular fa-calendar-check"></i>
                            {{ Auth::check() ? 'Book Now' : 'Please Login to Rent !' }}
                        </a>
                    </div>
                </div> --}}

                <div class="property-info mb-4  order-4 order-md-3">
                    @if ($property->space)
                        <div class="tag">
                            <i class="fa-regular fa-house"></i>
                            Property Space : SFT {{ $property->space }}
                        </div>
                    @endif

                    @if ($property->country_id == 19 && ($property->city || $property->propertyarea))
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

                    @if ($property->bedrooms)
                        <div class="tag">
                            <i class="fa-solid fa-bed"></i>
                            Bedrooms : {{ $property->bedrooms }}
                        </div>
                    @endif

                    @if ($property->bathrooms)
                        <div class="tag">
                            <i class="fa-solid fa-sink"></i>
                            Bathrooms : {{ $property->bathrooms }}
                        </div>
                    @endif

                    @if ($property->parking_space)
                        <div class="tag">
                            <i class="fa-solid fa-car"></i>
                            Parking Space : {{ $property->parking_space }}
                        </div>
                    @endif

                    @if ($property->decoration)
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

                    @if ($property->check_in)
                        <div class="tag">
                            <i class="fa-regular fa-clock"></i>
                            Check In Time : {{ $property->check_in }}
                        </div>
                    @endif
                    @if ($property->check_out)
                        <div class="tag">
                            <i class="fa-regular fa-clock"></i>
                            Check Out Time : {{ $property->check_out }}
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
                            @foreach ($property->images as $images)
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
                            @foreach ($property->features as $feature)
                                <p class="mb-1"><strong> {{ $feature->feature_keys }} : </strong>
                                    {{ $feature->feature_values }} </p>
                            @endforeach
                        @endif
                    </div>
                </div>
                <hr class="order-9">
                <div class="py-4 order-10">
                    <h4 class="mb-3">Amenities :</h4>
                    <div class="grid-container">
                        @if ($property->amenities)
                            @foreach ($property->amenities as $amenity)
                                <p class="mb-1"><i class="fa-solid fa-check-double"></i> {{ $amenity->amenities }} </p>
                            @endforeach
                        @endif
                    </div>
                </div>
                {{-- <hr> --}}
            </div>
            <div class="col-md-4">
                {{-- <div class="rent-section property-pricings mb-3">
                    <h5>
                            <i class="fa-solid fa-wallet"></i>
                            Price : <span class="pricePerNight">{{ $property->price }}</span> BDT
                            <sup>(per night)</sup>
                        </h5>
                        <div class="rentProperty mt-3">
                            <div class="mb-3">
                                <input type="text" class="rentDateRange form-control" placeholder="Select Booking Dates"
                                    readonly>
                            </div>

                            <h6 class="mt-2">
                                Total Price: <span class="totalPrice">0</span> BDT
                            </h6>

                            <a href="#"
                                class="rentSubmitBtn btn btn-primary w-100 {{ Auth::check() ? '' : 'disabled' }}">
                                <i class="fa-regular fa-calendar-check"></i>
                                {{ Auth::check() ? 'Book Now' : 'Please Login to Rent !' }}
                            </a>
                        </div>
                </div> --}}
                <div class="rent-section property-pricings mb-3 d-none d-md-block">

                    <ul class="nav nav-tabs mb-3 border-0" id="bookingTabs">

                        {{-- Per Night Tab --}}
                        @if ($property->price)
                            <li class="nav-item">
                                <button class="nav-link active" data-type="per-night" data-bs-toggle="tab"
                                    data-bs-target="#perNightTab">
                                    Per Night
                                </button>
                            </li>
                        @endif

                        {{-- Weekly Tab --}}
                        @if ($property->weekly_price)
                            <li class="nav-item">
                                <button class="nav-link {{ !$property->price && $property->weekly_price ? 'active' : '' }}"
                                    data-type="weekly" data-bs-toggle="tab" data-bs-target="#weeklyTab">
                                    Weekly
                                </button>
                            </li>
                        @endif

                        {{-- Monthly Tab --}}
                        @if ($property->monthly_price)
                            <li class="nav-item">
                                <button
                                    class="nav-link {{ !$property->price && !$property->weekly_price && $property->monthly_price ? 'active' : '' }}"
                                    data-type="monthly" data-bs-toggle="tab" data-bs-target="#monthlyTab">
                                    Monthly
                                </button>
                            </li>
                        @endif

                    </ul>


                    <div class="tab-content">
                        @if ($property->price)
                            <!-- PER NIGHT -->
                            <div class="tab-pane fade show active" id="perNightTab">
                                <h5>
                                    <i class="fa-solid fa-wallet"></i>
                                    Price: <span class="pricePerNight">{{ $property->price }}</span> BDT
                                    <sup>(per night)</sup>
                                </h5>

                                <div class="rentProperty mt-3">
                                    <input type="text" class="rentDateRange form-control"
                                        placeholder="Select Booking Dates" readonly>

                                    <h6 class="mt-2">Total Price: <span class="totalPrice">0</span> BDT</h6>

                                    <input type="hidden" class="bookingType" value="per-night">

                                    <a href="#"
                                        class="rentSubmitBtn btn btn-primary w-100 {{ Auth::check() ? '' : 'disabled' }}">
                                        <i class="fa-regular fa-calendar-check"></i>
                                        {{ Auth::check() ? 'Book Now' : 'Please Login to Rent !' }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Weekly Tab --}}
                        @if ($property->weekly_price)
                            <div class="tab-pane fade" id="weeklyTab">
                                <h5>
                                    <i class="fa-solid fa-wallet"></i>
                                    Weekly Price: <span class="priceWeekly">{{ $property->weekly_price }}</span> BDT
                                    <sup>(per week)</sup>
                                </h5>

                                <div class="rentProperty mt-3">
                                    <input type="text" class="weeklyDateRange form-control"
                                        placeholder="Select Weekly Booking" readonly>
                                    <div class="weeklyError text-danger small mt-1"></div>
                                    <h6 class="mt-2">Total Price: <span class="totalWeeklyPrice">0</span> BDT</h6>

                                    <input type="hidden" class="bookingType" value="weekly">
                                    

                                    <a href="#"
                                        class="rentSubmitBtnWeekly btn btn-primary w-100 {{ Auth::check() ? '' : 'disabled' }}">
                                        <i class="fa-regular fa-calendar-check"></i>
                                        {{ Auth::check() ? 'Book Weekly' : 'Please Login to Rent !' }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Monthly Tab --}}
                        @if ($property->monthly_price)
                            <div class="tab-pane fade" id="monthlyTab">
                                <h5>
                                    <i class="fa-solid fa-wallet"></i>
                                    Monthly Price: <span class="priceMonthly">{{ $property->monthly_price }}</span> BDT
                                    <sup>(per month)</sup>
                                </h5>

                                <div class="rentProperty mt-3">
                                    <input type="text" class="monthlyDateRange form-control"
                                        placeholder="Select Monthly Booking" readonly>
                                    <div class="monthlyError text-danger small mt-1"></div>
                                    <h6 class="mt-2">Total Price: <span class="totalMonthlyPrice">0</span> BDT</h6>

                                    <input type="hidden" class="bookingType" value="monthly">
                                    

                                    <a href="#"
                                        class="rentSubmitBtnMonthly btn btn-primary w-100 {{ Auth::check() ? '' : 'disabled' }}">
                                        <i class="fa-regular fa-calendar-check"></i>
                                        {{ Auth::check() ? 'Book Monthly' : 'Please Login to Rent !' }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="border rounded p-4">
                    <div class="rent-section ">


                        <div>
                            <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#inquiryModal">
                                <i class="fa-solid fa-envelope"></i> Property Inquiry
                            </a>
                            <a href="{{ route('property.print', $property->id) }}" target="_blank"
                                class="btn btn-primary">
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
                                $address =
                                    $property->road .
                                    ', ' .
                                    $property->city .
                                    ', ' .
                                    ($property->propertyarea->name ?? '') .
                                    ', ' .
                                    ($district->name ?? '') .
                                    ', ' .
                                    ($property->country->name ?? '');
                            } else {
                                $address =
                                    $property->road .
                                    ', ' .
                                    $property->city .
                                    ', ' .
                                    ($property->state->name ?? '') .
                                    ', ' .
                                    ($property->country->name ?? '');
                            }
                        @endphp

                        <iframe width="100%" height="300" style="border:0" loading="lazy" allowfullscreen
                            src="https://www.google.com/maps?q={{ urlencode($address ?? 'Dhaka, Bangladesh') }}&output=embed">
                        </iframe>

                    </div>
                    @if ($property->realtor)
                        <hr>
                        <div>
                            <p>Realtor :</p>
                            <div class="row border m-0 rounded p-3">
                                <div class="col-md-4">
                                    <img src="{{ asset('admin-assets/img/assets/1746548373_681a369536d71.png') }}"
                                        style="width: 100% ;" alt="">
                                </div>
                                <div class="col-md-8">
                                    <h4>{{ $property->realtor->name }}</h4>
                                    <p class="mb-1 realtor-email">Email : {{ $property->realtor->email }}</p>
                                    <p class="mb-1">Phone : {{ $property->realtor->phone }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-3">
                    @php
                    function renderStars($rating) {
                        $fullStars = floor($rating);
                        $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;
                    @endphp

                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="fas fa-star text-warning"></i>
                    @endfor

                    @if ($halfStar)
                        <i class="fas fa-star-half-alt text-warning"></i>
                    @endif

                    @for ($i = 0; $i < $emptyStars; $i++)
                        <i class="far fa-star text-warning"></i>
                    @endfor

                    @php
                    } // end function
                    @endphp

                    <p class="mb-2">Reviews :</p>
                    @php
                    $totalReviews = $reviews->count();
                    $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;
                    @endphp

                    <div class="average-rating mb-2">
                        @if($totalReviews > 0)
                            {!! renderStars($averageRating) !!}
                            <span class="ms-2">({{ number_format($averageRating, 1) }}/5 from {{ $totalReviews }} reviews)</span>
                        @else
                            {!! renderStars($averageRating) !!}
                            <span>( No reviews found. )</span>
                        @endif
                    </div>
                    <div class="swiper-container review-slider">
                        <div class="swiper-wrapper">
                        @if ($reviews->isNotEmpty())
                            @foreach ($reviews as $review)
                                <div class="swiper-slide">
                                    <div class="review-card property-reviews">
                                        <div class="stars mb-3">
                                            @for ($i = 0; $i < $review->rating; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        <p class="review-text">{{ $review->comment }}</p>

                                        <div class="reviewer-info d-flex align-items-center mt-4">
                                            <div class="text-start">
                                                <p class="reviewer-name">{{ $review->user_id ? $review->user->name : $review->name }}</p>
                                                <p class="reviewer-role">{{ $review->property_id ? 'Property: ' .$review->property->name : 'Service: ' . $review->service->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container  py-5">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="reviews-title">Related PROPERTIES</h3>
                <a href="{{ route('rent', ['type' => 'rent']) }}">View All <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="grid-container mt-4">
                @if ($properties->where('type', 'rent')->where('id', '!=', $property->id)->isNotEmpty())
                    @foreach ($properties->where('type', 'rent')->where('id', '!=', $property->id)->sortByDesc('created_at')->take(4) as $related)
                        <a href="{{ $related->type == 'rent' ? route('view.rent.property', $related->slug) : route('view.buy.property', $related->slug) }}"
                            class="no-hover-color-link">
                            <div class="property-card position-relative">
                                <img src="{{ asset($related->featured_image) }}" class="property-img"
                                    alt="Property Image">
                                <div class="property-tags propertyTypeFixed">
                                   <div class="property-tags propertyTypeFixed">
                                            @if ($related->property_listing)
                                                @foreach (explode(',', $related->property_listing) as $listing)
                                                    @if ($listing != 'New')
                                                        <span class="tag">{{ trim($listing) }}</span>
                                                    @endif
                                                    @if ($listing == 'New')
                                                        <img src="{{ asset('frontend-assets/images/svgviewer-png-output (1).png') }}" class="tag-image">
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                </div>
                                <div class="property-details">
                                    <div class="property-title">{{ $related->name }}</div>
                                    <div class="property-tags">
                                        <span class="tag">{{ $related->propertyType->property_type }}</span>
                                    </div>

                                    <div class="property-info">
                                        @if ($related->space)
                                            <div class="">
                                                <i class="fa-regular fa-house"></i>
                                                SFT {{ $related->space }}
                                            </div>
                                        @endif

                                        @if ($related->country_id == 19 && ($related->city || $related->propertyarea))
                                            <div class="">
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ $related->city . ', ' . $related->propertyarea->name }}
                                            </div>
                                        @elseif($related->country_id != 19 && ($related->city || $related->state))
                                            <div class="">
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ $related->city . ', ' . $related->state->name }}
                                            </div>
                                        @endif

                                        @if ($related->bedrooms)
                                            <div class="">
                                                <i class="fa-solid fa-bed"></i>
                                                {{ $related->bedrooms }}
                                            </div>
                                        @endif

                                        @if ($related->bathrooms)
                                            <div>
                                                <i class="fa-solid fa-sink"></i>
                                                {{ $related->bathrooms }}
                                            </div>
                                        @endif

                                        @if ($related->parking_space)
                                            <div>
                                                <i class="fa-solid fa-car"></i>
                                                {{ $related->parking_space }}
                                            </div>
                                        @endif

                                        @if ($related->decoration == 'Full Furnished')
                                            <div>
                                                <i class="fa-solid fa-couch"></i>
                                                {{ $related->decoration }}
                                            </div>
                                        @endif

                                        <div><i class="fa-solid fa-wallet"></i> {{ $related->price }} ৳</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p> Sorry! No realted Properties found . </p>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg ">
                <div class="modal-header bg-dark text-white rounded-top-4">
                    <h5 class="modal-title" id="inquiryModalLabel">Product Inquiry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light p-4">
                    <!-- Property Info -->
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset($property->featured_image) }}" alt="Product" class="rounded me-3"
                            style="width:100px; height:80px; object-fit:cover;">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $property->name }}</h6>
                        </div>
                    </div>

                    <!-- Inquiry Form -->
                    <form id="inquiryForm" class="position-relative"
                        action="{{ route('property.inquiries', $property->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Your Name"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input id="phoneInquiry" type="tel" name="phone" class="form-control"
                                    placeholder="e.g. +880..." required>
                                <small id="phoneErrorInquiry" class="text-danger"></small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Enter Your Email Address" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Living Country</label>
                                <select name="country_id" class="form-select" required>
                                    <option value="">Select Your Living Country</option>
                                    @if ($countries->isNotEmpty())
                                        @foreach ($countries as $country)
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
                                    <option value="Rent Inquiry">Rent Inquiry</option>
                                    <option value="Documentation Service Inquiry">Documentation Service Inquiry</option>
                                    <option value="Buy Property">Buy Property</option>
                                    <option value="Sell Property">Sell Property</option>
                                    <option value="Rental Service">Rental Service</option>
                                    <option value="Property Rent Management">Property Rent Management</option>
                                    <option value="Transfer Permission">Transfer Permission</option>
                                    <option value="Registration">Registration</option>
                                    <option value="Authority Mutation">Authority Mutation</option>
                                    <option value="Holding Mutation">Holding Mutation</option>
                                    <option value="Gas Mutation">Gas Mutation</option>
                                    <option value="Electricity Mutation">Electricity Mutation</option>
                                    <option value="Legal Vetting">Legal Vetting</option>
                                    <option value="Property Color">Property Color</option>
                                    <option value="Property Renovation">Property Renovation</option>
                                    <option value="Property Interior">Property Interior</option>
                                    <option value="Project Development">Project Development</option>
                                    <option value="Property Valuation">Property Valuation</option>
                                    <option value="Buy property">Buy property</option>
                                    <option value="Loan Service">Loan Service</option>
                                    <option value="Holding Mutation1">Holding Mutation1</option>
                                    <option value="RAJUK MUTATION">RAJUK MUTATION</option>
                                    <option value="Sale Permission">Sale Permission</option>
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
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {

            const bookedDates = @json($bookedDates);
            const bookingStartDate = "{{ $property->rent_start }}";
            const propertyId = {{ $property->id }};
            const baseUrl = `{{ route('user.booking.rent') }}`;

            // Loop through each rent section (for desktop + mobile)
            document.querySelectorAll('.rent-section').forEach(section => {
                const pricePerNight = parseFloat(section.querySelector('.pricePerNight').innerText);
                const totalPriceEl = section.querySelector('.totalPrice');
                const dateInput = section.querySelector('.rentDateRange');
                const rentBtn = section.querySelector('.rentSubmitBtn');

                // ✅ Initialize Flatpickr
                flatpickr(dateInput, {
                    mode: "range",
                    minDate: bookingStartDate < new Date().toISOString().split('T')[0] ?
                        new Date().toISOString().split('T')[0] :
                        bookingStartDate,
                    dateFormat: "Y-m-d",
                    disable: bookedDates,
                    onChange: function(selectedDates) {
                        if (selectedDates.length === 2) {
                            const diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                            const total = diffDays * pricePerNight;
                            totalPriceEl.innerText = total.toLocaleString();
                        } else {
                            totalPriceEl.innerText = 0;
                        }
                    }
                });

                // ✅ Handle booking button click
                rentBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (rentBtn.classList.contains('disabled')) return;

                    const dateRange = dateInput.value.trim();
                    if (!dateRange) {
                        alert('Please select your booking dates.');
                        return;
                    }

                    const [startDate, endDate] = dateRange.split(' to ');
                    const finalUrl =
                        `${baseUrl}?property_id=${propertyId}&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;

                    window.location.href = finalUrl;
                });
            });
        });
    </script> --}}

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    const bookedDates = @json($bookedDates);
    const bookingStartDate = "{{ $property->rent_start }}";
    const propertyId = {{ $property->id }};
    const baseUrl = `{{ route('user.booking.rent') }}`;
    const today = new Date().toISOString().split('T')[0];

    const minSelectableDate = bookingStartDate < today ? today : bookingStartDate;

    document.querySelectorAll('.rent-section').forEach(section => {

        // ---------------------------
        // PER NIGHT BOOKING - No change
        // ---------------------------
        const pricePerNight = parseFloat(section.querySelector('.pricePerNight')?.innerText || 0);
        const dateInput = section.querySelector('.rentDateRange');
        const totalPriceEl = section.querySelector('.totalPrice');
        const rentBtn = section.querySelector('.rentSubmitBtn');

        if (dateInput) {
            flatpickr(dateInput, {
                mode: "range",
                minDate: minSelectableDate,
                dateFormat: "Y-m-d",
                disable: bookedDates,
                onChange(selectedDates) {
                    if (selectedDates.length === 2) {
                        const diffDays = Math.ceil(Math.abs(selectedDates[1] - selectedDates[0]) / (1000 * 60 * 60 * 24));
                        totalPriceEl.innerText = (diffDays * pricePerNight).toLocaleString();
                    } else {
                        totalPriceEl.innerText = 0;
                    }
                }
            });

            rentBtn?.addEventListener('click', function(e) {
                e.preventDefault();
                if (rentBtn.classList.contains('disabled')) return;

                const dateRange = dateInput.value.trim();
                if (!dateRange) {
                    alert('Please select booking dates.');
                    return;
                }

                const [startDate, endDate] = dateRange.split(' to ');

                const url =
                    `${baseUrl}?property_id=${propertyId}&start_date=${startDate}&end_date=${endDate}&booking_type=per-night`;

                window.location.href = url;
            });
        }


        // ---------------------------
        // WEEKLY BOOKING VALIDATION
        // ---------------------------
        const priceWeekly = parseFloat(section.querySelector('.priceWeekly')?.innerText || 0);
        const weeklyInput = section.querySelector('.weeklyDateRange');
        const weeklyTotalEl = section.querySelector('.totalWeeklyPrice');
        const weeklyBtn = section.querySelector('.rentSubmitBtnWeekly');
        const weeklyError = section.querySelector('.weeklyError'); // ❗ create small <div class="weeklyError text-danger"></div>

        if (weeklyInput) {
            flatpickr(weeklyInput, {
                mode: "range",
                minDate: minSelectableDate,
                dateFormat: "Y-m-d",
                disable: bookedDates,
                onChange(selectedDates) {

                    weeklyError.innerText = "";  
                    weeklyBtn.classList.remove("disabled");

                    if (selectedDates.length === 2) {

                        const diffDays = Math.ceil(Math.abs(selectedDates[1] - selectedDates[0]) / (1000 * 60 * 60 * 24));

                        // ❗ Weekly must be 7, 14, 21...
                        if (diffDays % 7 !== 0) {
                            weeklyError.innerText = "Please select exact weekly dates (7, 14, 21 days...).";
                            weeklyTotalEl.innerText = 0;
                            weeklyBtn.classList.add("disabled");
                            return;
                        }

                        const weeks = diffDays / 7;
                        weeklyTotalEl.innerText = (weeks * priceWeekly).toLocaleString();

                    } else {
                        weeklyTotalEl.innerText = 0;
                    }
                }
            });

            weeklyBtn?.addEventListener('click', function(e) {
                e.preventDefault();
                if (weeklyBtn.classList.contains('disabled')) return;

                if (!isLoggedIn) {  
                    // Trigger the WhatsApp button
                    const whatsappBtn = document.querySelector('.header_whatsapp');
                    whatsappBtn?.click();
                    return; // Stop here
                }

                const dateRange = weeklyInput.value.trim();
                if (!dateRange) {
                    alert('Please select weekly dates.');
                    return;
                }

                const [startDate, endDate] = dateRange.split(' to ');

                const url =
                    `${baseUrl}?property_id=${propertyId}&start_date=${startDate}&end_date=${endDate}&booking_type=weekly`;

                window.location.href = url;
            });
        }


        // ---------------------------
        // MONTHLY BOOKING VALIDATION
        // ---------------------------
        const priceMonthly = parseFloat(section.querySelector('.priceMonthly')?.innerText || 0);
        const monthlyInput = section.querySelector('.monthlyDateRange');
        const monthlyTotalEl = section.querySelector('.totalMonthlyPrice');
        const monthlyBtn = section.querySelector('.rentSubmitBtnMonthly');
        const monthlyError = section.querySelector('.monthlyError'); // ❗ create <div class="monthlyError text-danger"></div>

        if (monthlyInput) {
            flatpickr(monthlyInput, {
                mode: "range",
                minDate: minSelectableDate,
                dateFormat: "Y-m-d",
                disable: bookedDates,
                onChange(selectedDates) {
                    monthlyError.innerText = "";
                    monthlyBtn.classList.remove("disabled");

                    if (selectedDates.length === 2) {
                        const start = selectedDates[0];
                        const end = selectedDates[1];

                        // Must start at day 1
                        if (start.getDate() !== 1) {
                            monthlyError.innerText = "Start date must be the 1st of the month.";
                            monthlyTotalEl.innerText = 0;
                            monthlyBtn.classList.add("disabled");
                            return;
                        }

                        // Must end at last day of month
                        const lastDayOfEndMonth = new Date(end.getFullYear(), end.getMonth() + 1, 0).getDate();
                        if (end.getDate() !== lastDayOfEndMonth) {
                            monthlyError.innerText = "End date must be the last day of the month.";
                            monthlyTotalEl.innerText = 0;
                            monthlyBtn.classList.add("disabled");
                            return;
                        }

                        // ✅ Calculate full months
                        const months = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth()) + 1;
                        monthlyTotalEl.innerText = (months * priceMonthly).toLocaleString();

                    } else {
                        monthlyTotalEl.innerText = 0;
                    }
                }
            });

            monthlyBtn?.addEventListener('click', function(e) {
                e.preventDefault();
                if (monthlyBtn.classList.contains('disabled')) return;

                if (!isLoggedIn) {  
                    // Trigger the WhatsApp button
                    const whatsappBtn = document.querySelector('.header_whatsapp');
                    whatsappBtn?.click();
                    return; // Stop here
                }

                const dateRange = monthlyInput.value.trim();
                if (!dateRange) {
                    alert('Please select monthly dates.');
                    return;
                }

                const [startDate, endDate] = dateRange.split(' to ');

                const url =
                    `${baseUrl}?property_id=${propertyId}&start_date=${startDate}&end_date=${endDate}&booking_type=monthly`;

                window.location.href = url;
            });
        }

    });
});
</script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            $('#inquiryForm').on('submit', function(e) {
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
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'inquiryModal'));
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

<script>
    window.addEventListener('load', () => {
        new Swiper('.review-slider', {
            speed: 800,
            lazy: {
                loadPrevNext: true
            },
            observer: true,
            observeParents: true,
            resistanceRatio: 0,
            centeredSlides: false,
            freeMode: false,

            slidesPerView: 1,
            loop: true,

            autoplay: {
                delay: 5000, // 5 seconds
                disableOnInteraction: false, // continue autoplay after user interaction
            },

            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 1
                }
            }
        });
    });
</script>

@endsection

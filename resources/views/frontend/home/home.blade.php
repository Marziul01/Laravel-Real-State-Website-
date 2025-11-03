@extends('frontend.master')

@section('title')
    Home
@endsection

@section('content')
    <div id="content" class="site-content">
        <div class="home-hero-section loading-normal-page">
            <div class="swiper mySwiper" slides-per-view="auto">
                <div class="swiper-wrapper" slides-per-view="auto">
                    <div class="swiper-slide">
                        <img class="slider-img" src="{{ asset('frontend-assets') }}/images/slider.jpg" alt="">
                        <div class="container slide-caption">
                            <h2 class="slider-heading">Lyvia By Palace at Dubai Creek Harbour</h2>
                            <p class="slider-subheading">Serene Haven of Branded Living</p>
                            <a href="#" class="btn slider-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="slider-img" src="{{ asset('frontend-assets') }}/images/slider1.webp" alt="">
                        <div class="container slide-caption">
                            <h2 class="slider-heading">Lyvia By Palace at Dubai Creek Harbour</h2>
                            <p class="slider-subheading">Serene Haven of Branded Living</p>
                            <a href="#" class="btn slider-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="slider-img" src="{{ asset('frontend-assets') }}/images/slider2.jpg" alt="">
                        <div class="container slide-caption">
                            <h2 class="slider-heading">Lyvia By Palace at Dubai Creek Harbour</h2>
                            <p class="slider-subheading">Serene Haven of Branded Living</p>
                            <a href="#" class="btn slider-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="slider-img" src="{{ asset('frontend-assets') }}/images/slider3.jpg" alt="">
                        <div class="container slide-caption">
                            <h2 class="slider-heading">Lyvia By Palace at Dubai Creek Harbour</h2>
                            <p class="slider-subheading">Serene Haven of Branded Living</p>
                            <a href="#" class="btn slider-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="slider-img" src="{{ asset('frontend-assets') }}/images/slider4.jpg" alt="">
                        <div class="container slide-caption">
                            <h2 class="slider-heading">Lyvia By Palace at Dubai Creek Harbour</h2>
                            <p class="slider-subheading">Serene Haven of Branded Living</p>
                            <a href="#" class="btn slider-btn">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>

            <div class="hero-content-wrapper">
                <div class="homesearch_mobile_filter">
                    <div class="property-form container">
                        <ul class="nav nav-tabs justify-content-start" id="propertyTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="rent-tab" data-bs-toggle="tab" data-bs-target="#rent"
                                    type="button" role="tab">Rent Property</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy"
                                    type="button" role="tab">Buy Property</button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- RENT TAB -->
                            <div class="tab-pane fade show active" id="rent" role="tabpanel">
                                <form class="property-form-select" id="searchrent-form" method="GET" action="{{ route('rent') }}">
                                    <!-- Hidden fields -->
                                    <input type="hidden" name="type" value="rent">
                                    <input type="hidden" name="country_id" value="19">
                                    <input type="hidden" id="rentDateRangeHidden" name="rent_date_range">
                                    <input type="hidden" id="property_type_id" name="property_type_id" value="{{ request('property_type_id') }}">
                                    <input type="hidden" id="district_id_hidden" name="district_id" value="{{ request('district_id_hidden') }}">

                                    <div
                                        class="d-flex flex-wrap align-items-center w-100 flex-column flex-md-row gap-4 gap-md-0">
                                        <!-- 🔹 Price Range -->
                                        <div class="custom-dropdown position-relative">
                                            <div class="price-range">
                                                <div class="d-flex align-items-center">
                                                    <label>Price Range :</label>
                                                    <div class="price-inputs">
                                                        <input type="number" id="rentMinPrice" class="form-control" name="min_price"
                                                            value="{{ request('min_price', $minPrice) }}">
                                                        <span>-to-</span>
                                                        <input type="number" id="rentMaxPrice" class="form-control" name="max_price"
                                                            value="{{ request('max_price', $maxPrice) }}">
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="range" id="rentPriceRangeMin" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                                        value="{{ request('min_price', $minPrice) }}">
                                                    <input type="range" id="rentPriceRangeMax" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                                        value="{{ request('max_price', $maxPrice) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 🔹 Property Type (Dynamic from DB) -->
                                        <div class="custom-dropdown">
                                            <input type="text" class="form-control" id="rentTypeInput" placeholder="Select Property Type"
                                             readonly>
                                            <div class="dropdown-box" style="max-height: 250px; overflow-y: auto;">
                                                <div class="option-grid">
                                                    @foreach($property_categories as $type)
                                                        <div class="option-box" data-value="{{ $type->id }}">{{ $type->property_type }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 🔹 Bedrooms -->
                                        <div class="custom-dropdown diffrent">
                                            <input type="text" class="form-control" id="rentBedroomsInput" placeholder="Select Bedrooms"
                                                name="bedrooms" value="{{ request('bedrooms') }}" readonly>
                                            <div class="dropdown-box" style="max-height: 250px; overflow-y: auto;">
                                                <div class="option-grid">
                                                    @for($i = $minBedrooms; $i <= $maxBedrooms; $i++)
                                                        <div class="option-box">{{ $i }}</div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Location -->
                                        <div class="custom-dropdown">

                                            <input type="text" class="form-control" id="rentLocationInput"
                                                placeholder="Select Location" readonly>
                                            <div class="dropdown-box" style="max-height: 250px; overflow-y: auto;">
                                                <div class="option-grid">
                                                    @foreach($districts as $district)
                                                        <div class="option-box" data-value="{{ $district->id }}">{{ $district->name }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Date Range -->
                                        <div class="custom-dropdown">

                                            <input type="text" id="rentDateRange" class="form-control"
                                                placeholder="Select Date Range" readonly>
                                        </div>
                                        <div class="custom-dropdown diffrent">
                                            <button type="submit" class="btn custom-button"><i
                                                    class="fa-solid fa-magnifying-glass me-2"></i> Search</button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <!-- BUY TAB -->
                            <div class="tab-pane fade" id="buy" role="tabpanel">
                                <form class="property-form-select" id="searchbuy-form" method="GET" action="{{ route('rent') }}">
                                    <input type="hidden" name="type" value="sell">
                                    <input type="hidden" name="country_id" value="19">
                                    
                                    <input type="hidden" id="sell_property_type_id" name="property_type_id" value="{{ request('property_type_id') }}">
                                    <input type="hidden" id="sell_district_id_hidden" name="district_id" value="{{ request('district_id_hidden') }}">
                                    <div
                                        class="d-flex flex-wrap align-items-center w-100 flex-column flex-md-row gap-4 gap-md-0">

                                        <!-- Price Range -->
                                        <div class="custom-dropdown buy position-relative">

                                            <div class="price-range">
                                                <div class="d-flex align-items-center">
                                                    <label>Price Range :</label>
                                                    <div class="price-inputs">
                                                        <input type="number" id="buyMinPrice" class="form-control"
                                                            name="min_price"
                                                            value="{{ request('min_price', $minPrice) }}">
                                                        <span>-to-</span>
                                                        <input type="number" id="buyMaxPrice" class="form-control"
                                                            name="max_price"
                                                            value="{{ request('max_price', $maxPrice) }}">
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="range" id="buyPriceRangeMin" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                                        value="{{ request('min_price', $minPrice) }}">
                                                    <input type="range" id="buyPriceRangeMax" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                                        value="{{ request('max_price', $maxPrice) }}">
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Property Type -->
                                        <div class=" custom-dropdown buy">

                                            <input type="text" class="form-control" id="buyTypeInput"
                                                placeholder="Select Property Type"  readonly>
                                            <div class="dropdown-box" style="max-height: 250px; overflow-y: auto;">
                                                <div class="option-grid">
                                                     @foreach($property_categories as $type)
                                                        <div class="option-box" data-value="{{ $type->id }}">{{ $type->property_type }}</div>
                                                    @endforeach
                                                </div>
                                            </div> 
                                        </div>

                                        <!-- Bedrooms -->
                                        <div class="custom-dropdown buy">

                                            <input type="text" class="form-control" id="buyBedroomsInput"
                                                placeholder="Select Bedrooms"  name="bedrooms" value="{{ request('bedrooms') }}" readonly>
                                            <div class="dropdown-box" style="max-height: 250px; overflow-y: auto;">
                                                <div class="option-grid">
                                                    @for($i = $minBedrooms; $i <= $maxBedrooms; $i++)
                                                        <div class="option-box">{{ $i }}</div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Location -->
                                        <div class="custom-dropdown buy">

                                            <input type="text" class="form-control" id="buyLocationInput"
                                                placeholder="Select Location" readonly>
                                            <div class="dropdown-box" style="max-height: 250px; overflow-y: auto;">
                                                <div class="option-grid">
                                                    @foreach($districts as $district)
                                                        <div class="option-box" data-value="{{ $district->id }}">{{ $district->name }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-dropdown buy">
                                            <button type="submit" class="btn custom-button"><i
                                                    class="fa-solid fa-magnifying-glass me-2"></i> Search</button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container  py-5">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="reviews-title">TOP LISTED PROPERTIES</h3>
                <a href="">View All <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="grid-container mt-4">
                @if (
                    $properties->isNotEmpty() &&
                        $properties->filter(fn($property) => str_contains($property->property_listing, 'Top Listed'))->isNotEmpty())
                    @foreach ($properties->filter(fn($property) => str_contains($property->property_listing, 'Top Listed'))->take(8) as $property)
                        <a href="{{ $property->type == 'rent' ? route('view.rent.property', $property->slug) : route('view.buy.property', $property->slug) }}"
                            class="no-hover-color-link">
                            <div class="property-card position-relative">
                                <img src="{{ asset($property->featured_image) }}" class="property-img"
                                    alt="Property Image">
                                <div class="property-tags propertyTypeFixed">
                                    <span class="tag">Top Listed</span>
                                    <span class="tag">{{ $property->type == 'sell' ? 'Buy' : 'Rent' }}</span>
                                </div>
                                <div class="property-details">
                                    <div class="property-title">{{ $property->name }}</div>
                                    <div class="property-tags">
                                        <span class="tag">{{ $property->propertyType->property_type }}</span>
                                    </div>

                                    <div class="property-info">
                                        @if ($property->space)
                                            <div class="">
                                                <i class="fa-regular fa-house"></i>
                                                SFT {{ $property->space }}
                                            </div>
                                        @endif

                                        @if ($property->country_id == 19 && ($property->city || $property->propertyarea))
                                            <div class="">
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ $property->city . ', ' . $property->propertyarea->name }}
                                            </div>
                                        @elseif($property->country_id != 19 && ($property->city || $property->state))
                                            <div class="">
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ $property->city . ', ' . $property->state->name }}
                                            </div>
                                        @endif

                                        @if ($property->bedrooms)
                                            <div class="">
                                                <i class="fa-solid fa-bed"></i>
                                                {{ $property->bedrooms }}
                                            </div>
                                        @endif

                                        @if ($property->bathrooms)
                                            <div>
                                                <i class="fa-solid fa-sink"></i>
                                                {{ $property->bathrooms }}
                                            </div>
                                        @endif

                                        @if ($property->parking_space)
                                            <div>
                                                <i class="fa-solid fa-car"></i>
                                                {{ $property->parking_space }}
                                            </div>
                                        @endif

                                        @if ($property->decoration == 'Full Furnished')
                                            <div>
                                                <i class="fa-solid fa-couch"></i>
                                                {{ $property->decoration }}
                                            </div>
                                        @endif

                                        <div><i class="fa-solid fa-wallet"></i> {{ $property->price }} ৳</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p> Sorry! No Properties Listed Yet . </p>
                @endif
            </div>
        </div>

        <div class="container renttal">
            <div class="d-flex justify-content-between align-items-center position-relative">
                <h3 class="reviews-title">Rent Properties</h3>
                <div class="swiper-button-prev swiper-button-prev1"></div>
                <div class="swiper-button-next swiper-button-next1"></div>
            </div>
            <div class="swiper mySwiper1">
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    @if ($properties->where('type', 'rent')->isNotEmpty())
                        @foreach ($properties->where('type', 'rent')->take(8) as $property)
                            <div class="swiper-slide">
                                <a href="{{ $property->type == 'rent' ? route('view.rent.property', $property->slug) : route('view.buy.property', $property->slug) }}"
                                    class="no-hover-color-link">
                                    <div class="property-card">
                                        <img src="{{ asset($property->featured_image) }}" class="property-img"
                                            alt="Property Image">
                                        <div class="property-tags propertyTypeFixed">
                                            @if ($property->property_listing)
                                                @foreach (explode(',', $property->property_listing) as $listing)
                                                    <span class="tag">{{ trim($listing) }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="property-details">
                                            <div class="property-title">{{ $property->name }}</div>
                                            <div class="property-tags">
                                                <span class="tag">{{ $property->propertyType->property_type }}</span>
                                            </div>
                                            <div class="property-info">
                                                @if ($property->space)
                                                    <div class="">
                                                        <i class="fa-regular fa-house"></i>
                                                        SFT {{ $property->space }}
                                                    </div>
                                                @endif

                                                @if ($property->country_id == 19 && ($property->city || $property->propertyarea))
                                                    <div class="">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                        {{ $property->city . ', ' . $property->propertyarea->name }}
                                                    </div>
                                                @elseif($property->country_id != 19 && ($property->city || $property->state))
                                                    <div class="">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                        {{ $property->city . ', ' . $property->state->name }}
                                                    </div>
                                                @endif

                                                @if ($property->bedrooms)
                                                    <div class="">
                                                        <i class="fa-solid fa-bed"></i>
                                                        {{ $property->bedrooms }}
                                                    </div>
                                                @endif

                                                @if ($property->bathrooms)
                                                    <div>
                                                        <i class="fa-solid fa-sink"></i>
                                                        {{ $property->bathrooms }}
                                                    </div>
                                                @endif

                                                @if ($property->parking_space)
                                                    <div>
                                                        <i class="fa-solid fa-car"></i>
                                                        {{ $property->parking_space }}
                                                    </div>
                                                @endif

                                                @if ($property->decoration == 'Full Furnished')
                                                    <div>
                                                        <i class="fa-solid fa-couch"></i>
                                                        {{ $property->decoration }}
                                                    </div>
                                                @endif
                                                <div><i class="fa-solid fa-wallet"></i> {{ $property->price }} ৳</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>


                <!-- Navigation arrows -->

            </div>
        </div>

        <div class="container renttal py-5">
            <div class="d-flex justify-content-between align-items-center position-relative">
                <h3 class="reviews-title">Buy Properties</h3>
                <div class="swiper-button-prev swiper-button-prev2"></div>
                <div class="swiper-button-next swiper-button-next2"></div>
            </div>
            <div class="swiper mySwiper2">
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    @if ($properties->where('type', 'sell')->isNotEmpty())
                        @foreach ($properties->where('type', 'sell')->take(8) as $property)
                            <div class="swiper-slide">
                                <a href="{{ $property->type == 'rent' ? route('view.rent.property', $property->slug) : route('view.buy.property', $property->slug) }}"
                                    class="no-hover-color-link">
                                    <div class="property-card">
                                        <img src="{{ asset($property->featured_image) }}" class="property-img"
                                            alt="Property Image">
                                        <div class="property-tags propertyTypeFixed">
                                            @if ($property->property_listing)
                                                @foreach (explode(',', $property->property_listing) as $listing)
                                                    <span class="tag">{{ trim($listing) }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="property-details">
                                            <div class="property-title">{{ $property->name }}</div>
                                            <div class="property-tags">
                                                <span class="tag">{{ $property->propertyType->property_type }}</span>
                                            </div>
                                            <div class="property-info">
                                                @if ($property->space)
                                                    <div class="">
                                                        <i class="fa-regular fa-house"></i>
                                                        SFT {{ $property->space }}
                                                    </div>
                                                @endif

                                                @if ($property->country_id == 19 && ($property->city || $property->propertyarea))
                                                    <div class="">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                        {{ $property->city . ', ' . $property->propertyarea->name }}
                                                    </div>
                                                @elseif($property->country_id != 19 && ($property->city || $property->state))
                                                    <div class="">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                        {{ $property->city . ', ' . $property->state->name }}
                                                    </div>
                                                @endif

                                                @if ($property->bedrooms)
                                                    <div class="">
                                                        <i class="fa-solid fa-bed"></i>
                                                        {{ $property->bedrooms }}
                                                    </div>
                                                @endif

                                                @if ($property->bathrooms)
                                                    <div>
                                                        <i class="fa-solid fa-sink"></i>
                                                        {{ $property->bathrooms }}
                                                    </div>
                                                @endif

                                                @if ($property->parking_space)
                                                    <div>
                                                        <i class="fa-solid fa-car"></i>
                                                        {{ $property->parking_space }}
                                                    </div>
                                                @endif

                                                @if ($property->decoration == 'Full Furnished')
                                                    <div>
                                                        <i class="fa-solid fa-couch"></i>
                                                        {{ $property->decoration }}
                                                    </div>
                                                @endif
                                                <div><i class="fa-solid fa-wallet"></i> {{ $property->price }} ৳</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="container my-5">
            <h2 class=" mb-4 reviews-title">OUR SERVICES</h2>
            <div class="row row-cols-2 row-cols-md-4 g-4">

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-home"></i>
                        </div>
                        <p class="service-text mb-0">Property Rent Management</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-key"></i>
                        </div>
                        <p class="service-text mb-0">Rental Service</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-tag"></i>
                        </div>
                        <p class="service-text mb-0">Sell Property</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <p class="service-text mb-0">Buy Property</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <p class="service-text mb-0">Holding Mutation</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <p class="service-text mb-0">Authority Mutation</p>
                    </a>
                </div>

                <div class="col">
                    <div class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-registered"></i>
                        </div>
                        <p class="service-text mb-0">Registration</p>
                    </div>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <p class="service-text mb-0">Transfer Permission</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-palette"></i>
                        </div>
                        <p class="service-text mb-0">Property Color</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <p class="service-text mb-0">Legal Vetting</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <p class="service-text mb-0">Electricity Mutation</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-fire"></i>
                        </div>
                        <p class="service-text mb-0">Gas Mutation</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <p class="service-text mb-0">Property Valuation</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-drafting-compass"></i>
                        </div>
                        <p class="service-text mb-0">Project Development</p>
                    </a>
                </div>

                <div class="col focused-card-col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-chair"></i>
                        </div>
                        <p class="service-text mb-0">Property Interior</p>
                    </a>
                </div>

                <div class="col">
                    <a class="service-card p-3">
                        <div class="icon-placeholder mb-2">
                            <i class="fas fa-tools"></i>
                        </div>
                        <p class="service-text mb-0">Property Renovation</p>
                    </a>
                </div>

            </div>
        </div>

        <div class="container">
            <section class="team-section py-5">
                <div class="">
                    <div class="d-flex justify-content-between align-items-center position-relative">
                        <h3 class="reviews-title">Team DHR</h3>
                        <a href="#">All Members <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    <div class="team-photo-container my-4">
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c" alt="Team Melody Group"
                            class="img-fluid team-group-photo">
                    </div>

                    <div class="swiper-container member-slider">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="member-card">
                                    <div class="member-image-wrapper">
                                        <img src="{{ asset('frontend-assets') }}/images/slider1.webp" alt="Md Saif Uddin"
                                            class="member-image">
                                    </div>
                                    <h4 class="member-name">Md Saif Uddin</h4>
                                    <p class="member-role">Executive, Accounts & Admin</p>
                                    <p class="member-contact">01974422770</p>
                                    <button class="btn btn-appointment">Get Appointment</button>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="member-card">
                                    <div class="member-image-wrapper">
                                        <img src="{{ asset('frontend-assets') }}/images/slider1.webp"
                                            alt="Salah Uddin Shikder" class="member-image">
                                    </div>
                                    <h4 class="member-name">Salah Uddin Shikder</h4>
                                    <p class="member-role">Managing Director</p>
                                    <p class="member-contact">01955443322</p>
                                    <button class="btn btn-appointment">Get Appointment</button>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="member-card">
                                    <div class="member-image-wrapper">
                                        <img src="{{ asset('frontend-assets') }}/images/slider1.webp"
                                            alt="Rainessa Mostafa" class="member-image">
                                    </div>
                                    <h4 class="member-name">Rainessa Mostafa</h4>
                                    <p class="member-role">Chairman</p>
                                    <p class="member-contact">01716679276</p>
                                    <button class="btn btn-appointment">Get Appointment</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="member-card">
                                    <div class="member-image-wrapper">
                                        <img src="{{ asset('frontend-assets') }}/images/slider1.webp"
                                            alt="Rainessa Mostafa" class="member-image">
                                    </div>
                                    <h4 class="member-name">Rainessa Mostafa</h4>
                                    <p class="member-role">Chairman</p>
                                    <p class="member-contact">01716679276</p>
                                    <button class="btn btn-appointment">Get Appointment</button>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-button-prev swiper-button-prev3"></div>
                        <div class="swiper-button-next swiper-button-next3"></div>
                    </div>
                </div>
            </section>
        </div>

        <section class="results-reviews-section py-5">
            <div class="container">

                <div class="text-center mb-5">
                    <p class="strength-subtitle">Our Strength</p>
                    <h2 class="strength-title">OUR RESULTS SPEAK FOR US</h2>
                </div>

                <div class="row g-3 mb-5 justify-content-center">

                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="metric-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="metric-number">+170</span>
                                <i class="fas fa-home metric-icon"></i>
                            </div>
                            <p class="metric-label">Sold</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="metric-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="metric-number">+180</span>
                                <i class="fas fa-chart-bar metric-icon"></i>
                            </div>
                            <p class="metric-label">Property Inventory</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="metric-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="metric-number">+3200</span>
                                <i class="fas fa-user-tie metric-icon"></i>
                            </div>
                            <p class="metric-label">Listed Agent</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="metric-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="metric-number">+175000</span>
                                <i class="fas fa-database metric-icon"></i>
                            </div>
                            <p class="metric-label">Client Database</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="metric-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="metric-number">+14</span>
                                <i class="fas fa-calendar-alt metric-icon"></i>
                            </div>
                            <p class="metric-label">Years</p>
                        </div>
                    </div>

                </div>

                <hr class="my-5">

                <div class="d-flex justify-content-between align-items-end mb-4 reviews-header">
                    <a href="">View All <i class="fa-solid fa-arrow-right"></i></a>
                    <h3 class="reviews-title">CLIENT REVIEWS</h3>
                </div>

                <div class="swiper-container review-slider">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="stars mb-3">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p class="review-text">Excellent service! They saved me days of work and ensured my
                                    documents were 100% accurate.</p>

                                <div class="reviewer-info d-flex align-items-center mt-4">
                                    <img src="path/to/manirul/sarker.jpg" alt="Md. Manirul Haque Sarker"
                                        class="reviewer-avatar">
                                    <div class="ms-3 text-start">
                                        <p class="reviewer-name">Md. Manirul Haque Sarker</p>
                                        <p class="reviewer-role">Document Service</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="stars mb-3">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p class="review-text">I had no idea about land documentation, but their team handled
                                    everything perfectly.</p>

                                <div class="reviewer-info d-flex align-items-center mt-4">
                                    <img src="path/to/sadman/khan.jpg" alt="Sadman Mahmud Khan" class="reviewer-avatar">
                                    <div class="ms-3 text-start">
                                        <p class="reviewer-name">Sadman Mahmud Khan</p>
                                        <p class="reviewer-role">Document Service</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="stars mb-3">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p class="review-text">Quick processing, clear communication, and no hidden charges —
                                    exactly what I needed.</p>

                                <div class="reviewer-info d-flex align-items-center mt-4">
                                    <img src="path/to/shahidul/huq.jpg" alt="MD. Shahidul Huq" class="reviewer-avatar">
                                    <div class="ms-3 text-start">
                                        <p class="reviewer-name">MD. Shahidul Huq</p>
                                        <p class="reviewer-role">Document Service</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="stars mb-3">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p class="review-text">Quick processing, clear communication, and no hidden charges —
                                    exactly what I needed.</p>

                                <div class="reviewer-info d-flex align-items-center mt-4">
                                    <img src="path/to/shahidul/huq.jpg" alt="MD. Shahidul Huq" class="reviewer-avatar">
                                    <div class="ms-3 text-start">
                                        <p class="reviewer-name">MD. Shahidul Huq</p>
                                        <p class="reviewer-role">Document Service</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

            </div>
        </section>

        <section class="contact-section pb-5">
            <div class="container" id="contact-section">
                <div class="mb-4">
                    <h2 class="reviews-title">Get In Touch</h2>
                </div>
                <div class="row g-5 m-0">
                    <div class="col-lg-6 form-column">
                        <form id="inquiryForm-footer" class="contact-form position-relative" action="{{ route('service.inquiries') }}" method="POST" enctype="multipart/form-data">

                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control mb-3" id="full_name" name="name"
                                placeholder="Enter Your Name">

                            <label for="contact_number" class="form-label">Contact Number</label>
                            <div class="input-group mb-3">
                                <input type="tel" class="form-control" id="phoneInquiry-footer"
                                    placeholder="Contact Nubmer" name="phone">
                                <small id="phoneErrorInquiry-footer" class="text-danger"></small>
                            </div>

                            <label for="email_address" class="form-label">Email Address</label>
                            <input type="email" class="form-control mb-3" id="email_address"
                                placeholder="Enter Your Email Address" name="email">

                            <label for="country" class="form-label">Select Your Living Country</label>
                            <select class="form-select mb-3" id="country" name="country_id">
                                @if ($countries->isNotEmpty())
                                    @foreach ($countries as $country )
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                            <div class="d-flex mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Set Your Schedule (BD Time)</label>
                                    <input type="date" name="schedule_date" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Preferred Time</label>
                                    <input type="time" name="schedule_time" class="form-control" required>
                                </div>
                            </div>

                            <label for="demands" class="form-label">Select Multiple Demands</label>
                            <select class="form-select mb-3" name="demands[]" id="demands-footer" multiple>
                                <option>...Select Multiple Demands</option>
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

                            <label for="message" class="form-label mt-3">Your Message</label>
                            <textarea class="form-control mb-4" id="message" rows="3"  name="message" placeholder="...go ahead. We are listening"></textarea>

                            <button type="submit" class="btn btn-primary  w-100">Submit</button>
                            <div id="formLoaderbooking1" class="form-loader d-none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1573.5049363022513!2d90.4144549927618!3d23.77490076110839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c70c0c6d5955%3A0xc6657c6b48450f38!2sMelody%20Housing%20Agency!5e0!3m2!1sen!2sbd!4v1717800000000!5m2!1sen!2sbd"
                                width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" class="contact-map"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('customJs')
    <script>
        // ✅ Dropdown toggle system
        document.querySelectorAll(".custom-dropdown input").forEach(input => {
            input.addEventListener("click", function(e) {
                const dropdown = this.nextElementSibling;
                document.querySelectorAll(".dropdown-box").forEach(box => {
                    if (box !== dropdown) box.style.display = "none";
                });
                dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            });
        });

        document.querySelectorAll(".option-box").forEach(option => {
            option.addEventListener("click", function() {
                const dropdown = this.closest(".dropdown-box");
                const input = dropdown.previousElementSibling;

                // Remove previous active selection
                dropdown.querySelectorAll(".option-box").forEach(opt => opt.classList.remove("active"));

                // Highlight current selection
                this.classList.add("active");

                // Set the input value
                input.value = this.textContent;

                // Close dropdown
                dropdown.style.display = "none";
            });
        });


        document.addEventListener("click", function(e) {
            if (!e.target.closest(".custom-dropdown")) {
                document.querySelectorAll(".dropdown-box").forEach(box => (box.style.display = "none"));
            }
        });

        // ✅ Flatpickr for Rent date range
        flatpickr("#rentDateRange", {
            mode: "range",
            minDate: "today",
            dateFormat: "d M Y",
            onChange: function(selectedDates, dateStr, instance) {
                // When both start and end dates are selected
                if (selectedDates.length === 2) {
                    const startDate = selectedDates[0];
                    const endDate = selectedDates[1];

                    // Format for sending (YYYY-MM-DD)
                    const formattedStart = instance.formatDate(startDate, "Y-m-d");
                    const formattedEnd = instance.formatDate(endDate, "Y-m-d");

                    // ✅ Save to hidden input
                    document.getElementById("rentDateRangeHidden").value =
                        formattedStart + " to " + formattedEnd;
                }
            },
            onClose: function(selectedDates, dateStr, instance) {
                // Optional: if user clears date
                if (selectedDates.length === 0) {
                    document.getElementById("rentDateRangeHidden").value = "";
                }
            }
        });

        // ✅ Dual Range System (Reusable Function)
        function setupRange(minRangeId, maxRangeId, minInputId, maxInputId) {
            const minRange = document.getElementById(minRangeId);
            const maxRange = document.getElementById(maxRangeId);
            const minInput = document.getElementById(minInputId);
            const maxInput = document.getElementById(maxInputId);

            function syncRanges() {
                let minVal = parseInt(minRange.value);
                let maxVal = parseInt(maxRange.value);
                if (minVal > maxVal)[minVal, maxVal] = [maxVal, minVal];
                minInput.value = minVal;
                maxInput.value = maxVal;
            }

            minRange.addEventListener("input", syncRanges);
            maxRange.addEventListener("input", syncRanges);
            minInput.addEventListener("input", () => {
                minRange.value = minInput.value;
                syncRanges();
            });
            maxInput.addEventListener("input", () => {
                maxRange.value = maxInput.value;
                syncRanges();
            });

            syncRanges();
        }

        // Apply to both Rent and Buy tabs
        setupRange("rentPriceRangeMin", "rentPriceRangeMax", "rentMinPrice", "rentMaxPrice");
        setupRange("buyPriceRangeMin", "buyPriceRangeMax", "buyMinPrice", "buyMaxPrice");
    </script>

    <script>
        window.addEventListener('load', () => {
            const swipers = [{
                    selector: '.mySwiper',
                    options: {
                        loop: true,
                        speed: 1500,
                        autoplay: {
                            delay: 5000
                        }
                    }
                },
                {
                    selector: '.mySwiper1',
                    options: {
                        slidesPerView: 4.3,
                        spaceBetween: 20,
                        loop: true,
                        autoplay: {
                            delay: 4000
                        },
                        breakpoints: {
                            0: {
                                slidesPerView: 1.3,
                                spaceBetween: 10
                            }, // Mobile
                            768: {
                                slidesPerView: 4.3,
                                spaceBetween: 20
                            } // Tablet/Desktop
                        }
                    }
                },
                {
                    selector: '.mySwiper2',
                    options: {
                        slidesPerView: 4.3,
                        spaceBetween: 20,
                        loop: true,
                        autoplay: {
                            delay: 3000
                        },
                        breakpoints: {
                            0: {
                                slidesPerView: 1.3,
                                spaceBetween: 10
                            },
                            768: {
                                slidesPerView: 4.3,
                                spaceBetween: 20
                            }
                        }
                    }
                },
                {
                    selector: '.member-slider',
                    options: {
                        slidesPerView: 3,
                        loop: false,
                        breakpoints: {
                            0: {
                                slidesPerView: 1
                            },
                            768: {
                                slidesPerView: 3
                            }
                        }
                    }
                },
                {
                    selector: '.review-slider',
                    options: {
                        slidesPerView: 3,
                        loop: false,
                        breakpoints: {
                            0: {
                                slidesPerView: 1
                            },
                            768: {
                                slidesPerView: 3
                            }
                        }
                    }
                }
            ];

            swipers.forEach(sw => new Swiper(sw.selector, {
                ...sw.options,
                speed: 800,
                lazy: {
                    loadPrevNext: true
                },
                observer: true,
                observeParents: true,
                resistanceRatio: 0,
                centeredSlides: false,
                freeMode: false,
            }));
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Property Type selection
            document.querySelectorAll('#searchrent-form .custom-dropdown .option-box').forEach(option => {
                option.addEventListener('click', function() {
                    const parentDropdown = this.closest('.custom-dropdown');
                    const input = parentDropdown.querySelector('input.form-control');

                    // Set visible input text
                    input.value = this.textContent.trim();

                    // For property type
                    if (input.id === 'rentTypeInput') {
                        document.querySelector('#property_type_id').value = this.getAttribute('data-value');
                    }

                    // For district
                    if (input.id === 'rentLocationInput') {
                        document.querySelector('#district_id_hidden').value = this.getAttribute('data-value');
                    }
                });
            });

        });
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {

            // Property Type selection
            document.querySelectorAll('#searchbuy-form .custom-dropdown .option-box').forEach(option => {
                option.addEventListener('click', function() {
                    const parentDropdown = this.closest('.custom-dropdown');
                    const input = parentDropdown.querySelector('input.form-control');

                    // Set visible input text
                    input.value = this.textContent.trim();

                    // For property type
                    if (input.id === 'buyTypeInput') {
                        document.querySelector('#sell_property_type_id').value = this.getAttribute('data-value');
                    }

                    // For district
                    if (input.id === 'buyLocationInput') {
                        document.querySelector('#sell_district_id_hidden').value = this.getAttribute('data-value');
                    }
                });
            });

        });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ✅ Initialize Select2
    
        $('#demands-footer').select2({
            width: '100%',
            placeholder: "Select Multiple Demands",
            allowClear: true
        });
    

    // ✅ Initialize intl-tel-input for phone field
    const phoneInput = document.querySelector("#phoneInquiry-footer");
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "bd",
        preferredCountries: ["bd", "in", "us", "gb"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });

    // ✅ Handle form submit via AJAX
    $('#inquiryForm-footer').on('submit', function (e) {
        e.preventDefault();

        const phoneError = document.querySelector('#phoneErrorInquiry-footer');
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

        const loader = document.getElementById('formLoaderbooking1');
        loader.classList.remove('d-none');
        // ✅ Send AJAX request
        fetch(actionUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(async response => {
            loader.classList.add('d-none');

            if (!response.ok) {
                // If it's a validation error (422)
                if (response.status === 422) {
                    const data = await response.json();
                    Object.values(data.errors).forEach(errorArray => {
                        toastr.error(errorArray[0]); // Show first error of each field
                    });
                    return;
                }

                // Other server error
                toastr.error('Something went wrong.');
                return;
            }

            const data = await response.json();
            if (data.status === 'success') {
                toastr.success(data.message);
                $('#inquiryForm-footer')[0].reset();
                $('#demands-footer').val(null).trigger('change');
                
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

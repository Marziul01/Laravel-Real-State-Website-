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
                                <form class="property-form-select" id="searchrent-form" >
                                    <div class="d-flex flex-wrap align-items-center w-100 flex-column flex-md-row gap-4 gap-md-0">
                                        <div class="custom-dropdown position-relative">
                                            <div class="price-range">
                                                <div class="d-flex align-items-center">
                                                    <label>Price Range :</label>
                                                    <div class="price-inputs">
                                                        <input type="number" id="rentMinPrice" class="form-control"
                                                            value="0">
                                                        <span>-to-</span>
                                                        <input type="number" id="rentMaxPrice" class="form-control"
                                                            value="1000">
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="range" id="rentPriceRangeMin" min="0" max="1000"
                                                    value="0">
                                                    <input type="range" id="rentPriceRangeMax" min="0" max="1000"
                                                    value="1000">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Property Type -->
                                        <div class="custom-dropdown">
                                            
                                            <input type="text" class="form-control" id="rentTypeInput"
                                                placeholder="Select Property Type" readonly>
                                            <div class="dropdown-box">
                                                <div class="option-grid">
                                                    <div class="option-box">Duplex</div>
                                                    <div class="option-box">Apartment</div>
                                                    <div class="option-box">Office</div>
                                                    <div class="option-box">Shop</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bedrooms -->
                                        <div class="custom-dropdown diffrent">
                                            
                                            <input type="text" class="form-control" id="rentBedroomsInput"
                                                placeholder="Select Bedrooms" readonly>
                                            <div class="dropdown-box">
                                                <div class="option-grid">
                                                    <div class="option-box">1</div>
                                                    <div class="option-box">2</div>
                                                    <div class="option-box">3</div>
                                                    <div class="option-box">4+</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Location -->
                                        <div class="custom-dropdown">
                                            
                                            <input type="text" class="form-control" id="rentLocationInput"
                                                placeholder="Select Location" readonly>
                                            <div class="dropdown-box">
                                                <div class="option-grid">
                                                    <div class="option-box">Dhaka</div>
                                                    <div class="option-box">Chittagong</div>
                                                    <div class="option-box">Sylhet</div>
                                                    <div class="option-box">Rajshahi</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Date Range -->
                                        <div class="custom-dropdown">
                                            
                                            <input type="text" id="rentDateRange" class="form-control"
                                                placeholder="Select Date Range" readonly>
                                        </div>
                                        <div class="custom-dropdown diffrent">
                                            <button type="submit" class="btn custom-button"><i class="fa-solid fa-magnifying-glass me-2"></i> Search</button>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
 
                            <!-- BUY TAB -->
                            <div class="tab-pane fade" id="buy" role="tabpanel">
                                <form class="property-form-select" id="searchbuy-form">
                                    <div class="d-flex flex-wrap align-items-center w-100 flex-column flex-md-row gap-4 gap-md-0">

                                        <!-- Price Range -->
                                        <div class="custom-dropdown buy position-relative">

                                            <div class="price-range">
                                                <div class="d-flex align-items-center">
                                                    <label>Price Range :</label>
                                                    <div class="price-inputs">
                                                        <input type="number" id="buyMinPrice" class="form-control"
                                                            value="0">
                                                        <span>-to-</span>
                                                        <input type="number" id="buyMaxPrice" class="form-control"
                                                            value="1000">
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="range" id="buyPriceRangeMin" min="0"
                                                    max="1000" value="0">
                                                    <input type="range" id="buyPriceRangeMax" min="0"
                                                        max="1000" value="1000">
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <!-- Property Type -->
                                        <div class=" custom-dropdown buy">
                                            
                                            <input type="text" class="form-control" id="buyTypeInput"
                                                placeholder="Select Property Type" readonly>
                                            <div class="dropdown-box">
                                                <div class="option-grid">
                                                    <div class="option-box">Duplex</div>
                                                    <div class="option-box">Apartment</div>
                                                    <div class="option-box">Office</div>
                                                    <div class="option-box">Land</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bedrooms -->
                                        <div class="custom-dropdown buy">
                                          
                                            <input type="text" class="form-control" id="buyBedroomsInput"
                                                placeholder="Select Bedrooms" readonly>
                                            <div class="dropdown-box">
                                                <div class="option-grid">
                                                    <div class="option-box">1</div>
                                                    <div class="option-box">2</div>
                                                    <div class="option-box">3</div>
                                                    <div class="option-box">4+</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Location -->
                                        <div class="custom-dropdown buy">
                                           
                                            <input type="text" class="form-control" id="buyLocationInput"
                                                placeholder="Select Location" readonly>
                                            <div class="dropdown-box">
                                                <div class="option-grid">
                                                    <div class="option-box">Dhaka</div>
                                                    <div class="option-box">Chittagong</div>
                                                    <div class="option-box">Sylhet</div>
                                                    <div class="option-box">Rajshahi</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-dropdown buy">
                                            <button type="submit" class="btn custom-button"><i class="fa-solid fa-magnifying-glass me-2"></i> Search</button>
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
                @if($properties->isNotEmpty() && $properties->filter(fn($property) => str_contains($property->property_listing, 'Top Listed'))->isNotEmpty() )
                @foreach ($properties->filter(fn($property) => str_contains($property->property_listing, 'Top Listed'))->take(8) as $property)
                    <a href="{{ $property->type == 'rent' ? route('view.rent.property', $property->slug) : route('view.buy.property', $property->slug) }}" class="no-hover-color-link">
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
                                    @if($property->space)
                                        <div class="">
                                            <i class="fa-regular fa-house"></i>
                                            SFT {{ $property->space }}
                                        </div>
                                    @endif

                                    @if($property->country_id == 19 && ($property->city || $property->propertyarea))
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

                                    @if($property->bedrooms)
                                        <div class="">
                                            <i class="fa-solid fa-bed"></i>
                                            {{ $property->bedrooms }}
                                        </div>
                                    @endif

                                    @if($property->bathrooms)
                                        <div>
                                            <i class="fa-solid fa-sink"></i>
                                           {{ $property->bathrooms }}
                                        </div>
                                    @endif

                                    @if($property->parking_space)
                                        <div>
                                            <i class="fa-solid fa-car"></i>
                                            {{ $property->parking_space }}
                                        </div>
                                    @endif

                                    @if($property->decoration == 'Full Furnished')
                                        <div >
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
                    @if($properties->where('type', 'rent')->isNotEmpty() )
                    @foreach ($properties->where('type', 'rent')->take(8) as $property)
                    <div class="swiper-slide">
                        <a href="{{ $property->type == 'rent' ? route('view.rent.property', $property->slug) : route('view.buy.property', $property->slug) }}" class="no-hover-color-link">
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
                                    @if($property->space)
                                        <div class="">
                                            <i class="fa-regular fa-house"></i>
                                            SFT {{ $property->space }}
                                        </div>
                                    @endif

                                    @if($property->country_id == 19 && ($property->city || $property->propertyarea))
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

                                    @if($property->bedrooms)
                                        <div class="">
                                            <i class="fa-solid fa-bed"></i>
                                            {{ $property->bedrooms }}
                                        </div>
                                    @endif

                                    @if($property->bathrooms)
                                        <div>
                                            <i class="fa-solid fa-sink"></i>
                                           {{ $property->bathrooms }}
                                        </div>
                                    @endif

                                    @if($property->parking_space)
                                        <div>
                                            <i class="fa-solid fa-car"></i>
                                            {{ $property->parking_space }}
                                        </div>
                                    @endif

                                    @if($property->decoration == 'Full Furnished')
                                        <div >
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
                    @if($properties->where('type', 'sell')->isNotEmpty() )
                    @foreach ($properties->where('type', 'sell')->take(8) as $property)
                    <div class="swiper-slide">
                        <a href="{{ $property->type == 'rent' ? route('view.rent.property', $property->slug) : route('view.buy.property', $property->slug) }}" class="no-hover-color-link">
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
                                    @if($property->space)
                                        <div class="">
                                            <i class="fa-regular fa-house"></i>
                                            SFT {{ $property->space }}
                                        </div>
                                    @endif

                                    @if($property->country_id == 19 && ($property->city || $property->propertyarea))
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

                                    @if($property->bedrooms)
                                        <div class="">
                                            <i class="fa-solid fa-bed"></i>
                                            {{ $property->bedrooms }}
                                        </div>
                                    @endif

                                    @if($property->bathrooms)
                                        <div>
                                            <i class="fa-solid fa-sink"></i>
                                           {{ $property->bathrooms }}
                                        </div>
                                    @endif

                                    @if($property->parking_space)
                                        <div>
                                            <i class="fa-solid fa-car"></i>
                                            {{ $property->parking_space }}
                                        </div>
                                    @endif

                                    @if($property->decoration == 'Full Furnished')
                                        <div >
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
                        <i class="fas fa-home"></i> </div>
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
                        <a href="#" >All Members <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    <div class="team-photo-container my-4">
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c" alt="Team Melody Group" class="img-fluid team-group-photo">
                    </div>

                    <div class="swiper-container member-slider">
                        <div class="swiper-wrapper">
                            
                            <div class="swiper-slide">
                                <div class="member-card">
                                    <div class="member-image-wrapper">
                                        <img src="{{ asset('frontend-assets') }}/images/slider1.webp" alt="Md Saif Uddin" class="member-image">
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
                                        <img src="{{ asset('frontend-assets') }}/images/slider1.webp" alt="Salah Uddin Shikder" class="member-image">
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
                                        <img src="{{ asset('frontend-assets') }}/images/slider1.webp" alt="Rainessa Mostafa" class="member-image">
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
                                        <img src="{{ asset('frontend-assets') }}/images/slider1.webp" alt="Rainessa Mostafa" class="member-image">
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
                    <a href="" >View All <i class="fa-solid fa-arrow-right"></i></a>
                    <h3 class="reviews-title">CLIENT REVIEWS</h3>
                </div>

                <div class="swiper-container review-slider">
                    <div class="swiper-wrapper">
                        
                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="stars mb-3">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p class="review-text">Excellent service! They saved me days of work and ensured my documents were 100% accurate.</p>
                                
                                <div class="reviewer-info d-flex align-items-center mt-4">
                                    <img src="path/to/manirul/sarker.jpg" alt="Md. Manirul Haque Sarker" class="reviewer-avatar">
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
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p class="review-text">I had no idea about land documentation, but their team handled everything perfectly.</p>
                                
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
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p class="review-text">Quick processing, clear communication, and no hidden charges — exactly what I needed.</p>
                                
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
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p class="review-text">Quick processing, clear communication, and no hidden charges — exactly what I needed.</p>
                                
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
                        <form class="contact-form">
                            
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control mb-3" id="full_name" placeholder="Enter Your Name">

                            <label for="contact_number" class="form-label">Contact Number</label>
                            <div class="input-group mb-3">
                                <input type="tel" class="form-control" id="contact_number" placeholder="Contact Nubmer">
                                <span class="input-group-text">(Bangladesh)</span>
                            </div>

                            <label for="email_address" class="form-label">Email Address</label>
                            <input type="email" class="form-control mb-3" id="email_address" placeholder="Enter Your Email Address">

                            <label for="country" class="form-label">Select Your Living Country</label>
                            <select class="form-select mb-3" id="country">
                                <option selected>Bangladesh</option>
                                <option>USA</option>
                                <option>UK</option>
                                </select>

                            <label class="form-label">Set Your Schedule (BD Time)</label>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <input type="time" class="form-control" value="10:00" step="600">
                                </div>
                                <div class="col-6">
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            
                            <label for="demands" class="form-label">Select Multiple Demands</label>
                            <select class="form-select mb-3" id="demands" multiple>
                                <option>...Select Multiple Demands</option>
                                <option>Property Inquiry</option>
                                <option>Consultation</option>
                                <option>Document Service</option>
                                </select>

                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control mb-4" id="message" rows="3" placeholder="...go ahead. We are listening"></textarea>
                            
                            <button type="submit" class="btn btn-submit w-100">Submit</button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="map-container">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1573.5049363022513!2d90.4144549927618!3d23.77490076110839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c70c0c6d5955%3A0xc6657c6b48450f38!2sMelody%20Housing%20Agency!5e0!3m2!1sen!2sbd!4v1717800000000!5m2!1sen!2sbd" 
                                width="100%" 
                                height="600" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                class="contact-map"
                            ></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
        const swiper1 = new Swiper(".mySwiper1", {
            slidesPerView: 4.3,
            spaceBetween: 20,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            centeredSlides: false, // prevent centering mid-way
            freeMode: false,       // snap to slides instead of stopping halfway
            resistanceRatio: 0,    // remove elastic feel when dragging
            slideToClickedSlide: true, // if user clicks, it aligns properly

            navigation: {
                nextEl: ".swiper-button-next1",
                prevEl: ".swiper-button-prev1",
            },
            
            breakpoints: {
                0: { slidesPerView: 1.3 },
                768: { slidesPerView: 2.3 },
                992: { slidesPerView: 3.3 },
                1200: { slidesPerView: 4.3 },
            },
        });
    </script>
    <script>
        const swiper2 = new Swiper(".mySwiper2", {
            slidesPerView: 4.3,
            spaceBetween: 20,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            centeredSlides: false, // prevent centering mid-way
            freeMode: false,       // snap to slides instead of stopping halfway
            resistanceRatio: 0,    // remove elastic feel when dragging
            slideToClickedSlide: true, // if user clicks, it aligns properly

            navigation: {
                nextEl: ".swiper-button-next2",
                prevEl: ".swiper-button-prev2",
            },
            
            breakpoints: {
                0: { slidesPerView: 1.3 },
                768: { slidesPerView: 2.3 },
                992: { slidesPerView: 3.3 },
                1200: { slidesPerView: 4.3 },
            },
        });
    </script>
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
        const swiper3 = new Swiper('.member-slider', {
            // Optional parameters
            direction: 'horizontal',
            loop: false,
            slidesPerView: 1,
            spaceBetween: 20,

            navigation: {
                nextEl: '.swiper-button-next3',
                prevEl: '.swiper-button-prev3',
            },

            breakpoints: {
                // when window width is >= 768px (for tablets)
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // when window width is >= 992px (for desktops)
                992: {
                    slidesPerView: 3,
                    spaceBetween: 40
                }
            },

            // Make sure all slides are the same height
            autoHeight: true, 
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper4 = new Swiper('.review-slider', {
                // Optional parameters
                direction: 'horizontal',
                loop: false, 

                // How many slides to show at once
                slidesPerView: 1,
                spaceBetween: 25,

                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 768px (for tablets)
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 30
                    },
                    // when window width is >= 992px (for desktops)
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    }
                },

                // Make sure all slides are the same height
                autoHeight: false, 
            });
        });
    </script>
@endsection

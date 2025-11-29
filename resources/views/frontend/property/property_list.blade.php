@if ($properties->isNotEmpty())
    @foreach ($properties as $property)
        <a href="{{ $property->type == 'rent' ? route('view.rent.property', $property->slug) : route('view.buy.property', $property->slug) }}"
            class="no-hover-color-link">
            <div class="property-card position-relative">
                <img src="{{ asset($property->featured_image) }}" class="property-img" alt="Property Image">
                <div class="property-tags propertyTypeFixed">
                    @if ($property->property_listing)
                        @foreach (explode(',', $property->property_listing) as $listing)
                            @if ($listing != 'New')
                                <span class="tag">{{ trim($listing) }}</span>
                            @endif
                            @if ($listing == 'New')
                                <img src="{{ asset('frontend-assets/images/svgviewer-png-output (1).png') }}"
                                    class="tag-image">
                            @endif
                        @endforeach
                    @endif
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
                    <p class="mt-3 d-none d-md-block"> {{ Str::limit(strip_tags($property->description), 200, '...') }} </p>
                </div>
            </div>
        </a>
    @endforeach
@else
    <p> Sorry! No Properties Listed Yet . </p>
@endif

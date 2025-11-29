@extends('frontend.master')

@section('title')
    All Properties
@endsection

@section('description')
    {{ $setting->site_name }} All Properties
@endsection

@section('content')
    {{-- <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > All Properties</p>
        </div>
    </div> --}}

    <div class="hero-otherpage">
        <div class="image-hero" style="background-image: url('{{ asset('frontend-assets/images/slider.jpg') }}')">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 overlay">
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    <h1 class="text-white">Our All Properties</h1>
                    <p class="text-white text-center px-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy ...</p>
                </div>
            </div>
        </div>
        <div class="container d-flex p-4 gap-4">
            <div class="row texts">
                <div class="col-md-4">
                    <h2>Buy Dubai Properties: Luxury Property for Sale in UAE</h2>
                </div>
                <div class="col-md-8">
                    <p>Experience the pinnacle of luxury with buying a property in Dubai, where stunning architecture meets world-class amenities. Each residence seamlessly blends elegance with comfort, offering breathtaking views of the city skyline and pristine beaches. Buy Dubai properties and embrace a lifestyle defined by sophistication and unmatched beauty.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container  py-5 position-relative">
        <div
            class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between align-items-between align-items-md-center mb-3">
            <div class="d-flex gap-md-4 align-items-center justify-content-between mb-3 mb-md-0">
                <h3 class="reviews-title mb-0">All PROPERTIES</h3>
                <button id="filterToggle" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
            </div>

            <div class="d-flex gap-2 align-items-center justify-content-end justify-content-md-end">
                <!-- Search -->
                <input type="text" id="searchProperty" class="form-control mobile-slider-filterS"
                    placeholder="Search property..." style="width: 200px;">

                <!-- Sort by per page -->
                <select id="perPage" class="form-select mobile-slider-filterP" style="width: 100px;">
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                <!-- Order by price -->
                <select id="orderBy" class="form-select mobile-slider-filterO" style="width: 150px;">
                    <option value="low_high">Low to High</option>
                    <option value="high_low">High to Low</option>
                </select>

                <!-- Filter Sidebar Button -->

            </div>
        </div>
        <div class="grid-container mt-4 not-grid" id="propertyList">
            @include('frontend.property.property_list', ['properties' => $properties])
        </div>
        <div id="formLoaderbooking" class="form-loader booking d-none">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
    </div>
    <!-- Sidebar Filter -->
    <div id="filterSidebar" class="position-fixed top-0 start-0 bg-white shadow"
        style="width: 300px; height: 100vh; transform: translateX(-100%); transition: transform 0.4s ease; z-index: 1050; overflow-y: auto;">
        <div class="panel-header">
            <h5 class="">Filter Properties</h5>
        </div>

        <div class="p-4">
            <!-- Type -->
            <div class="mb-3">
                <label class="fw-bold">Property Type</label>
                <div class="d-flex align-items-center gap-2">
                    <label>
                        <input type="radio" name="type" value="rent" {{ $request->type == 'rent' ? 'checked' : '' }}>
                        Rent
                    </label>
                    <label>
                        <input type="radio" name="type" value="sell" {{ $request->type == 'sell' ? 'checked' : '' }}>
                        Sell
                    </label>
                </div>
            </div>

            <!-- Property Category -->
            <div class="mb-3">
                <label class="fw-bold">Category</label>
                <select id="propertyCategory" class="form-select">
                    <option value="">All Categories</option>
                    @foreach (\App\Models\PropertyType::all() as $cat)
                        <option value="{{ $cat->id }}" {{ $request->property_type_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->property_type }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Price Range -->
            <div class="mb-3">
                <label class="fw-bold">Price Range (৳)</label>
                <div class="d-flex align-items-center gap-2">
                    <input type="number" id="minPrice" class="form-control"
                        value="{{ $request->min_price ?? $lowestPrice }}" style="width: 100px;">
                    <span>-</span>
                    <input type="number" id="maxPrice" class="form-control"
                        value="{{ $request->max_price ?? $highestPrice }}" style="width: 100px;">
                </div>

                <div class="d-flex align-items-center mt-4 mb-2">
                    <input type="range" id="priceRangeMin" min="{{ $lowestPrice }}" max="{{ $highestPrice }}"
                        value="{{ $request->min_price ?? $lowestPrice }}">
                    <input type="range" id="priceRangeMax" min="{{ $lowestPrice }}" max="{{ $highestPrice }}"
                        value="{{ $request->max_price ?? $highestPrice }}">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <label class="fw-bold">Location</label>
                <!-- Country -->
                <div class="col-md-6">
                    <label>Country</label>
                    <select id="country" name="country_id" class="form-select">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ $request->country_id == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- District / State -->
                <div class="col-md-6" id="districtWrapper">
                    <label>District / State</label>
                    <select id="district" name="district_id" class="form-select">
                        <option value="">Select</option>
                    </select>
                </div>

                <!-- Upazila (Bangladesh only) -->
                <div class="col-md-12" id="upazilaWrapper">
                    <label>Upazila / City Corp.</label>
                    <select id="upazila" name="upazila_id" class="form-select">
                        <option value="">Select</option>
                    </select>
                </div>

                <!-- City -->
                <div class="col-md-12" id="cityWrapper">
                    <label>City / Thana</label>
                    <select id="city" name="city" class="form-select">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>


            <!-- Bedrooms -->
            <div class="mb-3">
                <label class="fw-bold">Bedrooms</label>
                <input type="number" id="bedrooms" class="form-control" value="{{ $request->bedrooms }}"
                    placeholder="e.g. 2">
            </div>

            <!-- Bathrooms -->
            <div class="mb-3">
                <label class="fw-bold">Bathrooms</label>
                <input type="number" id="bathrooms" class="form-control" placeholder="e.g. 1">
            </div>

            <!-- Parking -->
            <div class="mb-3">
                <label class="fw-bold">Parking Space</label>
                <input type="number" id="parking" class="form-control" placeholder="e.g. 1">
            </div>

            <!-- Rent Dates (only for rent type) -->
            <div class="mb-3" id="rentDateContainer" style="display:none;">
                <label class="fw-bold">Rent Date Range</label>
                <input type="text" id="rentDateRange" class="form-control" placeholder="Select date range">
            </div>

            <button id="applyFilters" class="btn btn-primary w-100 mt-3">Apply Filters</button>
            <button id="resetFilters" class="btn btn-outline-secondary w-100 mt-2">
                Reset Filters
            </button>
        </div>

    </div>
    </div>

    <!-- Overlay -->
    <div id="overlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000070; z-index:1049;">
    </div>
@endsection

@section('customJs')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash/lodash.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Sidebar toggle
            const sidebar = document.getElementById('filterSidebar');
            const overlay = document.getElementById('overlay');
            document.getElementById('filterToggle').onclick = () => {
                sidebar.style.transform = "translateX(0)";
                overlay.style.display = "block";
            };
            overlay.onclick = () => {
                sidebar.style.transform = "translateX(-100%)";
                overlay.style.display = "none";
            };

            // ✅ Flatpickr for Rent date range
            const existingDateRange = '{{ $request->rent_date_range ?? '' }}';

            flatpickr("#rentDateRange", {
                mode: "range",
                minDate: "today",
                dateFormat: "Y-m-d",
                defaultDate: existingDateRange ? existingDateRange.split(" to ") : null,
            });

            // ✅ Dual Range Setup
            function setupRange(minRangeId, maxRangeId, minInputId, maxInputId) {
                const minRange = document.getElementById(minRangeId);
                const maxRange = document.getElementById(maxRangeId);
                const minInput = document.getElementById(minInputId);
                const maxInput = document.getElementById(maxInputId);

                function sync() {
                    let min = parseInt(minRange.value);
                    let max = parseInt(maxRange.value);
                    if (min > max)[min, max] = [max, min];
                    minInput.value = min;
                    maxInput.value = max;
                }
                minRange.addEventListener('input', sync);
                maxRange.addEventListener('input', sync);
                minInput.addEventListener('input', sync);
                maxInput.addEventListener('input', sync);
                sync();
            }
            setupRange("priceRangeMin", "priceRangeMax", "minPrice", "maxPrice");

            $(document).ready(function() {
                // Load initial (Bangladesh default)
                loadDistricts();

                $('#country').on('change', function() {
                    const countryId = $(this).val();

                    if (countryId == 19) {
                        // ✅ Bangladesh selected
                        $('#upazilaWrapper').show();
                        loadDistricts();
                    } else {
                        // 🌍 Other country selected
                        $('#upazilaWrapper').hide();
                        loadStates(countryId);
                    }
                });

                $('#district').on('change', function() {
                    const districtId = $(this).val();
                    const countryId = $('#country').val();

                    if (countryId == 19 && districtId) {
                        loadUpazilas(districtId);
                    } else if (countryId != 19 && districtId) {
                        loadCitiesByState(districtId);
                    }
                });

                $('#upazila').on('change', function() {
                    const upazilaId = $(this).val();
                    if (upazilaId) {
                        loadCitiesByUpazila(upazilaId);
                    }
                });

                // 🔹 Bangladesh — Districts
                // ✅ Function to load districts dynamically
                function loadDistricts() {
                    $.get('{{ route('collect.districts') }}', function(data) {
                        const selectedDistrict = '{{ $request->district_id ?? '' }}';
                        $('#district').empty().append('<option value="">Select District</option>');

                        data.forEach(d => {
                            const selected = (d.id == selectedDistrict) ? 'selected' : '';
                            $('#district').append(
                                `<option value="${d.id}" ${selected}>${d.name}</option>`
                                );
                        });
                    });
                }

                // 🔹 Bangladesh — Upazilas
                function loadUpazilas(districtId) {
                    $.get(`{{ url('/collect-upazilas/') }}/${districtId}`, function(data) {
                        $('#upazila').empty().append('<option value="">Select Upazila</option>');
                        data.forEach(u => $('#upazila').append(
                            `<option value="${u.id}">${u.name}</option>`));
                    });
                }

                // 🌍 Non-Bangladesh — States
                function loadStates(countryId) {
                    $.get(`{{ url('/collect-states/') }}/${countryId}`, function(data) {
                        $('#district').empty().append('<option value="">Select State</option>');
                        data.forEach(s => $('#district').append(
                            `<option value="${s.id}">${s.name}</option>`));
                    });
                }

                // 🔹 Load Cities (for non-BD countries)
                function loadCitiesByState(stateId) {
                    $.get(` {{ url('/get-cities-by-state/') }}/${stateId}`, function(data) {
                        $('#city').empty().append('<option value="">Select City</option>');
                        data.forEach(c => $('#city').append(`<option value="${c}">${c}</option>`));
                    });
                }

                // 🔹 Load Cities (for BD upazila)
                function loadCitiesByUpazila(upazilaId) {
                    $.get(` {{ url('/get-cities-by-upazila/') }}/${upazilaId}`, function(data) {
                        $('#city').empty().append('<option value="">Select City</option>');
                        data.forEach(c => $('#city').append(`<option value="${c}">${c}</option>`));
                    });
                }
            });





            // 🔹 Reset button logic
            $('#resetFilters').on('click', function() {
                // Clear all select & input fields
                $('#country').val('19').trigger('change'); // default to Bangladesh
                $('#district').val('');
                $('#upazila').val('');
                $('#city').val('');
                $('#propertyCategory').val('');
                $('#minPrice').val('');
                $('#maxPrice').val('');
                $('#bedrooms').val('');
                $('#bathrooms').val('');
                $('#parking').val('');
                $('#rentDateRange').val('');
                $('#searchProperty').val('');
                $('input[name="type"]').prop('checked', false);

                // Reload all properties
                fetchProperties();
            });

            // ✅ AJAX Filter Function
            function fetchProperties() {
                const params = {
                    search: document.getElementById('searchProperty').value,
                    per_page: document.getElementById('perPage').value,
                    order: document.getElementById('orderBy').value,
                    type: document.querySelector('input[name="type"]:checked')?.value,
                    property_type_id: document.getElementById('propertyCategory').value,
                    min_price: document.getElementById('minPrice').value,
                    max_price: document.getElementById('maxPrice').value,
                    bedrooms: document.getElementById('bedrooms').value,
                    bathrooms: document.getElementById('bathrooms').value,
                    parking_space: document.getElementById('parking').value,
                    rent_date_range: document.getElementById('rentDateRange').value,
                    country_id: document.getElementById('country')?.value || '',
                    district_id: document.getElementById('district')?.value || '',
                    upazila_id: document.getElementById('upazila')?.value || '',
                    city: document.getElementById('city')?.value || '',
                };

                const loader = document.getElementById('formLoaderbooking');
                loader.classList.remove('d-none');

                fetch("{{ route('properties.filter') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(params),
                    })
                    .then(res => res.text())
                    .then(html => {
                        loader.classList.add('d-none');
                        document.getElementById('propertyList').innerHTML = html;
                        overlay.style.display = "none";
                        sidebar.style.transform = "translateX(-100%)";
                    });
            }

            // Trigger filtering
            document.getElementById('applyFilters').onclick = fetchProperties;
            document.getElementById('searchProperty').onkeyup = _.debounce(fetchProperties, 500);
            document.getElementById('perPage').onchange = fetchProperties;
            document.getElementById('orderBy').onchange = fetchProperties;



        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const rentDateContainer = document.getElementById('rentDateContainer');

            // ✅ Function to toggle visibility
            function toggleRentDateContainer() {
                const selectedType = document.querySelector('input[name="type"]:checked');
                if (selectedType && selectedType.value === 'rent') {
                    rentDateContainer.style.display = 'block';
                } else {
                    rentDateContainer.style.display = 'none';
                }
            }

            // ✅ Run it once on page load (for preselected request values)
            toggleRentDateContainer();

            // ✅ Also listen for radio changes
            document.querySelectorAll('input[name="type"]').forEach(radio => {
                radio.addEventListener('change', toggleRentDateContainer);
            });

        });
    </script>
@endsection

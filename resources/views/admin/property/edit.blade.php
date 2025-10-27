@extends('admin.master')

@section('title')
    Edit Property
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid my-4 w-100">
            <div class="d-flex mb-2 justify-content-between align-items-center">
                <h3>Edit Property</h3>
                <a href="{{ route('property.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </section>

    <section class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="alert-ul">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('property.update', $property->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="row">
                <input type="hidden" name="type" id="type" value="{{ $property->type }}">
                {{-- Left Column --}}
                <div class="col-md-7">
                    {{-- Basic Info --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name">Property Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required value="{{ $property->name }}">
                            </div>
                        
                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" placeholder="Property description..."> {{ $property->description }} </textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Featured Image</h4>
                            <input type="file" name="featured_image" id="featured-image-upload" accept="image/*" class="form-control">

                            <div id="image-preview" class="mt-3" style="position: relative; max-width: 200px;">
                            @if ($property->featured_image)
                                <img id="preview-img" src="{{ asset($property->featured_image) }}" alt="Preview" class="img-fluid rounded border">
                            @endif
                            </div>
                        </div>
                    </div>

                    {{-- Gallery Images --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Image Gallery</h4>
                            <input type="file" name="gallery_images[]" id="gallery-images" accept="image/*" multiple class="form-control">

                            <div id="gallery-preview" class="mt-3 d-flex flex-wrap gap-2">
                            @foreach ($property->images as $image)
                                <div class="position-relative gallery-item" data-id="{{ $image->id }}" style="max-width:120px;">
                                <img src="{{ asset($image->image) }}" class="img-fluid rounded border">
                                <button type="button" class="remove-gallery-image"
                                    style="position:absolute;top:5px;right:5px;background:red;color:white;border:none;border-radius:50%;width:25px;height:25px;cursor:pointer;">🗑️</button>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Price & Inventory --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            @if($property->type == 'rent')
                            <div class="mb-3">
                                <label for="rent_start">Booking Starting Date</label>
                                <input type="date" name="rent_start" id="rent_start" class="form-control myDate" value="{{ $property->rent_start }}" placeholder="Booking Starting Date" required>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="number" name="price" id="price" class="form-control" placeholder="Price" value="{{ $property->price }}">
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="space">Property Space</label>
                                    <input type="number" name="space" id="space" class="form-control" value="{{ $property->space }}" placeholder="Property Space">
                                </div>
                                <div class="col-md-6">
                                    <label for="parking_space">Parking Space</label>
                                    <input type="number" name="parking_space" id="parking_space" class="form-control" value="{{ $property->parking_space }}" placeholder="Parking Space">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bedrooms">Bedrooms</label>
                                    <input type="number" name="bedrooms" id="bedrooms" class="form-control" placeholder="Bedrooms" value="{{ $property->bedrooms }}"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="bathrooms">Bathrooms</label>
                                    <input type="number" name="bathrooms" id="bathrooms" class="form-control" placeholder="Bathrooms" value="{{ $property->bathrooms }}">
                                </div>
                            </div>
                            @if($property->type == 'rent')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bedrooms">CheckIn Time</label>
                                    <input type="time" name="check_in" class="form-control" placeholder="Check In Time" value="{{ $property->check_in }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="bathrooms">Check Out Time</label>
                                    <input type="time" name="check_out" class="form-control" placeholder="Check Out Time" value="{{ $property->check_out }}">
                                </div>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label for="">Decoration Status</label>
                                <select name="decoration" class="form-select" id="">
                                    <option value="">Decoration Status</option>
                                    <option value="Painted" {{ $property->decoration == 'Painted' ? 'Selected' : '' }}>Painted</option> 
                                    <option value="Not Painted" {{ $property->decoration == 'Not Painted' ? 'Selected' : '' }}>Not Painted</option>
                                    <option value="Full Furnished" {{ $property->decoration == 'Full Furnished' ? 'Selected' : '' }}>Full Furnished</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Features</h4>

                            <div id="featuresContainer"></div>

                            <button type="button" class="btn btn-primary w-100 mt-3" id="addFeatureBtn">
                                Add Feature
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="col-md-5">
                    <div class="card mb-3">
                        <div class="card-body">
                            <label for="realtor_id">Select Realtor</label>
                                <select name="realtor_id" id="realtor_id" class="form-select">
                                <option value="">Select Realtor</option>
                                @foreach($realtors as $realtor)
                                    <option value="{{ $realtor->id }}" {{ $property->realtor_id == $realtor->id ? 'selected' : '' }} >{{ $realtor->name }}</option>
                                @endforeach
                                </select>
                        </div>
                    </div>
                    {{-- Country & State --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Location</h4>

                            {{-- Country --}}
                            <div class="mb-3">
                                <label for="country">Country</label>
                                <select name="country_id" id="country" class="form-select">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $property->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- State --}}
                            <div class="mb-3" id="state-wrapper">
                                <label for="state">State</label>
                                <select name="state_id" id="state" class="form-select">
                                    <option value="">Select State</option>
                                </select>
                            </div>

                            {{-- District (Bangladesh) --}}
                            <div class="mb-3 d-none" id="district-wrapper">
                                <label for="district">District</label>
                                <select name="district_id" id="district" class="form-select">
                                    <option value="">Select District</option>
                                </select>
                            </div>

                            {{-- Upazilla --}}
                            <div class="mb-3 d-none" id="upazilla-wrapper">
                                <label for="upazilla">Property Area</label>
                                <select name="upazilla_id" id="upazilla" class="form-select">
                                    <option value="">Select Property Area</option>
                                </select>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="">City</label>
                                    <input type="text" name="city" class="form-control" placeholder="City" value="{{ $property->city }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Road</label>
                                    <input type="text" name="road" class="form-control" placeholder="Road" value="{{ $property->road }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="">House</label>
                                    <input type="text" name="house" class="form-control" placeholder="House" value="{{ $property->house }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Property Type --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Property Type</h4>
                            <div class="mb-3 d-flex align-items-center gap-2">
                            <select name="property_type_id" id="property_type_id" class="form-select">
                                <option value="">Select Property Type</option>
                                @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}" {{ $property->property_type_id == $type->id ? 'selected' : '' }} >{{ $type->property_type }}</option>
                                @endforeach
                            </select>

                            <!-- Add New Button -->
                            <button type="button" id="addNewTypeBtn" class="btn btn-primary btn-sm">
                                + Add New
                            </button>
                            </div>

                            <!-- Hidden Add New Input -->
                            <div id="newTypeField" class="mt-2" style="display:none;">
                            <div class="input-group">
                                <input type="text" id="newTypeInput" class="form-control" placeholder="Enter new property type">
                                <button type="button" id="saveNewType" class="btn btn-success">Save</button>
                                <button type="button" id="cancelNewType" class="btn btn-danger">Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    @php
                        // Convert the comma-separated column into an array
                        $selectedCategories = explode(',', $property->property_listing ?? '');
                    @endphp
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Property Category</h4>
                            <select name="property_listing[]" id="property_categories" class="form-select" multiple>
                            <option value="Ready">Ready</option>
                            <option value="New">New</option>
                            <option value="Top Listed">Top Listed</option>
                            <option value="Resort Apartment">Used</option>
                            <option value="Brand New">Brand New</option>
                            <option value="Old">Old</option>
                            <option value="Old">Full </option>
                            </select>
                        </div>
                    </div>
                    {{-- Amenities --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Amenities</h4>

                            <div id="amenitiesContainer"></div>

                            <button type="button" class="btn btn-primary w-100 mt-3" id="addAmenityBtn">
                                Add Amenity
                            </button>
                        </div>
                    </div>

                </div>

            </div>

            <div class="pt-3 pb-5">
                <button type="submit" class="btn btn-primary w-100">Update Property</button>
            </div>

        </div>
        </form>
    </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
  /** ==============================
   *  FEATURED IMAGE
   * ============================== */
  const featuredInput = document.getElementById("featured-image-upload");
  const imagePreview = document.getElementById("image-preview");
  let originalImgHTML = imagePreview.innerHTML; // Save the original image HTML

  featuredInput.addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        // Replace preview with new image + remove button
        imagePreview.innerHTML = `
          <img id="preview-img" src="${e.target.result}" alt="Preview" class="img-fluid rounded border">
          <button type="button" id="remove-image"
            style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer;">
            🗑️
          </button>
        `;

        // Remove new preview
        document.getElementById("remove-image").addEventListener("click", function() {
          featuredInput.value = "";
          imagePreview.innerHTML = originalImgHTML; // Restore old image
        });
      };
      reader.readAsDataURL(file);
    }
  });

  /** ==============================
   *  GALLERY IMAGES
   * ============================== */
  const galleryInput = document.getElementById("gallery-images");
  const galleryPreview = document.getElementById("gallery-preview");
  let selectedFiles = [];

  // Handle deleting existing (old) gallery images
  galleryPreview.addEventListener("click", function(e) {
    if (e.target.classList.contains("remove-gallery-image")) {
      const parentDiv = e.target.closest(".gallery-item");
      const imageId = parentDiv.getAttribute("data-id");
      const galleryDeleteRoute = "{{ route('property.gallery.delete', ':id') }}";
      const url = galleryDeleteRoute.replace(':id', imageId); // replace :id with actual ID
      if (confirm("Delete this image permanently?")) {
        fetch(url, {
          method: "POST", // ✅ using POST not DELETE
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            parentDiv.remove();
            toastr.success("Image deleted successfully!");
          } else {
            toastr.error("Failed to delete image!");
          }
        })
        .catch(() => toastr.error("Error deleting image!"));
      }
    }
  });

  // Handle new gallery uploads
  galleryInput.addEventListener("change", function(event) {
    const files = Array.from(event.target.files);
    selectedFiles = selectedFiles.concat(files);
    renderGallery();
  });

  function renderGallery() {
    // Remove only new-uploaded previews
    galleryPreview.querySelectorAll(".new-upload").forEach(div => div.remove());

    selectedFiles.forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = function(e) {
        const div = document.createElement("div");
        div.classList.add("position-relative", "new-upload");
        div.style.maxWidth = "120px";

        const img = document.createElement("img");
        img.src = e.target.result;
        img.alt = "Gallery Image";
        img.classList.add("img-fluid", "rounded", "border");

        const removeBtn = document.createElement("button");
        removeBtn.innerHTML = "🗑️";
        removeBtn.type = "button";
        removeBtn.style.position = "absolute";
        removeBtn.style.top = "5px";
        removeBtn.style.right = "5px";
        removeBtn.style.background = "red";
        removeBtn.style.color = "white";
        removeBtn.style.border = "none";
        removeBtn.style.borderRadius = "50%";
        removeBtn.style.width = "25px";
        removeBtn.style.height = "25px";
        removeBtn.style.cursor = "pointer";

        // Instantly remove new preview (no confirmation)
        removeBtn.addEventListener("click", () => {
          selectedFiles.splice(index, 1);
          div.remove(); // ✅ Instantly remove from DOM
          updateGalleryInput();
        });

        div.appendChild(img);
        div.appendChild(removeBtn);
        galleryPreview.appendChild(div);
      };
      reader.readAsDataURL(file);
    });

    updateGalleryInput();
  }

  function updateGalleryInput() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    galleryInput.files = dataTransfer.files;
  }
});
</script>





<script>
$(document).ready(function () {
  // Initialize Select2 for Property Category
  const $propertyCategories = $('#property_categories');

    // Initialize select2
    $propertyCategories.select2({
        placeholder: "Select categories",
        allowClear: true
    });

    // Preselect saved values
    const selected = @json($selectedCategories); // ['Ready', 'Top Listed', ...]
    $propertyCategories.val(selected).trigger('change');

  /** ============================
   *  Add New Property Type Inline
   * ============================ */
  const $addNewBtn = $('#addNewTypeBtn');
  const $newTypeField = $('#newTypeField');
  const $newTypeInput = $('#newTypeInput');
  const $saveNewType = $('#saveNewType');
  const $cancelNewType = $('#cancelNewType');
  const $propertySelect = $('#property_type_id');

  // Show input field
  $addNewBtn.on('click', function () {
    $newTypeField.slideDown(200);
    $addNewBtn.hide();
    $newTypeInput.focus();
  });

  // Cancel adding new type
  $cancelNewType.on('click', function () {
    $newTypeInput.val('');
    $newTypeField.slideUp(200);
    $addNewBtn.show();
  });

  // Save new type (frontend only – you can extend with AJAX later)
  $saveNewType.on('click', function () {
    const newType = $newTypeInput.val().trim();

    if (newType === '') {
      alert('Please enter a property type name');
      return;
    }

    $.ajax({
        url: "{{ route('property-types.store') }}", // ✅ using route name
        method: "POST",
        data: {
        name: newType,
        _token: "{{ csrf_token() }}"
        },
        beforeSend: function() {
        $saveNewType.prop("disabled", true).text("Saving...");
        },
        success: function (response) {
        if (response.success) {
            // Add new option dynamically
            const newOption = new Option(response.name, response.id, true, true);
            $propertySelect.append(newOption).trigger('change');

            toastr.success(response.message || "Property type added successfully!");
            
            // Reset input and hide
            $newTypeInput.val('');
            $newTypeField.slideUp(200);
            $addNewBtn.show();
        } else {
            toastr.warning(response.message || "Something went wrong!");
        }
        },
        error: function (xhr) {
        if (xhr.status === 422 && xhr.responseJSON?.errors) {
            const errors = xhr.responseJSON.errors;
            Object.values(errors).forEach(err => toastr.error(err[0]));
        } else {
            toastr.error("Failed to add new property type. Try again.");
        }
        },
        complete: function() {
        $saveNewType.prop("disabled", false).text("Save");
        }
    });

    // Add to select list dynamically
    const newOption = new Option(newType, 'new_' + Date.now(), true, true);
    $propertySelect.append(newOption).trigger('change');

    // Reset input
    $newTypeInput.val('');
    $newTypeField.slideUp(200);
    $addNewBtn.show();
  });
});
</script>




<script>
$(document).ready(function () {
    const $country  = $('#country');
    const $state    = $('#state');
    const $district = $('#district');
    const $upazilla = $('#upazilla');

    const $stateWrapper    = $('#state-wrapper');
    const $districtWrapper = $('#district-wrapper');
    const $upazillaWrapper = $('#upazilla-wrapper');

    const selectedCountryId  = "{{ $property->country_id }}";
    const selectedStateId    = "{{ $property->state_id }}";
    const selectedUpazillaId = "{{ $property->property_area_id }}";

    function loadStates(countryId, callback) {
        $.ajax({
            url: "{{ route('get.states') }}",
            type: "GET",
            data: { country_id: countryId },
            success: function(res) {
                $state.html('<option value="">Select State</option>');
                if (res.success) {
                    res.data.forEach(s => {
                        const selected = s.id == selectedStateId ? 'selected' : '';
                        $state.append(`<option value="${s.id}" ${selected}>${s.name}</option>`);
                    });
                }
                callback?.();
            }
        });
    }

    function loadDistricts(countryId, callback) {
        $.ajax({
            url: "{{ route('get.districts') }}",
            type: "GET",
            data: { country_id: countryId },
            success: function(res) {
                $district.html('<option value="">Select District</option>');
                if (res.success) {
                    res.data.forEach(d => {
                        const selected = d.id == selectedStateId ? 'selected' : '';
                        $district.append(`<option value="${d.id}" ${selected}>${d.name}</option>`);
                    });
                }
                callback?.();
            }
        });
    }

    function loadUpazillas(districtId) {
        $.ajax({
            url: "{{ route('get.upazillas') }}",
            type: "GET",
            data: { district_id: districtId },
            success: function(res) {
                $upazilla.html('<option value="">Select Property Area</option>');
                if (res.success) {
                    $upazillaWrapper.removeClass('d-none');
                    res.data.forEach(u => {
                        const selected = u.id == selectedUpazillaId ? 'selected' : '';
                        $upazilla.append(`<option value="${u.id}" ${selected}>${u.name}</option>`);
                    });
                }
            }
        });
    }

    // ------------------
    // On page load
    // ------------------
    if (selectedCountryId == 19) {
        $stateWrapper.addClass('d-none');
        $state.val(''); // clear state value
        $districtWrapper.removeClass('d-none');
        loadDistricts(selectedCountryId, function() {
            if (selectedStateId) loadUpazillas(selectedStateId); // state_id stores district
        });
    } else if (selectedCountryId) {
        $stateWrapper.removeClass('d-none');
        $districtWrapper.addClass('d-none');
        $district.val(''); // clear district value
        loadStates(selectedCountryId);
    } else {
        $stateWrapper.addClass('d-none');
        $districtWrapper.addClass('d-none');
    }

    // ------------------
    // On Country change
    // ------------------
    $country.on('change', function () {
        const countryId = $(this).val();

        $state.html('<option value="">Select State</option>');
        $district.html('<option value="">Select District</option>');
        $upazilla.html('<option value="">Select Property Area</option>');
        $upazillaWrapper.addClass('d-none');

        if (!countryId) {
            $stateWrapper.addClass('d-none');
            $districtWrapper.addClass('d-none');
            return;
        }

        if (countryId == 19) {
            $stateWrapper.addClass('d-none');
            $state.val(''); // clear state value
            $districtWrapper.removeClass('d-none');
            loadDistricts(countryId);
        } else {
            $districtWrapper.addClass('d-none');
            $district.val(''); // clear district value
            $stateWrapper.removeClass('d-none');
            loadStates(countryId);
        }
    });

    // ------------------
    // On District change: load upazilla
    // ------------------
    $district.on('change', function () {
        const districtId = $(this).val();
        $upazilla.html('<option value="">Select Property Area</option>');
        if (!districtId) {
            $upazillaWrapper.addClass('d-none');
            return;
        }
        loadUpazillas(districtId);
    });
});
</script>




<script>
document.addEventListener("DOMContentLoaded", function () {
    const featuresContainer = document.getElementById("featuresContainer");
    const addFeatureBtn = document.getElementById("addFeatureBtn");

    // 🏷️ Saved features from server
    const savedFeatures = @json($property->features ?? []); 
    // Expected format: [{id: 1, feature_keys: "Size", feature_values: "1200 sqft"}, {...}]

    // 🧩 Function to create a feature input row
    function createFeatureInput(key = "", value = "", id = null) {
        const wrapper = document.createElement("div");
        wrapper.classList.add("input-group", "mb-2", "feature-item");

        // If it's an existing feature, store its ID
        const idInput = id ? `<input type="hidden" name="feature_ids[]" value="${id}">` : "";

        wrapper.innerHTML = `
            ${idInput}
            <input type="text" name="feature_keys[]" class="form-control" placeholder="Feature Name" value="${key}">
            <input type="text" name="feature_values[]" class="form-control" placeholder="Feature Value" value="${value}">
            <button type="button" class="btn btn-danger remove-feature">
                <i class="fa fa-trash"></i>
            </button>
        `;

        // Remove feature when clicked
        wrapper.querySelector(".remove-feature").addEventListener("click", function () {
            wrapper.remove();
        });

        return wrapper;
    }

    // ➡️ Render saved features correctly
    savedFeatures.forEach(feature => {
        featuresContainer.appendChild(
            createFeatureInput(feature.feature_keys, feature.feature_values, feature.id)
        );
    });

    // ➕ Add new feature
    addFeatureBtn.addEventListener("click", function () {
        featuresContainer.appendChild(createFeatureInput());
    });
});


</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const amenitiesContainer = document.getElementById("amenitiesContainer");
    const addAmenityBtn = document.getElementById("addAmenityBtn");

    // 🏷️ Saved amenities from server
    const savedAmenities = @json($property->amenities->pluck('amenities') ?? []);
    // This gives an array of saved amenity values

    // 🧩 Function to create one amenity input row
    function createAmenityInput(value = "") {
        const wrapper = document.createElement("div");
        wrapper.classList.add("input-group", "mb-2", "amenity-item");

        wrapper.innerHTML = `
            <input type="text" name="amenities[]" class="form-control" placeholder="Enter Amenity" value="${value}">
            <button type="button" class="btn btn-danger remove-amenity">
                <i class="fa fa-trash"></i>
            </button>
        `;

        wrapper.querySelector(".remove-amenity").addEventListener("click", function () {
            wrapper.remove();
        });

        return wrapper;
    }

    // ➡️ Render saved amenities first
    savedAmenities.forEach(amenity => {
        amenitiesContainer.appendChild(createAmenityInput(amenity));
    });

    // ➕ Add new amenity dynamically
    addAmenityBtn.addEventListener("click", function () {
        amenitiesContainer.appendChild(createAmenityInput());
    });
});
</script>


<script>
$(document).ready(function () {

    $('form').on('submit', function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        // Show loader
        $('#fullscreenLoader').fadeIn(200);

        $.ajax({
            url: form.action,
            method: form.method,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#fullscreenLoader').fadeOut(200);

                if (response.success) {
                    toastr.success(response.message || "Property updated successfully!");
                    // If property type is included in the response, adjust dynamically
                    
                    if (response.property_type && response.property_type.toLowerCase() === 'sell') {
                        redirectUrl = "{{ route('property.sell') }}";
                    } else if (response.property_type && response.property_type.toLowerCase() === 'rent') {
                        redirectUrl = "{{ route('property.index') }}";
                    }

                    window.location.href = redirectUrl;

                } else {
                    toastr.warning(response.message || "Unexpected response.");
                }
            },
            error: function (xhr) {
                $('#fullscreenLoader').fadeOut(200);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.values(errors).forEach(errArr => {
                        toastr.error(errArr[0]);
                    });
                } else {
                    toastr.error("Something went wrong while saving the property.");
                }
            }
        });
    });

});
</script>

@endsection

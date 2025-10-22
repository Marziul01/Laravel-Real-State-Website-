@extends('admin.master')

@section('title')
    Add New Selling Property
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid my-4 w-100">
            <div class="d-flex mb-2 justify-content-between align-items-center">
                <h3>Add New Selling Property</h3>
                <a href="{{ route('property.sell') }}" class="btn btn-primary">Back</a>
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

        <form action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <input type="hidden" name="type" id="type" value="sell">
                {{-- Left Column --}}
                <div class="col-md-7">
                    {{-- Basic Info --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name">Property Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                            </div>
                        
                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" placeholder="Property description..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Featured Image</h4>
                            <input type="file" name="featured_image" id="featured-image-upload" accept="image/*" class="form-control">
                            <div id="image-preview" class="mt-3" style="display:none; position: relative; max-width: 200px;">
                            <img id="preview-img" src="" alt="Preview" class="img-fluid rounded border">
                            <button type="button" id="remove-image"
                                style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer;">
                                🗑️
                            </button>
                            </div>
                        </div>
                    </div>

                        {{-- Gallery Images --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Image Gallery</h4>
                            <input type="file" name="gallery_images[]" id="gallery-images" accept="image/*" multiple class="form-control">
                            <div id="gallery-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>

                    {{-- Price & Inventory --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            
                            <div class="mb-3">
                                <label for="price"> Price</label>
                                <input type="number" name="price" id="price" class="form-control" placeholder="Price" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="space">Property Space</label>
                                    <input type="number" name="space" id="space" class="form-control" placeholder="Property Space">
                                </div>
                                <div class="col-md-6">
                                    <label for="parking_space">Parking Space</label>
                                    <input type="number" name="parking_space" id="parking_space" class="form-control" placeholder="Parking Space">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bedrooms">Bedrooms</label>
                                    <input type="number" name="bedrooms" id="bedrooms" class="form-control" placeholder="Bedrooms">
                                </div>
                                <div class="col-md-6">
                                    <label for="bathrooms">Bathrooms</label>
                                    <input type="number" name="bathrooms" id="bathrooms" class="form-control" placeholder="Bathrooms">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="">Decoration Status</label>
                                <select name="decoration" class="form-select" id="">
                                    <option value="">Decoration Status</option>
                                    <option value="Painted">Painted</option> 
                                    <option value="Not Painted">Not Painted</option>
                                    <option value="Full Furnished">Full Furnished</option>
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
                                    <option value="{{ $realtor->id }}">{{ $realtor->name }}</option>
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
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                                </select>
                            </div>

                            {{-- State or District --}}
                            <div class="mb-3" id="state-wrapper">
                                <label for="state">State</label>
                                <select name="state_id" id="state" class="form-select">
                                <option value="">Select State</option>
                                </select>
                            </div>

                            {{-- District (for Country 19) --}}
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
                                    <input type="text" name="city" class="form-control" placeholder="City" >
                                </div>
                                <div class="col-md-4">
                                    <label for="">Road</label>
                                    <input type="text" name="road" class="form-control" placeholder="Road" >
                                </div>
                                <div class="col-md-4">
                                    <label for="">House</label>
                                    <input type="text" name="house" class="form-control" placeholder="House" >
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
                                <option value="{{ $type->id }}">{{ $type->property_type }}</option>
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
                <button type="submit" class="btn btn-primary w-100">Create Property</button>
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
   *  FEATURED IMAGE PREVIEW
   * ============================== */
  const featuredInput = document.getElementById("featured-image-upload");
  const imagePreview = document.getElementById("image-preview");
  const previewImg = document.getElementById("preview-img");
  const removeImageBtn = document.getElementById("remove-image");

  featuredInput.addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewImg.src = e.target.result;
        imagePreview.style.display = "block";
      };
      reader.readAsDataURL(file);
    }
  });

  removeImageBtn.addEventListener("click", function() {
    featuredInput.value = ""; // clear input
    previewImg.src = "";
    imagePreview.style.display = "none";
  });

  /** ==============================
   *  GALLERY IMAGE PREVIEW
   * ============================== */
  const galleryInput = document.getElementById("gallery-images");
  const galleryPreview = document.getElementById("gallery-preview");

  // Keep track of current valid File objects
  let selectedFiles = [];

  galleryInput.addEventListener("change", function(event) {
    const files = Array.from(event.target.files);
    selectedFiles = selectedFiles.concat(files); // append new ones

    renderGallery();
  });

  function renderGallery() {
    galleryPreview.innerHTML = "";

    selectedFiles.forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = function(e) {
        const div = document.createElement("div");
        div.classList.add("position-relative");
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

        // Remove only this image
        removeBtn.addEventListener("click", () => {
          selectedFiles.splice(index, 1);
          renderGallery();
        });

        div.appendChild(img);
        div.appendChild(removeBtn);
        galleryPreview.appendChild(div);
      };
      reader.readAsDataURL(file);
    });

    // Update the <input type="file"> with remaining files
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
  $('#property_categories').select2({
    placeholder: "Select Property Categories",
    allowClear: true,
    width: '100%'
  });

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

  // Country Change
  $country.on('change', function () {
    const countryId = $(this).val();

    // Reset dropdowns
    $state.html('<option value="">Select State</option>');
    $district.html('<option value="">Select District</option>');
    $upazilla.html('<option value="">Select Upazilla</option>');
    $upazillaWrapper.addClass('d-none');

    if (!countryId) {
      $stateWrapper.addClass('d-none');
      $districtWrapper.addClass('d-none');
      return;
    }

    if (countryId == 19) {
      // Show districts for Bangladesh (id = 19)
      $stateWrapper.addClass('d-none');
      $districtWrapper.removeClass('d-none');

      $.ajax({
        url: "{{ route('get.districts') }}",
        type: "GET",
        data: { country_id: countryId },
        success: function (res) {
          if (res.success) {
            $district.html('<option value="">Select District</option>');
            res.data.forEach(function (district) {
              $district.append(`<option value="${district.id}">${district.name}</option>`);
            });
          } else {
            toastr.warning(res.message || "No districts found.");
          }
        },
        error: function () {
          toastr.error("Failed to load districts.");
        }
      });
    } else {
      // Load states for other countries
      $districtWrapper.addClass('d-none');
      $stateWrapper.removeClass('d-none');

      $.ajax({
        url: "{{ route('get.states') }}",
        type: "GET",
        data: { country_id: countryId },
        success: function (res) {
          if (res.success) {
            $state.html('<option value="">Select State</option>');
            res.data.forEach(function (state) {
              $state.append(`<option value="${state.id}">${state.name}</option>`);
            });
          } else {
            toastr.warning(res.message || "No states found.");
          }
        },
        error: function () {
          toastr.error("Failed to load states.");
        }
      });
    }
  });

  // District Change (for Bangladesh)
  $district.on('change', function () {
    const districtId = $(this).val();
    $upazilla.html('<option value="">Select Upazilla</option>');

    if (!districtId) {
      $upazillaWrapper.addClass('d-none');
      return;
    }

    $.ajax({
      url: "{{ route('get.upazillas') }}",
      type: "GET",
      data: { district_id: districtId },
      success: function (res) {
        if (res.success) {
          $upazillaWrapper.removeClass('d-none');
          res.data.forEach(function (upa) {
            $upazilla.append(`<option value="${upa.id}">${upa.name}</option>`);
          });
        } else {
          toastr.warning(res.message || "No upazillas found.");
        }
      },
      error: function () {
        toastr.error("Failed to load upazillas.");
      }
    });
  });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const featuresContainer = document.getElementById("featuresContainer");
    const addFeatureBtn = document.getElementById("addFeatureBtn");

    // 🧱 Default features list (key → value)
    const defaultFeatures = {
        "Property ID": "",
        "Amount": "",
        "Size": "",
        "Building Stories": "",
        "Building Facing": "",
        "Property Facing": "",
        "Property Condition": "",
        "Furnished Status": "",
        "Decoration Status": "",
        "Document Status": "",
        "Property Landmark": "",
        "Per Floor Unit": "",
        "Floor Position": "",
        "Total Floors": ""
    };

    // 🧩 Function to create a feature input row
    function createFeatureInput(key = "", value = "") {
        const wrapper = document.createElement("div");
        wrapper.classList.add("input-group", "mb-2", "feature-item");

        wrapper.innerHTML = `
            <input type="text" name="feature_keys[]" class="form-control" placeholder="Feature Name" value="${key}">
            <input type="text" name="feature_values[]" class="form-control" placeholder="Feature Value" value="${value}">
            <button type="button" class="btn btn-danger remove-feature">
                <i class="fa fa-trash"></i>
            </button>
        `;

        // 🗑️ Remove feature when clicked
        wrapper.querySelector(".remove-feature").addEventListener("click", function () {
            wrapper.remove();
        });

        return wrapper;
    }

    // 🧠 Initialize default features
    for (const [key, value] of Object.entries(defaultFeatures)) {
        featuresContainer.appendChild(createFeatureInput(key, value));
    }

    // ➕ Add new feature on button click
    addFeatureBtn.addEventListener("click", function () {
        featuresContainer.appendChild(createFeatureInput());
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const amenitiesContainer = document.getElementById("amenitiesContainer");
    const addAmenityBtn = document.getElementById("addAmenityBtn");

    // 🧱 Default amenities list
    const defaultAmenities = [
        "CCTV",
        "Security",
        "Lift",
        "Water",
        "Gas connection"
    ];

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

        // 🗑️ Remove feature when clicked
        wrapper.querySelector(".remove-amenity").addEventListener("click", function () {
            wrapper.remove();
        });

        return wrapper;
    }

    // 🧠 Initialize with default amenities
    defaultAmenities.forEach(function (item) {
        amenitiesContainer.appendChild(createAmenityInput(item));
    });

    // ➕ Add new amenity on button click
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
                    toastr.success(response.message || "Property created successfully!");
                    // Redirect after 1.5s
                    setTimeout(() => {
                        window.location.href = "{{ route('property.sell') }}";
                    }, 1500);
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

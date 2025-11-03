@extends('frontend.master')

@section('title')
    Sell/Rent Your Property
@endsection

@section('description')
    Sell/Rent Your Property
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Sell/Rent Your Property </p>
        </div>
    </div>
    <div class="container propertyView">

        <div class="panel-header text-white rounded-top-4 p-3 mt-4">
            <h5 class="modal-title" id="inquiryModalLabel">Submit Your Property Details</h5>

        </div>

        <div class="modal-body bg-light p-4">


            <!-- Inquiry Form -->
            <form id="inquiryForm" class=" position-relative" action="{{ route('client.properties') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    
                        <div class="col-md-12">
                            <label class="fw-bold">Property Type</label>
                            <div class="d-flex align-items-center gap-2">
                                <label>
                                    <input type="radio" name="type" value="rent"
                                        {{ $request->type == 'rent' ? 'checked' : '' }}>
                                    Rent
                                </label>
                                <label>
                                    <input type="radio" name="type" value="sell"
                                        {{ $request->type == 'sell' ? 'checked' : '' }}>
                                    Sell
                                </label>
                            </div>
                        </div>
                    

                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Your Name" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <input id="phoneInquiry" type="tel" name="phone" class="form-control"
                            placeholder="e.g. +880..." required>
                        <small id="phoneErrorInquiry" class="text-danger"></small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Your Email Address"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Property Address</label>
                        <input type="text" name="property_address" class="form-control"
                            placeholder="Enter Your Property Address" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Total Property Space</label>
                        <input type="number" name="property_space" class="form-control"
                            placeholder="Total Property Space ( Square Feet )" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Property Bedrooms</label>
                        <input type="number" name="property_bedrooms" class="form-control" placeholder="Property Bedrooms"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Your Estimate Price</label>
                        <input type="number" name="property_estimated_price" class="form-control"
                            placeholder="Your Estimate Price" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="">
                            <h4>Image Gallery</h4>
                            <input type="file" name="gallery_images[]" id="gallery-images" accept="image/*" multiple
                                class="form-control">
                            <div id="gallery-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                <div class=" mt-4">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
                <div id="formLoaderbooking" class="form-loader d-none">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('customJs')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

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
        document.addEventListener('DOMContentLoaded', function() {


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

                if (!iti.isValidNumber()) {
                    phoneError.textContent = 'Please enter a valid phone number.';
                    return;
                }

                const formData = new FormData(this);
                formData.set('phone', iti.getNumber());
                const actionUrl = $(this).attr('action');
                const loader = document.getElementById('formLoaderbooking');
                loader.classList.remove('d-none');

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
                        if (response.status === 422) {
                            const data = await response.json();
                            Object.values(data.errors).forEach(errArray => {
                                toastr.error(errArray[0]);
                            });
                            return;
                        }
                        toastr.error('Something went wrong.');
                        return;
                    }

                    const data = await response.json();
                    if (data.status === 'success') {
                        toastr.success(data.message);
                        $('#inquiryForm')[0].reset();
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

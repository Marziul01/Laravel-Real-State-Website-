@extends('frontend.master')

@section('title')
    {{ $team->name }}
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Team Member > {{ $team->name }}</p>
        </div>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <div class="member-card">
                    <div class="member-image-wrapper">
                        <img src="{{ asset($team->photo) }}" alt="{{ $team->name }}" class="member-image">
                    </div>
                    <h4 class="member-name">{{ $team->name }}</h4>
                    <p class="member-role">{{ $team->position }}</p>
                    @if ($team->email)
                        <p class="member-contact mb-0">{{ $team->email }}</p>
                    @endif
                    @if ($team->phone)
                        <p class="member-contact">{{ $team->phone }}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-8 mt-4 mt-md-2">
                <p>{{ $team->bio }}</p>
            </div>
        </div>
    </div>
    <section class="contact-section">
        <div class="container" id="contact-section">
            <div class="mb-4">
                <h2 class="reviews-title text-center">Appointment Form</h2>
            </div>
            <div class="mx-auto">
                <div class="w-100 form-column p-0">
                    <form id="inquiryForm" class="position-relative" action="{{ route('team.appointment.submit', $team->id) }}"
                        enctype="multipart/form-data">
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
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                        </div>
                        <div id="formLoaderbooking" class="form-loader d-none">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
<script>
        document.addEventListener('DOMContentLoaded', function() {
            // ✅ Initialize Select2
            
                $('#demands').select2({
                    
                    width: '100%',
                    placeholder: "Select Multiple Demands",
                    allowClear: true
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

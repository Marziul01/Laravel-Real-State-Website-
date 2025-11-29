@if(!in_array(Route::currentRouteName(), ['teams.appointment']))
<section class="contact-section">
    <div class="container" id="contact-section">
        <div class="mb-4">
            <h2 class="reviews-title">Get In Touch</h2>
        </div>
        <div class="row m-0">
            <div class="col-lg-6 form-column">
                <form id="inquiryForm-footer" class="contact-form position-relative"
                    action="{{ route('service.inquiries') }}" method="POST" enctype="multipart/form-data">

                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control mb-3" id="full_name" name="name"
                        placeholder="Enter Your Name">

                    <label for="contact_number" class="form-label">Contact Number</label>
                    <div class="input-group mb-3">
                        <input type="tel" class="form-control" id="phoneInquiry-footer" placeholder="Contact Nubmer"
                            name="phone">
                        <small id="phoneErrorInquiry-footer" class="text-danger"></small>
                    </div>

                    <label for="email_address" class="form-label">Email Address</label>
                    <input type="email" class="form-control mb-3" id="email_address"
                        placeholder="Enter Your Email Address" name="email">

                    <label for="country" class="form-label">Select Your Living Country</label>
                    <select class="form-select mb-3" id="country" name="country_id">
                        @if ($countries->isNotEmpty())
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        @endif
                    </select>

                    <div class="row mx-0 mb-3">
                        <div class="col-md-6 px-0">
                            <label class="form-label">Set Your Schedule (BD Time)</label>
                            <input type="date" name="schedule_date" class="form-control" required>
                        </div>

                        <div class="col-md-6 px-0">
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
                    <textarea class="form-control mb-4" id="message" rows="3" name="message"
                        placeholder="...go ahead. We are listening"></textarea>

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
@endif
<footer class="minimal-footer pt-5">
    <div class="container">

        <div class="row g-4 mb-5 top-boxes">

            <div class="col-md-6">
                <div class="cta-box white-box">
                    <p class="cta-subtitle">As an Agents</p>
                    <h3 class="cta-title">Do you want to work with DHR</h3>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('agents') }}" class="cta-arrow"><i class="fas fa-arrow-right"></i></a>
                        <p class="cta-action mb-0">Let's us show you the ropes</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="cta-box white-box">
                    <p class="cta-subtitle">As a Clients</p>
                    <h3 class="cta-title">Are you seeking professional documentation services for your Property</h3>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('document.services') }}" class="cta-arrow"><i
                                class="fas fa-arrow-right"></i></a>
                        <p class="cta-action mb-0">We support you to make a hassle free Property Documentation</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-5 main-footer-content">

            <div class="col-lg-4 order-lg-1 order-2">
                <div class="get-in-touch-box">
                    <h5 class="box-title">Get In Touch</h5>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control newsletter-input"
                            placeholder="Enter Your Email Address">
                        <button class="btn btn-purple-arrow" type="button"><i
                                class="fas fa-arrow-right"></i></button>
                    </div>
                    <p class="footer-description">
                        Looking to buy, sell, rent, or invest? DHR makes real estate easy! Get expert advice, property
                        listings, and personalized recommendation
                    </p>
                </div>
            </div>

            <div class="col-6 col-md-3 col-lg-2 order-lg-2 order-3">
                <h5 class="footer-column-title">COMPANY</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('about') }}">About us</a></li>
                    <li><a href="{{ route('all.blogs') }}">Blogs</a></li>
                    <li><a href="{{ route('careers.all') }}">Careers</a></li>
                    <li><a href="{{ route('contact') }}">Contact us</a></li>
                    <li><a href="{{ route('gallery') }}">Gallery</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-3 col-lg-2 order-lg-3 order-4">
                <h5 class="footer-column-title">Services</h5>
                @php
                    $currentSlug = request()->route('slug'); // get current service slug from URL
                    $servicesheaderfooter = \App\Models\Service::where('type', 'LIKE', '%Others%')->take(5)->get();
                @endphp
                <ul class="list-unstyled footer-links">
                    @if ($servicesheaderfooter->count())
                        @foreach ($servicesheaderfooter as $serviceheaderfooter)
                            <li><a
                                    href="{{ route('home.serives', $serviceheaderfooter->slug) }}">{{ $serviceheaderfooter->name }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="col-md-6 col-lg-4 order-lg-4 order-1">
                <div class="agency-info">
                    <h5 class="agency-name">{{ $setting->site_name }}</h5>
                    <p>Corporate Address: {{ $setting->site_address }}</p>
                    <p>Phone: {{ $setting->site_phone }}</p>
                    <p>Email: {{ $setting->site_email }}</p>

                    <div class="footer-logo-container mt-4">
                        <img src="{{ asset($setting->site_logo) }}" alt="DHR Housing Agency Logo"
                            class="footer-logo">
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="footer-bottom py-3">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-md-6 social-icons text-start mb-2 mb-md-0">
                    <a href="{{ $setting->facebook }}" class="social-link"><i
                            class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ $setting->twitter }}" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="{{ $setting->instagram }}" class="social-link"><i
                            class="fa-brands fa-instagram"></i></a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp) }}"
                        class="social-link"><i class="fa-brands fa-whatsapp"></i></a>
                </div>

                <div class="col-md-6 text-end">
                    <p class="copyright-text mb-0">Copyright Reserved by {{ $setting->site_name }}</p>
                    <p class="designed-by mb-0">Designed & Developed by SoftDivz</p>
                </div>

            </div>
        </div>
    </div>
</footer>

<div class="chat-widget">
    <div class="chat-icons">
        <a href="{{ $setting->facebook }}" class="icon messenger"><i class="fab fa-facebook-messenger"></i></a>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp) }}" class="icon whatsapp"><i
                class="fab fa-whatsapp"></i></a>
        <a href="tel:{{ $setting->site_phone }}" class="icon phone"><i class="fas fa-phone"></i></a>
    </div>

    <button class="main-btn">
        <i class="fas fa-comment"></i>
    </button>

    <button class="close-btn">
        <i class="fas fa-times"></i>
    </button>
</div>

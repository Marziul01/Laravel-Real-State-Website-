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
                        <a href="{{ route('document.services') }}" class="cta-arrow"><i class="fas fa-arrow-right"></i></a>
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
                        <input type="email" class="form-control newsletter-input" placeholder="Enter Your Email Address">
                        <button class="btn btn-purple-arrow" type="button"><i class="fas fa-arrow-right"></i></button>
                    </div>
                    <p class="footer-description">
                        Looking to buy, sell, rent, or invest? DHR makes real estate easy! Get expert advice, property listings, and personalized recommendation
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
                            <li><a href="{{ route('home.serives', $serviceheaderfooter->slug) }}">{{ $serviceheaderfooter->name }}</a></li>
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
                        <img src="{{ asset($setting->site_logo) }}" alt="DHR Housing Agency Logo" class="footer-logo">
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    
    <div class="footer-bottom py-3">
        <div class="container">
            <div class="row align-items-center">
                
                <div class="col-md-6 social-icons text-start mb-2 mb-md-0">
                    <a href="{{ $setting->facebook }}" class="social-link"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ $setting->twitter }}" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="{{ $setting->instagram }}" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp) }}" class="social-link"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
                
                <div class="col-md-6 text-end">
                    <p class="copyright-text mb-0">Copyright Reserved by {{ $setting->site_name  }}</p>
                    <p class="designed-by mb-0">Designed & Developed by SoftDivz</p>
                </div>
                
            </div>
        </div>
    </div>
</footer>

<div class="fixed-property-sec {{ Route::currentRouteName() == 'sendyourproperty' ? 'd-none' : '' }}">
    <div class="d-flex flex-column align-items-end">
        <a href="{{ route('sendyourproperty',['type' => 'rent']) }}" class="fixed-property-btn rental-fixed">
            <div class="d-flex flex-column align-items-center justify-content-center position-relative z-index-9">
                <i class="fa-regular fa-house mb-2"></i> <p class="mb-3"> Rent Your Property</p>
            </div>
        </a>
        <a href="{{ route('sendyourproperty',['type' => 'sell']) }}" class="fixed-property-btn selling-fixed">
            <div class="d-flex flex-column align-items-center justify-content-center position-relative z-index-9">
                <i class="fa-regular fa-house mb-2"></i> <p class="mb-1"> Sell Your Property</p>
            </div>
        </a>
    </div>
</div>

<div class="chat-widget">
  <div class="chat-icons">
    <a href="{{ $setting->facebook }}" class="icon messenger"><i class="fab fa-facebook-messenger"></i></a>
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp) }}" class="icon whatsapp"><i class="fab fa-whatsapp"></i></a>
    <a href="tel:{{ $setting->site_phone }}" class="icon phone"><i class="fas fa-phone"></i></a>
  </div>

  <button class="main-btn">
    <i class="fas fa-comment"></i>
  </button>

  <button class="close-btn">
    <i class="fas fa-times"></i>
  </button>
</div>

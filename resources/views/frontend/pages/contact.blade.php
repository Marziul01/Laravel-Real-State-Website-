@extends('frontend.master')

@section('title')
   Contact us
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Contact us</p>
        </div>
    </div>
    <div class="container py-5">
    <h2 class="text-center fw-bold text-uppercase text-dark mb-5">Contact Us</h2>

    <div class="row align-items-start">
        <!-- Left Side: Contact Info -->
        <div class="col-md-5 mb-5 mb-md-0">
            <div class="p-4 rounded-3 bg-white shadow-sm">
                <h4 class="fw-bold mb-4 text-dark">Get In Touch</h4>

                <ul class="list-unstyled mb-4">
                    <li class="mb-3">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <span class="text-muted">{{ $setting->site_address }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fa-solid fa-phone-volume"></i>
                        <a href="tel:{{ $setting->site_phone }}" class="text-decoration-none text-muted">
                            {{ $setting->site_phone }}
                        </a>
                    </li>
                    <li class="mb-3">
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:{{ $setting->site_email }}" class="text-decoration-none text-muted">
                            {{ $setting->site_email }}
                        </a>
                    </li>
                </ul>

                <h5 class="fw-bold mb-3 text-dark">Follow Us</h5>
                <div class="d-flex gap-3">
                    @if($setting->facebook)
                        <a href="{{ $setting->facebook }}" target="_blank" class="text-dark fs-4 hover-opacity">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    @endif
                    @if($setting->twitter)
                        <a href="{{ $setting->twitter }}" target="_blank" class="text-dark fs-4 hover-opacity">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    @endif
                    @if($setting->instagram)
                        <a href="{{ $setting->instagram }}" target="_blank" class="text-dark fs-4 hover-opacity">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                    @if($setting->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp) }}" target="_blank" class="text-dark fs-4 hover-opacity">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side: Google Map -->
        <div class="col-md-7">
            <div class="ratio ratio-16x9 shadow-sm rounded-3 overflow-hidden">
                <iframe 
                    src="https://www.google.com/maps?q={{ urlencode($setting->site_address) }}&output=embed" 
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')

@endsection

@extends('frontend.master')

@section('title')
   Our Services
@endsection

@section('content')
    {{-- <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Services</p>
        </div>
    </div> --}}
    <div class="hero-otherpage">
        <div class="image-hero" style="background-image: url('{{ asset($about->image) }}')">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 overlay">
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    <h1 class="fw-bold text-white mb-3">About <span class="text-primary fw-bold">{{ $setting->site_name }}</span></h1>
                    <p class="text-white text-center px-4">{{ $about->about_content ?? '' }}</p>
                </div>
            </div>
        </div>
        {{-- <div class="container d-flex p-4 gap-4">
            <div class="row texts">
                <div class="col-md-4">
                    <h2>Buy Dubai Properties: Luxury Property for Sale in UAE</h2>
                </div>
                <div class="col-md-8">
                    <p>Experience the pinnacle of luxury with buying a property in Dubai, where stunning architecture meets world-class amenities. Each residence seamlessly blends elegance with comfort, offering breathtaking views of the city skyline and pristine beaches. Buy Dubai properties and embrace a lifestyle defined by sophistication and unmatched beauty.</p>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="container my-5">
        {{-- <section class="py-5">
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6">
                        
                        <p class="text-muted mb-4" style="line-height: 1.8;">
                            {{ $about->about_content ?? '' }}
                        </p>
                        
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="{{ asset($about->image) }}" class="rounded-3 w-100 h-100">
                    </div>
                </div>
            </div>
        </section> --}}

        {{-- =================== MISSION & VISION =================== --}}
        <section class="py-5">
            <div class="container text-center">
                <h2 class="fw-bold mb-5">Our Mission & Vision</h2>
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="p-4 border rounded-3 h-100 shadow-sm">
                            <h4 class="text-primary mb-3">Our Mission</h4>
                            <p class="text-muted">
                                {{$about->mission ?? ''}}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 border rounded-3 h-100 shadow-sm">
                            <h4 class="text-primary mb-3">Our Vision</h4>
                            <p class="text-muted">
                                {{$about->vision ?? ''}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- =================== CHAIRMAN & MANAGING DIRECTOR =================== --}}
        <section class="py-5 bg-light">
            <div class="container text-center">
                <h2 class="fw-bold mb-5">Leadership</h2>
                <div class="row justify-content-center gy-4">
                    @if ($teams->where('position', 'Chairman')->first())
                        @php
                            $chairman = $teams->where('position', 'Chairman')->first();
                        @endphp
                        <div class="col-md-5">
                            <div class="p-4 rounded-3 border shadow-sm h-100 bg-white">
                                <img src="{{ asset($chairman->photo) }}" class="rounded-circle mb-3" width="120" height="120" alt="Chairman">
                                <h5 class="fw-bold mb-1">{{ $chairman->name }}</h5>
                                <p class="text-primary small mb-2">Chairman</p> 
                                <p class="text-muted small">
                                    {{ $chairman->bio }}
                                </p>
                                @if ($chairman->email)
                                    <strong><p class="small mb-0 realtor-email">Email: {{ $chairman->email }}</p></strong>
                                @endif
                                @if ($chairman->phone)
                                    <strong><p class="small mb-0 realtor-email">Phone: {{ $chairman->phone }}</p></strong>
                                @endif
                                <a href="{{ route('teams.appointment' ,['id' => $chairman->id , 'name' => $chairman->name ] ) }}" class="btn btn-primary w-100 mt-3">Get Appointment</a>
                            </div>
                        </div>
                    @endif
                    @if ($teams->where('position', 'Managing Director')->first())
                        @php
                            $md = $teams->where('position', 'Managing Director')->first();
                        @endphp
                        <div class="col-md-5">
                            <div class="p-4 rounded-3 border shadow-sm h-100 bg-white">
                                <img src="{{ asset($md->photo) }}" class="rounded-circle mb-3" width="120" height="120" alt="Managing Director">
                                <h5 class="fw-bold mb-1">{{ $md->name }}</h5>
                                <p class="text-primary small mb-2">Managing Director</p>
                                <p class="text-muted small">
                                    {{ $md->bio }}
                                </p>
                                @if ($md->email)
                                    <strong><p class="small mb-0 realtor-email">Email: {{ $md->email }}</p></strong>
                                @endif
                                @if ($md->phone)
                                    <strong><p class="small mb-0 realtor-email">Phone: {{ $md->phone }}</p></strong>
                                @endif
                                <a href="{{ route('teams.appointment' ,['id' => $md->id , 'name' => $md->name ] ) }}" class="btn btn-primary w-100 mt-3">Get Appointment</a>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </section>

        {{-- =================== OUR TEAM =================== --}}
        <section class="py-5">
            <div class="container text-center">
                <h2 class="fw-bold mb-5">Our Team</h2>
                <div class="row gy-4 justify-content-center">
                    @foreach ($teams as $member)
                        <div class="col-md-3 col-6">
                            <div class="team-card p-4 border rounded-3 shadow-sm bg-white h-100">
                                <img src="{{ asset($member->photo) }}" class="rounded-circle mb-3" width="100" height="100">
                                <h6 class="fw-bold mb-1">{{ $member->name }}</h6>
                                <p class="text-primary small mb-2">{{ $member->position }}</p>
                                @if ($member->email)
                                    <strong><p class="small mb-0 realtor-email">Email: {{ $member->email }}</p></strong>
                                @endif
                                @if ($member->phone)
                                    <strong><p class="small mb-0 realtor-email">Phone: {{ $member->phone }}</p></strong>
                                @endif
                                <a href="{{ route('teams.appointment' ,['id' => $member->id , 'name' => $member->name ] ) }}" class="btn btn-primary w-100 mt-3">Get Appointment</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        {{-- ==================== WHY BUY SECTION ==================== --}}
        <section class="py-5">
            <div class="container text-center">
                <h2 class="fw-bold mb-5">Why Buy From <span class="text-dark">{{ $setting->site_name }}</span></h2>

                <div class="row g-4 justify-content-center">
                    @for ($i = 1; $i <= 9; $i++)
                        @php
                            $value = $about->{'why_buy_'.$i} ?? '';
                            $parts = explode(',', $value);
                            $icon = $parts[0] ?? 'bi bi-question-circle'; // default icon
                            $title = $parts[1] ?? '';
                        @endphp
                        @if($icon || $title)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="why-card bg-white border-0 shadow-sm rounded-3 p-4 h-100">
                                    <div class="icon mb-3">
                                        <i class="{{ $icon }} fs-1 text-dark"></i>
                                    </div>
                                    <h6 class="fw-semibold text-dark mb-0">{{ $title }}</h6>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>
            </div>
        </section>

        {{-- ==================== WHY SELL SECTION ==================== --}}
        <section class="py-5 bg-light">
            <div class="container text-center">
                <h2 class="fw-bold mb-5">Why Sell From <span class="text-dark">{{ $setting->site_name }}</span></h2>

                <div class="row g-4 justify-content-center">
                    @for ($i = 1; $i <= 9; $i++)
                        @php
                            $value = $about->{'why_sell_'.$i} ?? '';
                            $parts = explode(',', $value);
                            $icon = $parts[0] ?? 'bi bi-question-circle'; // default icon
                            $title = $parts[1] ?? '';
                        @endphp
                        @if($icon || $title)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="why-card bg-white border-0 shadow-sm rounded-3 p-4 h-100">
                                    <div class="icon mb-3">
                                        <i class="{{ $icon }} fs-1 text-dark"></i>
                                    </div>
                                    <h6 class="fw-semibold text-dark mb-0">{{ $title }}</h6>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>
            </div>
        </section>

    </div>
@endsection

@section('customJs')

@endsection

@extends('frontend.master')

@section('title')
   Our Services
@endsection

@section('description')
    Explore the comprehensive range of services offered by DHR Real Estate, including property buying, selling, renting, legal documentation, and expert consultancy to meet all your real estate needs.
@endsection

@section('content')
    {{-- <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Services</p>
        </div>
    </div> --}}
    <div class="hero-otherpage">
        <div class="image-hero" style="background-image: url('{{ asset('frontend-assets/images/slider.jpg') }}')">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 overlay">
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    <h1 class="text-white">Our Services</h1>
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
    <div class="container my-5">
        {{-- <h2 class=" mb-4 reviews-title">OUR SERVICES</h2> --}}
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @if ($services->isNotEmpty())
                    @foreach ($services as $service )
                        <div class="col-md-6">
                            <a class="row service-card1 p-3 m-0" href="{{ route('home.serives', $service->slug) }}">
                                <div class="col-md-6">
                                    <div>
                                        <div class="icon-placeholder mb-2">
                                            @if ($service->file_type === 'Image' && $service->file)
                                                <img src="{{ asset($service->file) }}" class="img-fluid rounded-end w-100 h-100 object-fit-cover" alt="{{ $service->name }}">
                                            
                                            @elseif ($service->file_type === 'Video File' && $service->file)
                                                <video controls class="w-100 rounded-end">
                                                    <source src="{{ asset($service->file) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>

                                            @elseif ($service->file_type === 'Video Link' && $service->file)
                                                {{-- Embedded YouTube or Vimeo --}}
                                                <div class="ratio ratio-16x9 rounded-end">
                                                    <iframe src="{{ $service->file }}" title="{{ $service->name }}" allowfullscreen></iframe>
                                                </div>

                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded-end" style="height: 100%;">
                                                    <span class="text-secondary">No media available</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="mb-3 font-bold">{{ $service->name }}</h5>
                                        <p class="text-muted mb-0 font-sm"> {{ Str::limit(strip_tags($service->description), 150, '...') }} </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
    </div>
@endsection

@section('customJs')

@endsection

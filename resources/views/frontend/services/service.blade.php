@extends('frontend.master')

@section('title')
   Our Services
@endsection

@section('description')
    Explore the comprehensive range of services offered by DHR Real Estate, including property buying, selling, renting, legal documentation, and expert consultancy to meet all your real estate needs.
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Services</p>
        </div>
    </div>
    <div class="container my-5">
        <h2 class=" mb-4 reviews-title">OUR SERVICES</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @if ($services->isNotEmpty())
                    @foreach ($services as $service )
                        <div class="col">
                            <a class="service-card p-3" href="{{ route('home.serives', $service->slug) }}">
                                <div class="icon-placeholder mb-2">
                                    <i class="{{ $service->icon }}"></i>
                                </div>
                                <h5 class="mb-3 font-bold">{{ $service->name }}</h5>
                                <p class="text-muted mb-0 font-sm"> {{ Str::limit(strip_tags($service->description), 200, '...') }} </p>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
    </div>
@endsection

@section('customJs')

@endsection

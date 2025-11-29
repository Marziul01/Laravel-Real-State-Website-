@extends('frontend.master')

@section('title')
   Professional Documentation Property Services
@endsection

@section('description')
    Explore the comprehensive range of services offered by DHR for Professional Documentation Property Services, ensuring legal compliance and smooth transactions in real estate dealings.
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Documentation Services</p>
        </div>
    </div>
    <div class="container my-5">
        <h2 class=" mb-4 reviews-title text-center ">OUR Professional Documentation Property Services</h2>
            <div class="row row-cols-1 row-cols-md-3 my-4 g-4">
                @if ($docunments->isNotEmpty())
                    @foreach ($docunments as $service )
                        <div class="col">
                            <a class="service-card p-3" href="{{ route('home.serives', $service->slug) }}">
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

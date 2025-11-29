@extends('frontend.master')

@section('title')
    {{ $service->name }}
@endsection

@section('description')
    {{ Str::limit(strip_tags($service->description), 150) }}
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Services > {{ $service->name }}</p>
        </div>
    </div>
    <div class="container my-5">
        <div class="mb-4 ">
            <div class="row g-0 flex-column-reverse flex-lg-row">
                {{-- LEFT SIDE (TEXT CONTENT) --}}
                <div class="col-md-6 px-2 py-4 p-md-4">
                    <div class=" mb-3">
                        <div class="services-icon  mb-3">
                            {{-- <i class="{{ $service->icon }} fs-2"></i> --}}
                            @if ($service->icon_type === 'image' && $service->icon_image)
                                        {{-- Show uploaded icon image --}}
                                        <img src="{{ asset($service->icon_image) }}" 
                                            alt="icon" 
                                            style="width:45px; height:45px; object-fit:contain;" 
                                            class="rounded">
                                    @else
                                        {{-- Show icon picker icon --}}
                                        <i class="{{ $service->icon }} fs-2"></i>
                                    @endif
                        </div>
                        <h4 class="mb-0">{{ $service->name }}</h4>
                    </div>
                    <p class="text-muted mb-0">
                        {{ $service->description }}
                    </p>
                </div>

                {{-- RIGHT SIDE (MEDIA CONTENT) --}}
                <div class="col-md-6">
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
    </div>
@endsection

@section('customJs')

@endsection

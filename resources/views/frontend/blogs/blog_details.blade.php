@extends('frontend.master')

@section('title')
   {{ $blog->title }}
@endsection

@section('description')
    {{ Str::limit(strip_tags($blog->content), 150) }}
@endsection

@section('meta_image')
    {{ asset($blog->image) }}
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Blogs > {{ $blog->title }}</p>
        </div>
    </div>
    <section class="py-5 bg-white text-black">
        <div class="container">
            <div class="row g-5">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-3">{{ $blog->title }}</h1>
                    <div class="mb-4">
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="img-fluid rounded w-100" style="max-height: 450px; object-fit: cover; filter: grayscale(30%);">
                    </div>

                    <div class="content" style="font-size: 1rem; line-height: 1.8;">
                        {!! $blog->content !!}
                    </div>

                    @if ($blog->tags)
                    <div class="mt-5 border-top pt-4">
                        <h6 class="fw-bold mb-2">Tags:</h6>
                        @foreach(explode(',', $blog->tags) as $tag)
                            <span class="badge bg-dark text-white me-2 mb-2">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Related Posts -->
                    <div class="mb-5">
                        <h5 class="fw-bold border-bottom pb-2 mb-3">Related Posts</h5>
                        @foreach ($relatedPosts as $related)
                            <div class="mb-3">
                                <a href="{{ route('blog.details', $related->slug) }}" class="text-decoration-none text-dark">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($related->image) }}" alt="{{ $related->title }}" width="80" height="60" class="rounded me-3" style="object-fit: cover;">
                                        <span class="fw-semibold">{{ Str::limit($related->title, 50) }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Share Buttons -->
                    <div>
                        <h5 class="fw-bold border-bottom pb-2 mb-3">Share This Post</h5>
                        @php
                            $shareUrl = urlencode(url()->current());
                            $shareText = urlencode($blog->title);
                        @endphp
                        <div class="d-flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="fs-4"><i class="fab fa-facebook"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" class="fs-4"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareText }}" target="_blank" class="fs-4"><i class="fab fa-linkedin"></i></a>
                            <a href="https://pinterest.com/pin/create/button/?url={{ $shareUrl }}" target="_blank" class="fs-4"><i class="fab fa-pinterest"></i></a>
                            <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" class="fs-4"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')

@endsection

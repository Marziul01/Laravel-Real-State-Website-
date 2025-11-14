@extends('frontend.master')

@section('title')
   Our Blogs
@endsection

@section('description')
    Welcome to DHR Real Estate's blog section, where we share expert insights, market trends, and valuable tips to help you navigate the real estate world with confidence.
@endsection

@section('meta_image')
    {{ asset($setting->site_logo) }}
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Blogs</p>
        </div>
    </div>
    <section class="py-5 bg-white text-black">
        <div class="container">
            <h1 class="text-center fw-bold mb-5" style="letter-spacing:1px;">Latest Articles</h1>

            <div class="row g-4">
                @if ($blogs->isEmpty())
                    <div class="col-12">
                        <p class="text-center text-muted">No blogs available at the moment. Please check back later.</p>
                    </div>
                @endif
                @foreach ($blogs as $blog)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 blog-cards" style="transition:all 0.3s;">
                            <a href="{{ route('blog.details', $blog->slug) }}" class="text-decoration-none text-dark">
                                <img src="{{ asset($blog->image) }}" class="card-img-top" alt="{{ $blog->title }}" style="object-fit:cover; height:220px; transition: all .4s;">
                            </a>
                            <div class="card-body">
                                <h5 class="fw-bold mb-2">{{ Str::limit($blog->title, 60) }}</h5>
                                <p class="text-muted" style="font-size: 0.9rem;">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                                <a href="{{ route('blog.details', $blog->slug) }}" class="text-dark fw-bold" style="">Read More →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $blogs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
@endsection

@section('customJs')

@endsection

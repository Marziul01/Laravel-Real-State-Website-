@extends('frontend.master')

@section('title')
   {{ $career->title }}
@endsection

@section('description')
    {{ Str::limit(strip_tags($career->description), 150, '...') }}
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Carrers > {{ $career->title }}</p>
        </div>
    </div>
    <div class="container py-5">
        <a href="{{ route('careers.all') }}" class="text-decoration-none text-muted mb-4 d-inline-block">
            ← Back to Careers
        </a>

        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            @if($career->image)
                <img src="{{ asset($career->image) }}" alt="{{ $career->title }}" class="img-fluid rounded mb-4" style="max-height: 400px; object-fit: cover;">
            @endif

            <h2 class="fw-bold text-dark mb-3">{{ $career->title }}</h2>

            <ul class="list-unstyled mb-4">
                <li class="mb-2"><strong>Location:</strong> {{ $career->location }}</li>
                <li class="mb-2"><strong>Job Type:</strong> {{ ucfirst($career->type) }}</li>
                <li class="mb-2"><strong>Position:</strong> {{ $career->position }}</li>
                <li class="mb-2"><strong>Salary:</strong> {{ $career->salary ?? 'Negotiable' }}</li>
                <li class="mb-2"><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($career->deadline)->format('d M, Y') }}</li>
            </ul>

            <div class="border-top pt-4">
                <h5 class="fw-bold text-dark mb-3">Job Description</h5>
                <div class="text-muted" style="line-height: 1.7;">
                    {!! $career->description !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')

@endsection

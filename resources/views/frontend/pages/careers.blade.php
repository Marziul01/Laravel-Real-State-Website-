@extends('frontend.master')

@section('title')
   Our Carrers
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Carrers</p>
        </div>
    </div>
    <div class="container py-5">
        <h2 class="text-center mb-5 fw-bold text-uppercase text-dark">Current Job Openings</h2>

        @foreach($careers as $career)
            <div class="card mb-4 border-0 shadow-sm rounded-3 blog-cards">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <h4 class="fw-bold text-dark">{{ $career->title }}</h4>
                        <p class="mb-1 text-muted">{{ $career->location }} | {{ ucfirst($career->type) }}</p>
                        <p class="mb-1 text-muted">Position: {{ $career->position }}</p>
                        <p class="mb-0 text-secondary small">Deadline: {{ \Carbon\Carbon::parse($career->deadline)->format('d M, Y') }}</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('careers.show', $career->id) }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $careers->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@section('customJs')

@endsection

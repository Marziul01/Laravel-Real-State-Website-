@extends('frontend.master')

@section('title')
   WORK WITH DHR
@endsection

@section('content')
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > WORK WITH DHR</p>
        </div>
    </div>

    <div class="container py-5">
        <h2 class="text-center fw-bold text-uppercase text-dark mb-5">WORK WITH DHR AS AN AGENT</h2>

        <div class="row">
            <div class="col-md-8">
                <div class="p-4 pt-0 rounded-3 bg-white">
                    {!! $agentpage->description !!}
                </div>
            </div>
            <div class="col-md-4">
                <img src="{{ asset($agentpage->image) }}" alt="Agents Working" class="img-fluid rounded-3 shadow-sm">
            </div>
        </div>
    </div>
@endsection

@section('customJs')

@endsection



@extends('layout.layout')

@section('title', 'Freelancer Search')

@section('content')
    <section class="fr-lance-details" style="padding: 25px !important;">
        <div class="container-fluid">
            <div class="row my-3 align-items-center">
                <div class="my-1 col-md-3">
                    <input type="search" class="search-input" id="address" name="address" placeholder="Search by Location...">
                    <input type="hidden" name="latitude" class="form-control latitude">
                    <input type="hidden" name="longitude" class="form-control longitude">
                </div>
                <div class="my-2 col-md-2">
                    <select name="radius" id="radius" class="form-control">
                        <option value="5">5 km</option>
                        <option value="10">10 km</option>
                        <option value="25">25 km</option>
                        <option value="50">50 km</option>
                        <option value="75">75 km</option>
                        <option value="100">100 km</option>
                    </select>
                </div>
                <div class="my-2 col-md-2">
                    <select name="result" id="result" class="form-control">
                        <option value="10">10 Result</option>
                        <option value="25">25 Result</option>
                        <option value="50">50 Result</option>
                    </select>
                </div>
                <div class="my-1 col-md-3">
                    <input type="search" class="search-input" id="title" name="address" placeholder="Search by Keyword...">
                </div>
                <div class="my-1 col-md-2 d-flex">
                    <button class="btn btn-lg btn-primary btn-block" id="filter-btn">Filter</button>
                    <button class="btn btn-secondary btn-lg ml-1"><i class="fa fa-filter"></i></button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xxl-4 col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-right my-1 mb-2">
                                <button class="btn btn-primary boundary-btn">Hide Boundary</button>
                            </div>
                            <div class="search-map"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 col-xl-7">
                    <div class="row freelancers-data" >
                        @include('CustomerScreens.home_screens.freelancer.freelancers');
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="../../../assets/js/custom_js/homescreen/freelancer_search.js"></script>
@endpush

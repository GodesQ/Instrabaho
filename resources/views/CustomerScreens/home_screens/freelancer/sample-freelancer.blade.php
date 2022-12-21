@extends('layout.layout')

@section('content')
    <section class="fr-lance-details" style="padding-top: 25px !important;">
        <div class="container">
            <div class="row my-3 align-items-center">
                <div class="col-md-3">
                    <input type="text" class="search-input" id="address" name="address" placeholder="Search by Location...">
                    <input type="hidden" name="latitude" class="form-control latitude">
                    <input type="hidden" name="longitude" class="form-control longitude">
                </div>
                <div class="col-md-2">
                    <select name="radius" id="radius" class="form-control">
                        <option value="5">5 km</option>
                        <option value="10">10 km</option>
                        <option value="25">25 km</option>
                        <option value="50">50 km</option>
                        <option value="75">75 km</option>
                        <option value="100">100 km</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="result" id="result" class="form-control">
                        <option value="10">10 Result</option>
                        <option value="25">25 Result</option>
                        <option value="50">50 Result</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="search-input" id="address" name="address" placeholder="Search by Keyword...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-lg btn-primary">Filter</button>
                    <button class="btn btn-secondary btn-lg"><i class="fa fa-filter"></i></button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xl-5">
                    <div class="search-map"></div>
                </div>
                <div class="col-xl-7">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="result-card">
                                <img src="../../../images/user/profile/1244248-500w.jpg" alt="" class="img-container">
                                <div class="result-card-content p-3">
                                    <div><i class="fa fa-map-marker mr-50" style="color: #000;"></i> Handy Road, Projector X: Picturehouse, Singapore</div>
                                    <div class="font-weight-bold primary">Angelina George Herny Capitol</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="result-card"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="../../../js/freelancer-search.js"></script>
@endpush
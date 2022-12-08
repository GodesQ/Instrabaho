@extends('layout.layout')

@section('content')

<style>
    #map-canvas {
        height: 200px;
        width: 100%;
    }
    #freelancers-locations {
        height: 600px;
       width: 100%;
   }
</style>

{{-- <section class="fr-list-product bg-img">
    <div class="container">
       <div class="row">
          <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
             <div class="fr-list-content">
                <div class="fr-list-srch">
                   <h1>Freelancer Search</h1>
                </div>
                <div class="fr-list-details">
                   <ul>
                      <li><a href="index.html">Home</a></li>
                      <li><a href="javascript:void(0)">Freelancer Search</a></li>
                   </ul>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section> --}}
 <section class="fr-lance-details section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xs-12 col-sm-12 col-md-12 col-xl-4">
                <div class="project-sidebar">
                    <div class="heading">
                    <h4>Search Filters</h4>
                    <a href="/search_freelancers">Clear Result</a>
                    </div>
                    <div class="project-widgets">
                    <form action="#"  id="freelancer-filter-form">
                        <div class="row px-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="font-weight-bold mt-2" style="color: #000;">Address</div>
                                            <div class="mb-3">Street, City or State</div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="get-current-location">Current <i class=""></i></button>
                                    </div>
                                    <input type="text" name="address" id="map-search" class="form-control controls" value="" placeholder="Enter Address">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="map-canvas"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <!-- <div class="form-label font-weight-bold my-50">Latitude</div> -->
                                    <input type="hidden" name="latitude" class="form-control latitude">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <!-- <div class="form-label font-weight-bold my-50">Longitude</div> -->
                                    <input type="hidden" name="longitude" class="form-control longitude">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="font-weight-bold" style="color: #000;">Radius</div>
                                    <select name="radius" id="radius" class="form-control">
                                        <option value="5">5 km</option>
                                        <option value="10">10 km</option>
                                        <option value="25">25 km</option>
                                        <option value="50">50 km</option>
                                        <option value="75">75 km</option>
                                        <option value="100">100 km</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="font-weight-bold" style="color: #000;">Result Per Page</div>
                                    <select name="result" id="result" class="form-control">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 my-3">
                                <div class="form-group">
                                    <div class="font-weight-bold mt-2" style="color: #000;">Keyword</div>
                                    <div class="mb-3">Job Title, keywords, Freelancer</div>
                                    <input type="text" class="form-control" name="title" placeholder="Keyword or freelancer name" id="title">
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#price-widget"> Advance Search </a> </div>
                                <div id="price-widget" class="panel-collapse collapse" role="tabpanel" style="overflow: scroll !important;">
                                    <div class="panel-body" tabindex="2">
                                        <div class="form-group">
                                            <div class="font-weight-bold mt-4" style="color: #000;">Rate</div>
                                            <div class="mb-3">Hourly Rate of Freelancer</div>
                                            <div class="range-slider">
                                                <input type="text" class="services-range-slider" name="my_range" id="my_range" />
                                            </div>
                                            <div class="extra-controls">
                                                <input type="text" class="services-input-from form-control" value="" name="price-min">
                                                <input type="text" class="services-input-to form-control" value="" name="price-max">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="font-weight-bold mt-4" style="color: #000;">Skills</div>
                                            <div class="mb-3">Search by Skills  </div>
                                            <ul class="main">
                                                @foreach($skills as $skill)
                                                    <li class="">
                                                        <div class="pretty p-icon p-thick p-curve">
                                                        <input type="checkbox" name="skill[]" value="{{ $skill->id }}" id="skills">
                                                        <div class="state p-warning">
                                                            <i class="icon fa fa-check" aria-hidden="true"></i>
                                                            <label></label>
                                                        </div>
                                                        </div>
                                                        <span>{{ $skill->skill_name }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="form-group">
                                            <div class="font-weight-bold mt-4" style="color: #000;">Freelancer Type</div>
                                            <div class="mb-3">Search by Freelancer Type  </div>
                                            <ul class="main">
                                                <li class="">
                                                    <div class="pretty p-icon p-thick p-curve">
                                                        <input type="checkbox" name="freelance_type[]" id="freelancer_type" value="company" id="154">
                                                        <div class="state p-warning">
                                                        <i class="icon fa fa-check" aria-hidden="true"></i>
                                                        <label></label>
                                                        </div>
                                                    </div>
                                                    <span>Company (3)</span>
                                                </li>
                                                <li class="">
                                                    <div class="pretty p-icon p-thick p-curve">
                                                        <input type="checkbox" name="freelance_type[]" value="group" id="freelancer_type">
                                                        <div class="state p-warning">
                                                        <i class="icon fa fa-check" aria-hidden="true"></i>
                                                        <label></label>
                                                        </div>
                                                    </div>
                                                    <span>Group (1)</span>
                                                </li>
                                                <li class="">
                                                    <div class="pretty p-icon p-thick p-curve">
                                                        <input type="checkbox" name="freelance_type[]" value="individual" id="freelancer_type">
                                                        <div class="state p-warning">
                                                        <i class="icon fa fa-check" aria-hidden="true"></i>
                                                        <label></label>
                                                        </div>
                                                    </div>
                                                    <span>Individual (3)</span>
                                                </li>
                                                <li class="">
                                                    <div class="pretty p-icon p-thick p-curve">
                                                        <input type="checkbox" name="freelance_type[]" value="student" id="freelancer_type">
                                                        <div class="state p-warning">
                                                        <i class="icon fa fa-check" aria-hidden="true"></i>
                                                        <label></label>
                                                        </div>
                                                    </div>
                                                    <span>Student (1)</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="submit-btn">
                            <input type="hidden" name="sort" value="">
                            <button class="btn btn-theme btn-block" type="submit"> Filter Result</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-8 col-sm-12 col-md-12 col-xl-8">
                <div class="row">
                    <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                    <div class="services-filter">
                        <div>
                            <button type="button" class="btn btn-primary view-map-btn" data-toggle="modal" style="display: none;" data-target="#modal-map">
                                View Map
                            </button>
                        </div>
                        <div style="width: 50%">
                            <select name="sort" id="sort" class="form-control">
                                <option value="asc">Sort by Nearest</option>
                                <option value="hourly_rate">Sort By Lowest Price</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row freelancers-data">
                            @include('CustomerScreens.home_screens.freelancer.freelancers')
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
 </section>
 <div class="modal fade" id="modal-map" tabindex="-1" role="dialog" aria-labelledby="modal-map" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-header bg-primary white">
            <h4 class="modal-title text-white" id="myModalLabel8">Freelancers Location</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-content">
            <div class="card">
                <div class="card-body">
                    <div id="freelancers-locations"></div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-left">
                            <button class="btn btn-secondary hide-boundary-btn" type="button">Hide Boundary</button>
                            <button class="btn btn-primary show-boundary-btn" type="button">Show Boundary</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <script src="../../../js/user-location.js"></script>
@endsection

@push('scripts')
<script src="../../../assets/js/custom_js/homescreen/freelancer_search.js"></script>
@endpush

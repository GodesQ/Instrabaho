@extends('layout.layout')

@section('title', 'Project Search')

@section('content')

    @if (Session::get('fail'))
        @push('scripts')
            <script>
                toastr.error('{{ Session::get('fail') }}', 'Fail');
            </script>
        @endpush
    @endif

    @if (Session::get('success'))
        @push('scripts')
            <script>
                toastr.success('{{ Session::get('success') }}', 'Follow');
            </script>
        @endpush
    @endif

    <style>
        #map-canvas {
            height: 400px;
            width: 100%;
        }

        #projects-locations {
            height: 500px;
            width: 100%;
        }
    </style>

    {{-- <section class="fr-list-product bg-img">
    <div class="container">
       <div class="row">
          <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
             <div class="fr-list-content">
                <div class="fr-list-srch">
                   <h1>Project Search</h1>
                </div>
                <div class="fr-list-details">
                   <ul>
                      <li><a href="index.html">Home</a></li>
                      <li><a href="javascript:void(0)">Project Search</a></li>
                   </ul>
                </div>
             </div>
          </div>
       </div>
    </div>
</section> --}}

    <section class="fr-top-srvices mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-xs-12 col-sm-12 col-md-12">
                    <div class="service-side position-sticky">
                        <div class="heading">
                            <h4>Search Filters</h4>
                            <a href="/search_projects">Clear Result</a>
                        </div>
                        <div class="service-widget">
                            <form action="#" id="projects-filter-form">
                                <div class="row px-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="font-weight-bold mt-2" style="color: #000;">Address</div>
                                                    <div class="mb-3">Street, City or State</div>
                                                </div>
                                                <button type="button" class="btn btn-primary"
                                                    id="get-current-location">Current <i class=""></i></button>
                                            </div>
                                            <input type="text" name="address" id="map-search"
                                                class="form-control controls" value="" placeholder="Enter Address">
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
                                            <div class="mb-3">Project Title, keywords</div>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Keyword or freelancer name" id="title">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading"> <a role="button" class="" data-bs-toggle="collapse"
                                            href="#category-widget"> Advance Filter </a> </div>
                                    <div id="category-widget" class="panel-collapse collapse" role="tabpanel">
                                        <div class="panel-body" tabindex="2">
                                            <div class="form-group my-2">
                                                <div class="font-weight-bold mt-4" style="color: #000;">Categories</div>
                                                <ul>
                                                    @foreach ($service_categories as $category)
                                                        <li class="">
                                                            <div class="pretty p-icon p-thick p-curve">
                                                                <input type="checkbox" id="categories" name="categories[]"
                                                                    value="{{ $category->id }}" id="{{ $category->id }}">
                                                                <div class="state p-warning">
                                                                    <i class="icon fa fa-check" aria-hidden="true"></i>
                                                                    <label></label>
                                                                </div>
                                                            </div>
                                                            <span>{{ $category->name }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="form-group my-2">
                                                <div class="font-weight-bold mt-4" style="color: #000;">Price</div>
                                                <div class="range-slider">
                                                    <input type="text" class="services-range-slider" id="my_range"
                                                        name="my_range" value="" />
                                                </div>
                                                <div class="extra-controls">
                                                    <input type="text" class="services-input-from form-control"
                                                        value="" id="price-min" name="price-min">
                                                    <input type="text" class="services-input-to form-control"
                                                        value="" name="price-max" id="price-max">
                                                </div>
                                            </div>
                                            <div class="form-group my-2">
                                                <div class="font-weight-bold mt-4" style="color: #000;">Type</div>
                                                <div class="">
                                                    <select name="type" id="type" class="select2 form-control">
                                                        <option value="">Select Type</option>
                                                        <option value="simple">Simple</option>
                                                        <option value="featured">Featured</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="page" id="page_count" value="1">
                                <div class="submit-btn">
                                    <p><i>Select the options and press the Filter Result button to apply the changes </i>
                                    </p>
                                    <button class="btn btn-theme btn-block" type="submit"> Filter Result</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-9 col-xl-8 col-xs-12 col-sm-12 col-md-12">
                    <div class="row">
                        <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                            <div class="services-filter-2">
                                <form class="d-flex justify-content-between align-items-center">
                                    <div class="heading-area">
                                        <h4>Found Results</h4>
                                    </div>
                                    <div class=" float-right">
                                        <ul class="top-filters">
                                            <li>
                                                <a href="" class="services-grid-icon protip active list-style"
                                                    data-pt-position="top" data-pt-scheme="black"
                                                    data-pt-title="Grid View" data-list-style="grid">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </a>
                                            </li>
                                            <button type="button" class="btn btn-primary view-map-btn"
                                                data-toggle="modal" style="display: none;" data-target="#modal-map">
                                                View Map
                                            </button>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row projects-data">
                                @include('CustomerScreens.home_screens.project.projects');
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade " id="modal-map" tabindex="-1" role="dialog" aria-labelledby="modal-map"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title text-white" id="myModalLabel8">Projects Location</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-content">
                <div class="card">
                    <div class="card-body">
                        <div id="projects-locations"></div>
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
    <script src="../../../assets/js/custom_js/homescreen/projects_search.js"></script>
@endpush

@extends('layout.user-layout')

@section('content')
@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success("{{ Session::get('success') }}", 'Sucess');
        </script>
    @endpush
@endif

@if(Session::get('fail'))
    @push('scripts')
        <script>
            toastr.error("{{ Session::get('fail') }}", 'Error');
        </script>
    @endpush
@endif

    <div class="row grouped-multiple-statistics-card">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon primary d-flex justify-content-center mr-3">
                                    <i class="icon p-1 icon-settings customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600">$95k</h3>
                                    <p class="sub-heading">Services Offered</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                    <i class="icon p-1 icon-badge customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600">18.63%</h3>
                                    <p class="sub-heading">Completed Services</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon danger d-flex justify-content-center mr-3">
                                    <i class="icon p-1 icon-clock customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600">$27k</h3>
                                    <p class="sub-heading">On Going Services</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start">
                                <span class="card-icon warning d-flex justify-content-center mr-3">
                                    <i class="icon p-1 icon-star customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600">13700</h3>
                                    <p class="sub-heading">Reviews</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row minimal-modern-charts">
        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-12 power-consumption-stats-chart">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">MY PROJECTS IN EVERY MONTH</div>
                    <div id="column-basic-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-8 col-lg-8 col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Most Viewed Services</h4>
                    <div class="listing-widgets">
                        <ul>
                            <p> No, Stats available</p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Current Plan Detail</h4>
                        @if($freelancer->package_checkout)
                            @if(!$freelancer->package_checkout->isExpired && $freelancer->package_date_expiration > date('Y-m-d'))
                                <a href="#">{{ $freelancer->package_checkout->package_name }}</a>
                            @else
                                <a href="/freelance_packages">View Plans</a>
                            @endif
                        @else
                            <a href="/freelance_packages">View Plans</a>
                        @endif
                    </div>
                    <div class="listing-widgets">
                        <ul>
                            @if($freelancer->package_checkout && $freelancer->package_date_expiration > date('Y-m-d'))
                                <li class="my-1">
                                    <h4 style="font-weight: 400; font-size: medium;"><i class="feather icon-check-circle mr-1"></i> Projects Allowed: <span style="color: #091a3b; font-weight: 600;">{{ $freelancer->package_checkout->freelance_package->total_projects }}</span></h4>
                                </li>
                                <hr>
                                <li class="my-1">
                                    <h4 style="font-weight: 400; font-size: medium;"><i class="feather icon-check-circle mr-1"></i> Services Allowed To Create: <span style="color: #091a3b; font-weight: 600;">{{ $freelancer->package_checkout->freelance_package->total_services }}</span></h4>
                                </li>
                                <hr>
                                <li class="my-1">
                                    <h4 style="font-weight: 400; font-size: medium;"><i class="feather icon-check-circle mr-1"></i> Featured Services Allowed To Create: <span style="color: #091a3b; font-weight: 600;">{{ $freelancer->package_checkout->freelance_package->total_feature_services }}</span></h4>
                                </li>
                                <hr>
                                <li class="my-1">
                                    <h4 style="font-weight: 400; font-size: medium;"><i class="feather icon-check-circle mr-1"></i> Featured Profile: <span style="color: #091a3b; font-weight: 600;">{{ $freelancer->package_checkout->freelance_package->isProfileFeatured ? 'Yes' : 'No' }}</span></h4>
                                </li>
                                <hr>
                                <li class="my-1">
                                    <h4 style="font-weight: 400; font-size: medium;"><i class="feather icon-check-circle mr-1"></i> Expired Date: <span style="color: #091a3b; font-weight: 600;">{{ date_format(new DateTime($freelancer->package_date_expiration), "F d, Y")}}</span></h4>
                                </li>
                                <hr>
                            @else
                                <p> No, Stats available</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="../../../app-assets/js/scripts/charts/apexcharts/charts-apexcharts.js"></script>
@endpush

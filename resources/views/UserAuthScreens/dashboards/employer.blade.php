@extends('layout.user-layout')

@section('title', 'EMPLOYER DASHBOARD')

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
                                    <i class="icon p-1 icon-bar-chart customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600">$95k</h3>
                                    <p class="sub-heading">Revenue</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="success"><i class="fa fa-long-arrow-up"></i> 5.2%</small>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon danger d-flex justify-content-center mr-3">
                                    <i class="icon p-1 icon-pie-chart customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600">18.63%</h3>
                                    <p class="sub-heading">Growth Rate</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="danger"><i class="fa fa-long-arrow-down"></i> 2.0%</small>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                    <i class="icon p-1 icon-graph customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600">$27k</h3>
                                    <p class="sub-heading">Sales</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="success"><i class="fa fa-long-arrow-up"></i> 10.0%</small>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start">
                                <span class="card-icon warning d-flex justify-content-center mr-3">
                                    <i class="icon p-1 icon-basket-loaded customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600">13700</h3>
                                    <p class="sub-heading">Orders</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="danger"><i class="fa fa-long-arrow-down"></i> 13.6%</small>
                                </span>
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
                <div class="card-content pt-2 px-1">
                    <div class="row">
                        <div class="col-8 d-flex">
                            <div class="ml-1">
                                <h4 class="power-consumption-stats-title text-bold-500">Profile Views</h4>
                            </div>
                            <div class="ml-50 mr-50">
                                <p>(kWh/100km)</p>
                            </div>
                        </div>
                        <div class="col-4 d-flex justify-content-end pr-3">
                            <div class="dark-text">
                                <h5 class="power-consumption-active-tab text-bold-500">Week</h5>
                            </div>
                            <div class="light-text ml-2">
                                <h5>Month</h5>
                            </div>
                        </div>
                    </div>
                    <div id="spline-chart"></div>
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
        </div>
    </div>
@endsection

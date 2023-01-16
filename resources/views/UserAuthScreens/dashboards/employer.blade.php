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

    <div class="container-fluid">
        <h2 class="font-weight-bold">Welcome <span class="primary h2 font-weight-bold">{{ $employer->display_name }}</span>!</h2>
        <h6>Hope you're having a great time finding workers.</h6>
    </div>
    <div class="row my-2">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Total Projects</div>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <h3 class="font-weight-bold">105</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="height-250">
                        <canvas id="total-projects-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Recent Workers</div>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a href="#" class="primary font-weight-bold">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @forelse ($recent_workers as $recent_worker)
                        <div class="d-flex justify-content-start align-items-center mt-25 mb-2" style="gap: 20px;">
                            <img class="avatar avatar-lg" src="{{'../../../images/user/profile/' . $recent_worker->freelancer->user->profile_image }}" />
                            <div>
                                <h5 class="font-weight-bold">{{ $recent_worker->freelancer->display_name }}</h5>
                                <div class="">{{ substr($recent_worker->freelancer->user->email, 0, 25) }} {{ strlen($recent_worker->freelancer->user->email) > 25 ? '...' : null }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">
                            No Recent Workers Found
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Recent Payments</div>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a href="#" class="primary font-weight-bold">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @forelse ($recent_payments as $recent_payment)
                        <div class="d-flex justify-content-start align-items-center mt-25 mb-2" style="gap: 20px;">
                            <div>
                                <h5 class="font-weight-bold">{{ $recent_payment->transaction_code }}</h5>
                                <div class="">₱ {{ number_format($recent_payment->amount, 2) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">
                            No Recent Payments Found
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>

// Column chart
// ------------------------------
$(window).on("load", function(){
    //Get the context of the Chart canvas element we want to select
    var ctx = $("#total-projects-chart");

    // Chart Options
    var chartOptions = {
        // Elements options apply to all of the options unless overridden in a dataset
        // In this case, we are setting the border of each bar to be 2px wide and green
        elements: {
            rectangle: {
                borderWidth: 2,
                borderColor: '#000000',
                borderSkipped: 'bottom'
            }
        },
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        legend: {
            position: 'top',
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                }
            }]
        },
        title: {
            display: true,
            text: 'Total Projects'
        }
    };

    // Chart Data
    var chartData = {
        labels: ["January", "February",],
        datasets: [{
            label: "Projects Per Month",
            data: [65, 59, 80, 81, 56],
            backgroundColor: "#04bbff",
            hoverBackgroundColor: "#04bbff",
            borderColor: "transparent"
        }]
    };

    var config = {
        type: 'bar',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var lineChart = new Chart(ctx, config);
    });
</script>
@endpush

 <form id="signup-form" action="/submit-reset-form" method="POST">
                            @csrf
                            <input type="hidden" name="verify_token" value="{{ $token }}">
                            <div class="fr-sign-form">
                                <div class="fr-sign-logo"> <img src="../../../images/icons/password.png" alt="" class="img-fluid"> </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password" class="form-control" id="password-field" required="" data-smk-msg="Please provide password">
                                    <div data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password change-top" aria-hidden="true"></div>
                                    <span class="text-danger danger">@error('password'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="fr-sign-form">
                                <div class="fr-sign-logo"> <img src="../../../images/icons/password.png" alt="" class="img-fluid"> </div>
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" id="password-field" required="" data-smk-msg="Please provide password">
                                    <div data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password change-top" aria-hidden="true"></div>
                                    <span class="text-danger danger">@error('password_confirmation'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="fr-sign-submit">
                            <div class="form-group d-grid">
                                <input type="hidden" name="email" value="{{ $email }}">
                                <button type="submit" class="btn btn-theme btn-loading" id="signup-btn"> Sign in
                                    <span class="bubbles"> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> </span>
                                </button>
                            </div>
                            </div>
                        </form>

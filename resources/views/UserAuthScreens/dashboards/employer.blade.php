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
                    <div class="card-title"></div>
                </div>
                <div class="card-body">
                    <div class="height-300">
                        <canvas id="column-chart"></canvas>
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

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
        <h2 class="font-weight-bold">Welcome {{ $employer->display_name }}!</h2>
        <h6>Hope you're having a great time finding workers.</h6>
    </div>
    <div class="row my-2">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Recent Workers</div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Recent Payments</div>
                </div>
                <div class="card-body">
                       
                </div>
            </div>
        </div>
    </div>
@endsection

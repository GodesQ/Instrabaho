@extends('layout.user-layout')

@section('title')
    FAILED TRANSACTION
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-lg-2"></div>
                        <div class="col-xl-6 col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="danger text-center">Payment Failed!</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 my-50">
                                            <a href="/{{ session()->get('role') }}/dashboard" class="btn btn-outline-primary btn-lg font-weight-bold btn-block">Back to Dashboard</a>
                                        </div>
                                        <div class="col-xl-6 my-50">
                                            <a href="/user_fund" class="btn btn-primary btn-lg font-weight-bold btn-block">Go to My Funds</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

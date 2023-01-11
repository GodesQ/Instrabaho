@extends('layout.user-layout')

@section('title')
    SUCCESS TRANSACTION
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-lg-2">
                            
                        </div>
                        <div class="col-xl-6 col-lg-8">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h2 class="success text-center">Payment Successful!</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row my-50">
                                        <div class="col-xl-6">
                                            <h5>Payment Type</h5>
                                        </div>
                                        <div class="col-xl-6 text-xl-right">
                                            <h5 class="text-uppercase">{{ $transaction->payment_method }}</h5>
                                        </div>
                                    </div>
                                    <div class="row my-50">
                                        <div class="col-xl-6">
                                            <h5>Name of Transaction</h5>
                                        </div>
                                        <div class="col-xl-6 text-xl-right">
                                            <h5>{{ $transaction->name_of_transaction }}</h5>
                                        </div>
                                    </div>
                                    <div class="row my-50">
                                        <div class="col-xl-6">
                                            <h5 class="font-weight-bold">Total Amount</h5>
                                        </div>
                                        <div class="col-xl-6 text-xl-right">
                                            <h5 class=" font-weight-bold">₱ {{ number_format($transaction->amount, 2) }}</h5>
                                        </div>
                                    </div>
                                    <div class="row my-50">
                                        <div class="col-xl-6">
                                            <h5>Transaction Code</h5>
                                        </div>
                                        <div class="col-xl-6 text-xl-right">
                                            <h5>{{ $transaction->transaction_code }}</h5>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="my-1">
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
                        </div>
                        <div class="col-xl-3 col-lg-2">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
 
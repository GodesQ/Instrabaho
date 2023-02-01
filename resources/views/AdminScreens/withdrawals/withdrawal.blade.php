@extends('layout.admin-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>Withdrawal Information</h3>
                                    <div class="container rounded py-1 px-2 my-1" style="background: rgb(247, 247, 247);">
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                User :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->user->firstname }} {{ $withdrawal->user->lastname }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                User Email :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->user->email }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Reference No :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->reference_no }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Withdraw Transaction Code :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction_code }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Withdrawal Type :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->withdrawal_type }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Withdrawal Status :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                @if($withdrawal->status == 'pending')
                                                    <div class="badge badge-warning">{{ $withdrawal->status }}</div>
                                                @else
                                                    <div class="badge badge-primary">{{ $withdrawal->status }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if ($withdrawal->withdrawal_type == 'gcash')
                                        <h3>GCASH Information</h3>
                                        <div class="container rounded py-1 px-2 my-1" style="background: rgb(247, 247, 247);">
                                            <div class="row my-1">
                                                <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                    Gcash Number :
                                                </div>
                                                <div class="col-xl-7 col-lg-12">
                                                    +63{{ $withdrawal->type_data->gcash_number }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <h3>Transaction Information</h3>
                                    <div class="container rounded py-1 px-2 mt-1" style="background: rgb(247, 247, 247);">
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Transaction Code :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction->transaction_code }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Transaction Type :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction->transaction_type }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Name of Transaction :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction->name_of_transaction }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Payment Type :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction->payment_method }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

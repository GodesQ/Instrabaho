@extends('layout.user-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <form>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">Payment Information</div>
                                    <div class="border-bottom d-flex justify-content-between align-items-center px-2">
                                        <h4>Job Type</h4>
                                        <h5 class="font-weight-bold">Service</h5>
                                    </div>
                                    <div class="border-bottom d-flex justify-content-between align-items-center px-2 my-2">
                                        <h4>Date</h4>
                                        <h5 class="font-weight-bold">{{ date('F d, Y') }}</h5>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold">Job Cost</div>
                                            <input type="number" placeholder="0.00" value="{{ $job_data['cost'] }}" class="form-control" name="total_cost">
                                        </div>
                                        <div class="row skin skin-flat my-2">
                                            <div class="col-md-12">
                                                <h5 class="font-weight-bold">Payment Option</h5>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" value="gcash" id="input-radio-14">
                                                            <label for="input-radio-14">G CASH</label>
                                                        </fieldset>
                                                        <img src="../../../images/logo/gcash-logo.png" alt="" style="width: 50px;">
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" value="paymaya" id="input-radio-15">
                                                            <label for="input-radio-15">PAYMAYA</label>
                                                        </fieldset>
                                                        <img src="../../../images/logo/paymaya-logo.png" alt="" style="width: 50px;">
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" value="paypal" id="input-radio-18">
                                                            <label for="input-radio-18">PAYPAL</label>
                                                        </fieldset>
                                                        <img src="../../../images/logo/paypal-logo.png" alt="" style="width: 40px;">
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" value="online_bank" id="input-radio-17">
                                                            <label for="input-radio-17">ONLINE BANK</label>
                                                        </fieldset>
                                                        <img src="../../../images/logo/online-bank.png" alt="" style="width: 50px;">
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" value="credit_card" id="input-radio-16">
                                                            <label for="input-radio-16">CREDIT CARD</label>
                                                        </fieldset>
                                                        <img src="../../../images/logo/credit-card.png" alt="" style="width: 50px;">

                                                    </li>
                                                </ul>
                                                <span class="text-danger danger">@error('payment_method'){{ $message }}@enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">Summary</div>
                                    <div class="container-fluid">
                                        <h4 class="d-flex justify-content-between align-items-center font-weight-normal">
                                            {{ $job_data['title'] }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
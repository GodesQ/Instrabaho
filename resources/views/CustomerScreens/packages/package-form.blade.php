@extends('layout.layout')

@section('content')
@if(Session::get('fail'))
    @push('scripts')
        <script>
            toastr.error('{{ Session::get("fail") }}', "Fail");
        </script>
    @endpush
@endif
<style>
    #map-canvas {
        height: 400px;
        width: 100%;
    }
</style>
<section class="fr-list-product bg-img">
    <div class="container">
       <div class="row">
          <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
             <div class="fr-list-content">
                <div class="fr-list-srch">
                   <h1>Checkout</h1>
                </div>
                <div class="fr-list-details">
                   <ul>
                      <li><a href="/">Home</a></li>
                      <li><a href="javascript:void(0)">Checkout</a></li>
                   </ul>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 <section class="exertio-checkout my-5">
    <div class="container">
        <form action="/store_package_checkout" class="form" method="POST">
            @csrf
            <input type="hidden" name="user_role_id" value="{{ $user->id }}">
            <input type="hidden" name="role" value="{{ session()->get('role') }}">
            <div class="row">
                <div class="col-xl-8 col-md-12 col-lg-12 col-12">
                    <div class="card my-5">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-50">
                                            Firstname
                                        </div>
                                        <input type="text" readonly name="firstname" class="form-control" value="{{ $user->user->firstname }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-50">Lastname</div>
                                        <input type="text" readonly name="lastname" class="form-control" value="{{ $user->user->lastname }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-50">
                                            Company Name (optional)
                                        </div>
                                        <input type="text" name="company_name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-50">
                                            Country
                                        </div>
                                        <div class="form-label font-weight-bold my-50">
                                            PHILIPPINES
                                        </div>
                                        <input type="hidden" name="country" value="PHILIPPINES" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Address</div>
                                            <input type="text" name="complete_address" id="map-search" class="form-control controls" value="{{ $user->address }}">
                                            <br>
                                            <button class="btn btn-primary" type="button" id="get-current-location">Get Current Location</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="map-canvas"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group d-none">
                                            <div class="form-label font-weight-bold my-50">Latitude</div>
                                            <input type="text" name="latitude" value="{{ $user->latitude }}" class="form-control latitude">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group d-none">
                                            <div class="form-label font-weight-bold my-50">Longitude</div>
                                            <input type="text" name="longitude" class="form-control longitude" value="{{ $user->longitude }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-50">
                                            Phone
                                        </div>
                                        <input type="text" name="contactno" class="form-control"  value="{{ $user->contactno }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-50">
                                            Email
                                        </div>
                                        <input type="email" readonly name="email" class="form-control" value="{{ $user->user->email }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12 col-lg-12 col-12">
                    <div class="card my-5">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="float-right">
                                    Sub Total
                                </span>
                                Product
                            </li>
                            <li class="list-group-item">
                                <span class="float-right">
                                    ₱ {{ number_format($package->price, 2) }}
                                </span>
                                {{ $package->name }}
                            </li>
                            <li class="list-group-item">
                                <span class="float-right">
                                    ₱ {{ number_format($package->price, 2) }}
                                    <input type="number" hidden name="total" value="{{ number_format($package->price, 2) }}">
                                    <input type="hidden" name="package_name" value="{{ $package->name }}">
                                    <input type="hidden" name="package_type" value="{{ $package->id }}">
                                </span>
                                Total
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Payment Method</div>
                        </div>
                        <div class="card-body">
                            <fieldset class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_type" value="paid_by_wallet" id="customRadio8" checked>
                                    <label class="custom-control-label" for="customRadio8">Paid By Wallet</label>
                                </div>
                            </fieldset>
                            <hr>
                            <fieldset class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_type" value="test" id="customRadio1">
                                    <label class="custom-control-label" for="customRadio1">Sample Payment</label>
                                </div>
                            </fieldset>
                            <fieldset class="my-1 d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_type" value="gcash" id="customRadio2" disabled>
                                    <label class="custom-control-label" for="customRadio2">GCASH <span style="font-size: 10px; font-style: italic;">(Mobile)</span></label>
                                </div>
                                <div class="span">
                                    <img src="../../../images/payment_method/gcash.png" width="80" alt="">
                                </div>
                            </fieldset>
                            <fieldset class="my-1 d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_type" value="credit_card" id="customRadio3" disabled>
                                    <label class="custom-control-label" for="customRadio3">Credit Card</label>
                                </div>
                                <div class="span">
                                    <img src="../../../images/payment_method/credit_card.png" width="50" alt="">
                                </div>
                            </fieldset>
                            <fieldset class="my-1 d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_type" value="paypal" id="customRadio4" disabled>
                                    <label class="custom-control-label" for="customRadio4">Paypal</label>
                                </div>
                                <div class="span">
                                    <img src="../../../images/payment_method/paypal.png" width="60" alt="">
                                </div>
                            </fieldset>
                            <fieldset class="my-3 d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_type" value="bank_transfer" id="customRadio2" disabled>
                                    <label class="custom-control-label" for="customRadio2">Bank Transfer</label>
                                </div>
                                <div class="span">
                                    <img src="../../../images/payment_method/bank_transfer.png" width="30" alt="">
                                </div>
                            </fieldset>
                            <hr>
                            <div class="card">
                                <button class="btn btn-solid btn-primary float-right" type="submit">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
 </section>
<script src="../../../js/user-location.js"></script>
@endsection

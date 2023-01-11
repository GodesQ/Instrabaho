@extends('layout.user-layout')

@section('title')
    PAY JOB - {{ $job_data['title'] }}
@endsection

@section('content')

@if(Session::get('fail'))
    @push('scripts')
        <script>
            toastr.error('{{ Session::get("fail") }}', 'Fail');
        </script>
    @endpush
@endif

@if(Session::get('error'))
    @push('scripts')
        <script>
            toastr.error('{{ Session::get("error") }}', 'Fail');
        </script>
    @endpush
@endif


@if ($errors->any())
    @foreach ($errors->all() as $error)
        @push('scripts')
            <script>
                toastr.error('{{ $error }}', 'Error')
            </script>
        @endpush
    @endforeach
@endif


    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <form method="POST" action="/project_pay_job">
                    @csrf
                    <input type="hidden" name="cost_type" value="{{ $job_data['cost_type'] }}" id="cost_type">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">Payment Information</div>
                                    <div class="border-bottom d-lg-flex justify-content-between px-2">
                                        <h4>Job Type</h4>
                                        <h5 class="font-weight-bold text-uppercase">{{ $job_data['job_type'] }}</h5>
                                    </div>
                                    <div class="border-bottom d-lg-flex justify-content-between px-2 my-2">
                                        <h4>Date</h4>
                                        <h5 class="font-weight-bold">{{ date('F d, Y') }}</h5>
                                    </div>
                                    <div class="border-bottom d-lg-flex justify-content-between px-2 my-2">
                                        <h4>Total Cost</h4>
                                        <h5 class="font-weight-bold">{{ number_format($job_data['cost'], 2) }}</h5>
                                        <input type="hidden" name="job_cost" id="job_cost" value="{{ $job_data['cost'] }}">
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row my-2">
                                            <div class="col-md-12">
                                                <h5 class="font-weight-bold">Payment Option</h5>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <ul class="list-group my-1">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" class="payment_method mr-2" value="pay_using_wallet" id="input-radio-20">
                                                            <label for="input-radio-20">Pay using your Wallet</label>
                                                        </fieldset>
                                                        {{-- <!-- <img src="../../../images/logo/gcash-logo.png" style="width: 50px;"> --> --}}
                                                    </li>
                                                    <hr>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" class="payment_method mr-2" value="gcash" id="input-radio-14">
                                                            <label for="input-radio-14">G CASH</label>
                                                        </fieldset>
                                                        <img src="../../../images/logo/gcash-logo.png" style="width: 50px;">
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" class="payment_method mr-2" value="grab_pay" id="input-radio-17">
                                                            <label for="input-radio-17">GRAB PAY</label>
                                                        </fieldset>
                                                        <img src="../../../images/logo/grabpay.png" style="width: 50px;">
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" class="payment_method mr-2" value="paymaya" id="input-radio-15">
                                                            <label for="input-radio-15">PAYMAYA</label>
                                                        </fieldset>
                                                        <img src="../../../images/logo/paymaya-logo.png" style="width: 50px;">
                                                    </li>

                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <fieldset>
                                                            <input type="radio" name="payment_method" class="payment_method mr-2" value="card" id="input-radio-16">
                                                            <label for="input-radio-16">DEBIT/CREDIT CARD</label>
                                                        </fieldset>
                                                        <img src="../../../images/logo/credit-card.png" style="width: 50px;">

                                                    </li>
                                                </ul>
                                                <span class="text-danger danger">@error('payment_method'){{ $message }}@enderror</span>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="card" id="cc_form" style="box-shadow: 1px 0px 20px rgb(0 0 0 / 7%) !important; background: #fff; display: none;">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label class="label">Card Holder:</label>
                                                                    <input type="text" class="form-control"  placeholder="Card Holder" name="card_holder">
                                                                    <span class="text-danger danger">@error('card_holder'){{ $message }}@enderror</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label class="label">Card number:</label>
                                                                    <input type="text" class="form-control" data-mask="0000000000000000" name="card_number">
                                                                    <span class="text-danger danger">@error('card_number'){{ $message }}@enderror</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="label">Expiry Month:</label>
                                                                            <input type="text" class="form-control" data-mask="00" placeholder="00" name="expiry_month">
                                                                            <span class="text-danger danger">@error('expiry_month'){{ $message }}@enderror</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="label">Expiry Year:</label>
                                                                            <input type="text" class="form-control" data-mask="00" placeholder="00" name="expiry_year">
                                                                            <span class="text-danger danger">@error('expiry_year'){{ $message }}@enderror</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label class="label">CVC:</label>
                                                                    <input type="text" class="form-control" data-mask="000" placeholder="000" name="cvc">
                                                                    <span class="text-danger danger">@error('cvc'){{ $message }}@enderror</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                        <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                            <h5 style="width: 20%;" class="font-weight-bold">Title :</h5>
                                            <h4 style="width: 80%;" class="text-lg-right">{{ $job_data['title'] }}</h4>
                                        </div>
                                        <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                            <h5 class="font-weight-bold">Payment Type :</h5>
                                            <h4 class="payment_method_display"></h4>
                                        </div>
                                        @if ($job_data['cost_type'] == 'Hourly')
                                            <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                                <h5 class="font-weight-bold">Comission for Employer :</h5>
                                                <h4 class="">50.00</h4>
                                            </div>
                                            {{-- <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                                <h5 class="font-weight-bold">Deduction for Freelancer :</h5>
                                                <h4 class="system_deduction_display"></h4>
                                            </div> --}}
                                        @else
                                            {{-- <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                                <h5 class="font-weight-bold">Deduction for Freelancer :</h5>
                                                <h4 class="system_deduction_display"></h4>
                                            </div> --}}
                                        @endif
                                        <hr>
                                        <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                            <h5 class="font-weight-bold">Sub Total :</h5>
                                            <h4>₱ <span class="job_cost_display">{{ number_format($job_data['cost'], 2) }}</span></h4>
                                        </div>
                                        <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                            <h5 class="font-weight-bold">Commision :</h5>
                                            <h4>₱ <span class="job_cost_display">50.00</h4>
                                        </div>
                                        <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                            <h5 class="font-weight-bold">Total :</h5>
                                            <h4>₱ <span class="total_display">{{ number_format($job_data['cost'], 2) }}</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" name="system_deduction" id="system_deduction">
                                    <input type="hidden" name="total" id="total">
                                    <input type="hidden" name="employer_id" value="{{ $job_data['from_id'] }}">
                                    <input type="hidden" name="freelancer_id" value="{{ $job_data['to_id'] }}">
                                    <input type="hidden" name="job_id" value="{{ $job_data['job_id'] }}">
                                    <input type="hidden" name="job_type" value="{{ $job_data['job_type'] }}">
                                    <button class="btn btn-primary float-right" type="submit">Pay</button>
                                    <a class="btn btn-secondary float-right mx-50" href="{{ $job_data['job_type'] == 'project' ? '/employer/projects/ongoing' : null }}">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('input[type=radio][name=payment_method]').click(function() {
            switch (this.value) {
                case 'pay_using_wallet':
                    $('.payment_method_display').text('Pay using wallet');
                    $('#cc_form').css('display', 'none');
                    break;

                case 'gcash':
                    $('.payment_method_display').text('GCASH');
                    $('#cc_form').css('display', 'none');
                    break;

                case 'grab_pay':
                    $('.payment_method_display').text('GRABPAY');
                    $('#cc_form').css('display', 'none');
                    break;

                case 'paymaya':
                    $('.payment_method_display').text('PAYMAYA');
                    $('#cc_form').css('display', 'none');
                    break;

                case 'online_bank':
                    $('.payment_method_display').text('ONLINE BANK');
                    $('#cc_form').css('display', 'none');
                    break;

                case 'card':
                    $('.payment_method_display').text('CARD');
                    $('#cc_form').css('display', 'block');
                    break;
            }
        });

        function setSystemDeduction() {
            let job_cost = $('#job_cost').val();
            let cost_type = $('#cost_type').val();
            let system_deduction = Number(job_cost) * 0.15;
            $('.system_deduction_display').text(system_deduction.toFixed(2));
            $('#system_deduction').val(system_deduction.toFixed(2));
            let total_cost = 0;

            if(cost_type == 'Hourly') {
                total_cost = Number(job_cost) + 50;
            } else {
                total_cost = job_cost;
            }

            console.log(total_cost);
            $('.total_display').text(total_cost.toFixed(2));
            $('#total').val(total_cost.toFixed(2));
        }

        setSystemDeduction();
    </script>
@endpush

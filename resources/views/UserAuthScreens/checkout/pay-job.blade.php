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
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <form method="POST" action="/pay_job">
                    @csrf
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
                                                        <!-- <img src="../../../images/logo/gcash-logo.png" style="width: 50px;"> -->
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
                                            <h5 class="font-weight-bold">Sub Total :</h5>
                                            <h4>₱ <span class="job_cost_display">{{ number_format($job_data['cost'], 2) }}</span></h4>
                                        </div>
                                        <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                            <h5 class="font-weight-bold">Payment Method :</h5>
                                            <h4 class="payment_method_display"></h4>
                                        </div>
                                        <div class="d-lg-flex justify-content-between align-items-center font-weight-normal my-50">
                                            <h5 class="font-weight-bold">System Deduction :</h5>
                                            <h4 class="system_deduction_display"></h4>
                                        </div>
                                        <hr>
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
                    break;

                case 'gcash':
                    $('.payment_method_display').text('GCASH');
                    break;

                case 'paymaya':
                    $('.payment_method_display').text('PAYMAYA');
                    break;

                case 'online_bank':
                    $('.payment_method_display').text('ONLINE BANK');
                    break;

                case 'credit_card':
                    $('.payment_method_display').text('CREDIT CARD');
                    break;
            }
        });

        function setSystemDeduction() {
            let job_cost = $('#job_cost').val();
            let system_deduction = Number(job_cost) * 0.15;
            $('.system_deduction_display').text(system_deduction.toFixed(2));
            $('#system_deduction').val(system_deduction.toFixed(2));
            let total_cost = job_cost - system_deduction;
            $('.total_display').text(total_cost.toFixed(2));
            $('#total').val(total_cost.toFixed(2));
        }

        setSystemDeduction();
    </script>
@endpush

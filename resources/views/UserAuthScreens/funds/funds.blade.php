@extends('layout.user-layout')

@section('title', 'My Funds')
@section('content')
    <style>
        .payment-method-button {
            padding: 0.4rem 1rem;
            border-radius: 5px;
            background: transparent;
            border: transparent;
            outline: none;
        }

        .gcash-button {
            background: transparent;
            border: 1px solid #04bbff;
        }

        .btn-logo {
            width: 30px;
            height: 30px;
            border-radius: 50px;
            object-fit: cover;
        }
    </style>
    @if (Session::get('success'))
        @push('scripts')
            <script>
                toastr.success('{{ Session::get('success') }}', 'Success')
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
            <div class="page-body">
                @if ($user->wallet)
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-8 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-header">
                                            <h4 class="card-title" id="file-repeater">Total Funds</h4>
                                            <a class="heading-elements-toggle"><i
                                                    class="icon-ellipsis font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#withdrawForm">Withdraw </button>
                                            </div>
                                            <div class="modal fade text-left" id="withdrawForm" tabindex="-1"
                                                role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <label class="modal-title text-text-bold-600"
                                                                id="myModalLabel33">Withdraw Form</label>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('withdrawals') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="payment_method"
                                                                value="{{ $user->prefer_payment_method }}">
                                                            <div class="modal-body">
                                                                @if ($user->prefer_payment_method == 'gcash' || $user->prefer_payment_method == 'grab_pay')
                                                                    <label>Number: </label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"
                                                                                    id="basic-addon3">+63</span>
                                                                            </div>
                                                                            <input type="text" maxlength="10"
                                                                                max="10" class="form-control"
                                                                                placeholder="eg. 9123456490"
                                                                                name="gcash_number">
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if ($user->prefer_payment_method == 'card')
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <div class="form-group">
                                                                                <label class="label">Card Holder: </label>
                                                                                <input type="text" class="form-control"
                                                                                    placeholder="Card Holder"
                                                                                    name="card_holder"
                                                                                    value="{{ $user->firstname }} {{ $user->lastname }}">
                                                                                <span class="text-danger danger">
                                                                                    @error('card_holder')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <div class="form-group">
                                                                                <label class="label">Card number:</label>
                                                                                <input type="text" class="form-control"
                                                                                    data-mask="0000000000000000"
                                                                                    name="card_number">
                                                                                <span class="text-danger danger">
                                                                                    @error('card_number')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <div class="row">
                                                                                <div class="col-xl-6 col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <label class="label">Expiry
                                                                                            Month:</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            data-mask="00" placeholder="00"
                                                                                            name="exp_month">
                                                                                        <span class="text-danger danger">
                                                                                            @error('exp_month')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-6 col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <label class="label">Expiry
                                                                                            Year:</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            data-mask="00" placeholder="00"
                                                                                            name="exp_year">
                                                                                        <span class="text-danger danger">
                                                                                            @error('exp_year')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <div class="form-group">
                                                                                <label class="label">CVC:</label>
                                                                                <input type="text" class="form-control"
                                                                                    data-mask="000" placeholder="000"
                                                                                    name="cvc">
                                                                                <span class="text-danger danger">
                                                                                    @error('cvc')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <label>Amount: </label>
                                                                <div class="form-group">
                                                                    <input type="number" placeholder="Amount"
                                                                        name="amount" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="payment_method"
                                                                    value="{{ $user->prefer_payment_method }}">
                                                                <input type="reset" class="btn btn-secondary"
                                                                    data-dismiss="modal" value="close">
                                                                <input type="submit" class="btn btn-primary"
                                                                    name="action" value="Withdraw">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12 my-2">
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-3 col-md-4">
                                                            <div
                                                                class="badge badge-secondary d-flex justify-content-between align-items-center p-1 px-2 my-2">
                                                                <div>
                                                                    <h2 class="font-weight-bold">₱
                                                                        {{ number_format($user->wallet->amount, 2) }}</h2>
                                                                    <div>Your Balance</div>
                                                                </div>
                                                                <div class="icon-wallet font-size-large"></div>
                                                            </div>
                                                            {{-- <div>
                                                                <div class="d-flex align-items-center" style="gap: 8px;">
                                                                    <i class="fa fa-circle text-primary" style="font-size: 7px;"></i> <span style="font-size: 11px;" class="text-primary">Income</span>
                                                                </div>
                                                                <h4 class="font-weight-bold">₱ 0.00</h4>
                                                            </div>
                                                            <div>
                                                                <div class="d-flex align-items-center" style="gap: 8px;">
                                                                    <i class="fa fa-circle text-warning" style="font-size: 7px;"></i> <span style="font-size: 11px;" class="text-warning">Spending</span>
                                                                </div>
                                                                <h4 class="font-weight-bold">₱ 0.00</h4>
                                                            </div> --}}
                                                        </div>
                                                        <div class="col-xl-9 col-lg-9 col-md-8">
                                                            <div class="container-fluid table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <td>Transaction Code</td>
                                                                            <td>Name of Transaction</td>
                                                                            <td>Amount</td>
                                                                            <td>Payment Method</td>
                                                                            <td>Status</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($transactions as $transaction)
                                                                            <tr>
                                                                                <td>{{ $transaction->transaction_code }}
                                                                                </td>
                                                                                <td>{{ $transaction->name_of_transaction }}
                                                                                </td>
                                                                                <td>{{ $transaction->amount }}</td>
                                                                                <td>{{ $transaction->payment_method }}</td>
                                                                                <td>
                                                                                    <div
                                                                                        class="badge badge-{{ $transaction->status == 'succeeded' || $transaction->status == 'paid' || $transaction->status == 'success' ? 'success' : 'danger' }}">
                                                                                        {{ $transaction->status }}</div>
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                                {!! $transactions->links() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4>Account Information</h4>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#inlineForm">Deposit <i
                                                    class="feather icon-plus"></i></button>
                                        </div>
                                        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel33" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <label class="modal-title text-text-bold-600"
                                                            id="myModalLabel33">Deposit Form</label>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="/deposit" method="POST">
                                                        @csrf
                                                        <input type="hidden" value="{{ $user->id }}"
                                                            name="user_id">
                                                        <div class="modal-body">
                                                            @if ($user->prefer_payment_method == 'card')
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group">
                                                                            <label class="label">Card Holder:</label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Card Holder"
                                                                                name="card_holder"
                                                                                value="{{ $user->firstname }} {{ $user->lastname }}">
                                                                            <span class="text-danger danger">
                                                                                @error('card_holder')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group">
                                                                            <label class="label">Card number:</label>
                                                                            <input type="text" class="form-control"
                                                                                data-mask="0000000000000000"
                                                                                name="card_number">
                                                                            <span class="text-danger danger">
                                                                                @error('card_number')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="row">
                                                                            <div class="col-xl-6 col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="label">Expiry
                                                                                        Month:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        data-mask="00" placeholder="00"
                                                                                        name="expiry_month">
                                                                                    <span class="text-danger danger">
                                                                                        @error('expiry_month')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xl-6 col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="label">Expiry
                                                                                        Year:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        data-mask="00" placeholder="00"
                                                                                        name="expiry_year">
                                                                                    <span class="text-danger danger">
                                                                                        @error('expiry_year')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group">
                                                                            <label class="label">CVC:</label>
                                                                            <input type="text" class="form-control"
                                                                                data-mask="000" placeholder="000"
                                                                                name="cvc">
                                                                            <span class="text-danger danger">
                                                                                @error('cvc')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <label>Amount: </label>
                                                            <div class="form-group">
                                                                <input type="number" placeholder="Amount" name="amount"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="payment_method"
                                                                value="{{ $user->prefer_payment_method }}">
                                                            <input type="reset" class="btn btn-secondary"
                                                                data-dismiss="modal" value="close">
                                                            <input type="submit" class="btn btn-primary" name="action"
                                                                value="Deposit">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="/update_payment_method" method="POST" id="form_payment_method">
                                            @csrf
                                            <div class="row my-2">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Email:</div>
                                                        <input type="text" class="form-control" name="email"
                                                            value="{{ $user->email }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Payment Method:
                                                        </div>
                                                        <div class="row skin skin-flat my-2">
                                                            <div class="col-md-12 col-sm-12">
                                                                <ul class="list-group">
                                                                    <li
                                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <fieldset>
                                                                            <input type="radio" name="payment_method"
                                                                                value="gcash" class="payment-method-radio"
                                                                                {{ $user->prefer_payment_method == 'gcash' ? 'checked' : null }}
                                                                                id="input-radio-14">
                                                                            <label for="input-radio-14">G CASH</label>
                                                                        </fieldset>
                                                                        <img src="../../../images/logo/gcash-logo.png"
                                                                            alt="" style="width: 50px;">
                                                                    </li>
                                                                    <li
                                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <fieldset>
                                                                            <input type="radio" name="payment_method"
                                                                                value="grab_pay" id="input-radio-18" class="payment-method-radio"
                                                                                {{ $user->prefer_payment_method == 'grab_pay' ? 'checked' : null }}>
                                                                            <label for="input-radio-18">GRAB PAY</label>
                                                                        </fieldset>
                                                                        <img src="../../../images/logo/grabpay.png"
                                                                            alt="" style="width: 40px;">
                                                                    </li>
                                                                    {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <fieldset>
                                                                            <input type="radio" name="payment_method" value="paymaya" id="input-radio-15" {{ $user->prefer_payment_method == 'paymaya' ? 'checked' : null }}>
                                                                            <label for="input-radio-15">PAYMAYA</label>
                                                                        </fieldset>
                                                                        <img src="../../../images/logo/paymaya-logo.png" alt="" style="width: 50px;">
                                                                    </li> --}}
                                                                    <li
                                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <fieldset>
                                                                            <input type="radio" name="payment_method"
                                                                                value="card" id="input-radio-16" class="payment-method-radio"
                                                                                {{ $user->prefer_payment_method == 'card' ? 'checked' : null }}>
                                                                            <label for="input-radio-16">CARD</label>
                                                                        </fieldset>
                                                                        <img src="../../../images/logo/credit-card.png"
                                                                            alt="" style="width: 50px;">
                                                                    </li>

                                                                    {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <fieldset>
                                                                            <input type="radio" name="payment_method" value="online_bank" id="input-radio-17" {{ $user->prefer_payment_method == 'online_bank' ? 'checked' : null }}>
                                                                            <label for="input-radio-17">ONLINE BANK</label>
                                                                        </fieldset>
                                                                        <img src="../../../images/logo/online-bank.png" alt="" style="width: 50px;">
                                                                    </li> --}}
                                                                </ul>
                                                                <span class="text-danger danger">
                                                                    @error('payment_method')
                                                                        {{ $message }}
                                                                    @enderror
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-footer">
                                                        <button class="btn btn-secondary">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @include('UserAuthScreens.funds.create_wallet')
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(window).on("load", function() {

            //Get the context of the Chart canvas element we want to select
            var ctx = $("#funds-chart");

            // Chart Options
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration: 500,

            };
            // Chart Data
            var chartData = {
                labels: ["Income", "Spending"],
                datasets: [{
                    label: "My First dataset",
                    data: [65, 35],
                    backgroundColor: ['#04BBFF', '#FF7E00'],
                }]
            };

            var config = {
                type: 'doughnut',
                // Chart Options
                options: chartOptions,
                data: chartData,
            };
            // Create the chart
            var doughnutSimpleChart = new Chart(ctx, config);
        });

        $(".payment-method-radio").change(function(e) {
            console.log(e);
            $('#form_payment_method').submit();
        })

    </script>
@endpush

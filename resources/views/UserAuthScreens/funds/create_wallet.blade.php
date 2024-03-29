<div class="container">
    <div class="row">
        <div class="col-md-3">&nbsp;</div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold">Create Wallet</h4>
                    <p>Create Wallet for all transactions here in INSTRABAHO.</p>
                    <form action="/deposit" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $user->id }}" name="user_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold">Amount <span
                                            class="text-warning warning font-weight-light">(Minimum of 200 pesos)</span>
                                    </div>
                                    <input type="number" class="form-control" name="amount" min="200">
                                    <span class="text-danger danger">
                                        @error('amount')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-label font-weight-bold">Payment Method</div>
                                <div class="skin skin-flat">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <fieldset>
                                                <input type="radio" name="payment_method" value="gcash"
                                                    {{ $user->prefer_payment_method == 'gcash' ? 'checked' : null }}
                                                    id="input-radio-14">
                                                <label for="input-radio-14">G-CASH</label>
                                            </fieldset>
                                            <img src="../../../images/logo/gcash-logo.png" alt=""
                                                style="width: 50px;">
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <fieldset>
                                                <input type="radio" name="payment_method" value="grab_pay"
                                                    id="input-radio-18"
                                                    {{ $user->prefer_payment_method == 'grab_pay' ? 'checked' : null }}>
                                                <label for="input-radio-18">GRAB PAY</label>
                                            </fieldset>
                                            <img src="../../../images/logo/grabpay.png" alt=""
                                                style="width: 40px;">
                                        </li>
                                        {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <fieldset>
                                                <input type="radio" name="payment_method" value="paymaya" id="input-radio-15" {{ $user->prefer_payment_method == 'paymaya' ? 'checked' : null }}>
                                                <label for="input-radio-15">PAYMAYA</label>
                                            </fieldset>
                                            <img src="../../../images/logo/paymaya-logo.png" alt="" style="width: 50px;">
                                        </li> --}}
                                        {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <fieldset>
                                                <input type="radio" name="payment_method" value="card" id="input-radio-16" {{ $user->prefer_payment_method == 'card' ? 'checked' : null }}>
                                                <label for="input-radio-16">CARD</label>
                                            </fieldset>
                                            <img src="../../../images/logo/credit-card.png" alt="" style="width: 50px;">
                                        </li> --}}
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
                        <div class="form-footer my-1 float-right">
                            <input type="submit" value="Create" name="action" class="btn btn-primary">
                            <input type="submit" value="Create 0.00 Amount" name="action" class="btn btn-secondary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">&nbsp;</div>
    </div>
</div>

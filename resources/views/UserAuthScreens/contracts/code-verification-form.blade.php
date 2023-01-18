@extends('layout.user-layout')

@section('title')
    TRACK PROJECT
@endsection

@section('content')

@if (Session::get('fail'))
    @push('scripts')
        <script>
            toastr.warning('{{ Session::get("fail") }}', 'Warning');
        </script>
    @endpush
@endif

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-body">

            <div class="container d-flex justify-content-center align-items-center flex-column">
                <div class="my-2">
                    <a href="/employer/projects/ongoing" class="btn btn-secondary">Back to Ongoing Projects</a>
                </div>
                <div class="card" style="width: 350px !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <img src="../../../images/logo/main-logo.png" alt="Instrabaho Logo" style="width: 70%;" class="img-responsive">
                            <div style="width:300px;" class="my-2" id="reader"></div>
                            <form action="{{ route('contract.post_validate_code') }}" method="post" id="code-form" class="my-2">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Type the given code here.">
                                </div>
                                <button class="btn btn-primary btn-block">Send Code</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function onScanSuccess(qrCodeMessage) {
            $('#code').val(qrCodeMessage);
            // $('#code-form').submit();
        }
        function onScanError(errorMessage) {
            //
        }

        var html5QrcodeScanner = new Html5QrcodeScanner( "reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
@endpush


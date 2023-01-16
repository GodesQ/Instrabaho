@extends('layout.layout')
@section('content')

    @if(Session::get('success'))
        @push('scripts')
            <script>
                toastr.success('{{ Session::get("success") }}', 'Success');
            </script>
        @endpush
    @endif
    <style>
        .active-role {
            border: 2px solid #04bbff !important;
        }
        .active-role .icon-check {
            color: #04bbff;
            display: block !important;
        }
        .active-role .role {
            color: #04bbff !important;
        }
    </style>

    <section class="fr-sign-in-hero">
        <div class="row">
            <div class="col-md-12 col-xl-6">
                <div class="fr-sign-background add-bg"></div>
            </div>
            <div class="col-md-12 col-xl-6">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xs-12 col-sm-12 col-xl-10 col-md-12">
                        <div class="fr-sign-container" style="margin-top: -40px;">
                            <div class="fr-sign-content">
                                <div class="heading-panel">
                                    <h2>Forgot Password</h2>
                                </div>
                                @if ($errors->any())
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li class="alert alert-danger">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                @endif
                                <form id="signup-form" action="/submit-reset-form" method="POST">
                                    @csrf
                                    <input type="hidden" name="verify_token" value="{{ $token }}">
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Password</label>
                                        <input type="password" name="password" placeholder="Password" class="form-control" id="password-field" required="" data-smk-msg="Please provide password">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Confirm Password</label>
                                        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" id="password-field" required="" data-smk-msg="Please provide password">
                                    </div>
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <button type="submit" class="btn-theme btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="fr-sign-background add-bg"></div> --}}
    </section>
@endsection

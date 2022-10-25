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
    </style>

    <section class="fr-sign-in-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xs-12 col-sm-12 col-xl-6 col-md-12 align-self-center no-padding-hero">
                <div class="fr-sign-container">
                    <div class="fr-sign-content">
                        <div class="heading-panel">
                            <h2>Reset Password</h2>
                        </div>
                        @if(Session::get('fail'))
                                <div class="alert alert-danger">
                                    {{ Session::get('fail') }}
                                </div>
                        @endif
                        <form id="signup-form" action="/submit-reset-form" method="POST">
                            @csrf
                            <input type="hidden" name="verify_token" value="{{ $token }}">
                            <div class="fr-sign-form">
                                <div class="fr-sign-logo"> <img src="../../../images/icons/password.png" alt="" class="img-fluid"> </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password" class="form-control" id="password-field" required="" data-smk-msg="Please provide password">
                                    <div data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password change-top" aria-hidden="true"></div>
                                    <span class="text-danger danger">@error('password'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="fr-sign-form">
                                <div class="fr-sign-logo"> <img src="../../../images/icons/password.png" alt="" class="img-fluid"> </div>
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" id="password-field" required="" data-smk-msg="Please provide password">
                                    <div data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password change-top" aria-hidden="true"></div>
                                    <span class="text-danger danger">@error('password_confirmation'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="fr-sign-submit">
                            <div class="form-group d-grid">
                                <input type="hidden" name="email" value="{{ $email }}">
                                <button type="submit" class="btn btn-theme btn-loading" id="signup-btn"> Sign in                 
                                    <span class="bubbles"> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> </span>
                                </button>
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="fr-sign-bundle-content">
                        <p> Don't have an account? <span><a href="/register">Register here</a></span></p>
                    </div>
                </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="fr-sign-user-dashboard d-flex align-items-end">
                    <div class="sign-in owl-carousel owl-theme owl-loaded owl-drag two-item-owl">
                        <div class="owl-stage-outer">
                            <div class="owl-stage">
                            <div class="owl-item">
                                <div class="item">
                                    <div class="fr-sign-assets-2">
                                        <div class="fr-sign-main-content"> <img src="img/services-imgs/house-2.png" alt="" class="img-fluid"> </div>
                                        <div class="fr-sign-text">
                                        <h3>Post services and get hired</h3>
                                        <p>Exertio is a new world to get hired quickly. Freelancing talent at your fingertips at a reasonable cost   </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="item">
                                    <div class="fr-sign-assets-2">
                                        <div class="fr-sign-main-content"> <img src="img/services-imgs/phone-s1.png" alt="" class="img-fluid"> </div>
                                        <div class="fr-sign-text">
                                        <h3>Micro Earnings made easy</h3>
                                        <p>Admin can earn money by having a commission on each project. Freelancing talent at your fingertips at a reasonable cost   </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-nav"><button type="button" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" class="owl-next"><span aria-label="Next">›</span></button></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="fr-sign-background add-bg"></div>
    </section>
    <script>
        function selectRole(e, value) {
            const activeBtn = document.querySelector('.active-role');
            activeBtn.classList.remove('active-role');
            e.classList.add('active-role');
            document.querySelector('#role').value = value;
        }
    </script>
@endsection

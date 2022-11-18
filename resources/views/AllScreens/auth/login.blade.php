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
                            <h2>Sign to Instrabaho</h2>
                            <p>Sign in to use your dashboard it's fast and free. Showcase your brand, enhance your listings, and much more. </p>
                        </div>
                        <div class="d-flex align-items-center my-1 mb-4">
                            <div class="p-2 py-4 border mr-50 cursor-pointer d-flex align-items-center justify-content-center rounded flex-column active-role" onclick="selectRole(this, 'freelancer')">
                                <img src="https://img.icons8.com/ios-filled/55/04bbff/worker-male.png"/>
                                <div class="text-center" style="color: #000; font-weight: 800;">Freelancer</div>
                                <div class="text-center" style="color: #000; font-size: 10px;">Looking for dream projects</div>
                            </div>
                            <div class="p-4 py-4 border ml-50 cursor-pointer d-flex align-items-center justify-content-center rounded flex-column" onclick="selectRole(this, 'employer')">
                                <img src="https://img.icons8.com/ios-filled/55/04bbff/permanent-job.png"/>
                                <div class="text-center" style="color: #000; font-weight: 800;">Employer</div>
                                <div class="text-center" style="color: #000; font-size: 10px;">Looking for a perfect fit</div>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form id="signup-form" method="POST">
                            @csrf
                            <div class="fr-sign-form">
                            <div class="fr-sign-logo"> <img src="../../../images/icons/mail.png" alt="" class="img-fluid"> </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email address" class="form-control" required="" data-smk-msg="Email address is required">
                            </div>
                            </div>
                            <div class="fr-sign-form">
                                <div class="fr-sign-logo"> <img src="../../../images/icons/password.png" alt="" class="img-fluid"> </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password" class="form-control" id="password-field" required="" data-smk-msg="Please provide password">
                                    <div data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password change-top" aria-hidden="true"></div>
                                </div>
                            </div>
                            <div class="fr-sigin-requirements">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#forget_pwd"> <span> Forgot Password</span></a>
                            </div>
                            <div class="fr-sign-submit">
                            <div class="form-group d-grid">
                                <button type="submit" class="btn btn-theme btn-loading" id="signup-btn"> Sign in
                                    <span class="bubbles"> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> </span>
                                </button>
                                <input type="hidden" id="role" name="role" value="freelancer">
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
    <div class="modal fade forget_pwd show" id="forget_pwd" tabindex="-1" role="dialog" aria-labelledby="forget_pwd" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Forgot Password</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
                <div class="modal-body">
                <form id="fl-forget-form" method="POST" action="/send_forgot_form">
                    @csrf
                    <div class="fr-sign-form">
                        <div class="fr-sign-logo"> <img src="https://marketplace.exertiowp.com/wp-content/themes/exertio/images/icons/mail.png" alt="" class="img-fluid"> </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Registered email address" class="form-control" required="" data-smk-msg="Please provide valid registered email address">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-theme btn-block btn-loading" id="forget_btn">Recover now
                            <span class="bubbles"> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> </span>
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectRole(e, value) {
            const activeBtn = document.querySelector('.active-role');
            activeBtn.classList.remove('active-role');
            e.classList.add('active-role');
            document.querySelector('#role').value = value;
        }
    </script>
@endsection

@extends('layout.layout')
@section('title', 'Login')
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
                                    <h2>Sign to Instrabaho</h2>
                                    <p class="font-weight-bold"> Don't have an account? <span><a href="/register" class="text-primary">Register here</a></span></p>
                                </div>
                                <label for="" class="font-weight-bold" style="color: #2e405c">Are you?</label>
                                <div class="d-flex align-items-center my-1 mb-4">
                                    <div class="px-4 py-3 border mr-50 cursor-pointer d-flex align-items-center justify-content-around rounded active-role" onclick="selectRole(this, 'freelancer')">
                                        {{-- <img src="https://img.icons8.com/ios-filled/55/04bbff/worker-male.png"/> --}}
                                        <i class="fa fa-circle mr-50 my-50 text-primary" style="font-size: 9px;"></i>
                                        <div class="text-center role" style="color: #000; font-weight: 800;">Freelancer</div>
                                        {{-- <div class="text-center" style="color: #000; font-size: 10px;">Looking for dream projects</div> --}}
                                    </div>
                                    <div class="px-5 py-3 border ml-50 cursor-pointer d-flex align-items-center justify-content-center rounded" onclick="selectRole(this, 'employer')">
                                        {{-- <img src="https://img.icons8.com/ios-filled/55/04bbff/permanent-job.png"/> --}}
                                        <i class="far fa-circle mr-50 my-50 text-primary" style="font-size: 9px;"></i>
                                        <div class="text-center role" style="color: #000; font-weight: 800;">Client</div>
                                        {{-- <div class="text-center" style="color: #000; font-size: 10px;">Looking for a perfect fit</div> --}}
                                    </div>
                                </div>
                                @if ($errors->any())
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li class="alert alert-danger">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                @endif
                                <form id="signup-form" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Email Address or Username</label>
                                        <input type="text" name="email" placeholder="" class="form-control" data-smk-msg="Email address is required">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Password</label>
                                        <input type="password" name="password" placeholder="Password" class="form-control" id="password-field" data-smk-msg="Please provide password">
                                    </div>
                                    <div class="fr-sigin-requirements">
                                        <a href="#" data-bs-toggle="modal" class="text-primary" data-bs-target="#forget_pwd"> <span> Forgot Password</span></a>
                                    </div>
                                    <button type="submit" class="btn-theme btn-primary">Sign In</button>
                                    <input type="hidden" id="role" name="role" value="freelancer">
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
            let icon_circle = e.children[0];
            activeBtn.children[0].classList.remove('fa')
            activeBtn.children[0].classList.add('far')

            icon_circle.classList.remove('far')
            icon_circle.classList.add('fa')
        }
    </script>
@endsection

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Instrabaho is a community where you can post a project if you are an employer or you may post service if you are a freelancer. This initiative is to help" />
        <meta name="author" content="GODESQ DIGITAL MARKERTING SERVICES" />
        <meta name="generator" content="INSTRABAHO" />
        <title>@yield('title')</title>


		<!-- BEGIN: Vendor CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/vendors.min.css') }}"/>

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/icheck/custom.css') }}">

		<!-- END: Vendor CSS-->

		<!-- BEGIN: Theme CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap-extended.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/colors.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/components.css') }}">
		<!-- END: Theme CSS-->

		<!-- BEGIN: Page CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/meteocons/style.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/users.css') }}">
		<!-- END: Page CSS-->

		<!-- BEGIN: Custom CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/toggle/switchery.min.css') }}"
        />

        <!-- Bootstrap core CSS -->
        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"/>

        <!-- MENU CSS -->
        <link href="{{ URL::asset('css/sbmenu.css') }}" rel="stylesheet" />

        <!-- SELECT 2 CSS -->
        <link href="{{ URL::asset('css/select2.css') }}" rel="stylesheet" />

        <!-- PROTIP CSS -->
        <link href="{{ URL::asset('css/protip.min.css') }}" rel="stylesheet" />

        <!-- YOUTUBE POPUP CSS -->
        <link href="{{ URL::asset('css/youtube-popup.css') }}" rel="stylesheet" />

        <!-- FLEXSLIDER CSS -->
        <link href="{{ URL::asset('css/flexslider.css') }}" rel="stylesheet" />

        <!-- PRETTY CHECK BOX CSS -->
        <link href="{{ URL::asset('css/pretty-checkbox.min.css') }}" rel="stylesheet" />

        {{-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet"> --}}

        <!-- POPPINS FONT -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet"/>

        <!-- FONT-AWESOME CSS -->
        <link rel="stylesheet" href="{{ URL::asset('css/fontawesome1.css') }}" />

        <!-- owl-carousel-css -->
        <link rel="stylesheet" href="{{ URL::asset('css/owl.carousel.min.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/freelancer-search.css') }}">

        <!-- MAIN CSS -->
        <link href="{{ URL::asset('css/theme.css') }}" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />

        <link rel="icon"  href="../../../images/cropped-favicon-32x32.png" sizes="32x32" />

        <style>
            .active-link {
                color: #04bbff !important;
            }
        </style>
    </head>
    <body>
        <div class="fr-menu sb-header header-shadow viewport-lg exer-menu">
            <div class="container">
                <!-- sb header -->
                <div class="sb-header-container">
                    <!--Logo-->
                    <div
                        style="width: 170px;"
                        class="logo"
                        data-mobile-logo="../../../images/logo/main-logo.png"
                        data-sticky-logo="../../../images/logo/main-logo.png"
                    >
                        <a href="/"
                            ><img
                                style="width: 100%;"
                                src="../../../images/logo/main-logo.png"
                                alt=""
                        /></a>
                    </div>
                    <!-- Burger menu -->
                    <div class="burger-menu">
                        <div class="line-menu line-half first-line"></div>
                        <div class="line-menu"></div>
                        <div class="line-menu line-half last-line"></div>
                    </div>
                    <!--Navigation menu-->
                    <nav
                        class="sb-menu menu-caret submenu-top-border submenu-scale"
                    >
                        <ul>
                            <li class="">
                                <a href="/">Home</a>
                            </li>
                            <li class="">
                                <a href="/the-process">The Process</a>
                            </li>
                            <li class="active-link">
                                <a href="/search_freelancers" >Worker Search</a>
                            </li>
                            <li class="">
                                <a href="/search_projects">Projects Search</a>
                            </li>
							<li class="">
                                <a href="/search_services">Services Search</a>
                            </li>
                            <li class="">
                                <a href="/contact-us">Contact Us</a>
                            </li>
                            @php
                                $user_role = ['employer', 'freelancer'];
                            @endphp
                            @if(!Session::get('role') && !Session::get('id') || !in_array(Session::get('role'), $user_role))

                                <li class="fr-list">
                                    <a href="/register" class="btn-theme-warning style-1" style="padding: 0.7rem 1rem !important;">
                                        Register
                                    </a>
                                    <a href="/login" class="btn btn-theme" style="padding: 0.7rem 1rem !important;">Sign in</a>
                                </li>
                            @else
                                <li class="dropdown dropdown-user nav-item fr-list loggedin">
                                    <a class="dropdown-toggle nav-link dropdown-user-link d-flex justify-content-between align-items-center" href="#" data-toggle="dropdown">
                                        <div class="avatar avatar-online">
                                            @if(Session::get('profile_image'))
                                                <img class="brand-text" style="width: 30px; height: 30px; object-fit: cover;" src="../../../images/user/profile/{{ Session::get('profile_image') }}" alt="Avatar Image">
                                            @else
                                                <img class="brand-text" src="../../../images/user-profile.png" style="width: 30px; height: 30px; object-fit: cover;" alt="Avatar Image">
                                            @endif<i></i>
                                        </div>
                                        <div style="color: #000000 !important;" class="mx-2">
                                            {{ Session::get('username') }} <br>
                                            <div class="badge badge-primary text-uppercase">{{ Session::get('role') }}</div>
                                        </div>

                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right p-3" style="width: 300px;">
                                        <!-- <a href="/" class="container">
                                            <h6 class="h6 text-black-50">Wallet Funds</h6>
                                            <h3 class="text-primary">₱ 1000.00</h3>
                                        </a> -->
                                        <a href="/{{session()->get('role') == 'freelancer' ? 'freelancer' : 'employer'}}/dashboard" class="dropdown-item" style="color: #000000 !important;">
                                            <i class="fa fa-home"></i> Dashboard
                                        </a>
                                        <a href="{{ session()->get('role') == 'freelancer' ? route('freelancer.profile') : route('employer.profile')}}" class="dropdown-item" style="color: #000000 !important;">
                                            <i class="fa fa-user"></i> Edit Profile
                                        </a>
                                        @if(Session::get('role') == 'employer')
                                            <a class="dropdown-item" href="/change_login" style="color: #000000 !important;"><i class="feather icon-log-in"></i> Login as Freelancer</a>
                                        @else
                                            <a class="dropdown-item" href="/change_login" style="color: #000000 !important;"><i class="feather icon-log-in"></i> Login as Employer</a>
                                        @endif
                                        <a href="/logout" class="dropdown-item" style="color: #000000 !important;">
                                            <i class="feather icon-log-out"></i> Logout
                                        </a>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        @yield('content')

        <section class="fr-footer pt-2" style="background: #004E88;">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center py-5" style="border-bottom: 1px solid #fff;">
                    <h1 style="color: #fff !important;">Start Working <br> with <span style="color: #04bbff;">Instrabaho</span> Today</h1>
                    <a href="/register" class="btn btn-theme">Register Now</a>
                </div>
                <div class="row padding-bottom-60 py-5" style="border-bottom: 1px solid #fff;">
                    <div
                        class="col-xxl-4 col-xl-3 col-lg-12 col-12 col-sm-12 col-md-12"
                    >
                        <div class="fr-footer-details fr-footer-content">
                            <img
                                src="../../../images/logo/main-logo.png"
                                alt=""
                                class="img-fluid" 
                            />
                            <p style="color: #fff !important;">
                                Instrabaho is a community where you can post a project if you are an employer or you may post service if you are a freelancer.
                                This initiative is to help people who lose their job during the time of the pandemic.
                            </p>
                        </div>
                        <div class="fr-footer-icons">
                            <ul>
                                <li>
                                    <a href="#"
                                        ><i
                                            class="fab fa-facebook-f"
                                            aria-hidden="true"
                                        ></i
                                    ></a>
                                </li>
                                <li>
                                    <a href="#"
                                        ><i
                                            class="fab fa-twitter"
                                            aria-hidden="true"
                                        ></i
                                    ></a>
                                </li>
                                <li>
                                    <a href="#"
                                        ><i
                                            class="fab fa-linkedin-in"
                                            aria-hidden="true"
                                        ></i
                                    ></a>
                                </li>
                                <li>
                                    <a href="#"
                                        ><i
                                            class="fab fa-youtube"
                                            aria-hidden="true"
                                        ></i
                                    ></a>
                                </li>
                                <li>
                                    <a href="#"
                                        ><i
                                            class="fab fa-instagram"
                                            aria-hidden="true"
                                        ></i
                                    ></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-3 col-lg-4 col-xl-3 col-xs-12 col-sm-6 col-md-4"
                    >
                        <div class="fr-footer-content">
                            <h3 class="fr-style-8">Top Job Locations</h3>
                            <ul >
                                <li>
                                    <a href="#">Manila</a>
                                </li>
                                <li>
                                    <a href="#">Quezon City</a>
                                </li>
                                <li><a href="#">Rizal</a></li>
                                <li><a href="#">Cebu</a></li>
                                <li><a href="#">Davao</a></li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-3 col-lg-4 col-xl-3 col-xs-12 col-sm-6 col-md-4"
                    >
                        <div class="fr-footer-content">
                            <h3 class="fr-style-8">Top Jobs Offer</h3>
                            <ul>
                                <li><a href="#">Plumbing</a></li>
                                <li><a href="#">Technician</a></li>
                                <li>
                                    <a href="#">Welder</a>
                                </li>
                                <li>
                                    <a href="#">Cook</a>
                                </li>
                                <li><a href="#">Carpenter</a></li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-2 col-lg-4 col-xl-3 col-xs-12 col-sm-6 col-md-4"
                    >
                        <div class="fr-footer-content">
                            <h3 class="fr-style-8">Most Visited Links</h3>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li>
                                    <a href="/search_projects">Projects Search</a>
                                </li>
                                <li>
                                    <a href="/search_freelancers"
                                        >Freelancers Search</a
                                    >
                                </li>
                                <li>
                                    <a href="#"
                                        >Terms and Conditions</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fr-bottom">
                <p>
                    Copyright 2023 ©
                    <a href="https://instrabaho.com">Instrabaho</a>, All
                    Rights Reserved.
                </p>
            </div>
        </section>

        <script type="text/javascript" src="js/jquery-3.6.0.js"></script>
        <!-- BEGIN: Vendor JS-->
        <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
        <!-- BEGIN Vendor JS-->

        <!-- BEGIN: Page Vendor JS-->
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Theme JS-->
        <script src="../../../app-assets/js/core/app-menu.js"></script>
        <script src="../../../app-assets/js/core/app.js"></script>


        <!-- END: Theme JS-->

        <!-- BEGIN: Page JS-->
        <script src="{{ asset('app-assets/js/scripts/navs/navs.js')}}"></script>
        <script src="{{ asset('app-assets/js/scripts/forms/switch.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script type="text/javascript" src="{{ asset('/js/jquery-migrate-3.3.2.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/select2.full.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/youtube-popup-jquery.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/masonry.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/counter.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/flexslider.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/sbmenu.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/owl.carousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/rangeslider.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/custom-script.js') }}"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>
        @stack('scripts')
    </body>
</html>

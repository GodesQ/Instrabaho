<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta
            name="description"
            content="Instrabaho is a community where you can post a project if you are an employer or you may post service if you are a freelancer. This initiative is to help"
        />
        <meta name="author" content="" />
        <meta name="generator" content="Hugo 0.83.1" />
        <title>INSTRABAHO</title>


		<!-- BEGIN: Vendor CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/vendors.min.css') }}"/>

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/charts/morris.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/extensions/unslider.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/weather-icons/climacons.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/charts/leaflet.css') }}">
		<!-- END: Vendor CSS-->

		<!-- BEGIN: Theme CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap-extended.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/colors.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/components.css') }}">
		<!-- END: Theme CSS-->

		<!-- BEGIN: Page CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/colors/palette-gradient.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/colors/palette-climacon.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/meteocons/style.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/users.css') }}">
		<!-- END: Page CSS-->

		<!-- BEGIN: Custom CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">

        <link
            rel="stylesheet"
            type="text/css"
            href="{{ URL::asset('app-assets/vendors/css/forms/toggle/switchery.min.css') }}"
        />

        <!-- Bootstrap core CSS -->
        <link
            href="{{ URL::asset('css/bootstrap.min.css') }}"
            rel="stylesheet"
        />

        <!-- MENU CSS -->
        <link href="{{ URL::asset('css/sbmenu.css') }}" rel="stylesheet" />
        <!-- SELECT 2 CSS -->
        <link href="{{ URL::asset('css/select2.css') }}" rel="stylesheet" />
        <!-- PROTIP CSS -->
        <link href="{{ URL::asset('css/protip.min.css') }}" rel="stylesheet" />
        <!-- YOUTUBE POPUP CSS -->
        <link
            href="{{ URL::asset('css/youtube-popup.css') }}"
            rel="stylesheet"
        />
        <!-- FLEXSLIDER CSS -->
        <link href="{{ URL::asset('css/flexslider.css') }}" rel="stylesheet" />
        <!-- PRETTY CHECK BOX CSS -->
        <link
            href="{{ URL::asset('css/pretty-checkbox.min.css') }}"
            rel="stylesheet"
        />
        <!-- RANGE SLIDER CSS -->
        <link
            rel="stylesheet"
            href="{{ URL::asset('css/rangeslider.min.css') }}"
        />

        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500&display=swap" rel="stylesheet">

        <!-- POPPINS FONT -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet"/>

        <!-- FONT-AWESOME CSS -->
        <link rel="stylesheet" href="{{ URL::asset('css/fontawesome1.css') }}" />

        <!-- owl-carousel-css -->
        <link
            rel="stylesheet"
            href="{{ URL::asset('css/owl.carousel.min.css') }}"
        />
        <!-- MAIN CSS -->
        <link href="{{ URL::asset('css/theme.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
        <link
            rel="icon"
            href="https://instrabaho.com/wp-content/uploads/2021/02/cropped-favicon-32x32.png"
            sizes="32x32"
        />
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
                            <li class="">
                                <a href="/search_freelancers">Freelance Search</a>
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
                            @if(!Session::get('role') && !Session::get('id') || Session::get('role') == 'admin')
                            <li class="fr-list">
                                <a
                                    href="/register"
                                    class="btn-theme-warning style-1" style="padding: 0.7rem 1rem !important;"
                                >
                                    Register
                                </a>
                                <a href="/login" class="btn btn-theme" style="padding: 0.7rem 1rem !important;"
                                    >Sign in</a
                                >
                            </li>
                            @else
                            <li class="dropdown dropdown-user nav-item fr-list loggedin">
                                <a
                                    class="dropdown-toggle nav-link dropdown-user-link"
                                    href="#"
                                    data-toggle="dropdown"
                                >
                                    <div class="avatar avatar-online">
                                        @if(Session::get('profile_image'))
                                            <img class="brand-text" style="width: 30px; height: 30px; object-fit: cover;" src="../../../images/user/profile/{{ Session::get('profile_image') }}" alt="Avatar Image">
                                        @else
                                            <img class="brand-text" src="../../../images/user-profile.png" style="width: 30px; height: 30px; object-fit: cover;" alt="Avatar Image">
                                        @endif<i></i>
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
                                    <a href="" class="dropdown-item" style="color: #000000 !important;">
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
        <section class="fr-bg-style2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                    <div class="fr-bg-style">
                        <div class="row">
                          <div class="col-xl-8 col-lg-8">
                            <div class="fr-gt-content">
                              <h3>Handa Ka Na Ba?</h3>
                              <p>Join now in our trending community of blue-collar freelancers that lost their job in this time of the pandemic. Lets help our kapwa pinoy to survive in this time where everyone is struggling.
                                    Tara na! Join naaaaa!</p>
                            </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 align-self-center">
                            <div class="fr-gt-btn"> <a href="https://instrabaho.com/login/" class="btn btn-theme">Join Now!</a> </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </section>
        <section class="fr-browse-category">
            <div class="container">
                <div class="row">
                    <div
                        class="col-xl-12 col-lg-12 col-xs-12 col-md-12 col-xs-12"
                    >
                        <div class="heading-panel section-center">
                            <div class="heading-meta">
                                <h2>Browse Skills and Locations</h2>
                                <p>
                                    Look for the best meeting your skills and
                                    most preferred locations
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row grid">
                    <div
                        class="col-xxl-2 col-xl-4 col-6 col-sm-4 col-md-4 col-lg-4 grid-item"
                    >
                        <div class="fr-browse-content browse-style">
                            <h3>Project Skills</h3>
                            <ul>
                                <li>
                                    <a href="search-page.html">Developer</a>
                                </li>
                                <li><a href="search-page.html">Designer</a></li>
                                <li>
                                    <a href="search-page.html"
                                        >QA Speciallist</a
                                    >
                                </li>
                                <li>
                                    <a href="search-page.html">Support Agent</a>
                                </li>
                                <li><a href="search-page.html">Writter</a></li>
                                <li><a href="search-page.html">Singer</a></li>
                                <li>
                                    <a href="search-page.html" class="view-more"
                                        >View More</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-2 col-xl-4 col-6 col-sm-4 col-md-4 col-lg-4 grid-item"
                    >
                        <div class="fr-browse-content browse-style">
                            <h3>Trending skills</h3>
                            <ul>
                                <li><a href="search-page.html">Designer</a></li>
                                <li>
                                    <a href="search-page.html">Support Agent</a>
                                </li>
                                <li>
                                    <a href="search-page.html"
                                        >Android Developer</a
                                    >
                                </li>
                                <li>
                                    <a href="search-page.html">IOS Developer</a>
                                </li>
                                <li>
                                    <a href="search-page.html">Data Entry</a>
                                </li>
                                <li>
                                    <a href="search-page.html">Logo Design</a>
                                </li>
                                <li>
                                    <a href="search-page.html" class="view-more"
                                        >View More</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-2 col-xl-4 col-6 col-sm-4 col-md-4 col-lg-4 grid-item"
                    >
                        <div class="fr-browse-content browse-style">
                            <h3>Top Skills in US</h3>
                            <ul>
                                <li>
                                    <a href="search-page.html"
                                        >Content writter</a
                                    >
                                </li>
                                <li><a href="search-page.html">Musician</a></li>
                                <li>
                                    <a href="search-page.html">IOS Developer</a>
                                </li>
                                <li>
                                    <a href="search-page.html"
                                        >Android Developer</a
                                    >
                                </li>
                                <li>
                                    <a href="search-page.html">Video Editor</a>
                                </li>
                                <li>
                                    <a href="search-page.html">Data Entry</a>
                                </li>
                                <li>
                                    <a href="search-page.html" class="view-more"
                                        >View More</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-2 col-xl-4 col-6 col-sm-4 col-md-4 col-lg-4 grid-item"
                    >
                        <div class="fr-browse-content browse-style">
                            <h3>Jobs in Cities</h3>
                            <ul>
                                <li>
                                    <a href="search-page.html">California</a>
                                </li>
                                <li>
                                    <a href="search-page.html">Sacramento</a>
                                </li>
                                <li>
                                    <a href="search-page.html"
                                        >Citrus Heights</a
                                    >
                                </li>
                                <li><a href="search-page.html">Germany</a></li>
                                <li><a href="search-page.html">Pakistan</a></li>
                                <li>
                                    <a href="search-page.html">Abu Dhabi</a>
                                </li>
                                <li>
                                    <a href="search-page.html" class="view-more"
                                        >View More</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-2 col-xl-4 col-6 col-sm-4 col-md-4 col-lg-4 grid-item"
                    >
                        <div class="fr-browse-content browse-style">
                            <h3>Local Companies</h3>
                            <ul>
                                <li><a href="search-page.html">Muharraq</a></li>
                                <li>
                                    <a href="search-page.html">Arad, Bahrain</a>
                                </li>
                                <li>
                                    <a href="search-page.html">Abu Dhabi</a>
                                </li>
                                <li><a href="search-page.html">Pakistan</a></li>
                                <li><a href="search-page.html">Punjab</a></li>
                                <li>
                                    <a href="search-page.html">Australia</a>
                                </li>
                                <li>
                                    <a href="search-page.html" class="view-more"
                                        >View More</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-2 col-xl-4 col-6 col-sm-4 col-md-4 col-lg-4 grid-item"
                    >
                        <div class="fr-browse-content browse-style">
                            <h3>Workers From</h3>
                            <ul>
                                <li>
                                    <a href="search-page.html">Australia</a>
                                </li>
                                <li><a href="search-page.html">Germany</a></li>
                                <li>
                                    <a href="search-page.html">Frankfurt</a>
                                </li>
                                <li><a href="search-page.html">Pakistan</a></li>
                                <li>
                                    <a href="search-page.html">Arad, Bahrain</a>
                                </li>
                                <li><a href="search-page.html">Sharjah</a></li>
                                <li>
                                    <a href="search-page.html" class="view-more"
                                        >View More</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="fr-footer padding-top-80">
            <div class="container">
                <div class="row padding-bottom-80">
                    <div
                        class="col-xxl-4 col-xl-3 col-lg-12 col-12 col-sm-12 col-md-12"
                    >
                        <div class="fr-footer-details fr-footer-content">
                            <img
                                src="../../../images/logo/main-logo.png"
                                alt=""
                                class="img-fluid"
                            />
                            <p>
                                A modern user-focused, premium freelance
                                marketplace WordPress Theme, developed using
                                best practices from the market.
                            </p>
                        </div>
                        <div class="fr-footer-icons">
                            <ul>
                                <li>
                                    <a href="about-us.html"
                                        ><i
                                            class="fab fa-facebook-f"
                                            aria-hidden="true"
                                        ></i
                                    ></a>
                                </li>
                                <li>
                                    <a href="about-us.html"
                                        ><i
                                            class="fab fa-twitter"
                                            aria-hidden="true"
                                        ></i
                                    ></a>
                                </li>
                                <li>
                                    <a href="about-us.html"
                                        ><i
                                            class="fab fa-linkedin-in"
                                            aria-hidden="true"
                                        ></i
                                    ></a>
                                </li>
                                <li>
                                    <a href="about-us.html"
                                        ><i
                                            class="fab fa-youtube"
                                            aria-hidden="true"
                                        ></i
                                    ></a>
                                </li>
                                <li>
                                    <a href="about-us.html"
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
                            <h3 class="fr-style-8">Job Locations</h3>
                            <ul>
                                <li>
                                    <a href="search-page.html">Arad, Bahrain</a>
                                </li>
                                <li>
                                    <a href="search-page.html">Australia</a>
                                </li>
                                <li><a href="search-page.html">Bahrain</a></li>
                                <li><a href="search-page.html">Muharraq</a></li>
                                <li><a href="search-page.html">Germany</a></li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-3 col-lg-4 col-xl-3 col-xs-12 col-sm-6 col-md-4"
                    >
                        <div class="fr-footer-content">
                            <h3 class="fr-style-8">Services Locations</h3>
                            <ul>
                                <li><a href="search-page.html">Pakistan</a></li>
                                <li><a href="search-page.html">Germany</a></li>
                                <li>
                                    <a href="search-page.html">Australia</a>
                                </li>
                                <li>
                                    <a href="search-page.html">California</a>
                                </li>
                                <li><a href="search-page.html">Hamburg</a></li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xxl-2 col-lg-4 col-xl-3 col-xs-12 col-sm-6 col-md-4"
                    >
                        <div class="fr-footer-content">
                            <h3 class="fr-style-8">Most Visited Links</h3>
                            <ul>
                                <li><a href="search-page.html">Blog</a></li>
                                <li><a href="search-page.html">About Us</a></li>
                                <li>
                                    <a href="search-page.html"
                                        >Services Search</a
                                    >
                                </li>
                                <li>
                                    <a href="search-page.html"
                                        >Freelancer Search</a
                                    >
                                </li>
                                <li>
                                    <a href="search-page.html"
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
                    Copyright 2021 ©
                    <a href="https://scriptsbundle.com">Instrabaho</a>, All
                    Rights Reserved.
                </p>
            </div>
        </section>

        <script type="text/javascript" src="js/jquery-3.6.0.js"></script>
        <!-- BEGIN: Vendor JS-->
        <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
        <!-- BEGIN Vendor JS-->

        <!-- BEGIN: Page Vendor JS-->
        <script src="../../../app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>
        <script src="../../../app-assets/vendors/js/forms/toggle/switchery.min.js"></script>
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Theme JS-->
        <script src="../../../app-assets/js/core/app-menu.js"></script>
        <script src="../../../app-assets/js/core/app.js"></script>
        <!-- END: Theme JS-->

        <!-- BEGIN: Page JS-->
        <script src="../../../app-assets/js/scripts/forms/switch.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?v=beta&key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places,marker&callback=initialize"></script>
        <script type="text/javascript" src="../../../js/jquery-migrate-3.3.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="../../../js/select2.full.min.js"></script>
        <script type="text/javascript" src="../../../js/protip.min.js"></script>
        <script type="text/javascript" src="js/youtube-popup-jquery.js"></script>
        <script type="text/javascript" src="../../../js/masonry.min.js"></script>
        <script type="text/javascript" src="../../../js/imagesloaded.min.js"></script>
        <script type="text/javascript" src="../../../js/counter.js"></script>
        <script type="text/javascript" src="../../../js/flexslider.js"></script>
        <script type="text/javascript" src="../../../js/sbmenu.js"></script>
        <script type="text/javascript" src="../../../js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="../../../js/rangeslider.min.js"></script>
        <script type="text/javascript" src="../../../js/custom-script.js"></script>
        <script src="../../../app-assets/js/scripts/tinymce/js/tinymce.min.js"></script>
        @stack('scripts')
    </body>
</html>

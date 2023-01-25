<!-- - var menuBorder = true-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>INSTRABAHO</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />


    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/charts/morris.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/extensions/unslider.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('app-assets/vendors/css/weather-icons/climacons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/charts/leaflet.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('app-assets/css/plugins/forms/checkboxes-radios.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/card-statistics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/vertical-timeline.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/colors/palette-climacon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/meteocons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/users.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/app-chat.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/chat.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/custom-step.css') }}">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/app-todo.css') }}">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <link rel="icon" href="../../../images/cropped-favicon-32x32.png" sizes="32x32" />

    <style>
        .hide-profile-menu {
            display: none !important;
        }

        button.dt-button {
            background: #000 !important;
            border-radius: 5px !important;
            color: white !important;
        }

        .form-control {
            border: 1px solid gray !important;
            color: #000 !important;
            font-weight: 500;
        }

        .form-control:focus {
            border: 1px solid #04bbff !important;
        }

        .form-control:disabled {
            background: #bfbfbf !important;
        }
    </style>

</head>

<body>

    <body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu"
        data-col="2-columns">

        <!-- BEGIN: Header-->
        <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="feather icon-menu font-large-1"></i></a></li>
                        <li class="nav-item d-lg-flex justify-content-center align-items-center w-100">
                            <a class="navbar-brand" href="/">
                                <img class="brand-text" alt="stack admin logo"
                                    src="../../../images/logo/main-logo.png" style="width: 140px;">
                            </a>
                        </li>
                        <li class="nav-item d-md-none"><a class="nav-link open-navbar-container"
                                data-toggle="collapse" data-target="#navbar-mobile"><i
                                    class="fa fa-ellipsis-v"></i></a></li>
                    </ul>
                </div>
                <div class="navbar-container content">
                    <div class="collapse navbar-collapse" id="navbar-mobile">
                        <ul class="nav navbar-nav mr-auto float-left">
                            <li class="nav-item d-none d-md-block"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                        class="feather icon-menu"></i></a></li>
                            <li class="dropdown nav-item mega-dropdown d-none d-lg-block"><a
                                    class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Mega</a>
                                <ul class="mega-dropdown-menu dropdown-menu row p-1">
                                    <li class="col-md-4 bg-mega p-2">
                                        <h3 class="text-white mb-1 font-weight-bold">Mega Menu Sidebar</h3>
                                        <p class="text-white line-height-2">Candy canes bonbon toffee. Cheesecake
                                            dragée gummi bears chupa chups powder bonbon. Apple pie cookie sweet.</p>
                                        <button class="btn btn-outline-white">Learn More</button>
                                    </li>
                                    <li class="col-md-5 px-2">
                                        <h6 class="font-weight-bold font-medium-2 ml-1">Apps</h6>
                                        <ul class="row mt-2">
                                            <li class="col-6 col-xl-4"><a class="text-center mb-2 mb-xl-3"
                                                    href="app-email.html" target="_blank"><i
                                                        class="feather icon-mail font-large-1 mr-0"></i>
                                                    <p class="font-medium-2 mt-25 mb-0">Email</p>
                                                </a></li>
                                            <li class="col-6 col-xl-4"><a class="text-center mb-2 mb-xl-3"
                                                    href="app-chat.html" target="_blank"><i
                                                        class="feather icon-message-square font-large-1 mr-0"></i>
                                                    <p class="font-medium-2 mt-25 mb-0">Chat</p>
                                                </a></li>
                                            <li class="col-6 col-xl-4"><a
                                                    class="text-center mb-2 mb-xl-3 mt-75 mt-xl-0"
                                                    href="app-todo.html" target="_blank"><i
                                                        class="feather icon-check-square font-large-1 mr-0"></i>
                                                    <p class="font-medium-2 mt-25 mb-0">Todo</p>
                                                </a></li>
                                            <li class="col-6 col-xl-4"><a class="text-center mb-2 mt-75 mt-xl-0"
                                                    href="app-kanban.html" target="_blank"><i
                                                        class="feather icon-file-plus font-large-1 mr-0"></i>
                                                    <p class="font-medium-2 mt-25 mb-50">Kanban</p>
                                                </a></li>
                                            <li class="col-6 col-xl-4"><a class="text-center mb-2 mt-75 mt-xl-0"
                                                    href="app-contacts.html" target="_blank"><i
                                                        class="feather icon-users font-large-1 mr-0"></i>
                                                    <p class="font-medium-2 mt-25 mb-50">Contacts</p>
                                                </a></li>
                                            <li class="col-6 col-xl-4"><a class="text-center mb-2 mt-75 mt-xl-0"
                                                    href="invoice-template.html" target="_blank"><i
                                                        class="feather icon-printer font-large-1 mr-0"></i>
                                                    <p class="font-medium-2 mt-25 mb-50">Invoice</p>
                                                </a></li>
                                        </ul>
                                    </li>
                                    <li class="col-md-3">
                                        <h6 class="font-weight-bold font-medium-2">Components</h6>
                                        <ul class="row mt-1 mt-xl-2">
                                            <li class="col-12 col-xl-6 pl-0">
                                                <ul class="mega-component-list">
                                                    <li class="mega-component-item"><a class="mb-1 mb-xl-2"
                                                            href="component-alerts.html" target="_blank">Alert</a>
                                                    </li>
                                                    <li class="mega-component-item"><a class="mb-1 mb-xl-2"
                                                            href="component-callout.html" target="_blank">Callout</a>
                                                    </li>
                                                    <li class="mega-component-item"><a class="mb-1 mb-xl-2"
                                                            href="component-buttons-basic.html"
                                                            target="_blank">Buttons</a></li>
                                                    <li class="mega-component-item"><a class="mb-1 mb-xl-2"
                                                            href="component-carousel.html"
                                                            target="_blank">Carousel</a></li>
                                                </ul>
                                            </li>
                                            <li class="col-12 col-xl-6 pl-0">
                                                <ul class="mega-component-list">
                                                    <li class="mega-component-item"><a class="mb-1 mb-xl-2"
                                                            href="component-dropdowns.html" target="_blank">Drop
                                                            Down</a></li>
                                                    <li class="mega-component-item"><a class="mb-1 mb-xl-2"
                                                            href="component-list-group.html" target="_blank">List
                                                            Group</a></li>
                                                    <li class="mega-component-item"><a class="mb-1 mb-xl-2"
                                                            href="component-modals.html" target="_blank">Modals</a>
                                                    </li>
                                                    <li class="mega-component-item"><a class="mb-1 mb-xl-2"
                                                            href="component-pagination.html"
                                                            target="_blank">Pagination</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand"
                                    href="#"><i class="ficon feather icon-maximize"></i></a></li>
                            <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i
                                        class="ficon feather icon-search"></i></a>
                                <div class="search-input">
                                    <input class="input" type="text" placeholder="Explore Stack..."
                                        tabindex="0" data-search="template-search">
                                    <div class="search-input-close"><i class="feather icon-x"></i></div>
                                    <ul class="search-list"></ul>
                                </div>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                    href="#" data-toggle="dropdown"><i
                                        class="ficon feather icon-bell"></i><span
                                        class="badge badge-pill badge-danger badge-up">5</span></a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right"></ul>
                            </li>
                            <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                    href="#" data-toggle="dropdown"><i
                                        class="ficon feather icon-mail"></i><span
                                        class="badge badge-pill badge-warning badge-up">3</span></a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right"></ul>
                            </li>
                            <li class="dropdown dropdown-user nav-item"><a
                                    class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                    data-toggle="dropdown">
                                    <div class="avatar avatar-online"><img src="../../../images/user-profile.png"
                                            alt="avatar"><i></i></div><span
                                        class="user-name">{{ session()->get('username') }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="user-profile.html"><i
                                            class="feather icon-user"></i> Edit Profile</a>
                                    <a class="dropdown-item" href="app-email.html"><i class="feather icon-mail"></i>
                                        My Inbox</a>
                                    <a class="dropdown-item" href="app-chat.html"><i
                                            class="feather icon-message-square"></i> Chats</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item"
                                        href="/admin/logout"><i class="feather icon-power"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- END: Header-->

        <!-- BEGIN: Main Menu-->
        <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
            <div class="main-menu-content">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class=" navigation-header"><span>General</span><i class=" feather icon-minus"
                            data-toggle="tooltip" data-placement="right" data-original-title="General"></i>
                    </li>
                    <li class="{{ Request::path() == 'admin' ? 'active' : '' }} nav-item">
                        <a href="/admin"><i class="feather icon-home"></i>
                            <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                        </a>
                    </li>
                    <li class=" nav-item"><a href="#"><i class="feather icon-box"></i><span class="menu-title"
                                data-i18n="Packages">Packages</span></a>
                        <ul class="menu-content">
                            @can('manage_freelance_packages')
                                <li class="{{ Request::path() == 'admin/freelancer_packages' ? 'active' : '' }}"><a
                                        class="menu-item" href="/admin/freelancer_packages"
                                        data-i18n="Freelance Packages">Freelance Packages</a>
                                </li>
                            @endcan
                            @can('manage_employer_packages')
                                <li class="{{ Request::path() == 'admin/employer_packages' ? 'active' : '' }}"><a
                                        class="menu-item" href="/admin/employer_packages"
                                        data-i18n="Employer Packages">Employer Packages</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @can('manage_services')
                        <li class="{{ Request::path() == 'admin/services' ? 'active' : '' }} nav-item">
                            <a href="/admin/services"><i class="feather icon-arrow-up-circle"></i>
                                <span class="menu-title" data-i18n="Services">Services</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_projects')
                        <li class="{{ Request::path() == 'admin/projects' ? 'active' : '' }} nav-item">
                            <a href="/admin/projects"><i class="feather icon-arrow-up-circle"></i>
                                <span class="menu-title" data-i18n="Projects">Projects</span>
                            </a>
                        </li>
                    @endcan
                    <li class="{{ Request::path() == 'admin/addons' ? 'active' : '' }} nav-item">
                        <a href="/admin/addons"><i class="feather icon-arrow-up-circle"></i>
                            <span class="menu-title" data-i18n="Addons">Addons</span>
                        </a>
                    </li>
                    <li class=" navigation-header"><span>Users</span><i class=" feather icon-minus"
                            data-toggle="tooltip" data-placement="right" data-original-title="Apps"></i>
                    </li>
                    @can('manage_freelancers')
                        <li class="{{ Request::path() == 'admin/freelancers' ? 'active' : '' }} nav-item">
                            <a href="/admin/freelancers"><i class="feather icon-user"></i>
                                <span class="menu-title" data-i18n="Freelancers">Freelancers</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_employers')
                        <li class="{{ Request::path() == 'admin/employers' ? 'active' : '' }} nav-item">
                            <a href="/admin/employers"><i class="feather icon-user"></i>
                                <span class="menu-title" data-i18n="Employers">Employers</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_admins')
                        <li class="{{ Request::path() == 'admin/admins' ? 'active' : '' }} nav-item">
                            <a href="/admin/admins"><i class="feather icon-user"></i>
                                <span class="menu-title" data-i18n="Admins">Admins</span>
                            </a>
                        </li>
                    @endcan
                    <li class=" navigation-header"><span>Misc</span><i class=" feather icon-minus"
                            data-toggle="tooltip" data-placement="right" data-original-title="Misc"></i>
                    </li>
                    @can('manage_skills')
                        <li class="{{ Request::path() == 'admin/skills' ? 'active' : '' }} nav-item">
                            <a href="/admin/skills"><i class="feather icon-activity"></i>
                                <span class="menu-title" data-i18n="Skills">Skills</span>
                            </a>
                        </li>
                    @endcan
                    <li class="{{ Request::path() == 'admin/service_categories' ? 'active' : '' }} nav-item">
                        <a href="/admin/service_categories"><i class="feather icon-activity"></i>
                            <span class="menu-title" data-i18n="Service Categories">Service Categories</span>
                        </a>
                    </li>
                    <li><a class="menu-item" href="#" data-i18n="Freelancer"><i
                                class="feather icon-bookmark"></i> Saved Jobs</a>
                        <ul class="menu-content">
                            <li>
                                <a class="menu-item" href="" data-i18n="Saved Services">Saved Services</a>
                            </li>
                            <li class="{{ Request::path() == 'admin/saved_projects' ? 'active' : '' }}">
                                <a class="menu-item" href="/admin/saved_projects" data-i18n="Saved Projects">Saved
                                    Projects</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="menu-item" href="#" data-i18n="Freelancer"><i
                                class="feather icon-heart"></i> Followed Users</a>
                        <ul class="menu-content">
                            <li class="{{ Request::path() == 'admin/freelancers_followers' ? 'active' : '' }}">
                                <a class="menu-item" href="/admin/freelancers_followers"
                                    data-i18n="Followed Freelancers">Followed Freelancers</a>
                            </li>
                            <li>
                                <a class="menu-item" href="" data-i18n="Followed Employers">Followed
                                    Employers</a>
                            </li>
                        </ul>
                    </li>
                    <li class=" navigation-header"><span>REPORTS</span><i class=" feather icon-minus"
                            data-toggle="tooltip" data-placement="right" data-original-title="REPORTS"></i>
                    </li>
                    <li class=" nav-item"><a href="#"><i class="icon-graph"></i><span class="menu-title"
                                data-i18n="Sales Report">Sales Report</span></a>
                        <ul class="menu-content">
                            <li class="">
                                <a class="menu-item" href="" data-i18n="Daily Reports">Daily Reports</a>
                            </li>
                            <li>
                                <a class="menu-item" href="" data-i18n="Monthly Reports">Monthly Reports</a>
                            </li>
                            <li>
                                <a class="menu-item" href="" data-i18n="Yearly Reports">Yearly Reports</a>
                            </li>
                        </ul>
                    </li>
                    <li class=" nav-item"><a href="#"><i class="icon-graph"></i><span class="menu-title"
                                data-i18n="Jobs Report">Jobs Report</span></a>
                        <ul class="menu-content">
                            <li class="">
                                <a class="menu-item" href="" data-i18n="Services Report">Services Report</a>
                            </li>
                            <li>
                                <a class="menu-item" href="" data-i18n="Projects Report">Projects Report</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::path() == '/admin/services' ? 'active' : '' }} nav-item">
                        <a href="/admin"><i class="feather icon-grid"></i>
                            <span class="menu-title" data-i18n="Active Employer Reports">Active Employer
                                Reports</span>
                        </a>
                    </li>
                    <li class="{{ Request::path() == '/admin/services' ? 'active' : '' }} nav-item">
                        <a href="/admin"><i class="feather icon-grid"></i>
                            <span class="menu-title" data-i18n="Active Freelancer Reports">Active Freelancer
                                Reports</span>
                        </a>
                    </li>
                    <li class=" navigation-header"><span>CONTROLS</span><i class=" feather icon-minus"
                            data-toggle="tooltip" data-placement="right" data-original-title="CONTROLS"></i>
                    </li>
                    <li class="{{ Request::path() == '/admin/services' ? 'active' : '' }} nav-item">
                        <a href="/admin"><i class="fa fa-calendar"></i>
                            <span class="menu-title" data-i18n="Run Scheduled Tasks">Run Scheduled Tasks</span>
                        </a>
                    </li>
                    <li class="{{ Request::path() == '/admin/services' ? 'active' : '' }} nav-item">
                        <a href="/admin"><i class="fa fa-shield"></i>
                            <span class="menu-title" data-i18n="Blocked Users">Blocked Users</span>
                        </a>
                    </li>
                    <li class="{{ Request::path() == '/admin/services' ? 'active' : '' }} nav-item">
                        <a href="/admin"><i class="fa fa-check-circle"></i>
                            <span class="menu-title" data-i18n="Verify Users">Verify Users</span>
                        </a>
                    </li>
                    <li class=" navigation-header"><span>OTHERS</span><i class=" feather icon-minus"
                            data-toggle="tooltip" data-placement="right" data-original-title="OTHERS"></i>
                    </li>
                    @can('manage_user_types')
                        <li class="{{ Request::path() == 'admin/user_types' ? 'active' : '' }} nav-item">
                            <a href="/admin/user_types"><i class="fa fa-user-circle"></i>
                                <span class="menu-title" data-i18n="User Types">User Types</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_user_permissions')
                        <li class="{{ Request::path() == 'admin/user_permissions' ? 'active' : '' }} nav-item">
                            <a href="/admin/user_permissions"><i class="fa fa-lock"></i>
                                <span class="menu-title" data-i18n="User Permission">User Permission</span>
                            </a>
                        </li>
                    @endcan
                    <li class="{{ Request::path() == '/admin/services' ? 'active' : '' }} nav-item">
                        <a href="/admin"><i class="feather icon-settings"></i>
                            <span class="menu-title" data-i18n="Settings">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END: Main Menu-->
        <div class="app-content content my-2">
            <div class="content-overlay"></div>
            @yield('content')
        </div>


        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <!-- BEGIN: Footer-->
        <footer class="footer footer-static footer-light navbar-border">
            <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span
                    class="float-md-left d-block d-md-inline-block">Copyright &copy; 2020 <a
                        class="text-bold-800 grey darken-2" href="https://1.envato.market/pixinvent_portfolio"
                        target="_blank">INSTRABAHO </a></span><span
                    class="float-md-right d-none d-lg-block">Hand-crafted & Made with <i
                        class="feather icon-heart pink"></i></span></p>
        </footer>
        <!-- END: Footer-->

        <!-- BEGIN: Vendor JS-->
        <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
        <!-- BEGIN Vendor JS-->


        <!-- BEGIN: Page Vendor JS-->
        <script src="../../../app-assets/vendors/js/charts/apexcharts/apexcharts.min.js"></script>

        <script src="../../../app-assets/vendors/js/charts/chart.min.js"></script>
        <script src="../../../app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
        <script src="../../../app-assets/vendors/js/charts/leaflet/leaflet.js"></script>
        <script src="../../../app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
        <script src="../../../app-assets/vendors/js/extensions/jquery.knob.min.js"></script>
        <script src="../../../app-assets/vendors/js/charts/raphael-min.js"></script>
        <script src="../../../app-assets/vendors/js/charts/morris.min.js"></script>
        <script src="../../../app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
        <script src="../../../app-assets/vendors/js/extensions/unslider-min.js"></script>
        <script src="../../../app-assets/vendors/js/charts/apexcharts/apexcharts.min.js"></script>
        <script src="../../../app-assets/js/scripts/forms/custom-file-input.js"></script>
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Theme JS-->
        <script src="../../../app-assets/js/core/app-menu.js"></script>
        <script src="../../../app-assets/js/core/app.js"></script>

        <script src="../../../app-assets/js/scripts/charts/apexcharts/charts-apexcharts.js"></script>
        <!-- END: Theme JS-->

        <!-- BEGIN: Page JS-->
        <script src="../../../app-assets/js/scripts/pages/account-setting.js"></script>
        <script src="../../../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
        <script src="../../../app-assets/js/scripts/forms/select/form-select2.js"></script>
        <script src="../../../app-assets/js/scripts/cards/card-statistics.js"></script>
        <script src="../../../app-assets/js/scripts/cards/card-statistics.js"></script>
        <script src="../../../app-assets/js/scripts/pages/dashboard-fitness.js"></script>
        <script src="../../../app-assets/js/scripts/forms/form-repeater.js"></script>
        <script src="../../../app-assets/js/scripts/tinymce/js/tinymce.min.js"></script>
        <script src="../../../app-assets/js/scripts/pages/app-chat.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src='https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js'></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="../../../app-assets/js/scripts/forms/checkbox-radio.js"></script>
        <!-- END: Page JS-->

        @stack('scripts')
    </body>

</html>

<!-- - var menuBorder = true-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Instrabaho is a community where you can post a project if you are an employer or you may post service if you are a skilled worker. This initiative is to help people who lose their job during the time of the pandemic.">
    <meta name="keywords" content="instrabaho, blue collars, skilled workers, Online Platform for skilled workers, Online Job Portal">
    <meta name="author" content="GODESQ DIGITAL MARKETING SERVICES">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('images/cropped-favicon-32x32.png') }}" sizes="32x32" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet"/>


    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/charts/morris.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/charts/leaflet.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/extensions/unslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">

    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/plugins/forms/checkboxes-radios.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/colors/palette-callout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/plugins/file-uploaders/dropzone.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css-rtl/plugins/forms/wizard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/card-statistics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/vertical-timeline.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/meteocons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/users.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/app-chat.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/chat.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/proposals.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/custom-step.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/freelancer-search.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/pages/app-todo.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/plugins/forms/switch.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/plugins/pickers/daterange/daterange.css') }}">


    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <link rel="icon" href="{{ asset('images/cropped-favicon-32x32.png') }}" sizes="32x32" />

    <style>
        .hide-profile-menu {
            display: none !important;
        }
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 2-columns" data-open="click" data-menu="horizontal-menu" data-col="2-columns">
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-light navbar-border navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu font-large-1"></i></a></li>
                    <li class="nav-item d-lg-flex justify-content-center align-items-center w-100">
                        <a class="navbar-brand" href="/">
                            <img class="brand-text" alt="stack admin logo" src="{{ asset('images/logo/main-logo.png') }}" style="width: 140px;">
                        </a>
                    </li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container container center-layout">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu"></i></a></li>
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon feather icon-maximize"></i></a></li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon feather icon-search"></i></a>
                            <div class="search-input">
                                <input class="input" type="text" placeholder="Explore Stack..." tabindex="0" data-search="template-search">
                                <div class="search-input-close"><i class="feather icon-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i>
                            {{-- <span class="badge badge-pill badge-danger badge-up">0</span> --}}
                        </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0 text-center"><span class="grey darken-2">Notifications</span></h6>
                                </li>
                                <li class="scrollable-container media-list"></li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    @if(Session::get('profile_image'))
                                        <img class="brand-text" style="width: 30px; height: 30px; object-fit: cover;" src="{{ asset('images/user/profile') . '/' . Session::get('profile_image')  }}" alt="Avatar Image">
                                    @else
                                        <img class="brand-text" src="{{ asset('images/user-profile.png') }}" style="width: 30px; height: 30px; object-fit: cover;" alt="Avatar Image">
                                    @endif<i></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if(Session::get('role') == 'employer')
                                    <a class="dropdown-item" href="/employer/profile"><i class="feather icon-user"></i> Edit Profile</a>
                                @else
                                    <a class="dropdown-item" href="/freelancer/profile"><i class="feather icon-user"></i> Edit Profile</a>
                                @endif
                                <a class="dropdown-item" href="app-chat.html"><i class="feather icon-message-square"></i> Chats</a>
                                @if(Session::get('role') == 'employer')
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/change_login"><i class="feather icon-power"></i> Login as Freelancer</a>
                                @else
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/change_login"><i class="feather icon-log-in"></i> Login as Employer</a>
                                @endif
                                <a class="dropdown-item" href="/"><i class="feather icon-home"></i>Go to Home</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"><i class="feather icon-power"></i> Logout</a>
                            </div>
                        </li>
                        <li class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-sm btn-primary text-uppercase">{{ Session::get('role') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-static navbar-light navbar-without-dd-arrow navbar-shadow menu-border" role="navigation" data-menu="menu-wrapper">
        <!-- Horizontal menu content-->
        @if(Session::get('role') == 'employer')
            @include('layout.horizontal-employer-menu')
        @else
            @include('layout.horizontal-freelancer-menu')
        @endif
        <!-- /horizontal menu content-->
    </div>
    {{-- <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-border">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu font-large-1"></i></a></li>
                    <li class="nav-item d-lg-flex justify-content-center align-items-center w-100">
                        <a class="navbar-brand" href="/">
                            <img class="brand-text" alt="stack admin logo" src="../../../images/logo/main-logo.png" style="width: 140px;">
                        </a>
                    </li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu"></i></a></li>
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon feather icon-maximize"></i></a></li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon feather icon-search"></i></a>
                            <div class="search-input">
                                <input class="input" type="text" placeholder="Explore Stack..." tabindex="0" data-search="template-search">
                                <div class="search-input-close"><i class="feather icon-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    @if(Session::get('profile_image'))
                                        <img class="brand-text" style="width: 30px; height: 30px; object-fit: cover;" src="../../../images/user/profile/{{ Session::get('profile_image') }}" alt="Avatar Image">
                                    @else
                                        <img class="brand-text" src="../../../images/user-profile.png" style="width: 30px; height: 30px; object-fit: cover;" alt="Avatar Image">
                                    @endif<i></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if(Session::get('role') == 'employer')
                                    <a class="dropdown-item" href="/employer/profile"><i class="feather icon-user"></i> Edit Profile</a>
                                @else
                                    <a class="dropdown-item" href="/freelancer/profile"><i class="feather icon-user"></i> Edit Profile</a>
                                @endif
                                <a class="dropdown-item" href="app-chat.html"><i class="feather icon-message-square"></i> Chats</a>
                                @if(Session::get('role') == 'employer')
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/change_login"><i class="feather icon-power"></i> Login as Freelancer</a>
                                @else
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/change_login"><i class="feather icon-log-in"></i> Login as Employer</a>
                                @endif
                                <a class="dropdown-item" href="/"><i class="feather icon-home"></i>Go to Home</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"><i class="feather icon-power"></i> Logout</a>
                            </div>
                        </li>
                        <li class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-sm btn-primary text-uppercase">{{ Session::get('role') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
        @if(Session::get('role') == 'employer')
            @include('layout.employer-menu')
        @else
            @include('layout.freelancer-menu')
        @endif
    <!-- END: Main Menu--> --}}

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>



    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-border">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2022 <a class="text-bold-800 grey darken-2" href="https://godesq.com/" target="_blank">GodesQ Digital Marketing Agency </a></span></p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->


    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/extensions/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/chart.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/raphael-min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/morris.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/unslider-min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/custom-file-input.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/toggle/switchery.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>

    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('js/sidebar-project.js')}}"></script>
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/wizard-steps.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/account-setting.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/cards/card-statistics.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/cards/card-statistics.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/dashboard-fitness.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/app-chat.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/switch.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/extensions/dropzone.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/checkbox-radio.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('app-assets/js/scripts/pickers/dateTime/bootstrap-datetime.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    @stack('scripts')

    <script>
        window.addEventListener('load', function() {
            fetchNotifications();
        })

        function fetchNotifications() {
            let notifications = '';
            $.ajax({
                url: `{{ route('get.notifications') }}`,
                method: 'GET',
                success: function (response) {
                    if(response.length > 0) {
                        response.forEach(notification => {
                        notifications += `<a href="javascript:void(0)">
                                        <div class="media" data-id=${notification.id}>
                                            <div class="media-left align-self-center"><i class="feather icon-bell icon-bg-circle bg-primary bg-darken-1"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">${notification.entity.type}</h6>
                                                <p class="notification-text font-small-3 text-muted">${notification.notification_message}</p><small>
                                            </div>
                                        </div>
                                    </a>`;
                        });
                    } else {
                        notifications = '<div class="text-center p-1" style="font-size: 13px;">No Notification Found</div>'
                    }

                    $('.media-list').html(notifications);
                    $('.badge-up').html(response.length);
                },
            });
        }

        $('.dropdown-notification').on('click', function() {
            // set initial notification ids
            let notification_ids = [];
            let notification_elements = document.querySelectorAll('.media');

            if(notification_elements.length > 0) {
                notification_elements.forEach(notification => {
                    // get the id of the notification
                    let notification_id = notification.getAttribute('data-id');

                    // then push it to notification ids array
                    notification_ids.push(notification_id);
                });

                $.ajax({
                    url: `{{ route('put.mark_as_read') }}`,
                    method: "PUT",
                    data: {
                        _token : '{{ csrf_token() }}',
                        notification_ids,
                    }
                });
            }
        })

        setInterval(fetchNotifications(), 10000);
    </script>
</body>
<!-- END: Body-->

</html>

<div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
    <!-- include ../../../includes/mixins-->
    <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="dropdown px-2 nav-item {{  Request::path() == 'freelancer/dashboard' ? 'active' : ''  }}">
            <a class=" nav-link" href="/freelancer/dashboard" ><i class="feather icon-home"></i>
                <span data-i18n="Dashboard">Dashboard</span>
            </a>
        </li>
        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="feather icon-user"></i><span data-i18n="Profile">Profile</span></a>
            <ul class="dropdown-menu">
                {{-- <li data-menu="" class=""><a class="dropdown-item" href="/freelancer/view/{{ optional(\App\Model\User::User }}" target="_blank" data-i18n="View Profile" data-toggle="dropdown">View Profile</a>
                </li> --}}
                <li data-menu="" class="{{ Request::path() == 'employer/profile' ? 'active' : ''  }}"><a class="dropdown-item" href="/freelancer/profile" data-i18n="Edit Profile" data-toggle="dropdown">Edit Profile</a>
                </li>
            </ul>
        </li>
        <li class="dropdown px-2 nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="feather icon-layout"></i><span data-i18n="Projects">Projects</span></a>
            <ul class="dropdown-menu">
                <li class="{{ Request::path() == 'freelancer/proposals' ? 'active' : '' }}">
                    <a class="dropdown-item" href="/freelancer/proposals" data-toggle="dropdown" data-i18n="Proposals">Proposals</a>
                </li>
                <li class="{{ Request::path() == 'freelancer/projects/ongoing' ? 'active' : '' }}">
                    <a class="dropdown-item" href="/freelancer/projects/ongoing" data-toggle="dropdown" data-i18n="Ongoing Projects">Ongoing Projects</a>
                </li>
                <li class="{{ Request::path() == 'freelancer/projects/completed' ? 'active' : '' }}">
                    <a class="dropdown-item" href="/freelancer/projects/completed" data-toggle="dropdown" data-i18n="Completed Projects">Completed Projects</a>
                </li>
            </ul>
        </li>
        {{-- <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="feather icon-layout"></i><span data-i18n="Addons">Addons</span></a>
            <ul class="dropdown-menu">
                <li data-menu="" class="{{  Request::path() == 'freelancer/create_addon' ? 'active' : ''  }}"><a class="dropdown-item" href="/freelancer/create_addon" data-i18n="Create Addon" data-toggle="dropdown">Create Addon</a>
                </li>
                <li data-menu="" class="{{  Request::path() == 'freelancer/addons' ? 'active' : ''  }}"><a class="dropdown-item" href="/freelancer/addons" data-i18n="My Addons" data-toggle="dropdown">My Addons</a>
                </li>
            </ul>
        </li> --}}
        <li class="dropdown px-2 nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="feather icon-layout"></i><span data-i18n="Services">Services</span></a>
            <ul class="dropdown-menu">
                <li data-menu=""><a class="dropdown-item" href="/freelancer/create_service" data-i18n="Create Service" data-toggle="dropdown">Create Service</a>
                </li>
                <li data-menu=""><a class="dropdown-item" href="/freelancer/services" data-i18n="My Services" data-toggle="dropdown">My Services</a>
                </li>
            </ul>
        </li>
        <li class="dropdown px-2 nav-item {{  Request::path() == 'user_fund' ? 'active' : ''  }}">
            <a class=" nav-link" href="/user_fund" ><i class="fa fa-money"></i>
                <span data-i18n="Funds">Funds</span>
            </a>
        </li>
    </ul>
</div>

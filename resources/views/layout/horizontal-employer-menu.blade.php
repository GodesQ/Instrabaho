<div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
    <!-- include ../../../includes/mixins-->
    <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="dropdown px-2 nav-item {{  Request::path() == 'employer/dashboard' ? 'active' : ''  }}">
            <a class=" nav-link" href="/employer/dashboard" ><i class="feather icon-home"></i>
                <span data-i18n="Dashboard">Dashboard</span>
            </a>
        </li>
        <li class="dropdown px-2 nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="feather icon-user"></i><span data-i18n="Profile">Profile</span></a>
            <ul class="dropdown-menu">
                <li data-menu=""><a class="dropdown-item" href="/employer/view/{{ session()->get('id') }}" data-i18n="View Profile" data-toggle="dropdown">View Profile</a>
                </li>
                <li data-menu="" class="{{ Request::path() == 'employer/profile' ? 'active' : ''  }}"><a class="dropdown-item" href="/employer/profile" data-i18n="Edit Profile" data-toggle="dropdown">Edit Profile</a>
                </li>
            </ul>
        </li>
        <li class="dropdown px-2 nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="feather icon-layout"></i><span data-i18n="Projects">Projects</span></a>
            <ul class="dropdown-menu">
                <li data-menu=""><a class="dropdown-item" href="/employer/create_project" data-i18n="Create Project" data-toggle="dropdown">Create Project</a>
                </li>
                <li data-menu=""><a class="dropdown-item" href="/employer/projects" data-i18n="My Projects" data-toggle="dropdown">My Projects</a>
                </li>
                <li data-menu=""><a class="dropdown-item" href="/employer/projects/ongoing" data-i18n="Ongoing Projects" data-toggle="dropdown">Ongoing Projects</a>
                </li>
                <li data-menu=""><a class="dropdown-item" href="/employer/projects/completed" data-i18n="Completed Projects" data-toggle="dropdown">Completed Projects</a>
                </li>
            </ul>
        </li>
        {{-- <li class="dropdown px-2 nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="feather icon-layout"></i><span data-i18n="Services">Services</span></a>
            <ul class="dropdown-menu">
                <li data-menu=""><a class="dropdown-item" href="/employer/create_project" data-i18n="My Offers / Proposals" data-toggle="dropdown">My Offers / Proposals</a>
                </li>
                <li data-menu=""><a class="dropdown-item" href="#" data-i18n=".......
                     Services" data-toggle="dropdown">Ongoing Services</a>
                </li>
                <li data-menu=""><a class="dropdown-item" href="#" data-i18n="Completed Services" data-toggle="dropdown">Completed Services</a>
                </li>
            </ul>
        </li> --}}
        <li class="dropdown px-2 nav-item {{  Request::path() == 'user_fund' ? 'active' : ''  }}">
            <a class=" nav-link" href="/user_fund" ><i class="fa fa-money"></i>
                <span data-i18n="Funds">Funds</span>
            </a>
        </li>
    </ul>
</div>

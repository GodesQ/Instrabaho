<div class="main-menu menu-fixed menu-light menu-accordion" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="profile-menu my-2 card p-1 m-2 rounded">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="avatar avatar-xl profile-menu-avatar" style="width: 30% !important;">
                        @if(Session::get('profile_image'))
                            <img class="brand-text" style="width: 50px; height: 50px; object-fit: cover;" src="../../../images/user/profile/{{ Session::get('profile_image') }}" alt="Avatar Image">
                        @else
                            <img class="brand-text" src="../../../images/user-profile.png" alt="Avatar Image">
                        @endif
                    </div>
                    <div style="width: 70% !important;">
                        <h6 class="mt-75 profile-menu-text text-center" style="color: #000; line-height: 0px;" data-i18n="Name">{{ Session::get('username') }}</h6>
                    </div>
                </div>
            </li>
            <li class="{{  Request::path() == 'employer/dashboard' ? 'active' : ''  }} nav-item">
                <a href="/employer/dashboard"><i class="feather icon-home"></i>
                    <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                </a>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Profile">Profile</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="/employer/view/{{ session()->get('id') }}" data-i18n="View Profile">View Profile</a>
                    </li>
                    <li class="{{  Request::path() == 'employer/profile' ? 'active' : ''  }}"><a class="menu-item" href="/employer/profile" data-i18n="Edit Profile">Edit Profile</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-briefcase"></i><span class="menu-title" data-i18n="Projects">Projects</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::path() == 'employer/create_project' ? 'active' : ''  }}"><a class="menu-item" href="/employer/create_project" data-i18n="Post Project">Post Project</a>
                    </li>
                    <li><a class="menu-item" href="/employer/proposals" data-i18n="Proposals">Proposals</a></li>
                    <li class="{{ Request::path() == 'employer/projects' ? 'active' : ''  }}"><a class="menu-item" href="/employer/projects" data-i18n="My Projects">My Projects</a>
                    </li>
                    <li class="{{  Request::path() == 'employer/projects/ongoing' ? 'active' : ''  }}"><a class="menu-item" href="/employer/projects/ongoing" data-i18n="Ongoing Projects">Ongoing Projects</a>
                    </li>
                    <li class="{{  Request::path() == 'employer/projects/completed' ? 'active' : ''  }}"><a class="menu-item" href="/employer/projects/completed" data-i18n="Completed Projects">Completed Projects</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-briefcase"></i><span class="menu-title" data-i18n="Services">Services</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::path() == 'services_offer/pending' ? 'active' : '' }}">
                        <a class="menu-item" href="/services_offer/pending" data-i18n="Ongoing Services">My Offers / Proposals</a>
                    </li>
                    <li class="{{ Request::path() == 'services_offer/approved' ? 'active' : '' }}"><a class="menu-item" href="/services_offer/approved" data-i18n="Ongoing Services">Approved Services</a>
                    </li>
                    <li><a class="menu-item" href="" data-i18n="Canceled Services">Canceled Services</a>
                    </li>
                </ul>
            </li>
            <li  class="{{ Request::path() == 'user_fund' ? 'active' : '' }} nav-item">
                <a href="/user_fund"><i class="feather icon-file"></i>
                    <span class="menu-title" data-i18n="Fund Deposit & Transactions">Funds, Deposit & Transactions</span>
                </a>
            </li>

        </ul>
    </div>
</div>

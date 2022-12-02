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
            <li class=" nav-item {{ Request::path() == 'freelancer/dashboard' ? 'active' : '' }}">
                <a href="/freelancer/dashboard"><i class="feather icon-home"></i>
                    <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                </a>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Profile">Profile</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="/freelancer/view/{{ session()->get('id') }}" data-i18n="View Profile">View Profile</a>
                    </li>
                    <li class="{{ Request::path() == 'freelancer/profile' ? 'active' : '' }}">
                        <a class="menu-item" href="/freelancer/profile" data-i18n="Edit Profile">Edit Profile</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item "><a href="#"><i class="feather icon-layers"></i><span class="menu-title" data-i18n="Manage Addons">Manage Addons</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::path() == 'freelancer/create_addon' ? 'active' : '' }}"><a class="menu-item" href="/freelancer/create_addon" data-i18n="Create Addon">Create Addon</a>
                    </li>
                    <li class="{{ Request::path() == 'freelancer/addons' ? 'active' : '' }}"><a class="menu-item" href="/freelancer/addons" data-i18n="My Addon">My Addon</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="feather icon-briefcase"></i><span class="menu-title" data-i18n="Manage Services">Manage Services</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::path() == 'freelancer/create_service' ? 'active' : '' }}"><a class="menu-item" href="/freelancer/create_service" data-i18n="Create Services">Create Services</a>
                    </li>
                    <li class="{{ Request::path() == 'freelancer/services' ? 'active' : '' }}"><a class="menu-item" href="/freelancer/services" data-i18n="Active Services">My Services</a>
                    </li>
                    <li><a class="menu-item" href="" data-i18n="Canceled Services">Canceled Services</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-briefcase"></i><span class="menu-title" data-i18n="Manage Projects">Manage Projects</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::path() == 'freelancer/proposals' ? 'active' : '' }}">
                        <a class="menu-item" href="/freelancer/proposals" data-i18n="Proposals">Proposals</a>
                    </li>
                    <li class="{{ Request::path() == 'project_proposals/approved' ? 'active' : '' }}">
                        <a class="menu-item" href="/project_proposals/approved" data-i18n="Approved Projects">Approved Projects</a>
                    </li>
                    <li>
                        <a class="menu-item" href="" data-i18n="Canceled Projects">Canceled Projects</a>
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



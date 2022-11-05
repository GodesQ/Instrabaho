<div class="main-menu menu-fixed menu-light menu-accordion" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="profile-menu d-flex justify-content-center flex-column align-items-center my-2 bg-gradient-x-primary p-2 m-2 rounded">
                <div class="avatar avatar-xl profile-menu-avatar">
                    @if(Session::get('profile_image'))
                        <img class="brand-text" style="width: 70px; height: 70px; object-fit: cover;" src="../../../images/user/profile/{{ Session::get('profile_image') }}" alt="Avatar Image">
                    @else
                        <img class="brand-text" src="../../../images/user-profile.png" alt="Avatar Image">
                    @endif
                </div>
                <h4 class="mt-50 profile-menu-text" style="color: #ffffff; line-height: 10px;" data-i18n="Name">James Garnfil</h4>
                <span style="font-size: 10px; color: #ffffff;" class="profile-menu-text">jamesgarnfil@gmail.com</span>
            </li>
            <li class="{{  Request::path() == 'dashboard' ? 'active' : ''  }} nav-item">
                <a href="/dashboard"><i class="feather icon-home"></i>
                    <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                </a>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Profile">Profile</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="/employer/{{ session()->get('id') }}" data-i18n="View Profile">View Profile</a>
                    </li>
                    <li class="{{  Request::path() == 'profile' ? 'active' : ''  }}"><a class="menu-item" href="/profile" data-i18n="Edit Profile">Edit Profile</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-briefcase"></i><span class="menu-title" data-i18n="Manage Projects">Manage Projects</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::path() == 'create_project' ? 'active' : ''  }}"><a class="menu-item" href="/create_project" data-i18n="Create Projects">Create Projects</a>
                    </li>
                    <li class="{{ Request::path() == 'projects' ? 'active' : ''  }}"><a class="menu-item" href="/projects" data-i18n="Active Projects">Active Projects</a>
                    </li>

                    <li class="{{  Request::path() == 'project_proposals/approved' ? 'active' : ''  }}"><a class="menu-item" href="/project_proposals/approved" data-i18n="Approved Projects">Approved Projects</a>
                    </li>
                    <li><a class="menu-item" href="" data-i18n="Canceled Projects">Canceled Projects</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-users"></i><span class="menu-title" data-i18n="Services">Services</span></a>
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
            <li class="{{ Request::path() == 'proposal_lists/employer' ? 'active' : '' }} nav-item">
                <a class="menu-item" href="/proposal_lists/employer" data-i18n="Project Proposals">
                    <i class="fa fa-book"></i>
                    <span class="menu-title" data-i18n="Project Proposals">Project Proposals</span>
                </a>
            </li>
            <li class=" nav-item">
                <a href=""><i class="feather icon-book"></i>
                    <span class="menu-title" data-i18n="Saved Services">Saved Services</span>
                </a>
            </li>
            <li class="{{ Request::path() == 'followed_freelancer' ? 'active' : '' }} nav-item">
                <a href="/followed_freelancer"><i class="feather icon-heart"></i>
                    <span class="menu-title" data-i18n="Followed Freelancers">Followed Freelancers</span>
                </a>

            </li>
            <li  class="{{ Request::path() == 'user_fund' ? 'active' : '' }} nav-item">
                <a href="/user_fund"><i class="feather icon-file"></i>
                    <span class="menu-title" data-i18n="Fund Deposit & Transactions">Funds, Deposit & Transactions</span>
                </a>
            </li>
            <li class=" nav-item">
                <a href=""><i class="feather icon-shield"></i>
                    <span class="menu-title" data-i18n="Disputes">Disputes</span>
                </a>
            </li>
            <li class=" nav-item">
                <a href=""><i class="feather icon-user-check"></i>
                    <span class="menu-title" data-i18n="Verify Identity">Verify Identity</span>
                </a>
            </li>
        </ul>
    </div>
</div>

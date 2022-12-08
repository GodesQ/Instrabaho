@extends('layout.user-layout')

@section('content')
<style>
    .icon-con-circle {
        border-radius: 50px;
        width: 40px;
        height: 40px;
    }
    .cover-image {
        width: 100%;
        height: 90px;
        border: 3px solid #000000;
    }
    .cover-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-image {
        width: 100%;
        height: 50px;
        display: flex;
        justify-content: center;

    }
    .profile-image img {
        width: 80px;
        height: 80px;
        margin-top: -45px;
        border: 3px solid #000000;
        border-radius: 50px;
        object-fit: cover;
    }
    a {
        color: #000000 !important;
    }
    a.active {
        color: #fff !important;
    }
</style>

@if(Session::get('fail'))
    @push('scripts')
        <script>
            toastr.error('{{ Session::get("fail") }}', 'Fail');
        </script>
    @endpush
@endif

@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Success');
        </script>
    @endpush
@endif


@if ($errors->any())
    @foreach ($errors->all() as $error)
        @push('scripts')
            <script>
                toastr.error('{{ $error }}', 'Error')
            </script>
        @endpush
    @endforeach
@endif

<div class="page-wrapper">
    <div class="page-header">

    </div>
    <div class="page-content">
        <section id="page-account-settings">
            <div class="row">
                <!-- left menu section -->
                <div class="col-md-3 mb-2 mb-md-0">
                    <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                        <li class="nav-item">
                            <a class="nav-link d-flex active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                <i class="feather icon-globe"></i>
                                General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" id="account-pill-skills" data-toggle="pill" href="#account-vertical-skills" aria-expanded="false">
                                <i class="feather icon-command"></i>
                                Skills
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                <i class="feather icon-file"></i>
                                Certificates
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" id="account-pill-info" data-toggle="pill" href="#account-vertical-info" aria-expanded="false">
                                <i class="feather icon-briefcase"></i>
                                Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" id="account-pill-social" data-toggle="pill" href="#account-vertical-social" aria-expanded="false">
                                <i class="feather icon-activity"></i>
                                Experiences
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" id="account-pill-connections" data-toggle="pill" href="#account-vertical-connections" aria-expanded="false">
                                <i class="feather icon-book"></i>
                                Educations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" id="account-pill-notifications" data-toggle="pill" href="#account-vertical-notifications" aria-expanded="false">
                                <i class="feather icon-settings"></i>
                                Settings
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- right content section -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                        @include('UserAuthScreens.user.freelancer.freelancer-form', [$freelancer])
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="account-vertical-skills" aria-labelledby="account-pill-skills" aria-expanded="false">
                                        @include('UserAuthScreens.user.freelancer.skills-form', [$freelancer, $skills])
                                    </div>
                                    <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                        @include('UserAuthScreens.user.freelancer.certificates-form', [$freelancer])
                                    </div>
                                    <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                                        @include('UserAuthScreens.user.freelancer.projects-form', [$freelancer])
                                    </div>
                                    <div class="tab-pane fade " id="account-vertical-social" role="tabpanel" aria-labelledby="account-pill-social" aria-expanded="false">
                                        @include('UserAuthScreens.user.freelancer.experience-form', [$freelancer])
                                    </div>
                                    <div class="tab-pane fade" id="account-vertical-connections" role="tabpanel" aria-labelledby="account-pill-connections" aria-expanded="false">
                                        @include('UserAuthScreens.user.freelancer.educations-form', [$freelancer])
                                    </div>
                                    <div class="tab-pane fade" id="account-vertical-notifications" role="tabpanel" aria-labelledby="account-pill-notifications" aria-expanded="false">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="cover-image">
                                                    @if($freelancer->user->cover_image)
                                                        <img src="../../../images/user/cover/{{ $freelancer->user->cover_image }}" alt="">
                                                    @else
                                                        <img src="../../../images/cover-image-sample.png" alt="">
                                                    @endif
                                                </div>
                                                <div class="profile-image">
                                                    @if($freelancer->user->profile_image)
                                                        <img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" alt="">
                                                    @else
                                                        <img src="../../../images/user-profile.png" alt="">
                                                    @endif
                                                </div>
                                                <form class="form" enctype="multipart/form-data" method="POST" action="/change_user_picture">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $freelancer->user->id }}">
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Change Profile Photo</div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="new_profile_picture" id="inputGroupFile01">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                        </div>
                                                        <input type="hidden" name="old_profile_picture" id="" value="{{ $freelancer->user->profile_image }}">
                                                        <span style="font-style: italic; font-size: 10px;">Leave it empty if you want the current photo.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Change Cover Photo</div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="new_cover_picture" id="inputGroupFile01">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                        </div>
                                                        <input type="hidden" name="old_cover_picture" id="" value="{{ $freelancer->user->cover_image }}">
                                                        <span style="font-style: italic; font-size: 10px;">Leave it empty if you want the current photo.</span>
                                                    </div>
                                                    <div class="form-footer float-right">
                                                        <button class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    Change Password
                                                </div>
                                                <hr>
                                                <form class="form" method="post" action="/user_change_password">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $freelancer->user->id }}">
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Old Password</div>
                                                        <input type="password" required name="old_password" id="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">New Password</div>
                                                        <input type="password" required name="new_password" id="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Confirm Password</div>
                                                        <input type="password" required name="confirm_password" id="" class="form-control">
                                                    </div>
                                                    <div class="form-footer float-right">
                                                        <button class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#tinymce_description',
            height: 300
        });
    </script>
@endpush

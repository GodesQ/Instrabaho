@extends('layout.user-layout')

@section('title')
    {{ $employer->user->firstname . ' ' . $employer->user->lastname}}
@endsection

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
    <div class="page-content">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="h2">{{ $employer->user->firstname }} {{ $employer->user->lastname  }}</div>
                        <span >{{ $employer->user->email }}</span>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 my-50 d-flex justify-content-center align-items-center">
                                <div class="icon bg-primary d-flex justify-content-center align-items-center icon-con-circle">
                                    <div class="feather icon-mail text-white"></div>
                                </div>
                                <div class="col-md-10">
                                    <h6>{{ $employer->user->email }}</h6>
                                </div>
                            </div>
                            <div class="col-md-12 my-50 d-flex justify-content-center align-items-center">
                                <div class="icon bg-primary d-flex justify-content-center align-items-center icon-con-circle">
                                    <div class="feather icon-phone text-white"></div>
                                </div>
                                <div class="col-md-10">
                                    <h6>{{ $employer->contactno }}</h6>
                                </div>
                            </div>
                            <div class="col-md-12 my-50 d-flex justify-content-center align-items-center">
                                <div class="icon bg-primary d-flex justify-content-center align-items-center icon-con-circle">
                                    <div class="feather icon-navigation text-white"></div>
                                </div>
                                <div class="col-md-10">
                                    <h6>{{ $employer->address }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="cover-image">
                            @if($employer->user->cover_image)
                                <img src="../../../images/user/cover/{{ $employer->user->cover_image }}" alt="">
                            @else
                                <img src="../../../images/cover-image-sample.png" alt="">
                            @endif
                        </div>
                        <div class="profile-image">
                            @if($employer->user->profile_image)
                                <img src="../../../images/user/profile/{{ $employer->user->profile_image }}" alt="">
                            @else
                                <img src="../../../images/user-profile.png" alt="">
                            @endif
                        </div>
                        <form class="form" enctype="multipart/form-data" method="POST" action="/change_user_picture">
                            @csrf
                            <input type="hidden" name="id" value="{{ $employer->user->id }}">
                            <div class="form-group">
                                <div class="form-label font-weight-bold my-50">Change Profile Photo</div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="new_profile_picture" id="inputGroupFile01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                                <input type="hidden" name="old_profile_picture" id="" value="{{ $employer->user->profile_image }}">
                                <span style="font-style: italic; font-size: 10px;">Leave it empty if you want the current photo.</span>
                            </div>
                            <div class="form-group">
                                <div class="form-label font-weight-bold my-50">Change Cover Photo</div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="new_cover_picture" id="inputGroupFile01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                                <input type="hidden" name="old_cover_picture" id="" value="{{ $employer->user->cover_image }}">
                                <span style="font-style: italic; font-size: 10px;">Leave it empty if you want the current photo.</span>
                            </div>
                            <div class="form-footer float-right">
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-2">

                    <div class="card-body">
                        <div class="card-title">
                            Change Password
                        </div>
                        <hr>
                        <form class="form" method="post" action="/user_change_password">
                            @csrf
                            <input type="hidden" name="id" value="{{ $employer->user->id }}">
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
            <div class="col-md-8 col-sm-12">
                @include('UserAuthScreens.user.employer.employer-form', [$employer])
            </div>
        </div>
    </div>
</div>
@endsection

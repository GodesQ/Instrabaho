@extends('layout.admin-layout')

@section('content')
<style>
    #map-canvas {
        height: 300px;
        width: 100%;
    }
    a.nav-link {
        color: #000000 !important;
    }
    a.active {
        color: #fff !important;
    }
</style>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @push('scripts')
            <script>
                toastr.error('{{ $error }}', 'Error')
            </script>
        @endpush
    @endforeach
@endif

@if (Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Success')
        </script>
    @endpush
@endif

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="my-1 text-right">
                    <a href="/admin/freelancers" class="btn btn-secondary">Back to List</a>
                </div>
                <section id="page-account-settings">
                    <div class="row">
                        <div class="col-md-3 mb-2 mb-md-0">
                            <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                                <li class="nav-item">
                                    <a class="nav-link d-flex active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                        <i class="feather icon-globe"></i>
                                        General
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex" id="account-pill-skill" data-toggle="pill" href="#account-vertical-skill" aria-expanded="false">
                                        <i class="feather icon-command"></i>
                                        Skills
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex" id="account-pill-certificates" data-toggle="pill" href="#account-vertical-certificates" aria-expanded="false">
                                        <i class="feather icon-file"></i>
                                        Certificates
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex" id="account-pill-projects" data-toggle="pill" href="#account-vertical-projects" aria-expanded="false">
                                        <i class="feather icon-briefcase"></i>
                                        Projects
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex" id="account-pill-experiences" data-toggle="pill" href="#account-vertical-experiences" aria-expanded="false">
                                        <i class="feather icon-activity"></i>
                                        Experiences
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex" id="account-pill-educations" data-toggle="pill" href="#account-vertical-educations" aria-expanded="false">
                                        <i class="feather icon-book"></i>
                                        Educations
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
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h2 class="font-weight-bold">
                                                            <i class="fa fa-user text-primary mr-1"></i>
                                                            USER
                                                        </h2>
                                                        <hr>
                                                        <form action="{{ route('admin.freelancers.update') }}" method="post">
                                                            @method('PUT')
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $freelancer->id }}">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Username
                                                                            </div>
                                                                            <input type="text" class="form-control" name="username" value="{{ $freelancer->user->username }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Email <span class="text-italic font-weight-normal">(This email is not recognized to be updated)</span>
                                                                            </div>
                                                                            <input type="email" class="form-control" name="email" value="{{ $freelancer->user->email }}" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Firstname
                                                                            </div>
                                                                            <input type="text" class="form-control" name="firstname" value="{{ $freelancer->user->firstname }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Middlename
                                                                            </div>
                                                                            <input type="text" class="form-control" name="middlename" value="{{ $freelancer->user->middlename }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Lastname
                                                                            </div>
                                                                            <input type="text" class="form-control" name="lastname" value="{{ $freelancer->user->lastname }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h2 class="font-weight-bold mt-2">
                                                                <i class="fa fa-user text-primary mr-1"></i>
                                                                FREELANCER
                                                            </h2>
                                                            <hr>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Display Name
                                                                            </div>
                                                                            <input type="text" class="form-control" name="display_name" value="{{ $freelancer->display_name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Tagline
                                                                            </div>
                                                                            <input type="text" class="form-control" name="tagline" value="{{ $freelancer->tagline }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Freelancer Type
                                                                            </div>
                                                                            <select name="freelancer_type" id="" class="select2 form-control">
                                                                                <option {{ $freelancer->gender == "Individual" ? 'selected' : null }} value="Individual">Individual</option>
                                                                                <option {{ $freelancer->gender == "Group" ? 'selected' : null }} value="Group">Group</option>
                                                                                <option {{ $freelancer->gender == "Student" ? 'selected' : null }} value="Student">Student</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Hourly Rate
                                                                            </div>
                                                                            <input type="number" class="form-control" name="hourly_rate" value="{{ $freelancer->hourly_rate }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                               Gender
                                                                            </div>
                                                                            <select name="gender" id="" class="select2 form-control">
                                                                                <option {{ $freelancer->gender == "Male" ? 'selected' : null }} value="Male">Male</option>
                                                                                <option {{ $freelancer->gender == "Female" ? 'selected' : null }} value="Female">Female</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Contact No.
                                                                            </div>
                                                                            <input type="tel" class="form-control" name="contactno" value="{{ $freelancer->contactno }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold my-50">
                                                                                Description
                                                                            </div>
                                                                           <textarea name="description" id="" cols="30" class="form-control" rows="10">{{ $freelancer->description }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <div class="font-weight-bold">
                                                                                Address
                                                                            </div>
                                                                            <input type="text" class="form-control" id="map-search" name="address" value="{{ $freelancer->address }}"> <br>
                                                                            <div id="map-canvas"></div>
                                                                            <br>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <div class="form-label font-weight-bold my-50">Latitude</div>
                                                                                        <input type="text" name="latitude" value="{{ $freelancer->latitude }}" class="form-control latitude">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <div class="form-label font-weight-bold my-50">Longitude</div>
                                                                                        <input type="text" name="longitude" value="{{ $freelancer->longitude }}" class="form-control longitude">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-footer text-right">
                                                                <button class="btn btn-primary" type="submit">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade " id="account-vertical-skill" role="tabpanel" aria-labelledby="account-pill-skill" aria-expanded="false">
                                                @include('UserAuthScreens.user.freelancer.skills-form', [$freelancer, $skills])
                                            </div>
                                            <div class="tab-pane fade" id="account-vertical-certificates" role="tabpanel" aria-labelledby="account-pill-certificates" aria-expanded="false">
                                                <form novalidate>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="accountTextarea">Bio</label>
                                                                <textarea class="form-control" id="accountTextarea" rows="3" placeholder="Your Bio data here..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label for="account-birth-date">Birth date</label>
                                                                    <input type="text" class="form-control birthdate-picker" required placeholder="Birth date" id="account-birth-date" data-validation-required-message="This birthdate field is required">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="accountSelect">Country</label>
                                                                <select class="form-control" id="accountSelect">
                                                                    <option>USA</option>
                                                                    <option>India</option>
                                                                    <option>Canada</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="languageselect2">Languages</label>
                                                                <select class="form-control" id="languageselect2" multiple="multiple">
                                                                    <option value="English" selected>English</option>
                                                                    <option value="Spanish">Spanish</option>
                                                                    <option value="French">French</option>
                                                                    <option value="Russian">Russian</option>
                                                                    <option value="German">German</option>
                                                                    <option value="Arabic" selected>Arabic</option>
                                                                    <option value="Sanskrit">Sanskrit</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label for="account-phone">Phone</label>
                                                                    <input type="text" class="form-control" id="account-phone" required placeholder="Phone number" value="(+656) 254 2568" data-validation-required-message="This phone number field is required">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="account-website">Website</label>
                                                                <input type="text" class="form-control" id="account-website" placeholder="Website address">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="musicselect2">Favourite Music</label>
                                                                <select class="form-control" id="musicselect2" multiple="multiple">
                                                                    <option value="Rock">Rock</option>
                                                                    <option value="Jazz" selected>Jazz</option>
                                                                    <option value="Disco">Disco</option>
                                                                    <option value="Pop">Pop</option>
                                                                    <option value="Techno">Techno</option>
                                                                    <option value="Folk" selected>Folk</option>
                                                                    <option value="Hip hop">Hip hop</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="moviesselect2">Favourite movies</label>
                                                                <select class="form-control" id="moviesselect2" multiple="multiple">
                                                                    <option value="The Dark Knight" selected>The Dark Knight
                                                                    </option>
                                                                    <option value="Harry Potter" selected>Harry Potter</option>
                                                                    <option value="Airplane!">Airplane!</option>
                                                                    <option value="Perl Harbour">Perl Harbour</option>
                                                                    <option value="Spider Man">Spider Man</option>
                                                                    <option value="Iron Man" selected>Iron Man</option>
                                                                    <option value="Avatar">Avatar</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                                changes</button>
                                                            <button type="reset" class="btn btn-light">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade " id="account-vertical-projects" role="tabpanel" aria-labelledby="account-pill-projects" aria-expanded="false">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="account-twitter">Twitter</label>
                                                                <input type="text" id="account-twitter" class="form-control" placeholder="Add link" value="https://www.twitter.com">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="account-facebook">Facebook</label>
                                                                <input type="text" id="account-facebook" class="form-control" placeholder="Add link">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="account-google">Google+</label>
                                                                <input type="text" id="account-google" class="form-control" placeholder="Add link">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="account-linkedin">LinkedIn</label>
                                                                <input type="text" id="account-linkedin" class="form-control" placeholder="Add link" value="https://www.linkedin.com">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="account-instagram">Instagram</label>
                                                                <input type="text" id="account-instagram" class="form-control" placeholder="Add link">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="account-quora">Quora</label>
                                                                <input type="text" id="account-quora" class="form-control" placeholder="Add link">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                                changes</button>
                                                            <button type="reset" class="btn btn-light">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="account-vertical-experiences" role="tabpanel" aria-labelledby="account-pill-experiences" aria-expanded="false">
                                                @include('UserAuthScreens.user.freelancer.experience-form', [$freelancer])
                                            </div>
                                            <div class="tab-pane fade" id="account-vertical-educations" role="tabpanel" aria-labelledby="account-pill-educations" aria-expanded="false">
                                                @include('UserAuthScreens.user.freelancer.educations-form', [$freelancer])
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
    </div>
    <script src="../../../js/user-location.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>
@endsection

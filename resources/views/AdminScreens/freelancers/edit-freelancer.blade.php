@extends('layout.admin-layout')

@section('content')
<style>
    #map-canvas {
        height: 300px;
        width: 100%;
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
            <div class="container">
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
                                <a href="/admin/freelancers" class="btn btn-secondary">Back to List</a>
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/user-location.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>
@endsection 
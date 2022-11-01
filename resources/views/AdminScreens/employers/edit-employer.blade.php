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
                        <form action="{{ route('admin.employers.update') }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $employer->id }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Username
                                            </div>
                                            <input type="text" class="form-control" name="username" value="{{ $employer->user->username }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Email <span class="text-italic font-weight-normal">(This email is not recognized to be updated)</span>
                                            </div>
                                            <input type="email" class="form-control" name="email" value="{{ $employer->user->email }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Firstname
                                            </div>
                                            <input type="text" class="form-control" name="firstname" value="{{ $employer->user->firstname }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Middlename
                                            </div>
                                            <input type="text" class="form-control" name="middlename" value="{{ $employer->user->middlename }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Lastname
                                            </div>
                                            <input type="text" class="form-control" name="lastname" value="{{ $employer->user->lastname }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h2 class="font-weight-bold mt-2">
                                <i class="fa fa-user text-primary mr-1"></i> 
                                EMPLOYER
                            </h2>
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Display Name
                                            </div>
                                            <input type="text" class="form-control" name="display_name" value="{{ $employer->display_name }}"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Tagline
                                            </div>
                                            <input type="text" class="form-control" name="tagline" value="{{ $employer->tagline }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Number of Employees
                                            </div>
                                            <select name="number_employees" id="" class="custom-select form-control">
                                                <option value="">Select number of employees</option>
                                                <option value="0" {{ $employer->number_employees == '0' ? 'selected' : null }}>0 Employee</option>
                                                <option value="1-10" {{ $employer->number_employees == '1-10' ? 'selected' : null }}>1 - 10 Employees</option>
                                                <option value="11-20" {{ $employer->number_employees == '11-20' ? 'selected' : null }}>11 - 20 Employees</option>
                                                <option value="21-30" {{ $employer->number_employees == '21-30' ? 'selected' : null }}>21 - 30 Employees</option>
                                                <option value="31-50" {{ $employer->number_employees == '31-50' ? 'selected' : null }}>31 - 50 Employees</option>
                                                <option value="50+" {{ $employer->number_employees == '50+' ? 'selected' : null }}>More than 50</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Contact No.
                                            </div>
                                            <input type="tel" class="form-control" name="contactno" value="{{ $employer->contactno }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Facebook URL
                                            </div>
                                            <input type="url" name="facebook_url" value="{{ $employer->facebook_url }}" id="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Twitter URL
                                            </div>
                                            <input type="url" name="twitter_url" value="{{ $employer->twitter_url }}" id="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Instagram URL
                                            </div>
                                            <input type="url" name="instagram_url" value="{{ $employer->instagram_url }}" id="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                LinkedIn URL
                                            </div>
                                            <input type="url" name="linkedin_url" value="{{ $employer->linkedin_url }}" id="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold my-50">
                                                Description
                                            </div>
                                           <textarea name="description" id="" cols="30" class="form-control" rows="10">{{ $employer->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="font-weight-bold">
                                                Address
                                            </div>
                                            <input type="text" class="form-control" id="map-search" name="address" value="{{ $employer->address }}"> <br>
                                            <div id="map-canvas"></div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Latitude</div>
                                                        <input type="text" name="latitude" value="{{ $employer->latitude }}" class="form-control latitude">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Longitude</div>
                                                        <input type="text" name="longitude" value="{{ $employer->longitude }}" class="form-control longitude">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-footer text-right">
                                <a href="/admin/employers" class="btn btn-secondary">Back to List</a>
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
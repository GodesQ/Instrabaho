<style>
    #map-canvas {
        height: 400px;
        width: 100%;
    }
</style>
<div class="card">
    <div class="card-header">
        <div class="card-title">Profile Basics</div>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $freelancer->user->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Firstname</div>
                        <input type="text" name="firstname" value="{{ $freelancer->user->firstname }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Lastname</div>
                        <input type="text" name="email" class="form-control" value="{{ $freelancer->user->lastname }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Username</div>
                        <input type="text" name="username" value="{{ $freelancer->user->username }}" class="form-control">
                        <span style="font-style: italic; font-size: 10px;">Be careful while changing your username.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Email</div>
                        <input type="email" name="email" class="form-control" readonly value="{{ $freelancer->user->email }}">
                        <span style="font-style: italic; font-size: 10px;">You can not change your email address.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Display Name</div>
                        <input type="text" name="display_name" value="{{ $freelancer->display_name }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Tagline</div>
                        <input type="text" name="tagline" class="form-control" value="{{ $freelancer->tagline }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Hourly Rate</div>
                        <input type="number" name="hourly_rate" value="{{ $freelancer->hourly_rate }}" class="form-control">
                        <span style="font-style: italic; font-size: 10px;">Provide your hourly rate without currency symbol</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Contact No</div>
                        <input type="text" name="contactno" class="form-control" value="{{ $freelancer->contactno }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Gender</div>
                        <select name="gender" id="" class="select2 form-control">
                            <option value="Male" {{ $freelancer->gender == 'Male' ? 'selected' : null }}>Male</option>
                            <option value="Female" {{ $freelancer->gender == 'Female' ? 'selected' : null }}>Female</option>
                        </select>
                        <span class="text-danger">@error('gender'){{$message}}@enderror</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Location (Region)</div>
                        <input type="text" name="location" class="form-control" value="{{ $freelancer->location }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Description</div>
                        <textarea rows="4" name="description" class="form-control" id="tinymce_description">{{ $freelancer->description }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="displayName">Freelancer Type:</label>
                        <select name="freelancer_type" id="" class="select2 form-control">
                            <option value="">Select Freelancer Type</option>
                            <option {{ $freelancer->freelancer_type == 'Company' ? 'selected' : null }} value="Company">Company</option>
                            <option {{ $freelancer->freelancer_type == 'Group' ? 'selected' : null }} value="Group">Group</option>
                            <option {{ $freelancer->freelancer_type == 'Individual' ? 'selected' : null }} value="Individual">Individual</option>
                            <option {{ $freelancer->freelancer_type == 'Student' ? 'selected' : null }} value="Student">Student</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Address</div>
                        <input type="text" name="address" id="map-search" class="form-control controls" value="{{ $freelancer->address }}">
                        <br>
                        <button class="btn btn-primary" type="button" id="get-current-location">Get Current Location</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="map-canvas"></div>
                </div>
            </div>
            <div class="row d-none">
                <div class="col-md-6">
                    <div class="form-group d-none">
                        <div class="form-label font-weight-bold my-50">Latitude</div>
                        <input type="text" name="latitude" value="{{ $freelancer->latitude }}" class="form-control latitude">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-none">
                        <div class="form-label font-weight-bold my-50">Longitude</div>
                        <input type="text" name="longitude" class="form-control longitude" value="{{ $freelancer->longitude }}">
                    </div>
                </div>
            </div>
            <div class="form-footer float-right">
                <button class="btn btn-primary mt-1">Save</button>
            </div>
        </div>
    </form>
</div>

<script src="../../../js/user-location.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>

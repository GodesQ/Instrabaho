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
            <input type="hidden" name="id" value="{{ $employer->user->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Firstname</div>
                        <input type="text" name="firstname" value="{{ $employer->user->firstname }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Lastname</div>
                        <input type="text" name="email" class="form-control" value="{{ $employer->user->lastname }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Username</div>
                        <input type="text" name="username" value="{{ $employer->user->username }}" class="form-control">
                        <span style="font-style: italic; font-size: 10px;">Be careful while changing your username.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Email</div>
                        <input type="email" name="email" class="form-control" readonly value="{{ $employer->user->email }}">
                        <span style="font-style: italic; font-size: 10px;">You can not change your email address.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Display Name</div>
                        <input type="text" name="display_name" value="{{ $employer->display_name }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Tagline</div>
                        <input type="text" name="tagline" class="form-control" value="{{ $employer->tagline }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Department</div>
                        <input type="text" name="department" value="{{ $employer->department }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Contact No</div>
                        <input type="text" name="contactno" class="form-control" value="{{ $employer->contactno }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Number of Employees</div>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Location (Region)</div>
                        <input type="text" name="location" class="form-control" value="{{ $employer->location }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Description</div>
                        <textarea rows="8" name="description" class="form-control" >{{ $employer->description }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Address</div>
                        <input type="text" name="address" id="map-search" class="form-control controls" value="{{ $employer->address }}">
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
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Latitude</div>
                        <input type="text" name="latitude" value="{{ $employer->latitude }}" class="form-control latitude">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Longitude</div>
                        <input type="text" name="longitude" class="form-control longitude" value="{{ $employer->longitude }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Facebook URL</div>
                        <input type="text" name="facebook_url" value="{{ $employer->facebook_url }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Twitter URL</div>
                        <input type="text" name="twitter_url" class="form-control" value="{{ $employer->twitter_url }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Instagram URL</div>
                        <input type="text" name="instagram_url" value="{{ $employer->instagram_url }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Linkedin URL</div>
                        <input type="text" name="linkedin_url" class="form-control" value="{{ $employer->linkedin_url }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Dribble URL</div>
                        <input type="text" name="dribble_url" value="{{ $employer->dribble_url }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label font-weight-bold my-50">Behance URL</div>
                        <input type="text" name="behance_url" class="form-control" value="{{ $employer->behance_url }}">
                    </div>
                </div>
            </div>
            <div class="form-footer float-right">
                <button class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>

<script src="../../../js/user-location.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>
@extends('layout.user-layout')

@section('content')
<style>
    #map-canvas {
        height: 300px;
        width: 100%;
    }
</style>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <form action="/store_project" method="post" class="form" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">CREATE PROJECT</div>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Project</div>
                                    <input type="text" name="title" class="form-control">
                                    <span class="danger text-danger">@error('title'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">English Level</div>
                                    <select name="english_level" id="" class="select2 form-control">
                                        <option value="Basic">Basic Level</option>
                                        <option value="Bilingual">Bilingual Level</option>
                                        <option value="Fluent">Fluent Level</option>
                                        <option value="Professional">Professional Level</option>
                                    </select>
                                    <span class="danger text-danger">@error('english_level'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Services Category</div>
                                    <select name="category_id" id="" class="select2 form-control">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="danger text-danger">@error('category_id'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Attachment</div>
                                    <input type="file" multiple class="form-control" id="pass" name="attachments[]" placeholder="Attachment Name" required>
                                    <span class="danger text-danger">@error('attachments'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Project Level</div>
                                    <select name="project_level" id="" class="select2 form-control">
                                        <option value="Basic">Basic Level</option>
                                        <option value="Moderate">Moderate Level</option>
                                        <option value="Expensive">Expensive Level</option>
                                        <option value="Professional">Professional Level</option>
                                    </select>
                                    <span class="danger text-danger">@error('project_level'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Freelancer Type</div>
                                    <select name="freelancer_type" id="" class="select2 form-control">
                                        <option value="Company">Company</option>
                                        <option value="Group">Group</option>
                                        <option value="Individual">Individual</option>
                                        <option value="Student">Student</option>
                                    </select>
                                    <span class="danger text-danger">@error('freelancer_type'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Project Duration</div>
                                    <select name="project_duration" id="" class="select2 form-control">
                                        <option value="1-3 Weeks">1-3 Weeks</option>
                                        <option value="1-5 Days">1-5 Days</option>
                                        <option value="Long Term">Long Term</option>
                                        <option value="Short Term">Short Term</option>
                                        <option value="1 Months">1-2 Months</option>
                                    </select>
                                    <span class="danger text-danger">@error('project_duration'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Project Cost Type</div>
                                    <select name="project_cost_type" id="" class="select2 form-control">
                                        <option value="Hourly">Hourly</option>
                                        <option value="Fixed">Fixed</option>
                                    </select>
                                    <span class="danger text-danger">@error('project_cost_type'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Cost</div>
                                    <div class="controls">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">₱</span>
                                            </div>
                                            <input type="number" min="100" name="onlyNum" class="form-control" required="" data-validation-required-message="This field is required" aria-invalid="false">
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    <div class="help-block"></div></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Type</div>
                                    <select name="project_type" id="" class="select2 form-control">
                                        <option value="Simple">Simple</option>
                                        <option value="Featured">Featured</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Skills</div>
                                    <select name="skills[]" id="" multiple class="select2 form-control" required>
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->id }}">{{ $skill->skill_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Description</div>
                                    <textarea name="description" class="form-control" id="tinymce_description" cols="30" rows="8"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-50">Address</div>
                                    <input type="text" name="location" id="map-search" class="form-control controls" value="">
                                </div>
                                <div class="col-md-12">
                                    <div id="map-canvas"></div>
                                </div>
                                <div class="col-md-6 d-none">
                                    <div class="form-group d-none">
                                        <div class="form-label font-weight-bold my-50">Latitude</div>
                                        <input type="text" name="latitude" value="" class="form-control latitude">
                                    </div>
                                </div>
                                <div class="col-md-6 d-none">
                                    <div class="form-group d-none">
                                        <div class="form-label font-weight-bold my-50">Longitude</div>
                                        <input type="text" name="longitude" class="form-control longitude" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a href="/projects" class="btn btn-solid btn-warning float-right">Cancel</a>
                        <button type="submit" class="btn btn-solid btn-primary float-right mx-50">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../../../js/user-location.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>
@endsection

@push('scripts')
<script>
    tinymce.init({
        selector: 'textarea#tinymce_description',
        height: 300
    });
</script>
@endpush

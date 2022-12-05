@extends('layout.user-layout')

@section('content')

@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Create');
        </script>
    @endpush
@endif

<style>
    #map-canvas {
        height: 300px;
        width: 100%;
    }
</style>

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <form action="/update_project" method="post" class="form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $project->id }}">
                <input type="hidden" name="employer" value="{{ $project->employer_id }}">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">EDIT PROJECT</div>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="row my-1">
                            <div class="col-md-12">
                                <h4>Attachments</h4>
                                <div class="row">
                                    <input type="hidden" name="$service_images">
                                    @foreach($project_images as $key => $image)
                                        <div class="col-lg-1 col-md-2 col-sm-3">
                                            <img src="../../../images/projects/{{ $image }}" alt="attachment" class="my-75" width="100"> <br>
                                            <a href="#" id="{{ $key }}" class="remove-attachment btn btn-sm btn-danger">Remove</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Project</div>
                                    <input type="text" name="title" class="form-control" value="{{ $project->title }}">
                                    <span class="danger text-danger">@error('title'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">English Level</div>
                                    <select name="english_level" id="" class="select2 form-control">
                                        <option {{ $project->english_level == 'Basic' ? 'selected' : null }} value="Basic">Basic Level</option>
                                        <option {{ $project->english_level == 'Bilingual' ? 'selected' : null }} value="Bilingual">Bilingual Level</option>
                                        <option {{ $project->english_level == 'Fluent' ? 'selected' : null }} value="Fluent">Fluent Level</option>
                                        <option {{ $project->english_level == 'Professional' ? 'selected' : null }} value="Professional">Professional Level</option>
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
                                            <option {{ $project->category_id == $category->id ? 'selected' : null }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="danger text-danger">@error('category_id'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Attachment</div>
                                    <input type="file" multiple class="form-control" id="pass" name="attachments[]" placeholder="Attachment Name">
                                    <span class="danger text-danger">@error('attachments'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Project Level</div>
                                    <select name="project_level" id="" class="select2 form-control">
                                        <option {{ $project->project_level == 'Basic' ? 'selected' : null }} value="Basic">Basic Level</option>
                                        <option {{ $project->project_level == 'Moderate' ? 'selected' : null }} value="Moderate">Moderate Level</option>
                                        <option {{ $project->project_level == 'Expensive' ? 'selected' : null }} value="Expensive">Expensive Level</option>
                                        <option {{ $project->project_level == 'Professional' ? 'selected' : null }} value="Professional">Professional Level</option>
                                    </select>
                                    <span class="danger text-danger">@error('project_level'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Freelancer Type</div>
                                    <select name="freelancer_type" id="" class="select2 form-control">
                                        <option {{ $project->freelancer_type == 'Company' ? 'selected' : null }} value="Company">Company</option>
                                        <option {{ $project->freelancer_type == 'Group' ? 'selected' : null }} value="Group">Group</option>
                                        <option {{ $project->freelancer_type == 'Individual' ? 'selected' : null }} value="Individual">Individual</option>
                                        <option {{ $project->freelancer_type == 'Student' ? 'selected' : null }} value="Student">Student</option>
                                    </select>
                                    <span class="danger text-danger">@error('freelancer_type'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Project Duration</div>
                                    <select name="project_duration" id="" class="select2 form-control">
                                        <option {{ $project->project_duration == '1-3 Weeks' ? 'selected' : null }} value="1-3 Weeks">1-3 Weeks</option>
                                        <option {{ $project->project_duration == '1-5 Days' ? 'selected' : null }} value="1-5 Days">1-5 Days</option>
                                        <option {{ $project->project_duration == 'Long Term' ? 'selected' : null }} value="Long Term">Long Term</option>
                                        <option {{ $project->project_duration == 'Short Term' ? 'selected' : null }} value="Short Term">Short Term</option>
                                        <option {{ $project->project_duration == '1-2 Months' ? 'selected' : null }} value="1-2 Months">1-2 Months</option>
                                    </select>
                                    <span class="danger text-danger">@error('project_duration'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Project Cost Type</div>
                                    <select name="project_cost_type" id="" class="select2 form-control">
                                        <option {{ $project->project_cost_type == 'Hourly' ? 'selected' : null }} value="Hourly">Hourly</option>
                                        <option {{ $project->project_cost_type == 'Fixed' ? 'selected' : null }} value="Fixed">Fixed</option>
                                    </select>
                                    <span class="danger text-danger">@error('project_cost_type'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Cost</div>
                                    <input value="{{ $project->cost }}" type="number" name="cost" class="form-control">
                                    <span class="danger text-danger">@error('cost'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Type</div>
                                    <select name="project_type" id="" class="select2 form-control">
                                        <option {{ $project->project_type == 'simple' ? 'selected' : null }} value="simple">Simple</option>
                                        <option {{ $project->project_type == 'featured' ? 'selected' : null }} value="featured">Featured</option>
                                    </select>
                                    <span class="danger text-danger">@error('project_type'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Skills</div>
                                    <select name="skills[]" id="" multiple class="select2 form-control" required>
                                        @php
                                            $selected_skills = json_decode($project->skills);
                                        @endphp
                                        @foreach($skills as $skill)
                                            <option {{ in_array($skill->id, $selected_skills) ? 'selected' : null }} value="{{ $skill->id }}">{{ $skill->skill_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Description</div>
                                    <textarea name="description" class="form-control" id="tinymce_description" cols="30" rows="8">{{ $project->description }}</textarea>
                                    <span class="danger text-danger">@error('description'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold my-1">Address</div>
                                    <input type="text" value="{{ $project->location }}" name="location" class="form-control " id="map-search">
                                    <span class="danger text-danger">@error('location'){{ $message }}@enderror</span>
                                </div>
                                <div class="col-md-12">
                                    <div id="map-canvas"></div>
                                </div>
                                <div class="col-md-6 d-none">
                                    <div class="form-group d-none">
                                        <div class="form-label font-weight-bold my-50">Latitude</div>
                                        <input type="text" name="latitude" value="{{ $project->latitude }}" class="form-control latitude">
                                    </div>
                                </div>
                                <div class="col-md-6d-none">
                                    <div class="form-group d-none">
                                        <div class="form-label font-weight-bold my-50">Longitude</div>
                                        <input type="text" name="longitude" class="form-control longitude" value="{{ $project->longitude }}">
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

    $(document).ready(function () {
        $(document).on("click", ".remove-attachment", function (e) {
            let key_id = $(this).attr("id");
            let service_id = '{{ $project->id }}';
            let csrf = "{{ csrf_token() }}";
            Swal.fire({
                title: "Remove Image",
                text: "Are you sure you want to remove this?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, remove it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/remove_project_image/${service_id}/${key_id}`,
                        success: function (response) {
                            if(response.status == 201) {
                                Swal.fire(
                                    "Removed!",
                                    "Record has been removed.",
                                    "success"
                                ).then((result) => {

                                });
                            } else {
                                Swal.fire(
                                    "Fail!",
                                    `${response.message}`,
                                    "error"
                                ).then((result) => {

                                });
                            }
                        },
                    });
                }
            });
        });
    });
</script>
@endpush

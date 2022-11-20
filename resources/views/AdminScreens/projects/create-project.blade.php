@extends('layout.admin-layout')

@section('content')

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

<style>
    #map-canvas {
        height: 300px;
        width: 100%;
    }
</style>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header d-flex justify-content-between align-items-center" style="padding: 0rem 1.5rem !important;">
                            <h2 class="card-title font-weight-bold">Create Project</h2>
                            <a href="/admin/projects" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body">
                        <form action="{{ route('project.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_type" value="{{ base64_encode('admin') }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Project Name :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="title" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Employer :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group d-flex justify-content-between align-items-center" style="gap: 10px;">
                                        <div style="width:75% !important;">
                                            <select name="employer" id="employer_select" style="width: 100% !important;">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div style="width: 25% !important;">
                                            <select name="search_employer_type" id="search_employer_type" class="select2" style="width: 100% !important;">
                                                <option value="display_name">Display Name Search</option>
                                                <option value="full_name">Full Name Search</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Service Category :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <select name="category_id" id="category_id" class="select2">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Attachments :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="file" name="attachment[]" class="form-control" multiple>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Cost :
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" name="cost"  value=""  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="font-weight-bold text-right">
                                                Cost Type :
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <select name="project_cost_type" id="" class="select2 form-control">
                                                    <option value="Hourly">Hourly</option>
                                                    <option value="Fixed">Fixed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="font-weight-bold text-right">
                                                English Level :
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <select name="english_level" id="" class="select2 form-control">
                                                    <option value="Basic">Basic Level</option>
                                                    <option value="Bilingual">Bilingual Level</option>
                                                    <option value="Fluent">Fluent Level</option>
                                                    <option value="Professional">Professional Level</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Project Duration :
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group"><select name="project_duration" id="" class="select2 form-control">
                                        <option value="1-3 Weeks">1-3 Weeks</option>
                                        <option value="1-5 Days">1-5 Days</option>
                                        <option value="Long Term">Long Term</option>
                                        <option value="Short Term">Short Term</option>
                                        <option value="1-2 Months">1-2 Months</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="font-weight-bold text-right">
                                                Freelancer Type :
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <select name="freelancer_type" id="" class="select2 form-control">
                                                    <option value="Company">Company</option>
                                                    <option value="Group">Group</option>
                                                    <option value="Individual">Individual</option>
                                                    <option value="Student">Student</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="font-weight-bold text-right">
                                                Project Level :
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <select name="project_level" id="" class="select2 form-control">
                                                    <option value="Basic">Basic Level</option>
                                                    <option value="Moderate">Moderate Level</option>
                                                    <option value="Expensive">Expensive Level</option>
                                                    <option value="Professional">Professional Level</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Skills :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <select name="skills[]" id="" multiple class="select2 form-control" >
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->id }}">{{ $skill->skill_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Type :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <select name="project_type" id="" class="select2 form-control">
                                        <option value="simple">Simple</option>
                                        <option value="featured">Featured</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Description :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Location <br>
                                        <span style="font-size: 10px;" class="font-weight-normal">(You can drag the marker to get the specific location.)</span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="map-search" name="location" value=""> <br>
                                        <div id="map-canvas"></div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-label font-weight-bold my-50">Latitude</div>
                                                    <input type="text" name="latitude" value="" class="form-control latitude">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-label font-weight-bold my-50">Longitude</div>
                                                    <input type="text" name="longitude" value="" class="form-control longitude">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-footer float-right">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
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

@push('scripts')
    <script>
        $('#employer_select').select2({
            ajax: {
                delay: 250,
                url: '{{ route("admin.employers.search") }}',
                data: function (params) {
                let query = {
                    search: params.term,
                    type: $('#search_employer_type').val()
                }
                return query;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
    </script>
@endpush

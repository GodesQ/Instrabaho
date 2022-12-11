@extends('layout.user-layout')

@section('title', 'Create Project')
@section('content')
<style>
    #map-canvas {
        height: 300px;
        width: 100%;
    }
    .active-category {
        border: 1px solid #0bb4ff !important;
    }
    .active-category h5 {
        color: #0bb4ff !important;
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

<div class="page-wrapper pt-5">
    <div class="page-content">
        <div class="container">
             <!-- Form wizard with icon tabs section start -->
             <section id="icon-tabs">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form wizard with icon tabs</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-h font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form action="#" class="icons-tab-steps wizard-circle ">

                                        <!-- Step 1 -->
                                        <h6>Category of Project</h6>
                                        <fieldset class="my-3">
                                            <div class="form-group">
                                                <div class="form-label font-weight-bold h3">Select Category</div>
                                                <div class="row gap-2">
                                                    @foreach ($categories as $category)
                                                        <div onclick="selectCategory(this)" class="{{ $loop->first ? 'active-category' : null }} categories border p-2 col-lg-2 m-1 d-flex justify-content-center align-items-center cursor-pointer flex-column" data-value="{{ $category->id }}">
                                                            <h5 class="text-center">{{ $category->name }}</h5>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <input type="hidden" name="category_id" value="{{ $categories[0]->id }}" id="category_id">
                                        </fieldset>
                                        <!-- Step 2 -->
                                        <h6>Information of Project</h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-label my-1 font-weight-bold">Project Title</div>
                                                        <input type="text" class="form-control" name="title" id="project">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-label my-1 font-weight-bold">Skills</div>
                                                        <select name="skills[]" id="" multiple class="select2 form-control" required>
                                                            @foreach($skills as $skill)
                                                                <option value="{{ $skill->id }}">{{ $skill->skill_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <div class="form-label my-1 font-weight-bold">Description</div>
                                                            <textarea name="description" class="form-control" id="tinymce_description" cols="30" rows="8"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-label my-1 font-weight-bold">Attachment</div>
                                                        <input type="file" multiple class="form-control" id="pass" name="attachments[]" placeholder="Attachment Name" required>
                                                        <span class="danger text-danger">@error('attachments'){{ $message }}@enderror</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-label my-1 font-weight-bold">Type</div>
                                                        <select name="project_type" id="" class="select2 form-control">
                                                            <option value="Simple">Simple</option>
                                                            <option value="Featured">Featured</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Address</div>
                                                        <button type="button" class="btn btn-primary" id="get-current-location">Get Current Location</button>
                                                        <input type="text" name="location" id="map-search" class="form-control controls" value="">
                                                    </div>
                                                    <div class="col-md-12 my-2">
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
                                        </fieldset>

                                        <!-- Step 3 -->
                                        <h6>Project Cost </h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="eventName2">Event Name :</label>
                                                        <input type="text" class="form-control" id="eventName2">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="eventType2">Event Type :</label>
                                                        <select class="custom-select form-control" id="eventType2" data-placeholder="Type to search cities" name="eventType2">
                                                            <option value="Banquet">Banquet</option>
                                                            <option value="Fund Raiser">Fund Raiser</option>
                                                            <option value="Dinner Party">Dinner Party</option>
                                                            <option value="Wedding">Wedding</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="eventLocation2">Event Location :</label>
                                                        <select class="custom-select form-control" id="eventLocation2" name="location">
                                                            <option value="">Select City</option>
                                                            <option value="Amsterdam">Amsterdam</option>
                                                            <option value="Berlin">Berlin</option>
                                                            <option value="Frankfurt">Frankfurt</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Event Date - Time :</label>
                                                        <div class='input-group'>
                                                            <input type='text' class="form-control datetime" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <span class="feather icon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="eventStatus2">Event Status :</label>
                                                        <select class="custom-select form-control" id="eventStatus2" name="eventStatus">
                                                            <option value="Planning">Planning</option>
                                                            <option value="In Progress">In Progress</option>
                                                            <option value="Finished">Finished</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Requirements :</label>
                                                        <div class="c-inputs-stacked">
                                                            <div class="d-inline-block custom-control custom-checkbox">
                                                                <input type="checkbox" name="status2" class="custom-control-input" id="staffing2">
                                                                <label class="custom-control-label" for="staffing2">Staffing</label>
                                                            </div>
                                                            <div class="d-inline-block custom-control custom-checkbox">
                                                                <input type="checkbox" name="status2" class="custom-control-input" id="catering2">
                                                                <label class="custom-control-label" for="catering2">Catering</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <!-- Step 4 -->
                                        <h6><i class="step-icon fa fa-image"></i>Step 4</h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="meetingName2">Name of Meeting :</label>
                                                        <input type="text" class="form-control" id="meetingName2">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="meetingLocation2">Location :</label>
                                                        <input type="text" class="form-control" id="meetingLocation2">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="participants2">Names of Participants</label>
                                                        <textarea name="participants" id="participants2" rows="4" class="form-control"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="decisions2">Decisions Reached</label>
                                                        <textarea name="decisions" id="decisions2" rows="4" class="form-control"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Agenda Items :</label>
                                                        <div class="c-inputs-stacked">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="agenda2" class="custom-control-input" id="item21">
                                                                <label class="custom-control-label" for="item21">1st item</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="agenda2" class="custom-control-input" id="item22">
                                                                <label class="custom-control-label" for="item22">2nd item</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="agenda2" class="custom-control-input" id="item23">
                                                                <label class="custom-control-label" for="item23">3rd item</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="agenda2" class="custom-control-input" id="item24">
                                                                <label class="custom-control-label" for="item24">4th item</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="agenda2" class="custom-control-input" id="item25">
                                                                <label class="custom-control-label" for="item25">5th item</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
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

@push('scripts')
    <script>
        function selectCategory(e) {
            $('.categories').removeClass('active-category');
            $(e).addClass('active-category');
            let category_id = $(e).attr('data-value');
            $('#category_id').val(category_id);
        }
    </script>
@endpush
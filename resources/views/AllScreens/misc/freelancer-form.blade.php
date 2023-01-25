@extends('layout.layout')
@section('title', 'Freelancer Account Form')

@section('content')

    @if(Session::get('fail'))
        @push('scripts')
            <script>
                toastr.error('{{ Session::get("fail") }}', 'Fail');
            </script>
        @endpush
    @endif
    <style>
        .form-control {
            background-color: #fff !important;
        }
        #map-canvas {
            height: 300px;
            width: 100%;
        }
        input:read-only {
            background-color: rgb(224, 224, 224) !important;
            color: rgb(0, 0, 0) !important;
        }
    </style>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Form wizard with icon tabs section start -->
                <section id="number-tabs">
                    <div class="row ">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 col-sm-11 ">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h4 style="color: #fff;">Freelancer/Worker Form</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="{{ route('freelancer.save_role_form')}}" method="POST">
                                            @csrf
                                            <!-- Step 1 -->
                                            <h6><i class="step-icon fa fa-user"></i> Account Information</h6>
                                            <br>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="displayName">Display Name :</label>
                                                            <input type="text" name="display_name" readonly value="{{ $user->firstname . ' ' . $user->lastname}}" class="form-control" id="displayName">
                                                            <span style="font-style: italic; padding: 8px;">It will display on public profile</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="hourlyRate">Hourly Rate :</label>
                                                            <input type="number" name="hourly_rate" class="form-control" id="hourlyRate">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="contactno">Contact No:</label>
                                                            <input type="number" name="contactno"class="form-control" id="contactno" maxlength="11">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Address <span class="danger text-danger">*</span></div>
                                                        <div class="input-group">
                                                            <input type="text" name="address" id="map-search" class="form-control controls" value="{{ old('address') }}">
                                                            <div class="input-group-append" id="button-addon2">
                                                                <button class="btn btn-primary" type="button" id="get-current-location">Current Location</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="primary text-primary">You can drag the marker to get the specific location</div>
                                                        <div id="map-canvas"></div>
                                                    </div>
                                                    <div class="col-md-6 d-none">
                                                        <div class="form-group d-none">
                                                            <div class="form-label font-weight-bold my-50">Latitude</div>
                                                            <input type="text" name="latitude" class="form-control latitude" value="{{ old('latitude') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 d-none">
                                                        <div class="form-group d-none">
                                                            <div class="form-label font-weight-bold my-50">Longitude</div>
                                                            <input type="text" name="longitude" class="form-control longitude" value="{{ old('longitude') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="form-footer my-4">
                                                <button class="btn btn-secondary btn-solid" type="reset">Reset</button>
                                                <button class="btn btn-primary btn-solid" type="submit">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </section>
                <!-- Form wizard with icon tabs section end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <script src="../../../js/user-location.js"></script>
@endsection

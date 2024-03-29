@extends('layout.layout')
@section('title', 'Employer Account Form')

@section('content')

    @if(Session::get('fail'))
        @push('scripts')
            <script>
                toastr.error('{{ Session::get("fail") }}', 'Fail');
            </script>
        @endpush
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @push('scripts')
                <script>
                    toastr.error('{{ $error }}', 'Fail')
                </script>
            @endpush
        @endforeach
    @endif

    <style>
        .form-control {
            background-color: #fff !important;
        }
        #map-canvas {
            height: 300px;
            width: 100%;
        }
    </style>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper mb-5">
            <div class="content-body">
                <!-- Form wizard with icon tabs section start -->
                <section id="number-tabs">
                    <div class="row">
                        <div class="col-md-3 col-sm-1"></div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-gradient-x-primary text-white">
                                    <h4>Employer Form</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="{{ route('employer.save_role_form') }}" method="POST">
                                            @csrf
                                            <h6><i class="step-icon fa fa-user"></i> Basic Information</h6> <br>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="displayName">Display Name : <span class="danger text-danger">*</span> </label>
                                                            <input type="text" name="display_name" readonly class="form-control" id="displayName" value="{{ $user->firstname . ' ' . $user->lastname }}"  style="border: {{$errors->has('display_name') ? '1px solid #ff7588 !important' : 'none'}};">
                                                            <span style="font-style: italic; padding: 8px;">It will display on public profile</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactno">Contact No: <span class="danger text-danger">*</span></label>
                                                            <input type="number" name="contactno" class="form-control" id="contactno" maxlength="11" style="border: {{$errors->has('contactno') ? '1px solid #ff7588 !important' : 'none'}};" value="{{ old('contactno') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold my-50">Location <span class="danger text-danger">*</span></div>

                                                        <div class="input-group">
                                                            <input type="text" name="address" id="map-search" class="form-control controls" style="border: {{$errors->has('address') ? '1px solid #ff7588 !important' : 'none'}};" value="{{ old('address') }}">
                                                            <div class="input-group-append" id="button-addon2">
                                                                <button class="btn btn-primary" type="button" id="get-current-location">Current Location</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div id="map-canvas"></div>
                                                    </div>
                                                    <div class="col-md-6 d-none">
                                                        <div class="form-group d-none">
                                                            <div class="form-label font-weight-bold my-50">Latitude</div>
                                                            <input type="text" name="latitude" class="form-control latitude" value="{{ old('latitude') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6d-none">
                                                        <div class="form-group d-none">
                                                            <div class="form-label font-weight-bold my-50">Longitude</div>
                                                            <input type="text" name="longitude" class="form-control longitude" value="{{ old('longitude') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="form-footer my-3">
                                                <button class="btn btn-secondary btn-solid" type="reset">Reset</button>
                                                <button class="btn btn-primary btn-solid" type="submit">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-1"></div>
                    </div>
                </section>
                <!-- Form wizard with icon tabs section end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

<script src="../../../js/user-location.js"></script>
@endsection

@extends('layout.layout')

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
                                <div class="card-header bg-gradient-x-primary text-white">
                                    <h4 style="color: #ffffff;">Freelancer Form</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="{{ route('freelancer.save_role_form ')}}" method="POST">
                                            @csrf
                                            <!-- Step 1 -->
                                            <h6><i class="step-icon fa fa-user"></i> Account Information</h6>
                                            <br>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="displayName">Display Name :</label>
                                                            <input type="text" name="display_name" class="form-control" id="displayName">
                                                            <span style="font-style: italic; padding: 8px;">It will display on public profile</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="displayName">Freelancer Type:</label>
                                                            <select name="freelancer_type" id="" class="select2 form-control">
                                                                <option value="Company">Company</option>
                                                                <option value="Group">Group</option>
                                                                <option value="Individual">Individual</option>
                                                                <option value="Student">Student</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="hourlyRate">Hourly Rate :</label>
                                                            <input type="number" name="hourly_rate" class="form-control" id="hourlyRate">
                                                            <span style="font-style: italic; padding: 8px;">Provide your hourly rate without currency symbol</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactno">Contact No:</label>
                                                            <input type="number" name="contactno"class="form-control" id="contactno">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="gender">Gender :</label>
                                                            <select class="custom-select form-control" id="gender" name="gender">
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tagLine">Tagline :</label>
                                                            <input name="tagline" type="text" class="form-control" id="tagLine">
                                                            <span style="font-style: italic; padding: 8px;">It will display on public profile</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Description :</label>
                                                            <textarea name="description" class="form-control" id="description" cols="30" rows="5"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="address">Address:</label>
                                                            <input type="text" class="form-control" id="address" name="address">
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="form-footer">
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
@endsection

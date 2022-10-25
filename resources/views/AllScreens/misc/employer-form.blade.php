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
                    <div class="row">
                        <div class="col-md-3 col-sm-1"></div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-gradient-x-primary text-white">
                                    <h4 style="color: #ffffff;">Employer Form</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            @csrf
                                            <!-- Step 1 -->
                                            <h6><i class="step-icon fa fa-user"></i> Account Information</h6> <br>
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
                                                            <label for="tagLine">Tagline :</label>
                                                            <input type="text" name="tagline" class="form-control" id="tagLine">
                                                            <span style="font-style: italic; padding: 8px;">It will display on public profile</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="hourlyRate">Number of Employees :</label>
                                                            <select name="number_employees" id="" class="custom-select form-control">
                                                                <option value="">Select number of employees</option>
                                                                <option value="0">0 Employee</option>
                                                                <option value="1-10">1 - 10 Employees</option>
                                                                <option value="11-20">11 - 20 Employees</option>
                                                                <option value="21-30">21 - 30 Employees</option>
                                                                <option value="31-50">31 - 50 Employees</option>
                                                                <option value="50+">More than 50</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactno">Contact No:</label>
                                                            <input type="number" name="contactno" class="form-control" id="contactno">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="gender">Description :</label>
                                                            <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="date2">Address:</label>
                                                            <input type="text" name="address" class="form-control" id="address">
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
                        <div class="col-md-3 col-sm-1"></div>
                    </div>
                </section>
                <!-- Form wizard with icon tabs section end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection
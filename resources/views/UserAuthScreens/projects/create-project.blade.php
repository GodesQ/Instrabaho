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
                                    <h4 class="card-title">Create Project</h4>
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
                                <section>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <form action="{{ route('project.store') }}" id="create-project" method="POST"
                                                class="icons-tab-steps wizard-circle" enctype="multipart/form-data">
                                                @csrf
                                                <h6>Category of Project</h6>
                                                <fieldset class="my-3">
                                                    <div class="form-group">
                                                        <div class="form-label font-weight-bold h3">Select Category</div>
                                                        <div class="row">
                                                            @foreach ($categories as $category)
                                                                <div onclick="selectCategory(this)"
                                                                    class="{{ $loop->first ? 'active-category' : null }} categories border p-2 col-lg-2 col-xs-6 m-1 d-flex justify-content-center align-items-center cursor-pointer flex-column"
                                                                    data-value="{{ $category->id }}">
                                                                    <h5 class="text-center">{{ $category->name }}</h5>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="category_id" value="{{ $categories[0]->id }}" id="category_id">
                                                </fieldset>

                                                <h6>Project Schedule</h6>
                                                <fieldset class="my-3">
                                                    <div class="form-label font-weight-bold my-50" style="font-size: 20px;">
                                                        When do you need to complete this project?</div>
                                                    <div class="form-group">
                                                        <div class='input-group'>
                                                            <input type='text' class="form-control datetime"
                                                                name="datetime" value="{{ old('datetime') }}" readonly />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="start_date" id="start_date"
                                                            value="{{ old('start_date') }}">
                                                        <input type="hidden" name="end_date" id="end_date"
                                                            value="{{ old('end_date') }}">
                                                        <input type="hidden" name="total_dates" id="total_dates">
                                                    </div>
                                                </fieldset>


                                                <h6>Information of Project</h6>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="form-label my-1 font-weight-bold">Project Title
                                                                </div>
                                                                <input type="text" class="form-control" name="title"
                                                                    id="project" placeholder="e.g Fix my Aircon" required
                                                                    value="{{ old('title') }}" maxlength="100">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="form-label my-1 font-weight-bold">Skills</div>
                                                                <select name="skills[]" id="" multiple
                                                                    class="select2 form-control" required>
                                                                    @foreach ($skills as $skill)
                                                                        <option
                                                                            {{ in_array($skill->id, old('skills') ? old('skills') : []) }}
                                                                            value="{{ $skill->id }}">
                                                                            {{ $skill->skill_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <div class="form-label my-1 font-weight-bold">
                                                                        Description</div>
                                                                    <textarea name="description" class="form-control" id="tinymce_description" cols="30" rows="8" required>{{ old('description') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="form-label my-1 font-weight-bold">Attachment
                                                                </div>
                                                                <input type="file" multiple class="form-control"
                                                                    id="pass" name="attachments[]"
                                                                    placeholder="Attachment Name" required>
                                                                <span class="danger text-danger">
                                                                    @error('attachments')
                                                                        {{ $message }}
                                                                    @enderror
                                                                </span>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label my-1 font-weight-bold">Type</div>
                                                                <select name="project_type" id=""
                                                                    class="select2 form-control">
                                                                    <option
                                                                        {{ old('project_type') == 'Simple' ? 'selected' : null }}
                                                                        value="Simple">Simple</option>
                                                                    <option
                                                                        {{ old('project_type') == 'Featured' ? 'selected' : null }}
                                                                        value="Featured">Featured</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center my-50">
                                                                    <div class="form-label font-weight-bold my-50">Address
                                                                    </div>
                                                                    <button type="button" class="btn btn-primary"
                                                                        id="get-current-location">Get Current
                                                                        Location</button>
                                                                </div>
                                                                <input type="text" name="location" id="map-search"
                                                                    class="form-control controls"
                                                                    value="{{ old('location') }}" required>
                                                            </div>
                                                            <div class="col-md-12 my-2">
                                                                <div id="map-canvas"></div>
                                                            </div>
                                                            <div class="col-md-6 d-none">
                                                                <div class="form-group d-none">
                                                                    <div class="form-label font-weight-bold my-50">Latitude
                                                                    </div>
                                                                    <input type="text" name="latitude"
                                                                        value="{{ old('latitude') }}"
                                                                        class="form-control latitude">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 d-none">
                                                                <div class="form-group d-none">
                                                                    <div class="form-label font-weight-bold my-50">
                                                                        Longitude</div>
                                                                    <input type="text" name="longitude"
                                                                        class="form-control longitude"
                                                                        value="{{ old('longitude') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <!-- Step 3 -->
                                                <h6>Project Cost </h6>
                                                <fieldset>
                                                    <div class="row mt-2 justify-content-center align-items-center">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold"
                                                                    for="project_cost_type">Project Cost Type :</label>
                                                                <select name="project_cost_type" id="project_cost_type"
                                                                    class="select2">
                                                                    <option value="Fixed">Fixed</option>
                                                                    <option value="Hourly">Hourly</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="font-weight-bold" for="eventType2">Project
                                                                    Budget:</label>
                                                                <div class="input-group mt-0">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">₱</span>
                                                                    </div>
                                                                    <input type="number" class="form-control"
                                                                        placeholder="Rate your Budget" id="cost"
                                                                        aria-label="Amount (to the nearest dollar)"
                                                                        name="cost"
                                                                        min="1">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">.00</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="font-weight-bold" for="eventType2">Select
                                                                    Payment Method:</label>
                                                                <select class="select2 form-control" id="payment_method"
                                                                    name="payment_method">
                                                                    <optgroup label="Instrabaho Wallet">
                                                                        <option value="my-wallet">My Wallet</option>
                                                                    </optgroup>
                                                                    <optgroup label="E-WALLETS">
                                                                        <option value="gcash">GCASH</option>
                                                                        <option value="grabpay">GrabPay</option>
                                                                        <option value="maya">Maya</option>
                                                                    </optgroup>
                                                                    <optgroup label="Online Banking">
                                                                        <option value="bpi">BPI BANK</option>
                                                                    </optgroup>
                                                                    <optgroup label="Credit Card">
                                                                        <option value="credit_card">Credit Card</option>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <img src="../../../images/illustrations/project-cost.png"
                                                                alt="" class="text-right"
                                                                style="width: 80% !important;" class="img-responsive">
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                {{-- <!-- Step 4 -->
                                            <h6>Summary of Project</h6>
                                            <fieldset>

                                            </fieldset> --}}
                                                <input type="hidden" name="total_budget" id="total_budget">
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="../../../js/user-location.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize">
    </script>

    <script>
        function selectCategory(e) {
            $('.categories').removeClass('active-category');
            $(e).addClass('active-category');
            let category_id = $(e).attr('data-value');
            $('#category_id').val(category_id);
        }

        $('.datetime').daterangepicker({
            minDate: new Date(),
            locale: {
                format: 'MM/DD/YYYY ',
                cancelLabel: 'Clear'
            }
        }).val('');

        $('input[name="datetime"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            $('input[name="start_date"]').val(picker.startDate.format('MM/DD/YYYY'));
            $('input[name="end_date"]').val(picker.endDate.format('MM/DD/YYYY'));
            let totalLengthOfDates = getDateArray(new Date(picker.startDate.format('MM/DD/YYYY')), new Date(picker
                .endDate.format('MM/DD/YYYY')));
            $('input[name="total_dates"]').val(totalLengthOfDates.length);
        });

        $('input[name="datetime"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('input[name="start_date"]').val('');
            $('input[name="end_date"]').val('');
        });

        const getDateArray = (start_date, end_date) => {
            var arr = [];
            while (start_date <= end_date) {
                arr.push(new Date(start_date));
                start_date.setDate(start_date.getDate() + 1);
            }
            return arr;
        }

        // $('#cost').on('input', function(e) {
        //     if($('#project_cost_type').val() == 'Fixed') {
        //         $('.text-project-budget').html(Number(e.target.value).toFixed(2));
        //         let system_deduction = Number(e.target.value) * 0.10
        //         $('.text-system-deduction').html(Number(system_deduction, 2).toFixed(2));
        //         $('.text-total-budget').html(Number(Number(e.target.value) - system_deduction).toFixed(2));
        //     }
        // })
    </script>
@endpush

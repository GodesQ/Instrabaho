<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="repeat-form">Educations</h4>
        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="repeater-default">
                <form action="/store_educations" method="POST">
                    @csrf
                    <div data-repeater-list="educations">
                        @forelse($freelancer->educations as $education)
                            <div data-repeater-item="">
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12 text-center">
                                        <button type="button" class="btn btn-danger float-right" data-repeater-delete=""> <i class="feather icon-x"></i> Delete</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mb-1 col-sm-12 col-md-6">
                                        <label for="email-addr">Education Title</label>
                                        <br>
                                        <input type="text" class="form-control" id="" name="education_title" placeholder="Education Name" value="{{ $education->education_title }}" required>
                                        <span class="text-danger danger">@error('education_title'){{ $message }}@enderror</span>
                                        <span style="font-size: 11px; font-style:italic;">e.g "Junior High School", "Senior High School", "Course"</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-6">
                                        <label for="">Institute/School Name</label>
                                        <br>
                                        <input type="text" class="form-control" id="" name="institute_name" placeholder="Institute Name" value="{{ $education->institute_name }}" required>
                                        <span class="text-danger danger">@error('institute_name'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mb-1 col-sm-12 col-md-6">
                                        <label for="email-addr">Start Date</label>
                                        <br>
                                        <input type="date" class="form-control" id="" name="start_date" placeholder="Start Date" value="{{ $education->start_date }}" required>
                                        <span class="text-danger danger">@error('start_date'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-6">
                                        <label for="">End Date</label>
                                        <br>
                                        <input type="date" class="form-control" id="" name="end_date" placeholder="End Date" value="{{ $education->end_date }}">
                                        <span class="text-danger danger">@error('end_date'){{ $message }}@enderror</span>
                                        <span style="font-size: 11px; font-style:italic;">Leave it empty to set the current date</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12">
                                        <label for="">Description</label>
                                        <br>
                                        <textarea name="description" id="" cols="30" rows="8" class="form-control" placeholder="Description">{{ $education->description }}</textarea>
                                        <span class="text-danger danger">@error('description'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @empty
                            <div data-repeater-item="">
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12 text-center">
                                        <button type="button" class="btn btn-danger float-right" data-repeater-delete=""> <i class="feather icon-x"></i> Delete</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mb-1 col-sm-12 col-md-6">
                                        <label for="email-addr">Education Title</label>
                                        <br>
                                        <input type="text" class="form-control" id="" name="education_title" placeholder="Education Name" required>
                                        <span style="font-size: 11px; font-style:italic;">e.g "Junior High School", "Senior High School", "Course"</span>
                                        <span class="text-danger danger">@error('education_title'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-6">
                                        <label for="">Institute/School Name</label>
                                        <br>
                                        <input type="text" class="form-control" id="" name="institute_name" placeholder="Institute Name" required>
                                        <span class="text-danger danger">@error('institute_name'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mb-1 col-sm-12 col-md-6">
                                        <label for="email-addr">Start Date</label>
                                        <br>
                                        <input type="date" class="form-control" id="" name="start_date" placeholder="Start Date" required>
                                        <span class="text-danger danger">@error('start_date'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-6">
                                        <label for="">End Date</label>
                                        <br>
                                        <input type="date" class="form-control" id="" name="end_date" placeholder="End Date">
                                        <span class="text-danger danger">@error('end_date'){{ $message }}@enderror</span>
                                        <span style="font-size: 11px; font-style:italic;">Leave it empty to set the current date</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12">
                                        <label for="">Description</label>
                                        <br>
                                        <textarea name="description" id="" cols="30" rows="8" class="form-control" placeholder="Description"></textarea>
                                        <span class="text-danger danger">@error('description'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforelse
                    </div>
                    <div class="form-group overflow-hidden">
                        <div class="col-12">
                            <button type="button" data-repeater-create="" class="btn btn-dark btn-solid">
                                <i class="icon-plus4"></i> Add Education
                            </button>
                            <button type="submit" class="btn btn-primary btn-solid">
                                <i class="icon-plus4"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
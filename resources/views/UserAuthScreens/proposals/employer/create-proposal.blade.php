@extends('layout.layout')

@section('content')
    <div class="container pt-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Send Offer to Freelancer</h3>
                <div class="my-2">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold">What Project do you want to offer?</div>
                                    <select name="project_id" id="project_id" class="form-control select2">
                                        <option value="">Select Project</option>
                                        @forelse ($employer->projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                                        @empty
                                            <option value="">No Projects Found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold">How much is your budget?</div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="number" min="100" name="cost" class="form-control"  data-validation-required-message="This field is required" aria-invalid="false">
                                        <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-label font-weight-bold">What is your prefer pay type?</div>
                                    <div class="input-group">
                                        <select name="project_cost_type" class="form-control" id="project_cost_type">
                                            <option value="Fixed">Fixed</option>
                                            <option value="Hourly">Hourly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
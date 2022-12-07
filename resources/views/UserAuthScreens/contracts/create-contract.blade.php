@extends('layout.user-layout')

@section('title', 'Create Contract - INSTRABAHO')

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
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <h2 class="my-2 font-weight-bold">Create Contract</h2>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <h3 class="font-weight-bold">{{ $proposal->project->title }}</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusamus, quos.</p>
                                        <form action="{{ route('store.contract') }}" method="POST" class="my-2">
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $proposal->project->id }}">
                                            <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
                                            <input type="hidden" name="employer_id" value="{{ $proposal->employer_id }}">
                                            <input type="hidden" name="freelancer_id" value="{{ $proposal->freelancer_id }}">

                                            <div class="form-group">
                                                <label for="cost" class="font-weight-bold">Cost</label>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta, labore consectetur.</p>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">₱</span>
                                                    </div>
                                                    <input type="number" min="100" name="cost" class="form-control" value="{{ $proposal->offer_price }}" data-validation-required-message="This field is required" aria-invalid="false">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="start_date" class="font-weight-bold">Start Date <span class="info ml-50">optional</span></label>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta, labore consectetur.</p>
                                                <input type="date" class="form-control" name="start_date">
                                            </div>
                                            <div class="form-group">
                                                <label for="end_date" class="font-weight-bold">End Date <span class="info ml-50">optional</span></label>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta, labore consectetur.</p>
                                                <input type="date" class="form-control" name="end_date">
                                            </div>
                                            <div class="form-footer">
                                                <button class="btn btn-primary">Create Proposal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="font-weight-bold">About Freelancer</h3>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusamus, quos.</p>
                                    <div class="my-2">
                                        <div class="my-25 border-bottom p-1">
                                            Name : {{ $proposal->freelancer->user->firstname . " " . $proposal->freelancer->user->lastname }}
                                        </div>
                                        <div class="my-25 border-bottom p-1">
                                            Display Name : {{ $proposal->freelancer->display_name }}
                                        </div>
                                        <div class="my-25 border-bottom p-1">
                                            Hourly Rate : ₱ {{ $proposal->freelancer->hourly_rate }}.00
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layout.user-layout')

@section('title')
    TRACK PROJECT - {{ $contract->project->title }}
@endsection


@section('content')
    <style>
        .time-tracker-container {
            width: 100%;
            margin-top: 1rem;
            border-radius: 5px;
            padding: 0.5rem;
            display: flex;
            justify-content: center;
            align-items: center,
        }
        .time-tracker-inner-container {
            width: 100%;
            border-radius: 5px;
            background: #ffffff;
            padding: 1rem;
            box-shadow: 1px 2px 3px rgba(87, 87, 87, 0.25);
        }
        .timerDisplay{
            position: relative;
            width: 100%;
            color: #000;
            font-size: 20px;
        }
        .buttons{
            width: 90%;
            margin: 30px auto 0 auto;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="my-2">
                        <button onclick="history.back()" class="btn btn-secondary">Back</button>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-xl-4">
                            <div class="card">
                                <div class="card-body">

                                    @if ($contract->status && $contract->job_done)
                                        <div class="bs-callout-success callout-bordered my-1" >
                                            <div class="media align-items-stretch">
                                                <div class="d-flex align-items-center bg-success p-2">
                                                    <i class="fa fa-thumbs-o-up white font-medium-5"></i>
                                                </div>
                                                <div class="media-body d-flex align-items-center justify-content-center">
                                                    <strong>This Contract is completed!</strong>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @csrf
                                    <input type="hidden" name="contract_id" data-id="{{ $contract->id }}" id="contract_id">
                                    <input type="hidden" name="status" value="{{ $contract->status == 'stop' ? 'stop' : 'start' }}" id="status">
                                    <input type="hidden" name="start_date" id="start_date_input" value="{{ optional($contract->tracker)->start_time }}">
                                    <input type="hidden" name="end_date" id="end_date_input" value="{{ optional($contract->tracker)->stop_time }}">
                                    <input type="hidden" name="current_minute_input" id="current_minute_input" value="">
                                    <input type="hidden" name="current_hours_input" id="current_hours_input" value="">

                                    <div class="text-right">
                                        @if (session()->get('role') == 'employer' && $contract->is_start_working && !$contract->status)
                                            <a href="/project_pay_job/project/{{ $contract->id }}" class="btn btn-primary job-completed-btn">Job Complete</a>
                                        @endif

                                        @if (session()->get('role') == 'freelancer' && $contract->cost_type == 'Fixed' && !$contract->is_start_working)
                                            <button id="start-working-btn" data-id="{{ $contract->id }}" class="btn btn-primary start-working-btn">Start Working</button>
                                        @endif
                                    </div>
                                    <hr>

                                    @if($contract->cost_type == 'Fixed')
                                        <div class="container my-2">
                                            <h4 class="font-weight-bold text-uppercase">Fixed Type Project</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">Start Working Date: <span class="font-weight-bold working-date-text">{{ $contract->start_working_date ? date_format(new DateTime($contract->start_working_date), 'M d, Y h:i:s A') : 'No Date Found' }}</span></li>
                                                <li class="list-group-item">Job Done Date: <span class="font-weight-bold job-done-date">{{ $contract->job_done_date ? date_format(new DateTime($contract->job_done_date), 'M d, Y h:i:s A') : 'No Date Found' }}</span></li>
                                            </ul>
                                        </div>
                                    @else
                                        @if (session()->get('role') == 'freelancer')
                                            <div class="container my-2">
                                                <h4 class="font-weight-bold text-uppercase">Hourly Type Project</h4>
                                                <div class="form-group text-right">
                                                    <input type="checkbox" id="timer-btn" class="switchery" {{ optional($contract->tracker)->status == 'start' ? 'checked' : null }}/>
                                                    <span class="timer-btn-label">Start</span>
                                                </div>
                                                <ul class="list-group my-1">
                                                    {{-- <input type="checkbox" id="timer-btn" hidden/> --}}
                                                    <li class="list-group-item">Start DateTime : <span class="font-weight-bold start_date">{{ date_format(new DateTIme(optional($contract->tracker)->start_time), 'm/d/Y h:i:s A') }}</span></li>
                                                    <li class="list-group-item">Stop DateTime : <span class="font-weight-bold end_date"></span></li>
                                                    <li class="list-group-item">Total Hours : <span class="font-weight-bold total-hours-text">0</span> hrs</li>
                                                    <li class="list-group-item">Total Minutes : <span class="font-weight-bold total-minutes-text">0</span> min</li>
                                                </ul>

                                            </div>
                                        @else
                                            <div class="container my-2">
                                                <h4 class="font-weight-bold text-uppercase">Hourly Type Project</h4>
                                                <ul class="list-group">
                                                    <input type="checkbox" id="timer-btn" hidden/>
                                                    <li class="list-group-item">Total Hours: <span class="font-weight-bold hours-text">0</span> hrs</li>
                                                    <li class="list-group-item">Total Minutes: <span class="font-weight-bold minutes-text">0</span> min</li>
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="header d-flex justify-content-between align-items-center">
                                        <div>
                                            <h2 class="font-weight-bold">{{ $contract->project->title }}</h2>
                                            <h6>{{ $contract->project->category->name }}</h6>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-xxl-6">
                                            <div class="container my-1">
                                                <h3 class="primary">Project Information</h3>
                                                <ul class="list-group">
                                                    <li class="list-group-item">Title of Project: <span class="font-weight-bold">{{ $contract->project->title }}</span></li>
                                                    <li class="list-group-item">Start Date: <span class="font-weight-bold">{{ date_format(new DateTime($contract->start_date), 'F d, Y') }}</span></li>
                                                    <li class="list-group-item">End Date: <span class="font-weight-bold">{{ date_format(new DateTime($contract->end_date), 'F d, Y') }}</span></li>
                                                    @if($contract->cost_type == 'Fixed')
                                                        <li class="list-group-item">Total Cost: <span class="font-weight-bold">₱ {{ number_format($contract->total_cost, 2) }}</span></li>
                                                    @else
                                                        <li class="list-group-item">Total Cost: <span class="font-weight-bold">The total cost will see after the job completed.</span></li>
                                                    @endif
                                                    <li class="list-group-item">Project Cost Type: <span class="font-weight-bold">{{ $contract->cost_type }}</span></li>
                                                    <li class="list-group-item">Address: <span class="font-weight-bold">{{ $contract->project->location }}</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6">
                                            <div class="container my-1">
                                                <h3 class="primary">Freelancer Information</h3>
                                                <ul class="list-group">
                                                    <li class="list-group-item">Freelancer Name: <span class="font-weight-bold">{{ $contract->freelancer->user->firstname }} {{ $contract->freelancer->user->lastname }}</span></li>
                                                    <li class="list-group-item">Freelancer Display Name: <span class="font-weight-bold">{{ $contract->freelancer->display_name }}</span></li>
                                                    <li class="list-group-item">Email : <span class="font-weight-bold">{{ $contract->freelancer->user->email }}</span></li>
                                                    <li class="list-group-item">Contact No. : <span class="font-weight-normal"><a class="primary" href="tel:{{ $contract->freelancer->contactno }}">{{ $contract->freelancer->contactno }}</a></span></li>
                                                </ul>
                                            </div>
                                            <div class="container my-2">
                                                <h3 class="primary">Employer Information</h3>
                                                <ul class="list-group">
                                                    <li class="list-group-item">Employer Name: <span class="font-weight-bold">{{ $contract->project->employer->user->firstname }} {{ $contract->project->employer->user->lastname }}</span></li>
                                                    <li class="list-group-item">Employer Display Name: <span class="font-weight-bold">{{ $contract->project->employer->display_name }}</span></li>
                                                    <li class="list-group-item">Email : <span class="font-weight-bold">{{ $contract->project->employer->user->email }}</span></li>
                                                    <li class="list-group-item">Contact No. : <span class="font-weight-normal"><a class="primary" href="tel:{{ $contract->project->employer->contactno }}">{{ $contract->project->employer->contactno }}</a></span></li>
                                                </ul>
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
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/track-contract.js')}}"></script>
@endpush

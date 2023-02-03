@extends('layout.user-layout')

@section('title', 'WORKER DASHBOARD')

@section('content')
@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success("{{ Session::get('success') }}", 'Sucess');
        </script>
    @endpush
@endif

@if(Session::get('fail'))
    @push('scripts')
        <script>
            toastr.error("{{ Session::get('fail') }}", 'Error');
        </script>
    @endpush
@endif
<style>
    .evo-calendar {
        box-shadow: 0 10px 50px -20px #b4e6f8;
    }
    .calendar-sidebar {
        background-color: #04bbff !important;
        box-shadow: 5px 0 18px -3px #b4e6f8;
    }
    .calendar-sidebar>.month-list>.calendar-months>li.active-month {
        background-color: #1a90f0;
    }
    .calendar-sidebar>.month-list>.calendar-months>li:hover {
        background-color: #8bc8fa;
    }
    .calendar-sidebar>span#sidebarToggler {
        background-color: #04bbff !important;
    }
    #eventListToggler {
        background-color: #04bbff;
        box-shadow: 5px 0 18px -3px #b4e6f8;
    }
    th[colspan="7"] {
        color: #04bbff;
    }
    .event-list>.event-empty {
        border: 1px solid #04bbff;
        background-color: #e5f3ff;
    }
    .event-list>.event-empty>p {
        color: #04bbff;
    }
    @media screen and (max-width: 425px) {
        .calendar-sidebar>.calendar-year {
            background-color: #04bbff;

        }
    }
</style>

    <div class="container-fluid my-2">
        <h2 class="font-weight-bold">Welcome <span class="primary h2 font-weight-bold">{{ $freelancer->display_name }}</span>!</h2>
        <h6>Hope you're having a great time freelancing.</h6>
    </div>
    {{-- <div id="calendar" class="my-3"></div> --}}
    <div class="row minimal-modern-charts">
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-12 power-consumption-stats-chart">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title font-weight-bold">New Job near you</h3>
                    <div class="row projects-data">
                        @forelse ($projects as $project)
                            <div class="col-xxl-4 col-xl-6">
                                <div class="card rounded" style="box-shadow: 5px 5px 5px 0px rgba(181, 230, 250, 0.22) !important;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="/projects/{{ $project->id }}/{{ $project->title }}" class="font-weight-medium h4 info">{{ strlen($project->title) > 15 ? substr($project->title, 0, 15) . '...' : $project->title }}</a>
                                                <div class="warning">{{ $project->employer->user->firstname . " " . $project->employer->user->lastname }}</div>
                                                <div class="font-weight-bold">Location: <span class="font-weight-normal">{{ substr($project->location, 0, 20) }}...</span></div>
                                                <div class="font-weight-bold">Distance: <span class="font-weight-normal">{{ number_format($project->distance, 2) }} km</span></div>
                                            </div>
                                        </div>
                                        <div class=" my-1 d-flex justify-content-end align-items-center">
                                            <a href="/projects/{{ $project->id }}/{{ $project->title }}" class="btn btn-outline-primary mr-50">View Project <i class="fa fa-eye"></i></a>
                                            <a href="/projects/{{ $project->id }}/{{ $project->title }}#fr-bid-form" class="btn btn-primary">Apply <i class="fa fa-send"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty

                        @endforelse
                    </div>
                    <input type="hidden" value="1" id="page-count">
                </div>
            </div>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recent Completed Projects</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a href="/freelancer/projects/completed" class="primary">All Completed Projects</a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Cost</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recent_projects as $recent_project)
                                    <tr>
                                        <td>
                                            <a href="/projects/{{ $recent_project->project->id }}/{{ $recent_project->project->title }}" class="font-weight-medium primary">
                                                {{ substr($recent_project->project->title, 0, 20) . "..." }}
                                            </a>
                                        </td>
                                        <td>₱ {{ number_format($recent_project->cost, 2) }}</td>
                                        <td class="text-right">
                                            <span class="dropdown">
                                                <a id="btnSearchDrop7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-v"></i></a>
                                                <span aria-labelledby="btnSearchDrop7" class="dropdown-menu mt-1 dropdown-menu-right">
                                                    <a href="/projects/{{ $recent_project->project->id }}/{{ $recent_project->project->title }}" class="dropdown-item delete"><i class="feather icon-eye"></i> View Project</a>
                                                    <a href="/project/contract/view/{{ $recent_project->id }}" class="dropdown-item"><i class="feather icon-file "></i> View Contract</a>
                                                    <a href="/project/contract/track/{{ $recent_project->id }}" class="dropdown-item"><i class="feather icon-file "></i> View Track Record</a>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            No Projects Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Scheduled Projects This Week</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a href="/freelancer/projects/ongoing" class="primary">All Ongoing Projects</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Cost</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects_schedule_week as $project)
                                <tr>
                                    <td>
                                        <a href="/projects/{{ $project->project->id }}/{{ $project->project->title }}" class="font-weight-medium primary">
                                            {{ substr($project->project->title, 0, 20) . "..."  }}
                                        </a>
                                    </td>
                                    <td>₱ {{ number_format($project->cost, 2) }}</td>
                                    <td class="text-right" >
                                        <span class="dropdown">
                                            <a id="btnSearchDrop7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-v"></i></a>
                                            <span aria-labelledby="btnSearchDrop7" class="dropdown-menu mt-1 dropdown-menu-right">
                                                <a href="" class="dropdown-item delete"><i class="feather icon-x"></i> Cancel Project</a>
                                                <a href="/projects/{{ $project->project->id }}/{{ $project->project->title }}" class="dropdown-item delete"><i class="feather icon-eye"></i> View Project</a>
                                                <a href="/project/contract/view/{{ $project->id }}" class="dropdown-item"><i class="feather icon-file "></i> View Contract</a>
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        No Projects Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script src="../../../app-assets/js/scripts/charts/apexcharts/charts-apexcharts.js"></script>
<script>
    $(document).ready(function() {
        let date = new Date();
        $('#calendar').evoCalendar({
            theme: 'Orange Coral',
            calendarEvents: [
                {
                    id: '4hducye', // Event's id (required, for removing event)
                    date: date, // Date of event
                    type: 'event', // Type of event (event|holiday|birthday)
                },
                // {
                //     id: '4hducye', // Event's id (required, for removing event)
                //     date: date, // Date of event
                //     type: 'event', // Type of event (event|holiday|birthday)
                // },
            ]
        })
    })
</script>
@endpush

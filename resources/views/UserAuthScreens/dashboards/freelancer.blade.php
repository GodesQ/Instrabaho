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
    <div class="row minimal-modern-charts">
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-12 power-consumption-stats-chart">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title font-weight-bold">New Job Offers near you</h3>
                    <div class="row projects-data">
                        @forelse ($projects as $project)
                            <div class="col-xxl-4 col-xl-6">
                                <div class="card border rounded">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="/project/view/{{ $project->id }}" class="font-weight-bold h4 info">{{ strlen($project->title) > 15 ? substr($project->title, 0, 15) . '...' : $project->title }}</a>
                                                <div>{{ $project->employer->user->firstname . " " . $project->employer->user->lastname }}</div>
                                                <div class="font-weight-bold">Location: <span class="font-weight-normal">{{ substr($project->location, 0, 25) }}...</span></div>
                                                <div class="font-weight-bold">Distance: <span class="font-weight-normal">{{ number_format($project->distance, 2) }} km</span></div>
                                            </div>
                                        </div>
                                        <div class=" my-1 d-flex justify-content-end align-items-center">
                                            <a href="/project/view/{{ $project->id }}" class="btn btn-outline-primary mr-50">View Project</a>
                                            <a href="/project/view/{{ $project->id }}#fr-bid-form" class="btn btn-primary">Apply</a>
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
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                        </ul>
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
                                            <a href="/project/view/{{ $recent_project->project->id }}" class="font-weight-bold primary">
                                                {{ substr($recent_project->project->title, 0, 20) . "..." }}
                                            </a>
                                        </td>
                                        <td>₱ {{ number_format($recent_project->cost, 2) }}</td>
                                        <td class="text-right">
                                            <span class="dropdown">
                                                <a id="btnSearchDrop7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-v"></i></a>
                                                <span aria-labelledby="btnSearchDrop7" class="dropdown-menu mt-1 dropdown-menu-right">
                                                    <a href="/project/view/{{ $recent_project->project->id }}" class="dropdown-item delete"><i class="feather icon-eye"></i> View Project</a>
                                                    <a href="/project/contract/view/{{ $recent_project->id }}" class="dropdown-item"><i class="feather icon-file "></i> View Contract</a>
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
                                        <a href="/project/view/{{ $project->project->id }}" class="font-weight-bold primary">
                                            {{ substr($project->project->title, 0, 20) . "..."  }}
                                        </a>
                                    </td>
                                    <td>₱ {{ number_format($project->cost, 2) }}</td>
                                    <td class="text-right" >
                                        <span class="dropdown">
                                            <a id="btnSearchDrop7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-v"></i></a>
                                            <span aria-labelledby="btnSearchDrop7" class="dropdown-menu mt-1 dropdown-menu-right">
                                                <a href="" class="dropdown-item delete"><i class="feather icon-x"></i> Cancel Project</a>
                                                <a href="/project/view/{{ $project->project->id }}" class="dropdown-item delete"><i class="feather icon-eye"></i> View Project</a>
                                                <a href="/project/contract/view/{{ $project->id }}" class="dropdown-item"><i class="feather icon-file "></i> View Contract</a>
                                                <a href="/proposal/info/{{ $project->proposal->id }}" class="dropdown-item"><i class="feather icon-file "></i> View Proposal</a>
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

@endpush

@extends('layout.user-layout')

@section('title', 'Completed Projects')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                @if ($completed_projects->count())
                    <div class="page-header my-2">
                        <h2 class="font-weight-bold">
                            Completed Projects
                        </h2>
                    </div>
                @endif
                <div class="row">
                    @forelse ($completed_projects as $completed_project)
                        <div class="col-xxl-3 col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="/projects/{{ $completed_project->project->id }}/{{ $completed_project->project->title }}" class="font-weight-bold h4 info">{{ $completed_project->project->title }}</a>
                                            <h6 class="warning">{{ $completed_project->project->category->name }}</h6>
                                        </div>
                                        <span class="dropdown">
                                            <a id="btnSearchDrop7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                            <span aria-labelledby="btnSearchDrop7" class="dropdown-menu mt-1 dropdown-menu-right">
                                                <a href="/project/contract/track/{{ $completed_project->contract->id }}" class="dropdown-item"><i class="feather icon-eye primary"></i>View Contract Record</a>
                                            </span>
                                        </span>
                                    </div>
                                    <p>{{ strlen($completed_project->project->description) > 100 ? substr($completed_project->project->description, 0, 100) . '...' : $completed_project->project->description }}</p>
                                    <div class="text-right">
                                        <a href="/project/contract/view/{{ $completed_project->contract ? $completed_project->contract->id : null }}" class="info mx-50">View Contract</a>
                                        @if(!$completed_project->contract->is_freelancer_review)
                                            <a href="/review_employer/project/{{ $completed_project->contract->id }}" class="btn btn-primary mx-50">Add Review</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="container-fluid">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <img src="../../../images/illustrations/no-data.png" alt="" class="" style="width: 300px !important;">
                                <h3>No Completed Projects Found</h3>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

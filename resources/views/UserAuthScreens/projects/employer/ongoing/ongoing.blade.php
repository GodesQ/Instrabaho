@extends('layout.user-layout')

@section('title', 'Ongoing Projects')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="page-header my-2">
                    <h2 class="font-weight-bold">
                        Ongoing Projects
                    </h2>
                </div>
                <div class="row">
                    @forelse ($proposals as $proposal)
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="/project/view/{{ $proposal->project->id }}" class="font-weight-bold h4 info">{{ $proposal->project->title }}</a>
                                            <h6>{{ $proposal->project->category->name}}</h6>
                                        </div>
                                        <span class="dropdown">
                                            <a id="btnSearchDrop7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-v"></i></a>
                                            <span aria-labelledby="btnSearchDrop7" class="dropdown-menu mt-1 dropdown-menu-right">
                                                {{-- <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit">
                                                    <i class="feather icon-edit-2 primary"></i>
                                                    Edit Contract</a> --}}
                                                <a href="#" class="dropdown-item delete"><i class="feather icon-x danger"></i> Cancel Project</a>
                                                <a href="/pay_job/project/{{$proposal->id}}" class="dropdown-item"><i class="feather icon-check success"></i> Set to Complete and Pay Job</a>
                                            </span>
                                        </span>
                                    </div>
                                    <p>{{ strlen($proposal->project->description) > 150 ? substr($proposal->project->description, 0, 150) . '...' : $proposal->project->description }}</p>
                                    <ul>
                                        <li><i class="fa fa-calendar mr-1"></i> Start Date : <span class="font-weight-bold">{{ $proposal->contract->start_date ? $proposal->contract->start_date : 'No Start Date' }}</span></li>
                                        <li><i class="fa fa-calendar mr-1"></i> End Date : <span class="font-weight-bold">{{ $proposal->contract->end_date ? $proposal->contract->end_date : 'No End Date' }}</span></li>
                                    </ul>
                                    <div class="text-right">
                                        <a href="/project/contract/{{ $proposal->contract->id }}" class="info mx-50">View Contract</a>
                                        <a href="/proposal/info/{{ $proposal->id }}?act=message" class="btn btn-primary mx-50">Chat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body">
                                No Projects Found
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

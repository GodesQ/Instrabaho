@extends('layout.user-layout')

@section('title', 'Ongoing Projects')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                @if ($ongoing_projects->count())
                    <div class="page-header my-2">
                        <h2 class="font-weight-bold">
                            Ongoing Projects
                        </h2>
                    </div>
                @endif
                <div class="row">
                    @forelse ($ongoing_projects as $data)
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="/projects/{{ $data->project->id }}/{{ $data->project->title }}"
                                                class="font-weight-bold h4 info">{{ $data->project->title }}</a>
                                            <h6 class="warning">{{ $data->project->category->name }}</h6>
                                        </div>
                                        <span class="dropdown">
                                            <a id="btnSearchDrop7" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="true" class="dropdown-toggle dropdown-menu-right">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                            <span aria-labelledby="btnSearchDrop7"
                                                class="dropdown-menu mt-1 dropdown-menu-right">
                                                <a href="" class="dropdown-item delete"><i
                                                        class="feather icon-x danger"></i> Cancel Project</a>
                                                <a href="/project/contract/track/{{ $data->contract->id }}"
                                                    class="dropdown-item delete"><i class="feather icon-clock primary"></i>
                                                    Track Project</a>
                                            </span>
                                        </span>
                                    </div>
                                    <p>
                                        {{ strlen($data->project->description) > 150 ? substr($data->project->description, 0, 150) . '...' : $data->project->description }}
                                    </p>
                                    <ul>
                                        <li><i class="fa fa-calendar mr-1"></i> Start Date : <span
                                                class="font-weight-bold">{{ $data->contract->start_date ? date_format(new DateTime($data->contract->start_date), 'F d, Y') : 'No Start Date' }}</span>
                                        </li>
                                        <li><i class="fa fa-calendar mr-1"></i> End Date : <span
                                                class="font-weight-bold">{{ $data->contract->end_date ? date_format(new DateTime($data->contract->end_date), 'F d, Y') : 'No End Date' }}</span>
                                        </li>
                                    </ul>
                                    <div class="text-right">
                                        <a href="/project/contract/view/{{ $data->contract->id }}" class="info mx-50">View
                                            Contract</a>
                                        <a href="/{{ $data->contract ? $data->contract->proposal_type : null }}/info/{{ $data->id }}?act=message"
                                            class="btn btn-primary mx-50">Chat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="container-fluid">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <img src="../../../images/illustrations/no-data.png" alt="" class=""
                                    style="width: 300px !important;">
                                <h3>No Ongoing Projects Found</h3>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

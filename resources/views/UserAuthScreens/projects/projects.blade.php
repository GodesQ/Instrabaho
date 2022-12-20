@extends('layout.user-layout')

@section('title', 'Projects')

@section('content')
@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Create');
        </script>
    @endpush
@endif
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-wrap">
                <h2>My Projects</h2>
                {{-- <a href="#" class="btn btn-secondary">Back to Dashboard</a> --}}
            </div>

            <div class="row my-1">
                @forelse($projects as $key => $project)
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-sm-6 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between my-1">
                                    @if($project->status == 'pending')
                                        <div class="badge my-25 badge-warning">{{ $project->status }}</div>
                                    @elseif ($project->status == 'approved')
                                        <div class="badge my-25 badge-primary-accent">{{ $project->status }}</div>
                                    @elseif ($project->status == 'completed')
                                        <div class="badge my-25 badge-success">{{ $project->status }}</div>
                                    @else
                                        <div class="badge my-25 badge-danger">{{ $project->status }}</div>
                                    @endif
                                    <span class="dropdown">
                                        <a id="btnSearchDrop7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-v"></i></a>
                                        <span aria-labelledby="btnSearchDrop7" class="dropdown-menu mt-1 dropdown-menu-right">
                                            <a href="#" class="dropdown-item delete"><i class="feather icon-x danger"></i> Cancel Project</a>
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <h5 style="font-weight: 600;">{{ $project->title }}</h5>
                                    <h6>{{ $project->category->name }}</h6>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 my-25 font-weight-bold">
                                        Created Date :
                                    </div>
                                    <div class="col-md-6 my-25 text-xl-right">
                                        {{ date_format(new DateTime($project->created_at), "F d, Y") }}
                                    </div>
                                    <div class="col-md-6 my-25 font-weight-bold">
                                        Project Budget :
                                    </div>
                                    <div class="col-md-6 my-25 text-xl-right">
                                        ₱ {{ number_format($project->cost, 2) }}
                                    </div>
                                    <div class="col-md-6 my-25 font-weight-bold">
                                        Start Date :
                                    </div>
                                    <div class="col-md-6 my-25 text-xl-right">
                                        {{ date_format(new DateTime($project->start_date), "F d, Y") }}
                                    </div>
                                    <div class="col-md-6 my-25 font-weight-bold">
                                        End Date :
                                    </div>
                                    <div class="col-md-6 my-25 text-xl-right">
                                        {{ date_format(new DateTime($project->end_date), "F d, Y") }}
                                    </div>
                                </div>
                                <div class="btn-footer my-2">
                                    <a href="projects/info/{{ $project->title }}" class="btn btn-block btn-outline-primary p-1">View Project</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    No Projects Found
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $(document).on("click", ".delete-project", function (e) {
                e.preventDefault();
                let id = $(this).attr("id");
                let csrf = "{{ csrf_token() }}";
                Swal.fire({
                    title: "Delete Service",
                    text: "Are you sure you want to delete this?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/destroy_project/${id}`,
                            success: function (response) {
                                Swal.fire(
                                    "Deleted!",
                                    "Record has been deleted.",
                                    "success"
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>
@endpush

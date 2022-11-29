@extends('layout.user-layout')

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
            <div class="card">
                <div class="card-header">
                   <div class="card-title">
                        My Projects
                   </div>
                </div>
                <div class="card-content">
                    <div class="card-body table-responsive">
                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Date Created</th>
                                    <th>Date Expiration</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $key => $project)
                                <tr>
                                    <td>
                                        <div>
                                            @if($project->project_type == 'featured')
                                                <div class="badge badge-warning my-50">Featured</div>
                                            @endif
                                            <h4 class="font-weight-bold">{{ $project->title }}</h4>
                                            <p>{{ substr($project->description, 0, 8) . '...' }}</p>
                                            <div class="d-flex align-items-center">
                                                <a href="/employer/edit_project/{{ $project->id }}" class="btn btn-outline-primary btn-sm mr-50"><i class="fa fa-edit"></i> Edit</a>
                                                <button id="{{ $project->id }}" class="delete-project btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h3 style="font-size: 15px;">{{ date_format(new DateTime($project->created_at), "F d, Y")}}</h3>
                                    </td>
                                    <td>
                                        <h3 style="font-size: 15px;">{{ date_format(new DateTime($project->expiration_date), "F d, Y")}}</h3>
                                    </td>
                                    <td valign="center">
                                        <h3 class="font-weight-bold">
                                            ₱ {{ $project->cost }}
                                        </h3>
                                    </td>
                                </tr>
                                @empty
                                </tr>
                                    <td align="center" colspan="3">
                                        <h3 class="mt-4">Sorry!! No Record Found</h3>
                                        <img src="../../../images/nothing-found.png" alt="">
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $projects->links() }}
                    </div>
                </div>
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

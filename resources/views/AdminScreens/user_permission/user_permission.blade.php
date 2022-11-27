@extends('layout.admin-layout')

@section('content')

@if (Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Success')
        </script>
    @endpush
@endif

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="text-right my-2">
                    <a class="btn btn-primary" href="/admin/user_permissions/create">
                        Create <i class="feather icon-plus"></i>
                    </a>
                </div>
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-borderless data-table">
                            <thead>
                                <tr>
                                    <th>Permission ID</th>
                                    <th>Permission</th>
                                    <th>Roles Access</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    let table = $('.data-table').DataTable({
        processing: true,
        pageLength: 10,
        responsive: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.user_permissions.data_table') }}",
        },
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'permission',
                name: 'permission',
                orderable: true,
                searchable: true
            },
            {
                data: 'roles',
                name: 'roles',
                orderable: true,
                searchable: true
            },
            {
                data: 'created_at',
                name: 'created_at',
                orderable: true,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ],
    });

    $(document).on("click", ".delete_user_permission", function (e) {
        e.preventDefault();
        let id = $(this).attr("id");
        let csrf = "{{ csrf_token() }}";
        Swal.fire({
            title: "Delete Permission",
            text: "Are you sure you want to delete this?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#000",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.user_permissions.destroy') }}",
                    method: 'DELETE',
                    data: {
                        'id': id,
                        '_token': csrf
                    },
                    success: function (response) {
                        if(response.status == 201) {
                            Swal.fire(
                                "Deleted!",
                                `${response.message}`,
                                "success"
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire(
                                "Error!",
                                `Something went wrong! Please Try Again.`,
                                "error"
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                });
            }
        });
    });
    </script>
@endpush

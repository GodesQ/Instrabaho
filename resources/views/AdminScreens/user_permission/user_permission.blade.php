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
        pageLength: 25,
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
    </script>
@endpush

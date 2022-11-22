@extends('layout.admin-layout')

@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @push('scripts')
            <script>
                toastr.error('{{ $error }}', 'Error')
            </script>
        @endpush
    @endforeach
@endif

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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
                    Create <i class="feather icon-plus"></i>
                </button>
            </div>
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-borderless data-table">
                        <thead>
                            <tr>
                                <th>User Type ID</th>
                                <th>User Type</th>
                                <th>Slug</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-labelledby="create" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    @include('AdminScreens.user_types.create-user-type')
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    @include('AdminScreens.user_types.edit-user-type')
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
            url: "{{ route('admin.user_types.data_table') }}",
        },
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'role',
                name: 'role',
                orderable: true,
                searchable: true
            },
            {
                data: 'slug',
                name: 'slug',
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

    function getUserType(id) {
        $.ajax({
            url: `/admin/user_types/edit?id=${id}`,
            method: 'GET',
            success: function(response) {
                $('#edit_user_type').val(response.role);
                $('#edit_slug').val(response.slug);
                $('#user_type_id').val(response.id);
            }
        })
    }
    </script>
@endpush

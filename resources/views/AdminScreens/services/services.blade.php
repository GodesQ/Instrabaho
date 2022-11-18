@extends('layout.admin-layout')

@section('content')

@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Success');
        </script>
    @endpush
@endif

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="text-right my-2">
                <a class="btn btn-primary" href="/admin/services/create">
                    Create <i class="feather icon-plus"></i>
                </a>
            </div>
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-borderless table-striped data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Service Category</th>
                                <th>Cost</th>
                                <th>Freelancer</th>
                                <th>Type</th>
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

        $(document).ready(function () {
            $(document).on("click", ".delete-service", function (e) {
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
                            url: `/destroy_service`,
                            method: 'DELETE',
                            data: {
                                _token: csrf,
                                id: id,
                            },
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

        let table = $('.data-table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print',
        ],
        processing: true,
        pageLength: 10,
        responsive: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.services.data_table') }}",
        },
        columns: [
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'service_category',
                name: 'service_category',
                orderable: true,
                searchable: true
            },
            {
                data: 'cost',
                name: 'cost',
                orderable: true,
                searchable: true
            },
            {
                data: 'freelancer',
                name: 'freelancer',
                orderable: true,
                searchable: true
            },
            {
                data: 'type',
                name: 'type',
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

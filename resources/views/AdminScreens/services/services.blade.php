@extends('layout.admin-layout')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
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
        let table = $('.data-table').DataTable({
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

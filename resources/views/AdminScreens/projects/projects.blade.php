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
                                <th>Title</th>
                                <th>Category</th>
                                <th>Employer</th>
                                <th>Project Level</th>
                                <th>Cost</th>
                                <th>Project Type</th>
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
            url: "{{ route('admin.projects.data_table') }}",
        },
        columns: [
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'category',
                name: 'category',
                orderable: true,
                searchable: true
            },
            {
                data: 'employer',
                name: 'employer',
                orderable: true,
                searchable: true
            },
            {
                data: 'project_level',
                name: 'project_level',
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
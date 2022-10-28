@extends('layout.admin-layout')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-borderless data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Cost</th>
                                <th>Freelancer</th>
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
            url: "{{ route('admin.addons.data_table') }}",
        },
        columns: [
            {
                data: 'title',
                name: 'title',
                orderable: true,
                searchable: true
            },
            {
                data: 'price',
                name: 'price',
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
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ],
    });
    </script>
@endpush
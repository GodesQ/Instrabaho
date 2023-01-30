@extends('layout.admin-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container-fluid">
                    <div class="text-right my-1">
                        <a href="{{ route('admin.accounting.create') }}" class="btn btn-primary">Create Accounting</a>
                    </div>
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-borderless table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>Accounting No</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
                url: "{{ route('admin.accounting.data_table') }}",
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'username',
                    name: 'username',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
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

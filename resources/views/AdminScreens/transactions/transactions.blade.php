@extends('layout.admin-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-borderless table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>Transaction Code</th>
                                        <th>Transaction Type</th>
                                        <th>Name of Transaction</th>
                                        <th>From User</th>
                                        <th>Status</th>
                                        <th>Transaction Date</th>
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
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print',
            ],
            processing: true,
            pageLength: 10,
            responsive: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.transactions.data_table') }}",
            },
            columns: [
                {
                    data: 'transaction_code',
                    name: 'transaction_code'
                },
                {
                    data: 'transaction_type',
                    name: 'transaction_type',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'name_of_transaction',
                    name: 'name_of_transaction',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'from',
                    name: 'from',
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

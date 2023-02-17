@extends('layout.user-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Invoices
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderedless">
                                <thead>
                                    <tr>
                                        <td>Invoice Code</td>
                                        <td>Invoice Name</td>
                                        <td>Payment Method</td>
                                        <td>Invoice Date</td>
                                        <td>Due Date</td>
                                        <td>Action</td>
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
                url: '/project_proposals/get_approved_proposals',
            },
            columns: [{
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'user',
                    name: 'user',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'offer_price',
                    name: 'offer_price',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'estimated_days',
                    name: 'estimated_days',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'project_cost_type',
                    name: 'project_cost_type',
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

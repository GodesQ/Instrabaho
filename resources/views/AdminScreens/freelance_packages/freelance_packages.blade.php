@extends('layout.admin-layout')

@section('content')
@if(Session::get('success'))
@push('scripts')
    <script>
        toastr.success("{{ Session::get('success') }}", 'Success');
    </script>
@endpush
@endif
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-body">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-borderedless data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Total Projects</th>
                                    <th>Total Services</th>
                                    <th>Total Feature Services</th>
                                    <th>Price</th>
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
                url: "{{ route('admin.freelancer_packages.data_table') }}",
            },
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'total_projects',
                    name: 'total_projects',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'total_services',
                    name: 'total_services',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'total_feature_services',
                    name: 'total_feature_services',
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
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ],
        });
    </script>
@endpush
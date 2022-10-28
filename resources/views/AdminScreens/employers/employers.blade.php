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
                                    <th>Employer</th>
                                    <th>Tagline</th>
                                    <th>Number of Employees</th>
                                    <th>Member Since</th>
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
                url: "{{ route('admin.employers.data_table') }}",
            },
            columns: [
                {
                    data: 'employer',
                    name: 'employer'
                },
                {
                    data: 'tagline',
                    name: 'tagline',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'number_employees',
                    name: 'number_employees',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'member_since',
                    name: 'member_since',
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
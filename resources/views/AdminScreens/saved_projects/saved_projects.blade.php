@extends('layout.admin-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-borderless table-striped data-table">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Project Owner</th>
                                    <th>Total Followers</th>
                                    <th>Saved Date</th>
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
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print',
            ],
            processing: true,
            pageLength: 10,
            responsive: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.saved_projects.datatables') }}",
            },
            columns: [
                {
                    data: 'project',
                    name: 'project'
                },
                {
                    data: 'project_owner',
                    name: 'project_owner',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'followers',
                    name: 'followers',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'saved_date',
                    name: 'saved_date',
                    orderable: true,
                    searchable: true
                },
            ],
        });
    </script>
@endpush

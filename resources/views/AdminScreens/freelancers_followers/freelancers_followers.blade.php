@extends('layout.admin-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-borderless table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>Freelancer</th>
                                        <th>Tagline</th>
                                        <th>Total Followers</th>
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
                url: "{{ route('admin.freelancers_followers.datatables') }}",
            },
            columns: [
                {
                    data: 'freelancer',
                    name: 'freelancer'
                },
                {
                    data: 'tagline',
                    name: 'tagline',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'total_followers',
                    name: 'total_followers',
                    orderable: true,
                    searchable: true
                },
            ],
        });
    </script>
@endpush


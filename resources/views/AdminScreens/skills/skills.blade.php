@extends('layout.admin-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <table class="table table-borderless table-striped data-table">
                                    <thead>
                                        <tr>
                                            <th>Skill ID</th>
                                            <th>Skill</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Skill</div>
                            </div>
                            <div class="card-body">

                            </div>
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
            url: "{{ route('admin.skills.data_table') }}",
        },
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'skill_name',
                name: 'skill_name',
                orderable: true,
                searchable: true
            },
            {
                data: 'created_at',
                name: 'created_at',
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
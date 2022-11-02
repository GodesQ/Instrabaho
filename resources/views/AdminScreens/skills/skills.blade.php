@extends('layout.admin-layout')

@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @push('scripts')
            <script>
                toastr.error('{{ $error }}', 'Error')
            </script>
        @endpush
    @endforeach
@endif

@if (Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Success')
        </script>
    @endpush
@endif

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
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
                </div>
            </div>
            <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        @include('AdminScreens.skills.edit-skill')
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

    function getSkill(id) {
        $.ajax({
            url: `/admin/skills/edit?id=${id}`,
            method: 'GET',
            success: function(response) {
                console.log(response.skill_name);
                $('#skill_name').val(response.skill_name);
                $('#skill_id').val(response.id);
            }
        })
    }
</script>
@endpush

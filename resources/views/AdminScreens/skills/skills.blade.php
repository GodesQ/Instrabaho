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
                <div class="text-right my-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
                        Create <i class="feather icon-plus"></i>
                    </button>
                </div>
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
            <div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-labelledby="create" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        @include('AdminScreens.skills.create-skill')
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
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print',
        ],
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
                $('#edit_skill_name').val(response.skill_name);
                $('#edit_skill_id').val(response.id);
            }
        })
    }

    $(document).on("click", ".delete-skill", function (e) {
        e.preventDefault();
        let id = $(this).attr("id");
        let csrf = "{{ csrf_token() }}";
        Swal.fire({
            title: "Delete Skill",
            text: "Are you sure you want to delete this?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#000",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.skills.destroy') }}",
                    method: 'DELETE',
                    data: {
                        'id': id,
                        '_token': csrf
                    },
                    success: function (response) {
                        if(response.status == 201) {
                            Swal.fire(
                                "Deleted!",
                                `${response.message}`,
                                "success"
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire(
                                "Error!",
                                `Something went wrong! Please Try Again.`,
                                "error"
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                });
            }
        });
    });
</script>
@endpush

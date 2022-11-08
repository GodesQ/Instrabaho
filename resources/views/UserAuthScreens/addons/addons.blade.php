@extends('layout.user-layout')

@section('content')
@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Success');
        </script>
    @endpush
@endif
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                   <div class="card-title">
                        My Addons
                   </div>
                </div>
                <div class="card-content">
                    <div class="card-body table-responsive">
                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Date Created</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($addons as $key => $addon)
                                <tr>
                                    <td>
                                        <div>
                                            <h4 class="font-weight-bold">{{ $addon->title }}</h4>
                                            <p>{{ substr($addon->description, 0, 8) . '...' }}</p>
                                            <div class="d-flex align-items-center">
                                                <a href="/edit_addon/{{ $addon->id }}" class="btn btn-outline-primary btn-sm mr-50"><i class="fa fa-edit"></i> Edit</a>
                                                <button id="{{ $addon->id }}" class="delete-addon btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h3 style="font-size: 20px;">{{ date_format(new DateTime($addon->created_at), "F d, Y") }}</h3>
                                    </td>
                                    <td valign="center">
                                        <h3 class="font-weight-bold">
                                            ₱ {{ $addon->price }}
                                        </h3>
                                    </td>
                                </tr>
                                @empty
                                </tr>
                                    <td align="center" colspan="3">
                                        <h3 class="mt-4">Sorry!! No Record Found</h3>
                                        <img src="../../../images/nothing-found.png" alt="">
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $addons->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $(document).on("click", ".delete-addon", function (e) {
                e.preventDefault();
                let id = $(this).attr("id");
                let csrf = "{{ csrf_token() }}";
                Swal.fire({
                    title: "Delete Addon Service",
                    text: "Are you sure you want to delete this?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/destroy_addon/${id}`,
                            success: function (response) {
                                Swal.fire(
                                    "Deleted!",
                                    "Record has been deleted.",
                                    "success"
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>
@endpush

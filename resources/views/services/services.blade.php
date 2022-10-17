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
                        My Services
                   </div>
                </div>
                <div class="card-content">
                    <div class="card-body table-responsive">
                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Date Created</th>
                                    <th>Date Expiration</th>
                                    <th>Price</th>
                                    <th>Service Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $key => $service)
                                <tr>
                                    <td>
                                        <div>
                                            <h4 class="font-weight-bold">{{ $service->name }}</h4>
                                            <div class="d-flex align-items-center">
                                                <a href="/edit_service/{{ $service->id }}" class="btn btn-outline-primary btn-sm mr-50"><i class="fa fa-edit"></i> Edit</a>
                                                <button id="{{ $service->id }}" class="delete-service btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td> 
                                        <h3 style="font-size: 15px;">{{ date_format(new DateTime($service->created_at), "F d, Y")}}</h3>
                                    </td>
                                    <td> 
                                        <h3 style="font-size: 15px;">{{ date_format(new DateTime($service->expiration_date), "F d, Y")}}</h3>
                                    </td>
                                    <td valign="center">
                                        <h3 class="font-weight-bold">
                                            ₱ {{ $service->cost }}
                                        </h3>
                                    </td>
                                    <td>
                                        @if($service->type == 'featured')
                                            <div class="badge badge-warning my-50">Featured</div>
                                        @endif
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
                        {!! $services->links() !!}
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
            $(document).on("click", ".delete-service", function (e) {
                e.preventDefault();
                let id = $(this).attr("id");
                let csrf = "{{ csrf_token() }}";
                Swal.fire({
                    title: "Delete Service",
                    text: "Are you sure you want to delete this?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/destroy_service/${id}`,
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
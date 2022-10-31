@extends('layout.user-layout')

@section('content')
    @if(Session::get('success'))
        @push('scripts')
            <script>
                toastr.success('{{ Session::get("success") }}', 'Success');
            </script>
        @endpush
    @endif

    @if(Session::get('fail'))
    @push('scripts')
        <script>
            toastr.error('{{ Session::get("fail") }}', 'Failed');
        </script>
    @endpush
@endif
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">Offers</div>
                    </div>
                    <div class="card-content">
                        <div class="card-body table-responsive">
                            <form action="/purchased_service/change_status" method="POST">
                                @csrf
                                <table class="table table-border">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Service</th>
                                            <th>{{ session()->get('role') == 'freelancer' ? 'Customer' : 'Freelancer' }}</th>
                                            <th>Service Category</th>
                                            <th>Cost</th>
                                            <th style="text-align:center;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($purchased_services as $key => $purchased_service)
                                            <tr>
                                                <td>
                                                    <div class="d-inline-block custom-control custom-checkbox mr-1">
                                                        <input type="checkbox" class="custom-control-input" name="purchased_services[]" value="{{ $purchased_service->id }}" id="{{ $purchased_service->id }}">
                                                        <label class="custom-control-label" for="{{ $purchased_service->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 80%;">
                                                        <h4 class="font-weight-bold">{{ $purchased_service->service->name }}</h4>
                                                        <p>{{ substr($purchased_service->message, 0, 10) . '...' }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold">
                                                        @if (session()->get('role') == 'freelancer')
                                                            {{ $purchased_service->employer->user->firstname . ' ' . $purchased_service->employer->user->lastname }}
                                                            <span style="font-size: 12px;">{{ $purchased_service->employer->user->email }}</span>
                                                        @else
                                                            {{ $purchased_service->freelancer->user->firstname . ' ' . $purchased_service->freelancer->user->lastname }}
                                                            <span style="font-size: 12px;">{{ $purchased_service->freelancer->user->email }}</span>
                                                        @endif
                                                    </div>
                                                        
                                                </td>
                                                <td> 
                                                    <div>{{ $purchased_service->service->category->name }}</div>
                                                </td>
                                                <td> 
                                                    <div>
                                                        ₱ {{ number_format($purchased_service->total, 2) }}
                                                    </div>
                                                </td>
                                                <td style="text-align: center;">
                                                    <a href="/service_proposal_information/{{ $purchased_service->id }}" class="btn btn-solid btn-outline-info"><i class="feather icon-eye"></i> View</a>
                                                    @if(session()->get('role') == 'freelancer')
                                                        <button type="button" id="{{ $purchased_service->id }}" class="btn btn-solid btn-outline-success approve-btn"><i class="fa fa-check"></i> Approve</button>
                                                    @endif    
                                                        <button type="button" id="{{ $purchased_service->id }}" class="btn btn-solid btn-outline-danger cancel-btn"><i class="feather icon-x"></i>Cancel</button>
                                                </td>
                                            </tr>
                                        @empty
                                            </tr>
                                                <td colspan="7" style="display: flex; align-items: center;flex-direction:column; justify-content: center;" colspan="6">
                                                    <h3 class="mt-4">Sorry!! No Record Found</h3>
                                                    <img src="../../../images/nothing-found.png" alt="">
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @if(count($purchased_services) > 0)
                                    <div class="form-foote float-right hide-buttons">
                                        <input type="submit" name="action" class="btn btn-solid btn-success" value="Approve"/>
                                        <input type="submit" name="action" class="btn btn-solid btn-danger" value="Cancel"/>
                                    </div>
                                @endif
                            </form>
                            {!! $purchased_services->links() !!}
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
        $(document).on("click", ".approve-btn", function (e) {
            e.preventDefault();
            let id = $(this).attr("id");
            let csrf = "{{ csrf_token() }}";
            Swal.fire({
                title: "Approved Service?",
                text: "Are you sure you want to approved this?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    changeStatus('approved', csrf, id);
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on("click", ".cancel-btn", function (e) {
            e.preventDefault();
            let id = $(this).attr("id");
            let csrf = "{{ csrf_token() }}";
            Swal.fire({
                title: "Cancel Service?",
                text: "Are you sure you want to cancel this proposal?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    changeStatus('cancel', csrf, id);
                }
            });
        });
    });

    function changeStatus(status, csrf, id) {
        $.ajax({
            url: `/purchased_service/change_status`,
            data: {
                _token: csrf,
                action: status,
                purchased_services: [id]
            },
            method: 'POST',
            success: function (response) {
                Swal.fire(
                    "Update!",
                    "Status update Successfully.",
                    "success"
                ).then((result) => {
                    if (result.isConfirmed) {
                        if(status == 'Approve') {
                            location.href = '/purchased_service/ongoing';
                        }
                    }
                });
            },
        });
    }
</script>
@endpush
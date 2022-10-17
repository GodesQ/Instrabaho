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
                        <div class="card-title">Ongoing Services</div>
                    </div>
                    <div class="card-content">
                        <div class="card-body table-responsive">
                            <form action="/purchased_service/change_status" method="POST">
                                @csrf
                                <table class="table table-border">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Buyer</th>
                                            <th>Service Category</th>
                                            <th>Cost</th>
                                            <th style="text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($purchased_services as $key => $purchased_service)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <div class="font-weight-bold">{{ $purchased_service->service->name }}</div>
                                                        <p>{{ substr($purchased_service->message, 0, 10) . '...' }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold">{{ $purchased_service->employer->user->firstname . ' ' . $purchased_service->employer->user->lastname }}</div>
                                                    <span style="font-size: 12px;">{{ $purchased_service->employer->user->email }}</span>
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
                                                    <a href="/service_proposal_information/{{ $purchased_service->id }}" class="btn btn-solid btn-info"><i class="feather icon-eye"></i> View</a>
                                                    <button type="button" class="btn btn-danger cancel-service-btn" data-receiver="{{ $purchased_service->employer->id }}" onclick="setServiceInfo(this)" id="{{ $purchased_service->id }}" data-toggle="modal" data-target="#inlineForm">
                                                        <i class="feather icon-x"></i> Cancel Service
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            </tr>
                                                <td colspan="6" style="display: flex; align-items: center;flex-direction:column; justify-content: center;">
                                                    <h3 class="mt-4">Sorry!! No Record Found</h3>
                                                    <img src="../../../images/nothing-found.png" alt="">
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </form>
                            {!! $purchased_services->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">Request Service Cancellation</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <label>Cancel Reason: </label>
                        <div class="form-group">
                            <textarea name="" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="job_type" value="service">
                        <input type="hidden" name="job_id" id="job_id" value="">
                        <input type="hidden" name="status_of_job" value="approved">
                        <input type="hidden" name="receiver_id" id="receiver_id" value="">
                        <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function setServiceInfo(e) {
            $('#job_id').val(e.id);
            let receiver = $(e).attr("data-receiver");
            $('#receiver_id').val(receiver);
        }
    </script>
@endpush

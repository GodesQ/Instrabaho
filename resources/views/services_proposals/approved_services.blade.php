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
                <div class="my-1 mb-3">
                    <h2>Approved Services</h2>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="card-body table-responsive">
                            <table class="table table-active data-table">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>{{ session()->get('role') == 'freelancer' ? 'Client' : 'Freelancer' }}</th>
                                        <th>Service Category</th>
                                        <th>Cost</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
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
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="../../../app-assets/js/scripts/pages/app-todo.js"></script>
<script>
    function setServiceInfo(e) {
        $('#job_id').val(e.id);
        let receiver = $(e).attr("data-receiver");
        $('#receiver_id').val(receiver);
    }

    let table = $('.data-table').DataTable({
    processing: true,
    pageLength: 10,
    responsive: true,
    serverSide: true,
    ajax: {
        url: '/purchased_service/get_approved_services',
        data: function (d) {
            d.search = $('input[type="search"]').val()
        }
    },
    columns: [
        {
            data: 'service',
            name: 'service'
        },
        {
            data: 'user',
            name: 'user',
            orderable: true,
            searchable: true
        },
        {
            data: 'category',
            name: 'category',
            orderable: true,
            searchable: true
        },
        {
            data: 'cost',
            name: 'cost',
            orderable: true,
            searchable: true
        },
        {
            data: 'status',
            name: 'status',
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

@extends('layout.admin-layout')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="">Total Freelancers</h6>
                                    <h1 class="font-weight-bold" style="font-size: 40px;">200,000</h1>
                                </div>
                                <div>
                                    <div class="badge bg-success bg-accent-4 text-secondary font-weight-bold px-2 p-1"><i class="fa fa-arrow-up"></i> 20%</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="">Verified Freelancers</h6>
                                    <h1 class="font-weight-bold" style="font-size: 40px;">30,000</h1>
                                </div>
                                <div>
                                    <div class="badge bg-danger bg-accent-4 text-secondary font-weight-bold px-2 p-1"><i class="fa fa-arrow-down"></i> 10%</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="">Active Now</h6>
                                    <h1 class="font-weight-bold" style="font-size: 40px;">10,000</h1>
                                </div>
                                <div>
                                    <img src="../../../images/user-profile.png" alt="" class="avatar avatar-sm" style="margin-left: -10px;">
                                    <img src="../../../images/user-profile.png" alt="" class="avatar avatar-sm" style="margin-left: -10px;">
                                    <img src="../../../images/user-profile.png" alt="" class="avatar avatar-sm" style="margin-left: -10px;">
                                    <img src="../../../images/user-profile.png" alt="" class="avatar avatar-sm" style="margin-left: -10px;">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-1 text-right">
                <a href="" class="btn btn-primary">Create <i class="feather icon-plus"></i></a>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless table-striped data-table">
                        <thead>
                            <tr>
                                <th>Freelancer</th>
                                <th>Tagline</th>
                                <th>Freelancer Type</th>
                                <th>Hourly Rate</th>
                                <th>Member Since</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../../js/user-location.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>
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
                url: "{{ route('admin.freelancers.data_table') }}",
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
                    data: 'freelancer_type',
                    name: 'freelancer_type',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'hourly_rate',
                    name: 'hourly_rate',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'member_since',
                    name: 'member_since',
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
@extends('layout.user-layout')

@section('title', 'Worker Proposals')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div id="proposals" role="tablist" aria-multiselectable="true">
                        <div class="card accordion collapse-icon accordion-icon-rotate">
                            <div id="submitted_proposals" class="card-header primary" data-toggle="collapse" href="#accordion11" aria-expanded="true" aria-controls="accordion11">
                                <a class="card-title lead primary" href="#">Submitted Proposals ({{$pending_proposals->count()}})</a>
                            </div>
                            <div id="accordion11" role="tabpanel" data-parent="#proposals" aria-labelledby="submitted_proposals" class="collapse show">
                                <div class="card-content">
                                    <div class="card-body">
                                        @include('UserAuthScreens.proposals.freelancer.pending.pending')
                                    </div>
                                </div>
                            </div>
                            <div id="heading13" class="card-header primary" data-toggle="collapse" href="#accordion13" aria-expanded="false" aria-controls="accordion13">
                                <a class="card-title lead primary collapsed" href="#">Approved Proposals ({{$approved_proposals->count()}})</a>
                            </div>
                            <div id="accordion13" role="tabpanel" data-parent="#proposals" aria-labelledby="heading13" class="collapse" aria-expanded="false">
                                <div class="card-content">
                                    <div class="card-body">
                                        @include('UserAuthScreens.proposals.freelancer.approved.approved')
                                    </div>
                                </div>
                            </div>
                            <div id="heading12" class="card-header primary" data-toggle="collapse" href="#accordion12" aria-expanded="false" aria-controls="accordion12">
                                <a class="card-title lead primary collapsed" href="#">Offers</a>
                            </div>
                            <div id="accordion12" role="tabpanel" data-parent="#proposals" aria-labelledby="heading12" class="collapse" aria-expanded="false">
                                <div class="card-content">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layout.user-layout')

@section('title')
    TRACK PROJECT -
@endsection


@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="header d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="font-weight-bold">{{ $contract->project->title }}</h2>
                                    <h6>{{ $contract->project->category->name }}</h6>
                                </div>
                                <div>
                                    <button class="btn btn-outline-warning">Cancel Contract</button>
                                    <button class="btn btn-primary">Start Work</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <ul style="font-size: 20px;">
                                        <li>Total Cost : <span class="font-weight-bold" style="font-size: 20px;">₱ {{ number_format($contract->total_co                                                                                                                      st, 2) }}</span></li>
                                        <li>Total Cost : <span class="font-weight-bold" style="font-size: 20px;">₱ {{ number_format($contract->total_cost, 2) }}</span></li>
                                        <li>Total Cost : <span class="font-weight-bold" style="font-size: 20px;">₱ {{ number_format($contract->total_cost, 2) }}</span></li>
                                        <li>Total Cost : <span class="font-weight-bold" style="font-size: 20px;">₱ {{ number_format($contract->total_cost, 2) }}</span></li>
                                    </ul>
                                </div>
                                <div class="col-xl-6">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

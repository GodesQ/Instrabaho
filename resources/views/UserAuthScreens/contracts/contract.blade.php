@extends('layout.user-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="my-1">
                        <a href="/{{ session()->get('role') }}/projects/ongoing" class="btn btn-secondary">Back to List</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <div class="card-title d-flex justify-content-around align-items-center flex-column">
                                    <img style="width: 130px;" src="../../../images/logo/main-logo.png" alt="instrabaho logo" class="my-2" />
                                    <h2 class="text-center font-weight-bold">{{ $contract->project->title }}</h2>
                                    <h6 class="text-center">{{ $contract->project->category->name }}</h6>
                                </div>
                                <div class="description my-2">
                                    <p class="text-center">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officia, mollitia impedit doloremque, id, illum maxime corrupti dolores doloribus tenetur nobis animi dolorem nihil harum exercitationem repellat blanditiis quis. Aliquid enim accusamus cumque quibusdam mollitia ex qui dolores laboriosam praesentium nemo nostrum deleniti ducimus delectus est nam commodi iure, necessitatibus suscipit.</p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-lg-4">
                                    <h4 class="font-weight-bold">Start Date</h4>
                                    <div class="primary">{{ $contract->start_date  ? $contract->start_date : 'No Start Date Found.'}}</div>
                                </div>
                                <div class="col-lg-4">
                                    <h4 class="font-weight-bold">End Date</h4>
                                    <div class="primary">{{ $contract->end_date  ? $contract->end_date : 'No End Date Found.'}}</div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="font-weight-bold">Project Cost</h4>
                                    <div class="primary">₱ {{ number_format($contract->cost, 2) }}</div>
                                </div>
                            </div>
                            <div class="description my-2">
                                <p class="text-center">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officia, mollitia impedit doloremque, id, illum maxime corrupti dolores doloribus tenetur nobis animi dolorem nihil harum exercitationem repellat blanditiis quis. Aliquid enim accusamus.</p>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="font-weight-bold text-center">
                                        About Freelancer
                                    </h3>
                                    <hr>
                                    <ul class="text-center">
                                        <li><span class="font-weight-bold">Name: </span>{{$contract->proposal->freelancer->user->firstname . ' ' .$contract->proposal->freelancer->user->lastname}}</li>
                                        <li><span class="font-weight-bold">Display Name: </span>{{$contract->proposal->freelancer->display_name}}</li>
                                        <li><span class="font-weight-bold">Address: </span>{{ $contract->proposal->freelancer->address }}</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="font-weight-bold text-center">
                                        About Client
                                    </h3>
                                    <hr>
                                    <ul class="text-center">
                                        <li><span class="font-weight-bold">Name: </span>{{$contract->project->employer->user->firstname . ' ' .$contract->project->employer->user->lastname}}</li>
                                        <li><span class="font-weight-bold">Display Name: </span>{{$contract->project->employer->display_name}}</li>
                                        <li><span class="font-weight-bold">Address: </span>{{ $contract->project->employer->address }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
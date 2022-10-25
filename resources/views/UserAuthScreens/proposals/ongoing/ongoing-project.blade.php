@extends('layout.user-layout')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-body">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-borderedless">
                            <thead>
                                <tr>
                                    <th>Project Title</th>
                                    <th>Offer Price</th>
                                    <th>Estimated Days</th>
                                    <th>Project Cost Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ongoing_projects as $ongoing_project) 
                                    <tr>
                                        <td>{{ $ongoing_project->project->title }}</td>
                                        <td>₱ {{ number_format($ongoing_project->offer_price, 2) }}</td>
                                        <td>{{ $ongoing_project->estimated_days }} Days</td>
                                        <td>Fixed</td>
                                        <td>
                                            <div class="badge badge-info p-50">{{ $ongoing_project->status }}</div>
                                        </td>
                                        <td>
                                            <a href="/project_proposal_information/{{ $ongoing_project->id }}" class="btn btn-md btn-primary"><i class="fa fa-eye"></i></a>
                                            <a href="" class="btn btn-md btn-danger"><i class="feather icon-x"></i> Cancel Project</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td align="center" colspan="6">
                                            <h3 class="mt-4">Sorry!! No Record Found</h3>
                                            <img src="../../../images/nothing-found.png" alt="">
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
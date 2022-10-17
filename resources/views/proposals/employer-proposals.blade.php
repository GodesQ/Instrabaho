@extends('layout.user-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Freelancer</th>
                                        <th>Project Title</th>
                                        <th>Offer Price</th>
                                        <th>Estimated Days</th>
                                        <th>project Cost Type</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($proposals as $proposal)
                                        <tr>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center" style="gap: 10px;">
                                                    <img src="../../../images/user/profile/{{ $proposal->freelancer->user->profile_image }}" class="avatar" />
                                                    <div class="font-weight-bold">
                                                        {{ $proposal->freelancer->user->firstname }} {{ $proposal->freelancer->user->lastname }}
                                                        <div class="font-weight-normal">{{ $proposal->freelancer->display_name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    {{ $proposal->project->title }}
                                                </div>
                                            </td>
                                            <td>₱ {{ $proposal->offer_price }}</td>
                                            <td>{{ $proposal->estimated_days }} Days</td>
                                            <td>{{ $proposal->project_cost_type }}</td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    {{ date_format(new DateTime($proposal->created_at), "F d, Y")}}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="mx-50"><a href="/project_proposal_information/{{ $proposal->id }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a></span>
                                                <span><a href="" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></a></span>
                                            </td>
                                        </tr>
                                    @empty

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
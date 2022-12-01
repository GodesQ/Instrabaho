@if(isset($proposals))
    @forelse ($proposals as $proposal)
        <div class="d-flex justify-content-center my-2">
            <div class="container" style="width: 95% !important;">
                <div class="d-flex p-2" style="gap: 20px; box-shadow: 1px 0px 20px rgb(0 0 0 / 7%);">
                    <div>
                        <img class="rounded" src="../../../images/user/profile/{{$proposal->freelancer->user->profile_image}}" alt="employer_image" style="height: 100px !important;">
                    </div>
                    <div>
                        <a href="" style="color: #003066;">{{ $proposal->freelancer->user->firstname . " " . $proposal->freelancer->user->lastname }}</a>
                        <h3 class="text-secondary">{{ $proposal->freelancer->tagline }}</h3>
                        <p class="font-weight-light">{{ $proposal->freelancer->description }}</p>
                        <div class="text-right mt-2">
                            <a href="/service_proposal_information/" class="btn btn-primary">View Proposal <i class="fa fa-arrow-right"></i></a>
                            <a href="/service_proposal_information/" class="btn btn-success">Hire Freelancer <i class="fa fa-thumbs-up"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! $proposals->links() !!}
    @empty
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <img src="../../../images/illustrations/no-data.png" alt="" class="" style="width: 200px !important;">
                    <h2>No Porposals Found</h2>
                </div>
            </div>
        </div>
    @endforelse
@else
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="../../../images/illustrations/find.png" alt="" class="" style="width: 200px !important;">
                <h2>Search Project</h2>
            </div>
        </div>
    </div>
@endif

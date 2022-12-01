@if(isset($proposals))
    @forelse ($proposals as $proposal)
        <div class="card my-2">
            <div class="card-body">
                <div class="d-flex justify-content-center my-2">
                    <div class="container" style="width: 90% !important;">
                        <div class="d-flex p-2" style="gap: 20px; box-shadow: 1px 0px 20px rgb(0 0 0 / 7%);">
                            <div>
                                <img class="rounded" src="../../../images/user/profile/" alt="employer_image" style="height: 100px !important;">
                            </div>
                            <div>
                                <div style="color: #003066;"></div>
                                <h3 class="text-secondary"></h3>
                                <p class="font-weight-light"></p>
                                <div class="text-right mt-2">
                                    <a href="/employer/" class="btn btn-outline-primary">View Client <i class="fa fa-user"></i></a>
                                    <a href="/service_proposal_information/" class="btn btn-success">Approved Offer <i class="fa fa-thumbs-up"></i></a>
                                    <a href="/service_proposal_information/" class="btn btn-primary">View Offer <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

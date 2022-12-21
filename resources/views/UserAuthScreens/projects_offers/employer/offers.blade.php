@forelse ($offers as $offer)
    <div class="d-flex justify-content-center my-1">
        <div class="container" style="width: 95% !important;">
            <div class="d-flex p-2" style="gap: 20px; box-shadow: 1px 0px 20px rgb(0 0 0 / 7%); position: relative !important; background: #fff;">
                <div>
                    @if ($offer->freelancer->user->profile_image)
                        <img class="rounded" src="../../../images/user/profile/{{ $offer->freelancer->user->profile_image }}" alt="employer_image" style="height: 100px !important;">
                    @else
                        <img src="../../../images/user-profile.png" alt="" style="height: 100px !important;">
                    @endif

                </div>
                <div>
                    <a href="/freelancer/view/{{ $offer->freelancer->display_name }}" style="color: #003066;">{{ $offer->freelancer->user->firstname . " " . $offer->freelancer->user->lastname }}</a>
                    <h3 class="text-secondary">{{ $offer->freelancer->tagline }}</h3>
                    <p class="font-weight-light">{{ strlen($offer->freelancer->description) > 250 ? substr($offer->freelancer->description, 0, 250) . "..." : $offer->freelancer->description }} </p>
                    <div class="mt-2">
                        <a href="/offer/info/{{ $offer->id }}?act=message" class="btn btn-outline-primary">Chat </a>
                        <a href="/offer/info/{{ $offer->id }}" class="btn btn-primary">View offer</a>
                        @if ($offer->is_freelancer_approve && $offer->project->status == 'pending')
                            <a href="/project/create-contract/offer/{{ $offer->id }}" class="btn btn-success">Hire</a>
                        @endif
                    </div>
                </div>
                <div class="badge badge-{{$offer->status == 'approved' ? 'success' : 'primary'}} position-absolute" style="right: 20px;">
                    {{ $offer->status }}
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="../../../images/illustrations/no-data.png" alt="" class="" style="width: 200px !important;">
                <h2>No Offers Found</h2>
            </div>
        </div>
    </div>
@endforelse



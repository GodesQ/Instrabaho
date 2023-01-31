@if (isset($freelancers))
    @forelse($freelancers as $freelancer)
        <div class="col-xs-12 col-xl-6 col-lg-4 col-md-6 col-xxl-4 grid-item">
            <div class="fr-latest-grid py-3">
                <div class="d-flex justify-content-between align-items-center">
                        <h6>₱ {{ number_format($freelancer->hourly_rate, 2) }}</h6>
                    <a href="" class="secondary h5"><i class="far fa-bookmark primary"></i></a>
                </div>
                <div class="fr-latest-img d-flex justify-content-center">
                    @if ($freelancer->user->profile_image)
                        <img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" class="rounded"
                            alt=""
                            style="width: 130px; height: 130px; object-fit: cover; border-radius: 50% !important;">
                    @else
                        <img src="../../../images/user-profile.png" alt=""
                            style="width: 130px; height: 130px; object-fit: cover; border-radius: 50% !important;">
                    @endif
                </div>
                <div class="fr-latest-details">
                    <div class="fr-latest-content-service" style="min-height: 120px;">
                        <div class="">
                            {{-- <a class="user-image" href="/freelancers/{{ $freelancer->user->username }}"><img src="img/services-imgs/eshal-dp.jpg" alt="" class="img-fluid"></a> --}}
                            <div class=" text-center my-1">
                                <h5>
                                    <a href="/freelancers/{{ $freelancer->user->username }}"
                                        class="h5">{{ $freelancer->user->firstname . ' ' . $freelancer->user->lastname }}</a>
                                </h5>
                            </div>
                        </div>
                        <div class="text-center">
                            @if ($freelancer->rate)
                                <span class="primary">{{ number_format($freelancer->rate, 1) }}</span>
                                @for ($i = 0; $i < round($freelancer->rate); $i++)
                                    <i class="fas fa-star" style="color: #04bbff !important; font-size: 12px;"
                                        aria-hidden="true"></i>
                                @endfor
                                @for ($i = 0; $i < round(5 - $freelancer->rate); $i++)
                                    <i class="far fa-star" style="color: #04bbff !important; font-size: 12px;"
                                        aria-hidden="true"></i>
                                @endfor
                            @else
                                <span class="primary">{{ number_format($freelancer->rate, 1) }}</span>
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="far fa-star" style="color: #04bbff !important; font-size: 12px;"
                                        aria-hidden="true"></i>
                                @endfor
                            @endif
                        </div>
                        <div class="mt-2">
                            <ul class="fr-project-skills text-center">
                                @forelse($freelancer->skills as $key => $skill)
                                    <li class="badge badge-warning p-50 my-50 font-weight-normal"
                                        style="background: #004E88 !important;">
                                        {{ $skill->skill->skill_name }}</li>
                                    @if ($key == 1)
                                    @break
                                @endif
                            @empty
                                <li class="badge p-50 my-50 font-weight-normal border-primary"
                                    style="background: none !important; color: #000;">No Skills
                                    Found</li>
                            @endforelse
                        </ul>
                        @if($freelancer->distance)
                            <h6 class="font-weight-bold text-center my-1" style="font-size: 12px;"><i class="fas fa-map-marker"></i> Distance : {{ number_format($freelancer->distance, 2) }} km</h6>
                        @endif
                    </div>
                </div>

                <div class="mt-3">
                    <div class="p-3 rounded" style="background: rgb(236, 236, 236) !important;">
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <a href="/freelancers/{{ $freelancer->user->username }}" class="btn"
                                    style="width: 100% !important; background: #fff;">View Profile
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/employer/offer/create_offer/{{ $freelancer->display_name }}" class="btn btn-primary" style="width: 100% !important;">Send Offer </a>
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
                <img src="../../../images/illustrations/no-data.png" style="width: 300px;" alt="">
                <h2>No Freelancer Found</h2>
            </div>
        </div>
    </div>
@endforelse
@endif

@if (isset($freelancers))
<div class="fl-navigation">
    {{ $freelancers->links() }}
</div>
@endif

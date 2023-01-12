@forelse($freelancers as $freelancer)
    <div class="col-xl-12 col-xxl-6 col-lg-12 grid-item">
        <div class="fr3-details">
            <div class="fr3-job-detail">
                <div class="fr3-job-img">
                    <a href="/freelancers/{{ $freelancer->user->username }}">
                        @if($freelancer->user->profile_image)
                            <img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" alt="profile pic" style="width: 110px; height: 100px; object-fit: cover;">
                        @else
                            <img src="../../../images/user-profile.png" alt="profile pic" style="width: 100%; height: 100px; object-fit: cover;">
                        @endif
                    </a>
                    <div class="my-1 text-center">
                        @if($freelancer->rate)
                            <span class="primary">{{ number_format($freelancer->rate, 1) }}</span>
                            @for ($i = 0; $i < round($freelancer->rate); $i++)
                                <i class="fas fa-star" style="color: #04bbff !important; font-size: 9px;" aria-hidden="true"></i>
                            @endfor
                        @else
                        {{-- @for ($i = 0; $i < 5; $i++)
                            <i class="far fa-star" style="color: #04bbff !important; font-size: 8px;" aria-hidden="true"></i>
                        @endfor --}}
                        @endif
                        <div class="font-weight-bold my-25" style="font-size: 9px;">( {{ ($freelancer->total_reviews) }} {{ $freelancer->total_reviews > 1 ? 'Reviews' : 'Review' }} )</div>
                    </div>
                    <!-- <a class="follow follow-freelancer protip text-danger" style="border: 1px solid rgb(255, 0, 0); padding: 0.3rem 1rem;" data-fid="177" data-pt-position="top" data-pt-scheme="black" data-pt-title="Follow">
                            <i class="fas fa-heart mr-50 text-danger" aria-hidden="true"></i> Follow
                    </a> -->
                </div>
                <div class="fr3-job-text">
                    <a href="/freelancers/{{ $freelancer->user->username }}">
                        <h3 cla>{{ $freelancer->user->firstname . ' ' . $freelancer->user->lastname  }}</h3>
                    </a>
                    <p class="price-tag"><span class="currency">₱ </span><span class="price">{{ number_format($freelancer->hourly_rate, 2) }}</span><span class="bottom-text"> / hr</span></p>
                    @if($freelancer->distance)
                        <div class="font-weight-bold" style="color: #000;">Distance :</div>
                        {{ number_format($freelancer->distance, 2) }} km
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div  style="width: 63%;" class="fr3-product-skills">
                            @forelse($freelancer->skills as $skill)
                                <a href="#" style="padding: 0.4rem;">{{ $skill->skill->skill_name }}</a>
                            @empty
                            <a href="#" class="bg-info text-white">No Skills Found</a>
                            @endforelse
                        </div>
                        <div style="width: 37%;" class="text-right">
                            <a href="/freelancers/{{ $freelancer->user->username }}" class="btn btn-md btn-primary">View Profile </a>
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

<div class="fl-navigation">
    {{ $freelancers->links() }}
 </div>

@forelse($freelancers as $freelancer)
    <div class="col-xl-12 col-lg-12 grid-item">
        <div class="fr3-details">
            <div class="fr3-job-detail">
                <div class="fr3-job-img">
                    <a href="/freelancer/view/{{ $freelancer->user_id }}">
                        @if($freelancer->user->profile_image)
                            <img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" alt="profile pic" style="width: 100%; height: 90px; object-fit: cover;">
                        @else
                            <img src="../../../images/user-profile.png" alt="profile pic" style="width: 100%; height: 100px; object-fit: cover;">
                        @endif
                    </a>
                    <p class="mb-2"><i class="fas fa-star colored" aria-hidden="true"></i> No Reviews</p>
                    <!-- <a class="follow follow-freelancer protip text-danger" style="border: 1px solid rgb(255, 0, 0); padding: 0.3rem 1rem;" data-fid="177" data-pt-position="top" data-pt-scheme="black" data-pt-title="Follow">
                            <i class="fas fa-heart mr-50 text-danger" aria-hidden="true"></i> Follow
                    </a> -->
                </div>
                <div class="fr3-job-text">
                    <span class="name"><a href="/freelancer/view/{{ $freelancer->user_id }}">	<i class="fa fa-check verified protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Verified" aria-hidden="true"></i>{{ $freelancer->display_name }}</a></span>
                    <a href="#">
                        <h3>{{ $freelancer->tagline }}</h3>
                    </a>
                    <p class="excerpt">{{ htmlentities(substr($freelancer->description, 0, 200)) }}...</p>
                    <p class="price-tag"><span class="currency">₱ </span><span class="price">{{ number_format($freelancer->hourly_rate, 2) }}</span><span class="bottom-text"> / hr</span></p>
                    <ul class="lists d-flex justify-content-between" style="gap: 10px;">
                        <li style="width: 25%;">
                            @if($freelancer->distance)
                                <div class="font-weight-bold" style="color: #000;">Distance :</div>
                                {{ number_format($freelancer->distance, 2) }} km
                            @else
                                <div class="font-weight-bold" style="color: #000;">Member Since :</div>
                                {{ date_format(new DateTime($freelancer->created_at), "F d, Y") }}
                                @endif
                        </li>
                        <li style="width: 33%;">
                            <div class="font-weight-bold" style="color: #000;">Location : </div>
                            {{ $freelancer->address }}
                        </li>
                        <li style="width: 33%;">
                            <div class="font-weight-bold" style="color: #000;">Freelancer Type : </div>
                            {{ $freelancer->freelancer_type }}
                        </li>
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fr3-product-skills">
                            @forelse($freelancer->skills as $skill)
                                <a href="">{{ $skill->skill->skill_name }}</a>
                            @empty
                            <a href="#" class="bg-info text-white">No Skills Found</a>
                            @endforelse
                            </div>
                        <a href="/freelancer/view/{{ $freelancer->user_id }}" class="btn btn-theme btn-sm btn-outline-primary">View Profile <i class="fa fa-chevron-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty

@endforelse

<div class="fl-navigation">
    {{ $freelancers->links() }}
 </div>

<div class="row">
@forelse ($recommendations as $freelancer)
    <div class="col-xl-3 col-lg-4 col-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <a href="/freelancers/{{ $freelancer->user->username }}" class="freelancer-image img-fluid">
                        <img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" alt="{{ $freelancer->user->profile_image }} Image" style="object-fit: cover; height: 150px; width: 150px; border-radius: 50%;">
                    </a>
                    <div class="freelancer-content">
                        <h3>{{ $freelancer->display_name }}</h3>
                        <div class="text-center mb-1">
                            @if ($freelancer->rate)
                                <span class="primary">{{ number_format($freelancer->rate, 1) }}</span>
                                @for ($i = 0; $i < round($freelancer->rate); $i++)
                                    <i class="fas fa-star"
                                        style="color: #04bbff !important; font-size: 12px;"
                                        aria-hidden="true"></i>
                                @endfor
                                @for ($i = 0; $i < 5 - $freelancer->rate; $i++)
                                    <i class="far fa-star"
                                    style="color: #04bbff !important; font-size: 12px;"
                                    aria-hidden="true"></i>
                                @endfor
                            @else
                                <span class="primary">{{ number_format($freelancer->rate, 1) }}</span>
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="far fa-star" style="color: #04bbff !important; font-size: 12px;" aria-hidden="true"></i>
                                @endfor
                            @endif
                        </div>
                        <ul class="text-center">
                            @forelse($freelancer->skills as $key => $skill)
                                    <li class="badge badge-warning p-50 font-weight-normal "
                                        style="background: #004E88 !important;">
                                        {{ $skill->skill->skill_name }}</li>
                                    @if ($key === 1)
                                        <li class="badge badge-warning p-50 my-50 font-weight-normal"
                                        style="background: #004E88 !important;">{{ ($freelancer->skills->count() - 2 > 0 ? '+ ' . ($freelancer->skills->count() - 2) : null) }}</li>
                                    @break
                                @endif
                            @empty
                                <li class="badge p-50 my-50 font-weight-normal border-primary"
                                    style="background: none !important; color: #000;">No Skills
                                    Found</li>
                            @endforelse
                        </ul>
                        <div class="text-center font-weight-bold">Distance : {{ number_format($freelancer->distance, 2)}} km</div>
                    </div>
                    <div class="p-1 rounded">
                        <a href="/employer/offer/create_offer/{{ $freelancer->display_name }}"
                            class="btn btn-primary btn-block">Send
                            Offer </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="../../../images/illustrations/no-data.png" alt="" class="" style="width: 200px !important;">
                <h2>No Freelancers Found</h2>
            </div>
        </div>
    </div>
</div>
@endforelse
</div>

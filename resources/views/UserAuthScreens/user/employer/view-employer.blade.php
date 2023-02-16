@extends('layout.layout')

@section('title')
    {{ $employer->display_name }}
@endsection

@section('content')
@if(Session::get('success'))
	@push('scripts')
		<script>
			toastr.success('{{ Session::get("success") }}', 'Success');
		</script>
	@endpush
@endif

@if(Session::get('fail'))
	@push('scripts')
		<script>
			toastr.error('{{ Session::get("fail") }}', 'Fail');
		</script>
	@endpush
@endif

    <section class="fr-hero-theme">
        @if($employer->user->cover_image)
            <img width="100%" height="250" style="object-fit: cover; object-position: center;" src="../../../images/user/cover/{{ $employer->user->cover_image }}" alt="">
        @else
            <img width="100%" height="250" style="object-fit: cover; object-position: center;" src="../../../images/bg-image/default-cover.png" alt="">
        @endif
	</section>
    <section class="fr-expert">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-xs-12 col-sm-12 col-md-12"> </div>
                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-7">
                        <div class="fr-expert-details">
                            <h1 class="text-white">{{ $employer->display_name }}</h1>
                            <p class="text-white"><i class="fas fa-map-marker-alt"></i>{{ $employer->address }}</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-5 col-sm-5 align-self-center">
                        @if(session()->get('role') == 'freelancer')
                            <div class="fr-expert-content">
                                <a href="/freelancer/follow_employer/{{ $employer->id }}" class="btn btn-danger follow-employer" data-emp-id="804"><i class="fa fa-heart"></i> {{ $follow_employer ? 'Unfollow' : 'Follow' }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
    <section class="fr-c-information padding-bottom-80 actionbar_space">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xl-4 col-md-12 col-xs-12 col-sm-12">
                    <div class="fr-c-details">
                        <div class="fr-c-detail-box">
                        <div class="fl-profile-img">
                            @if($employer->user->profile_image)
								<img src="../../../images/user/profile/{{ $employer->user->profile_image }}" alt="" class="img-fluid">
							@else
							    <img src="../../../images/user-profile.png" alt="" class="img-fluid">
							@endif
                        </div>
                        <p><i class="fa fa-check protip" data-pt-position="top" data-pt-scheme="black" data-pt-title=" Verified" aria-hidden="true"></i>{{ $employer->display_name }}</p>
                        <p>{{ $employer->tagline }}</p>
                    </div>
                        <div class="fr-c-followers">
                        <ul>
                            <li>
                                <div class="fr-c-more-details">
                                    <span>{{ count($employer->projects) < 10 ? 0 . count($employer->projects) : count($employer->projects) }}</span>
                                    <p> Projects</p>
                                </div>
                            </li>
                            <li class="fr-style-3">
                                <div class="fr-c-more-details">
                                    <span>00</span>
                                    <p>Followers</p>
                                </div>
                            </li>
                        </ul>
                        </div>
                        <div class="fr-ca-more-details">
                        <ul>
                            <li>
                                <div class="fr-c-full-details">
                                    <span>Member Since</span>
                                    <p>{{ date_format(new DateTime($employer->created_at), "F d, Y")}}</p>
                                </div>
                            </li>
                        </ul>
                        </div>
                        <div class="fr-c-social-icons">
                        <ul>
                            <li> <a href="{{ $employer->facebook_url }}" target="_blank"><i class="feather icon-facebook"></i></a> </li>
                            <li> <a href="{{ $employer->twitter_url }}" target="_blank"><i class="feather icon-twitter"></i></a> </li>
                            <li> <a href="{{ $employer->linkedin_url }}" target="_blank"><i class="feather icon-linkedin"></i></a> </li>
                        </ul>
                        </div>
                    </div>
                    <p class="report-button text-center"> <a href="#" data-bs-toggle="modal" data-bs-target="#report-modal"><i class="fas fa-exclamation-triangle"></i>Report Employer</a></p>
                    <div class="fr-lance-banner">
                    </div>
                </div>
                <div class="col-lg-8 col-xl-8 col-md-12 col-xs-12 col-sm-12">
                    <div class="fr-product-des-box heading-contents custom-class">
                        <h3>Employer Summary</h3>
                        {{ $employer->description }}
                    </div>
                    <h6>Completed Projects</h6>
                    @forelse($completed_projects as $completed_project)
                        <div class="posted-projects">
                            <div class="fr-right-detail-box">
                            <div class="fr-right-detail-content">
                                <div class="fr-right-details-products">
                                    <div class="fr-jobs-price">
                                        <div class="style-hd">₱ {{ number_format($completed_project->cost, 2) }}</div>
                                        <p class="price_type protip" data-pt-title="For 80 hours total will be  $1,600.00" data-pt-position="top" data-pt-scheme="black">Hourly  <i class="far fa-question-circle"></i></p>
                                    </div>
                                    <div class="fr-right-details2">
                                        <a href="/projects/{{ $completed_project->id }}/{{ $completed_project->title }}">
                                        <h3>{{ $completed_project->title }}</h3>
                                        </a>
                                    </div>
                                    <div class="fr-right-product">
                                        <ul class="skills">
                                            <!-- convert the json array ids into model and get to fetch in blade -->

                                        <!-- <li class="hide"><a href="#">Support Agent</a></li>
                                        <li class="hide"><a href="#">Support Agent</a></li>
                                        <li class="hide"><a href="#">Support Agent</a></li> -->
                                        <!-- <li class="show-skills"><a href="#"><i class="fas fa-ellipsis-h" aria-hidden="true"></i></a></li> -->
                                        </ul>
                                    </div>
                                    <div class="fr-right-index">
                                        <div>{{ substr($completed_project->description, 0, 200) }}...</div>
                                    </div>
                                </div>
                            </div>
                            <div class="fr-right-information">
                                <div class="fr-right-list">
                                    <ul>
                                        <li>
                                        <p class="heading">Level: </p>
                                            <span>
                                                {{ $completed_project->project_level }}
                                            </span>
                                        </li>
                                        <li>
                                        <p class="heading">Location: </p>
                                            <span>
                                                {{ $completed_project->location }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="fr-right-bid">
                                    <ul>
                                        <li><a href="/projects/{{ $completed_project->id }}/{{ $completed_project->title }}" class="btn btn-theme">View Detail</a></li>
                                    </ul>
                                </div>
                            </div>
                            </div>
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-content-center">
                                No Featured Projects Found
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection

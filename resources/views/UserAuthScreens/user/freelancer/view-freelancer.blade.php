@extends('layout.layout')

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

<section class="fr-hero-theme add-bg-img">
	@if($freelancer->user->cover_image)
		<img width="100%" height="250" style="object-fit: cover; object-position: center;" src="../../../images/user/cover/{{ $freelancer->user->cover_image }}" alt="">
	@else
		<img width="100%" height="250" style="object-fit: cover; object-position: center;" src="../../../images/bg-image/default-cover.png" alt="">
	@endif
</section>
		<section class="fr-hero-detail style-1">
		   <div class="container">
		      <div class="row custom-product">
		         <div class="col-lg-9 col-xl-9 col-xs-12 col-md-9 col-sm-12">
		            <div class="fr-hero-details-content">
		               <div class="fr-hero-details-products">
							@if($freelancer->user->profile_image)
								<img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" alt="" class="img-fluid">
							@else
							<img src="../../../images/user-profile.png" alt="" class="img-fluid">
							@endif

						</div>
		               <div class="fr-hero-details-information">
		                  <span class="title"><i class="fa fa-check add-weight"></i>{{ $freelancer->display_name }}</span>
		                  <h1 class="name">{{ $freelancer->tagline }}</h1>
		                  <div class="fr-hero-m-deails">
		                     <ul>
		                        <li> <span> Member since {{ date_format(new DateTime($freelancer->created_at), "F d, Y") }}</span> </li>
		                        <li>
                                    <span class="primary mr-25">{{ number_format($freelancer->rate, 1) }}</span>
                                    @for ($i = 0; $i < round($freelancer->rate); $i++)
                                        <i class="fas fa-star" style="color: #04bbff !important;" aria-hidden="true"></i>
                                    @endfor
                                </li>
		                     </ul>
		                  </div>
		               </div>
		            </div>
		         </div>
		         <div class="col-lg-3 col-xl-3 col-xs-12 col-md-3 col-sm-12">
		            <div class="fr-hero-hire">
		               <div class="fr-hero-short-list">
		                    <p><span class="currency">₱ </span>
                                <span class="price">{{ number_format($freelancer->hourly_rate, 2) }}</span>
                            </p>
		                  <span class="type">(per hour)</span>
		               </div>
		               <div class="fr-hero-short-list-2">
		                  <div class="fr-hero-hire-content">
                            @if(session()->get('role') == 'employer')
                                <a href="/follow_freelancer/view/{{ $freelancer->id }}" class="follow-freelancer protip" data-fid="171" data-pt-position="top" data-pt-scheme="black" data-pt-title="Follow Freelancer">
                                    <i class="{{ $follow_freelancer ? 'fa' : 'far' }} fa-heart text-danger"></i>
                                </a>
								<a href="/employer/offer/create_offer/{{$freelancer->display_name}}" class="btn btn-primary">
									Hire Now
								</a>
							 @endif
		                  </div>
		               </div>
		            </div>
		         </div>
		      </div>
		      <div class="row">
		         <div class="col-lg-12 col-xl-12 col-xs-12 col-md-12 col-sm-12">
		            <div class="fr-hero-m-jobs-bottom">
		               <ul>
		                  <li> <span><small>{{ count($active_services) }}</small> Active Services</span> </li>
		                  <li> <span><small>{{ $freelancer->projects_completed()->count() }}</small> Completed Projects</span> </li>
		                  <li> <span><small>0</small> Completed Services</span> </li>
		                  <li> <span><small>{{ $freelancer->total_reviews }}</small> {{ $freelancer->total_reviews > 1 ? 'Reviews' : 'Review' }}</span> </li>
		               </ul>
		            </div>
		         </div>
		      </div>
		   </div>
		</section>
		{{-- <section class="fr-services-content-2">
		   <div class="container">
		      <div class="row">
		         <div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
		            <div class="fr-top-services fr-bg-white-2">
						<div class="heading-contents">
							<h3>Featured Services </h3>
						</div>
						<div class="row">
							@forelse($featured_services as $service)
								@php
									$images = json_decode($service->attachments)
								@endphp
								<div class="col-md-4">
									<a href="/service/{{ $service->id }}">
										<div class="badge badge-info p-2 text-uppercase position-relative" style="margin-bottom: -200px; z-index: 10;"></div>
										<div class="fr-top-contents bg-white-color">
										   <div class="fr-top-product">
											  <img height="250" width="100%" style="object-fit: cover;" src="../../../images/services/{{ $images[0] }}" alt="" class="img-responsive">
											  <div class="fr-top-rating"> <a href="" class="save_service protip" data-fid="171" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="355"><i class="fa fa-heart text-danger" aria-hidden="true"></i></a> </div>
											  @if($service->type == 'featured')
												 <div class="fr-top-right-rating">Featured</div>
											  @endif
										   </div>
										   <div class="fr-top-details">
											  <span class="rating"> <i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
											  <a href="/service/{{ $service->id }}" title="We’ll create graphic for 3d unity game with all component">
											  <div class="fr-style-5">{{ substr($service->name, 0, 20) . '...' }}</div>
											  </a>
											  <p>Starting From<span class="style-6"><span class="currency">₱ </span><span class="price">{{ number_format($service->cost, 2) }}</span></span></p>
											  <div class="fr-top-grid"> <a href="freelancer-detail.html"><img src="img/freelancers-imgs/deo-profile.jpg" alt="" class="img-fluid"></a></div>
										   </div>
										</div>
									 </a>
								</div>
							@empty

							@endforelse
						</div>
		            </div>
		         </div>
		      </div>
		   </div>
		</section> --}}
		<section class="fr-product-description padding-bottom-80">
		   <div class="container">
		      <div class="row">
		         <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
		            <!-- <div class="fl-advert-box">
		               <a href="index.html"><img src="img/top-trending-imgs/exertio-elementor.jpg" alt="exertio theme" class="img-fluid"></a>
		            </div> -->
		            <div class="main-box fr-product-des-box">
		               <div class="">
		                  <div class="heading-contents">
		                     <h3>Description</h3>
		                  </div>
		                  {{ $freelancer->description }}
		               </div>
		            </div>
		            <div class="main-box">
		               <div class="heading-contents">
		                  <h3>Recent Projects</h3>
		               </div>
		               <div class="fr-recent-model">
		                  <ul>
                            @forelse ($freelancer->projects as $project)
                                <li>
                                    <div class="fancy-model">
                                    <a data-fancybox="portfolio" href="{{ $project->project_url }}" data-caption="" data-wheel="false">
                                        <img class="img-fluid" src="../../../images/freelancer_projects/{{ $project->project_image }}" alt="">
                                    </a>
                                    </div>
                                    <div class="figcaption">
                                    <h6><a href="{{ $project->project_url }}" target="_blank">{{ $project->project_name }}</a></h6>
                                    </div>
                                </li>
                            @empty
                            <div class="heading-contents">
                                <h3 class="text-center">No Projects Found</h3>
                            </div>
                            @endforelse
		                  </ul>
		               </div>
		            </div>
		            <div class="main-box">
		               <div class="heading-contents">
		                  <h3>Experience</h3>
		               </div>
		               <div class="fr-expertise-content">
							@forelse($freelancer->experiences as $experience)
								<div class="fr-expertise-product">
									<div class="fr-expertise-product2"> <i class="fas fa-long-arrow-alt-right"></i> </div>
									<div class="fr-expertise-details">
										<h4>{{ $experience->experience_title }}</h4>
										<ul class="experties-meta">
										<li><span> {{ $experience->company_name }}</span> </li>
										<li>
											<span>
											{{ date_format(new DateTime($experience->start_date), "F d, Y") }} - {{ !$experience->end_date ? 'Current' : date_format(new DateTime($experience->start_date), "F d, Y") }}</span>
										</li>
										</ul>
										<p>
											{{ $experience->description }}
										</p>
									</div>
								</div>
							@empty
								<div class="heading-contents">
									<h3 class="text-center">No Experience Found</h3>
								</div>
							@endforelse

		               </div>
		            </div>
		            <div class="main-box">
                        <div class="heading-contents">
                            <h3>Educational Details</h3>
                        </div>
                        <div class="fr-expertise-content">
                            @forelse($freelancer->educations as $education)
                                <div class="fr-expertise-product">
                                    <div class="fr-expertise-product2"> <i class="fas fa-long-arrow-alt-right"></i> </div>
                                    <div class="fr-expertise-details">
                                        <h4>{{ $education->education_title }}</h4>
                                        <ul class="experties-meta">
                                        <li><span> {{ $education->institute_name }}</span> </li>
                                        <li>
                                            <span>
                                            {{ date_format(new DateTime($education->start_date), "F d, Y") }} - {{ !$education->end_date ? 'Current' : date_format(new DateTime($education->start_date), "F d, Y") }}</span>
                                        </li>
                                        </ul>
                                        <p>
                                            {{ $education->description }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="heading-contents">
                                    <h3 class="text-center">No Education Found</h3>
                                </div>
                            @endforelse
                        </div>
		            </div>
                    <div class="main-box">
                        <div class="heading-contents">
                            <h3>Reviews</h3>
                         </div>
                         <div class="fr-expertise-content">
                            @forelse($reviews as $review)
                                <div class="fr-expertise-product">
                                    <div class="fr-expertise-details">
                                        <h4 style="margin: 0 !important;">{{ $review->reviewer->user->firstname . ' ' . $review->reviewer->user->lastname }}</h4>
                                        <div>
                                            <span>
                                                @for ($i = 0; $i < $review->freelancer_rate; $i++)
                                                    <i class="fas fa-star" style="color: #04bbff !important; font-size: 8px;" aria-hidden="true"></i>
                                                @endfor
                                            </span>
                                        </div>
                                        <ul class="">
                                            <li>
                                                <span></span>
                                            </li>
                                        </ul>
                                        <p>
                                            {{ $review->review }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="heading-contents">
                                    <h3 class="text-center">No Education Found</h3>
                                </div>
                            @endforelse
                        </div>
                    </div>
		            <div class="fl-advert-box">
		               <a href="/"><img class="brand-text" alt="stack admin logo" src="../../../images/logo/main-logo.png" style="width: 140px;"></a>
		            </div>
		         </div>
		         <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
		            <div class="freelance-sidebar">
		               <div class="fr-product-progress sidebar-box">
		                  <a href="/"><img class="brand-text" alt="stack admin logo" src="../../../images/logo/main-logo.png" style="width: 140px;"></a>
		               </div>
		               <div class="fr-recent-certification sidebar-box">
		                  <div class="sidebar-heading">
		                     <h3>Awards and Certificates</h3>
		                  </div>
		                  <ul>
							@forelse($freelancer->certificates as $certificate)
								<li>
									<div class="fr-recent-us-profile"><a target="_blank" data-fancybox="awards" href="../../../images/freelancer_certificates/{{ $certificate->certificate_image }}">  <img src="../../../images/freelancer_certificates/{{ $certificate->certificate_image }}" alt="" class="img-fluid"></a> </div>
									<div class="fr-recent-us-skills">
									<p>{{ $certificate->certificate }}</p>
									<span>{{ date_format(new DateTime($certificate->certificate_date), "F d, Y")}}</span>
									</div>
								</li>
							@empty
								<div class="heading-contents">
									<div class="text-center">No Awards/Certificates Found</div>
								</div>
							@endforelse
		                  </ul>
		               </div>
		               <div class="fr-product-progress sidebar-box">
						   <div class="sidebar-heading">
						      <h3>My Skills</h3>
						   </div>
						   <ul>
								@forelse($freelancer->skills as $skill)
									<li>
										<div class="fr-product-progress-content">
											<p>{{ $skill->skill->skill_name }}</p>
											<span>{{ $skill->skill_percentage }}%</span>
										</div>
										<div class="progress">
											<div class="progress-bar bg-primary" style="width: {{$skill->skill_percentage}}% !important;" role="progressbar" aria-valuenow="{{ $skill->skill_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</li>
								@empty

								@endforelse
						   </ul>
					   </div>
		               <div class="fr-recent-employers sidebar-box">
		                  <div class="sidebar-heading">
		                     <h3>About Me</h3>
		                  </div>
		                  <ul>
							 <li>
		                        <i class="fas fa-location-arrow"></i>
		                        <div class="meta">
		                           <span>Location</span>
		                           <p>{{ $freelancer->address }}</p>
		                        </div>
		                     </li>
							 {{-- <li>
		                        <i class="fas fa-phone"></i>
		                        <div class="meta">
		                           <span>Contact No.</span>
		                           <p>{{$freelancer->contactno}}</p>
		                        </div>
		                     </li> --}}
		                  </ul>
		               </div>
		               <div class="fr-product-progress sidebar-box">
		                  <a href="/"><img class="brand-text" alt="stack admin logo" src="../../../images/logo/main-logo.png" style="width: 140px;"></a>
		               </div>
		            </div>
		            <p class="report-button text-center"> <a href="#" data-bs-toggle="modal" data-bs-target="#report-modal"><i class="fas fa-exclamation-triangle"></i>Report Freelancer</a></p>
		         </div>
		      </div>
		   </div>
		</section>
@endsection

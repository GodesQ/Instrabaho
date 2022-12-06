@extends('layout.layout')

@section('content')
@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', "Login");
        </script>
    @endpush
@endif
<div
    id="exertio-carousal"
    class="carousel slide carousel-fade pointer-event"
    data-bs-ride="carousel"
>
    <ol class="carousel-indicators">
        <li
            data-bs-target="#carouselExampleControls"
            data-bs-slide-to="0"
            class=""
        ></li>
        <li
            data-bs-target="#carouselExampleControls"
            data-bs-slide-to="1"
            class="active"
        ></li>
        <li
            data-bs-target="#carouselExampleControls"
            data-bs-slide-to="2"
            class=""
        ></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img
                class="d-block w-100"
                src="../../../images/slider/Instrabaho_Slider_01_WEB15.png"
                alt="1558"
            />
        </div>
        <div class="carousel-item">
            <img
                class="d-block w-100"
                src="../../../images/slider/Instrabaho_Slider_01_WEB16.png"
                alt="1558"
            />
        </div>
        <div class="carousel-item">
            <img
                class="d-block w-100"
                src="../../../images/slider/Instrabaho_Slider_01_WEB17.png"
                alt="1558"
            />
        </div>
    </div>
    <div class="fr-hero3 hero-slider logoslider" style="z-index: 2;">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-xs-12 col-sm-12 col-lg-8 col-md-12">
                    <div class="fr-hero3-main">
                        <div class="fr-hero3-content">
                            <span>Get Started</span>
                            <h1>Trabaho o trabahador?
                                Boss, anong hanap mo?</h1>
                            <p>
                                Instrabaho is a community where you can post a project if you are an employer or you may post service if you are a freelancer.
                                This initiative is to help people who lose their job during the time of the pandemic.
                            </p>
                        </div>
                        <div class="fr-hero3-srch">
                            {{-- <form
                                class="hero-one-form"
                                action="search-page.html"
                            >
                                <ul>
                                    <li>
                                        <div class="form-group">
                                            <input
                                                type="text"
                                                placeholder="What are you look for"
                                                class="form-control"
                                                name="titl"
                                            />
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <select
                                                class="default-select post-type-change"
                                            >
                                                <option value="Choose category">
                                                    Choose category
                                                </option>
                                                <option value="Projects">
                                                    Projects
                                                </option>
                                                <option value="Services">
                                                    Services
                                                </option>
                                                <option value="Employers">
                                                    Employers
                                                </option>
                                                <option value="Freelancer">
                                                    Freelancer
                                                </option>
                                            </select>
                                            <div class="fr-hero3-submit">
                                                <button class="btn btn-theme">
                                                    <i
                                                        class="fas fa-search-plus"
                                                    ></i
                                                    >Search
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </form> --}}
                        </div>
                        {{-- <div class="fr-her3-elemnt">
                            Trending Keywords:
                            <a href="search-page.html">React Native</a>
                            <a href="search-page.html">Flutter</a>
                            <a href="search-page.html">Plumber</a>
                            <a href="search-page.html">Artist</a>
                            <a href="search-page.html">Singer</a>
                            <a href="search-page.html">Writer</a>
                        </div> --}}
                        <div class="fr-hero3-video">
                            <a
                                href="https://www.youtube.com/watch?v=C0DPdy98e4c"
                                target="_blank"
                                rel="nofollow"
                                class="popup-video"
                                ><i class="fas fa-play-circle"></i
                            ></a>
                            <div class="fr-hero3-text">
                                <span>Watch Demo</span>
                                <p>Get started in minutes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="fr-serv-2 fr-services-content-2">
    <div class="container">
       <div class="row fr-serv2">
          <div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
             <div class="heading-panel  section-center">
                <div class="heading-meta">
                   <h2>Boss! Kailangan mo ng tulong?</h2>
                   <p>Recent Posted Projects</p>
                </div>
             </div>
            <div class="row">
                @forelse ($projects as $project)
                    <div class="col-xl-6 col-lg-6">
                        <div class="fr-project-details bg-white">
                            <div class="d-flex justify-content-between align-items-start border-bottom p-3" style="height: 185px;">
                                <div style="width: 14%">
                                    <img class="" src="../../../images/user/profile/{{ $project->employer->user->profile_image }}" alt="profile image" style="width: 80px; height: 80px; border-radius: 50%;">
                                </div>
                                <div style="width: 70%" class="fr-project-content">
                                    <div class="fr-project-f-des" style="background: transparent !important; padding: 0 !important;">
                                        <h6>
                                            <a href="/project/view/{{ $project->id }}" style="color: black; font-weight: 500;">{{ $project->title }}</a>
                                        </h6>
                                        <div style="color: #000;">{{ $project->employer->display_name }}</div>
                                        <div>{{ $project->location }}</div>
                                        <div class="my-2">
                                            <div class="font-weight-medium"><i class="feather icon-target success"></i> Actively Looking for</div>
                                            <ul class="fr-project-skills" style="margin-top: 10px;">

                                                <!-- convert the json array ids into model and get to fetch in blade -->
                                                @php $project->setSkills(json_decode($project->skills)) @endphp
                                                @php $project->getSkills() @endphp

                                                @foreach($project->skills_name as $skill)
                                                    <li class=""><a href="#">{{ $skill->skill_name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary " style="border-radius: 25px;">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
          </div>
       </div>
    </div>
 </section>
 <div class="section-padding-extra text-center call-actionz">
    <div class="container">
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="parallex-text">
                 <h5>Since the Start </h5>
                 <h4>We Provide Stable Service With Experts</h4>
                 <p>Freelancers around the globe, are looking for work and provide the best they have. Start now </p>
                 <a href="/search_projects" class="btn btn-theme-secondary">View Projects</a>
                 <a href="/search_services" class="btn btn-theme">View Services</a>
              </div>
           </div>
        </div>
    </div>
</div>
<section class="fr-serv-2 fr-services-content-2">
    <div class="container">
       <div class="row fr-serv2">
          <div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
             <div class="heading-panel  section-center">
                <div class="heading-meta">
                   <h2>TOP RATED SKILLED WORKERS <br> NEAR YOU</h2>
                   <p>Work with skilled people at the most affordable price to get your job done</p>
                </div>
             </div>
             <div class="row grid">
               @forelse($freelancers as $freelancer)
                  <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                     <div class="fr-latest-grid">
                        <div class="fr-latest-img d-flex justify-content-center">
                           <img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" class="rounded" alt="" style="width: 130px; height: 130px; object-fit: cover; border-radius: 50% !important;">
                        </div>
                        <div class="fr-latest-details">
                           <div class="fr-latest-content-service">
                              <div class="fr-latest-profile">
                                 <a class="user-image" href="/freelancer/view/{{ $freelancer->user_id }}"><img src="img/services-imgs/eshal-dp.jpg" alt="" class="img-fluid"></a>
                                 <div class=" text-center">
                                    <span class="fr-latest-name">{{ $freelancer->tagline }}</span>
                                    <h4>
                                       <a href="/freelancer/view/{{ $freelancer->user_id }}" class="h4">{{ $freelancer->display_name }}</a>
                                    </h4>
                                 </div>
                              </div>
                              <div class="d-flex justify-content-between align-items-center">
                                 <div>Starting from : <span class="info">₱ {{ number_format($freelancer->hourly_rate, 2) }}</span></div>
                                 <div class="text-right">Reviews : 20</div>
                              </div>
                           </div>
                           <div class="mt-3 p-1 px-2 d-flex justify-content-around align-items-center flex-column" style="background: #f8f8f8 !important; height: 200px;">
                              <p class="text-center">{{ strlen($freelancer->description) > 100 ? substr($freelancer->description, 0, 100) . '...' : $freelancer->description }}</p>
                              <div class="group-buttons">
                                 <a href="/freelancer/view/{{ $freelancer->user_id}}" class="btn btn-outline-primary" style="width: 100% !important">View Profile</a>
                                 <button class="btn btn-primary mt-2" style="width: 100% !important">Send Offer</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               @empty

               @endforelse
            </div>
         </div>
       </div>
    </div>
 </section>
@endsection

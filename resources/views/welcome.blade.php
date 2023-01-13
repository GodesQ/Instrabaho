@extends('layout.layout')

@section('content')
@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', "Login");
        </script>
    @endpush
@endif

<style>
    .btn-home {
        border: 1px solid #04bbff;
        background-image: linear-gradient(to right, #04bbff 11%, #08303e81 89%) !important;
        padding: 1rem 1.3rem;
        font-weight: 800;
        color: #fff;
        font-size: 20px;
        border-radius: 10px;
    }
    .btn-home:hover {
        color: #fff;
        transition: 0.5s;
        background: #04bbff;
    }

    .second-span {
            font-size: 15px;
            font-weight: 400;
        }

    @media (max-width: 567px) {
        .btn-home {
            border: 1px solid #04bbff;
            background-image: linear-gradient(to right, #04bbff 21%, #08303e81 79%) !important;
            padding: 1rem 1.3rem;
            font-weight: 800;
            color: #fff;
            font-size: 15px;
            border-radius: 10px;
        }
        .second-span {
            font-size: 10px;
            font-weight: 400;
        }
    }
</style>
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
                src="../../../images/slider/Instrabaho_Slider_01_WEB18.png"
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
                        <a href="/project/view/{{ $project->id }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start px-3 py-4">
                                        <div style="width: 14%">
                                            <img class="" src="../../../images/user/profile/{{ $project->employer->user->profile_image }}" alt="profile image" style="width: 80px; height: 80px; border-radius: 50%;">
                                        </div>
                                        <div style="width: 80%" class="fr-project-content">
                                            <div class="fr-project-f-des" style="background: transparent !important; padding: 0 !important;">
                                                <h6>
                                                    <a href="/project/view/{{ $project->id }}" style="color: black; font-weight: 500;">{{ $project->title }}</a>
                                                </h6>
                                                <div style="color: #000;">{{ $project->employer->user->firstname . ' ' . $project->employer->user->lastname }}</div>
                                                <div>{{ $project->location }}</div>
                                                {{-- <div class="my-2">
                                                    {{-- <div class="font-weight-medium"><i class="feather icon-target success"></i> Actively Looking for</div> --}}
                                                    {{-- <ul class="fr-project-skills" style="margin-top: 10px;">

                                                        <!-- convert the json array ids into model and get to fetch in blade -->
                                                        @php $project->setSkills(json_decode($project->skills)) @endphp
                                                        @php $project->getSkills() @endphp

                                                        @foreach($project->skills_name as $skill)
                                                            <li class=""><a href="#">{{ $skill->skill_name }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div> --}}
                                                <div class="my-1 mt-3">
                                                    <a href="/project/view/{{ $project->id }}" class="primary mx-2">View Project</a>
                                                    <a href="/project/view/{{ $project->id }}#fr-bid-form" class="btn btn-primary">Send Proposal</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
 </section>
 <div class="section-padding-extra text-center call-actionz">
    <div class="container">
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="parallex-text text-left">
                 <h5>Since the Start </h5>
                 <h4 class="font-weight-bold">We Provide <br> Stable Service <br> With Skilled Workers</h4>
                 <p>Skilled Workers around the Philippines, are looking for work and provide the <br> best they have. Start now </p>
                 <div class="d-flex justify-content-start px-2 gap-2">
                    <a href="/search_projects" class="btn-home d-flex justify-content-center flex-column" style="font-weight: 500 !important;">
                        <span>Explore Projects</span>
                        <span class="second-span">
                            View Projects Catalog <i class="fa fa-arrow-right ml-xl-1"></i>
                        </span>
                    </a>
                     <a href="/search_services" class="btn-home d-flex justify-content-center flex-column" style="font-weight: 500 !important;">
                        <span>Explore Services</span>
                        <span class="second-span">
                            View Services Catalog <i class="fa fa-arrow-right ml-xl-1"></i>
                        </span>
                    </a>
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
                   <h2>TOP RATED SKILLED WORKERS</h2>
                   <p>Work with skilled people at the most affordable price to get your job done</p>
                </div>
             </div>
             <div class="row grid">
               @forelse($freelancers as $freelancer)
                  <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                     <div class="fr-latest-grid">
                        <div class="fr-latest-img d-flex justify-content-center">
                            @if ($freelancer->user->profile_image)
                                <img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" class="rounded" alt="" style="width: 130px; height: 130px; object-fit: cover; border-radius: 50% !important;">
                            @else
                                <img src="../../../images/user-profile.png" alt="" style="width: 130px; height: 130px; object-fit: cover; border-radius: 50% !important;">
                            @endif
                        </div>
                        <div class="fr-latest-details">
                           <div class="fr-latest-content-service">
                              <div class="fr-latest-profile">
                                 <a class="user-image" href="/freelancers/{{ $freelancer->user->username }}"><img src="img/services-imgs/eshal-dp.jpg" alt="" class="img-fluid"></a>
                                 <div class=" text-center">
                                    {{-- <span class="fr-latest-name">{{ $freelancer->tagline }}</span> --}}
                                    <h5>
                                       <a href="/freelancers/{{ $freelancer->user->username }}" class="h5">{{ $freelancer->user->firstname . ' ' . $freelancer->user->lastname }}</a>
                                    </h5>
                                 </div>
                              </div>
                              <div class="d-flex justify-content-between align-items-center">
                                 <div>Starting from : <span class="info">₱ {{ number_format($freelancer->hourly_rate, 2) }}</span></div>
                                 <div class="text-right">Reviews : 20</div>
                              </div>
                           </div>
                           <div class="mt-3 p-1 d-flex justify-content-around align-items-center flex-column" style="background: #f8f8f8 !important; height: 200px;">
                              <p class="text-center">{{ strlen($freelancer->description) > 100 ? substr($freelancer->description, 0, 100) . '...' : $freelancer->description }}</p>
                              <div class="container-fluid">
                                    <a href="/freelancers/{{ $freelancer->user->username }}" class="btn btn-outline-primary" style="width: 100% !important;">My Profile</a>
                                    <button class="btn btn-primary mt-2" style="width: 100% !important;">Send Offer</button>
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

 {{-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
 <script>
     // Enable pusher logging - don't include this in production
     Pusher.logToConsole = true;
    let backendBaseUrl = "http://127.0.0.1:8000";

    var pusher = new Pusher('0a303fc13dbe529739fa', {
        cluster: 'ap1',
    });

    var channel = pusher.subscribe('project-chats');

    channel.bind('new-project-chats', function(data) {
        console.log(JSON.parse(data.data));
    });

    channel.bind('pusher:subscription_succeeded', function(members) {
        alert('successfully subscribed!');
    });

    channel.bind('pusher:subscription_error', function(data) {
        console.log(data);
    });

 </script> --}}
@endsection

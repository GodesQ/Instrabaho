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
                   <h2>Most Hired Freelancers</h2>
                   <p>Work with talented people at the most affordable price to get your job done</p>
                </div>
             </div>
             <div class="row grid">
               @forelse($freelancers as $freelancer)
                  <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                     <div class="fr-latest-grid">
                        <div class="fr-latest-img d-flex justify-content-center">
                           <img src="../../../images/user/profile/{{ $freelancer->freelancer->user->profile_image }}" class="rounded" alt="" style="width: 100%; height: 200px; object-fit: cover;">
                        </div>
                        <div class="fr-latest-details">
                           <div class="fr-latest-content-service">
                              <div class="fr-latest-profile">
                                 <a class="user-image" href="/freelancer/view/{{ $freelancer->freelancer->user_id }}"><img src="img/services-imgs/eshal-dp.jpg" alt="" class="img-fluid"></a>
                                 <div class="fr-latest-profile-data">
                                    <span class="fr-latest-name"><a href="/freelancer/view/{{ $freelancer->freelancer->user_id }}">{{ $freelancer->freelancer->display_name }}</a></span>
                                 </div>
                              </div>
                              <p><a href="/freelancer/view/{{ $freelancer->freelancer->user_id }}">{{ substr($freelancer->freelancer->description, 0, 50) . '...' }}</a></p>
                              <span class="reviews"><i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                           </div>
                           <div class="fr-latest-bottom">
                              <p>Starting From<span><span class="currency">₱</span><span class="price">{{ number_format($freelancer->freelancer->hourly_rate, 2) }}</span></span></p>
                              <a href="/freelancer/view/{{ $freelancer->freelancer->user_id }}" class="save_service protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Follow Freelancer" data-post-id="182"><i class="fa fa-heart" aria-hidden="true"></i></a>
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
                   <h2>Boss! Kailangan mo ng tulong?</h2>
                   <p>Most viewed and top rated services</p>
                </div>
             </div>
             <div class="row grid">
                <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                   <div class="fr-latest-grid">
                      <div class="fr-latest-img">
                         <img src="img/services-imgs/link-building.jpg" alt="" class="img-fluid">
                      </div>
                      <div class="fr-latest-details">
                         <div class="fr-latest-content-service">
                            <div class="fr-latest-profile">
                               <a class="user-image" href="freelancer-detail.html"><img src="img/services-imgs/eshal-dp.jpg" alt="" class="img-fluid"></a>
                               <div class="fr-latest-profile-data">
                                  <span class="fr-latest-name"><a href="freelancer-detail.html">Eshaal Mehta<i class="fa fa-check verified protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Verified" aria-hidden="true"></i> </a></span>
                               </div>
                            </div>
                            <p><a href="services-details-page.html">Website link building and trafic generat....</a></p>
                            <a href="javascript:void(0)" class="queue">0 Order in queue</a>
                            <span class="reviews"><i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                         </div>
                         <div class="fr-latest-bottom">
                            <p>Starting From<span><span class="currency">$</span><span class="price">300.00</span></span></p>
                            <a href="services-details-page.html" class="save_service protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="182"><i class="fa fa-heart" aria-hidden="true"></i></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                   <div class="fr-latest-grid">
                      <div class="fr-latest-img">
                         <img src="img/services-imgs/link-service.jpg" alt="" class="img-fluid">
                      </div>
                      <div class="fr-latest-details">
                         <div class="fr-latest-content-service">
                            <div class="fr-latest-profile">
                               <a class="user-image" href="freelancer-detail.html"><img src="img/services-imgs/eshal-dp.jpg" alt="" class="img-fluid"></a>
                               <div class="fr-latest-profile-data">
                                  <span class="fr-latest-name"><a href="freelancer-detail.html">Eshaal Mehta<i class="fa fa-check verified protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Verified" aria-hidden="true"></i> </a></span>
                               </div>
                            </div>
                            <p><a href="services-details-page.html" title="Generate Leads and Social Media Marketing">Generate Leads and Social Media Marketin....</a></p>
                            <a href="javascript:void(0)" class="queue">0 Order in queue</a>
                            <span class="reviews"><i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                         </div>
                         <div class="fr-latest-bottom">
                            <p>Starting From<span><span class="currency">$</span><span class="price">150.00</span></span></p>
                            <a href="services-details-page.html" class="save_service protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="194"><i class="fa fa-heart" aria-hidden="true"></i></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                   <div class="fr-latest-grid">
                      <div class="fr-latest-img">
                         <img src="img/services-imgs/seo-1image.jpg" alt="" class="img-fluid">
                      </div>
                      <div class="fr-latest-details">
                         <div class="fr-latest-content-service">
                            <div class="fr-latest-profile">
                               <a class="user-image" href="freelancer-detail.html"><img src="img/services-imgs/eshal-dp.jpg" alt="" class="img-fluid"></a>
                               <div class="fr-latest-profile-data">
                                  <span class="fr-latest-name"><a href="freelancer-detail.html">Eshaal Mehta<i class="fa fa-check verified protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Verified" aria-hidden="true"></i> </a></span>
                               </div>
                            </div>
                            <p><a href="services-details-page.html" title="Looking to hire an digital marketing champ">Looking to hire an digital marketing cha....</a></p>
                            <a href="javascript:void(0)" class="queue">0 Order in queue</a>
                            <span class="reviews"><i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                         </div>
                         <div class="fr-latest-bottom">
                            <p>Starting From<span><span class="currency">$</span><span class="price">350.00</span></span></p>
                            <a href="services-details-page.html" class="save_service protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="195"><i class="fa fa-heart" aria-hidden="true"></i></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                   <div class="fr-latest-grid">
                      <div class="fr-latest-img">
                         <img src="img/services-imgs/pile-3d-popular1-1.jpg" alt="" class="img-fluid">
                      </div>
                      <div class="fr-latest-details">
                         <div class="fr-latest-content-service">
                            <div class="fr-latest-profile">
                               <a class="user-image" href="freelancer-detail.html"><img src="img/services-imgs/jason-dp.jpg" alt="" class="img-fluid"></a>
                               <div class="fr-latest-profile-data">
                                  <span class="fr-latest-name"><a href="freelancer-detail.html">Voorhees Jason<i class="fa fa-check" aria-hidden="true"></i></a></span>
                               </div>
                            </div>
                            <p><a href="services-details-page.html" title="I will share your post to a large social media audience">I will share your post to a large social....</a></p>
                            <a href="javascript:void(0)" class="queue">0 Order in queue</a>
                            <span class="reviews"><i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                         </div>
                         <div class="fr-latest-bottom">
                            <p>Starting From<span><span class="currency">$</span><span class="price">6.00</span></span></p>
                            <a href="services-details-page.html" class="save_service protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="302"><i class="fa fa-heart" aria-hidden="true"></i></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                   <div class="fr-latest-grid">
                      <div class="fr-latest-img">
                         <img src="img/services-imgs/language1.jpg" alt="" class="img-fluid">
                      </div>
                      <div class="fr-latest-details">
                         <div class="fr-latest-content-service">
                            <div class="fr-latest-profile">
                               <a class="user-image" href="freelancer-detail.html"><img src="img/services-imgs/jason-dp.jpg" alt="" class="img-fluid"></a>
                               <div class="fr-latest-profile-data">
                                  <span class="fr-latest-name"><a href="freelancer-detail.html">Voorhees Jason<i class="fa fa-check" aria-hidden="true"></i></a></span>
                               </div>
                            </div>
                            <p><a href="services-details-page.html" title="I will impeccably translate any content from English to French">I will impeccably translate any content ....</a></p>
                            <a href="javascript:void(0)" class="queue">0 Order in queue</a>
                            <span class="reviews"><i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                         </div>
                         <div class="fr-latest-bottom">
                            <p>Starting From<span><span class="currency">$</span><span class="price">10.00</span></span></p>
                            <a href="services-details-page.html" class="save_service protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="305"><i class="fa fa-heart" aria-hidden="true"></i></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                   <div class="fr-latest-grid">
                      <div class="fr-latest-img">
                         <img src="img/services-imgs/programming1.jpg" alt="" class="img-fluid">
                      </div>
                      <div class="fr-latest-details">
                         <div class="fr-latest-content-service">
                            <div class="fr-latest-profile">
                               <a class="user-image" href="freelancer-detail.html"><img src="img/services-imgs/jason-dp.jpg" alt="" class="img-fluid"></a>
                               <div class="fr-latest-profile-data">
                                  <span class="fr-latest-name"><a href="freelancer-detail.html">Voorhees Jason<i class="fa fa-check" aria-hidden="true"></i></a></span>
                               </div>
                            </div>
                            <p><a href="services-details-page.html" title="I will create a responsive WordPress website design">I will create a responsive WordPress web....</a></p>
                            <a href="javascript:void(0)" class="queue">0 Order in queue</a>
                            <span class="reviews"><i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                         </div>
                         <div class="fr-latest-bottom">
                            <p>Starting From<span><span class="currency">$</span><span class="price">980.00</span></span></p>
                            <a href="services-details-page.html" class="save_service protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="307"><i class="fa fa-heart" aria-hidden="true"></i></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                   <div class="fr-latest-grid">
                      <div class="fr-latest-img">
                         <img src="img/services-imgs/social-link-img.png" alt="" class="img-fluid">
                      </div>
                      <div class="fr-latest-details">
                         <div class="fr-latest-content-service">
                            <div class="fr-latest-profile">
                               <a class="user-image" href="freelancer-detail.html"><img src="img/services-imgs/lara-dp.jpg" alt="" class="img-fluid"></a>
                               <div class="fr-latest-profile-data">
                                  <span class="fr-latest-name"><a href="freelancer-detail.html">Hannah Finn<i class="fa fa-check" aria-hidden="true"></i></a></span>
                               </div>
                            </div>
                            <p><a href="services-details-page.html" title="I will build up your android and ios application in react native">I will build up your android and ios app....</a></p>
                            <a href="javascript:void(0)" class="queue">0 Order in queue</a>
                            <span class="reviews"><i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                         </div>
                         <div class="fr-latest-bottom">
                            <p>Starting From<span><span class="currency">$</span><span class="price">400.00</span></span></p>
                            <a href="services-details-page.html" class="save_service protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="319"><i class="fa fa-heart" aria-hidden="true"></i></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6  grid-item">
                   <div class="fr-latest-grid">
                      <div class="fr-latest-img">
                         <img src="img/services-imgs/social1-icons.jpg" alt="" class="img-fluid">
                      </div>
                      <div class="fr-latest-details">
                         <div class="fr-latest-content-service">
                            <div class="fr-latest-profile">
                               <a class="user-image" href="freelancer-detail.html"><img src="img/services-imgs/lara-dp.jpg" alt="" class="img-fluid"></a>
                               <div class="fr-latest-profile-data">
                                  <span class="fr-latest-name"><a href="freelancer-detail.html">Hannah Finn<i class="fa fa-check" aria-hidden="true"></i></a></span>
                               </div>
                            </div>
                            <p><a href="services-details-page.html" title="I will be your social media marketing manager and content creator">I will be your social media marketing ma....</a></p>
                            <a href="javascript:void(0)" class="queue">0 Order in queue</a>
                            <span class="reviews"><i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                         </div>
                         <div class="fr-latest-bottom">
                            <p>Starting From<span><span class="currency">$</span><span class="price">100.00</span></span></p>
                            <a href="services-details-page.html" class="save_service protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="323"><i class="fa fa-heart" aria-hidden="true"></i></a>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
@endsection

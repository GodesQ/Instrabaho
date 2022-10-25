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
         toastr.error('{{ Session::get("fail") }}', 'Failed');
      </script>
   @endpush
@endif

<section class="fr-service-bar">
    <div class="container">
       <div class="row">
          <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 col-xl-12">
             <div class="fr-service-container">
                <ul>
                   <li class="links"> <a href="#description" class="scroll">Description</a> </li>
                   <li class="links"> <a href="#seller" class="scroll">Seller Detail</a> </li>
                   <li class="links"> <a href="#reviews" class="scroll">Reviews</a> </li>
                   <li class="links"> <a href="#faqs" class="scroll">FAQ,s</a> </li>
                   <li class="links"> <a href="#related" class="scroll">Related Services</a> </li>
                   <li class="links">
                      <div class="fr-m-products-2">
                         <ul>
                            <li>
                               <a href="about-us.html" class="fr-m-assets save_service " data-post-id="323"><i class="far fa-heart" aria-hidden="true"></i></a> 
                            </li>
                            <li> <a href="#" class="fr-m-assets" data-bs-toggle="modal" data-bs-target="#report-modal"><i class="fas fa-exclamation-triangle"></i></a> </li>
                            <li class="social-share">
                               <div id="wrapper">
                                  <input type="checkbox" class="checkbox" id="share">
                                  <label for="share" class="label fl-export"><i class="fas fa-share-alt"></i><span>Share</span></label>
                                  <div class="social">
                                     <ul>
                                        <li class="fl-facebook"><a href="about-us.html" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                                        <li class="fl-linkedin"><a href="about-us.html" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a></li>
                                        <li class="fl-pinterest"><a href="about-us.html" target="_blank"><i class="fab fa-pinterest" aria-hidden="true"></i></a></li>
                                        <li class="fl-twitter"><a href="about-us.html" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="fl-instagram"><a class="tumblr-share-button" href="about-us.html" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                                     </ul>
                                  </div>
                               </div>
                            </li>
                         </ul>
                      </div>
                   </li>
                </ul>
             </div>
          </div>
       </div>
    </div>
 </section>
   <section class="fr-services2-details padding-top-bottom-2">
      <div class="container">
         <div class="row">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                @if($service->type == 'featured')
                    <div class="badge badge-primary p-2 text-uppercase" style="font-size: 15px;">{{ $service->type }}</div>
                @endif
               <div class="fr-m-contents">
                  <div class="fr-m-main-title">
                     <p>
                        {{ $service->category->name }}       
                     </p>
                     <h1>
                        {{ $service->name }}
                     </h1>
                  </div>
                  <div class="fr-m-products">
                     <ul>
                        <li>
                           <p><i class="fa fa-star" aria-hidden="true"></i>No Reviews</p>
                        </li>
                        <li>
                           <p>0 Order in queue</p>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="slider-box">
                  <div class="flexslider fr-slick image-popup1">
                     <div class="flex-viewport">
                        <ul class="slides">
                            @php 
                                $attachments = json_decode($service->attachments)
                            @endphp
                            @foreach($attachments as $image)
                            <li class="clone " aria-hidden="true"> 
                                <a data-fancybox="services" href="../../../images/services/{{ $image }}"><img style="width: 100%; min-height: 400px !important; max-height: 600px; object-fit: cover;" src="../../../images/services/{{ $image }}" draggable="false"></a> 
                            </li>
                            @endforeach
                        </ul>
                     </div>
                     <ul class="flex-direction-nav">
                        <li class="flex-nav-prev"><a class="flex-prev" href="#"><i class="fas fa-angle-left" aria-hidden="true"></i></a></li>
                        <li class="flex-nav-next"><a class="flex-next" href="#"><i class="fas fa-angle-right" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
                  <div class="flexslider carousel fr-slick-thumb">
                     <div class="flex-viewport">
                        <ul class="slides">
                            @foreach($attachments as $image)
                            <li class="clone " aria-hidden="true"> 
                                <a data-fancybox="services" href="../../../images/services/{{ $image }}"><img src="../../../images/services/{{ $image }}" class="img-fluid" alt="" draggable="false"></a> 
                            </li>
                            @endforeach
                        </ul>
                     </div>
                     <ul class="flex-direction-nav">
                        <li class="flex-nav-prev"><a class="flex-prev flex-disabled" href="#" tabindex="-1"><i class="fas fa-angle-left" aria-hidden="true"></i></a></li>
                        <li class="flex-nav-next"><a class="flex-next flex-disabled" href="#" tabindex="-1"><i class="fas fa-angle-right" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
               </div>
               <div class="fl-advert-box">
                  <a href="javascript:void(0)"><img src="../../../images/logo/main-logo.png" width="124" alt="exertio theme" class="img-fluid"></a>
               </div>
               <div class="main-box-services" id="description">
                  <div class="fr-product-des-box heading-contents vector-bg">
                     <h3>Description </h3>
                     {!! $service->description !!}
                  </div>
               </div>
               <div class="fr-seller-servives-2" id="seller">
                  <div class="fr-seller-servives">
                     <div class="heading-contents">
                        <h3>About The Seller</h3>
                     </div>
                     <div class="fr-seller-servives-meta">
                        <a href="/freelancer/{{ $service->freelancer->user_id }} ">
                           <div class="fr-seller-profile"> <img src="../../../images/user/profile/{{ $service->freelancer->user->profile_image }}" alt="" class="img-fluid"> </div>
                        </a>
                        <div class="fr-seller-details">
                           <a href="/freelancer/{{ $service->freelancer->user_id }} "><span><i class="fa fa-check" aria-hidden="true"></i>{{ $service->freelancer->display_name }}</span></a>
                           <h3>{{ $service->freelancer->tagline }}</h3>
                           <div class="fr-seller-rating">
                              No Reviews                
                           </div>
                        </div>
                        <div class="fr-seller-view"> <a href="/freelancer/{{ $service->freelancer->user_id }}" class="btn btn-theme">View Profile</a> </div>
                     </div>
                  </div>
                  <div class="fr-seller-contents">
                     <ul>
                        <li>
                           <p>Location:</p>
                           <span>{{ $service->freelancer->location }}</span> 
                        </li>
                        <li>
                           <p>Member since:</p>
                           <span>{{ date_format(new DateTime($service->freelancer->created_at), "F d, Y") }}</span> 
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
               <div class="service-sidebar position-sticky">
                  <div class="project-price service">
                     <div class="card-body">
                        <div class="row">
                           <div class="col">
                              <span class="price-label">Starting From</span>
                              <div class="price"><span class="currency">₱ </span><span class="price">{{ number_format($service->cost, 2) }}</span></div>
                           </div>
                           <div class="feature"> <i class="fas fa-coins"></i> </div>
                        </div>
                     </div>
                  </div>
                  <div class="fr-services2-box">
                     <form id="purchased_addon_form" method="POST" action="/submit_proposal">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="seller_id" value="{{ $service->freelancer->id }}">
                        <input type="hidden" name="service_cost" value="{{ $service->cost }}">
                        <div class="fr-services2-h-style">
                           <h3> Addons Services</h3>
                        </div>
                        @forelse($addons as $addon)
                            <div class="fr-services-products">
                                <div class="fr-services2-sm">
                                <div class="pretty p-default">
                                    <input type="checkbox" name="services_addon[]" value="{{ $addon->id }}" class="fl_addon_checkbox" id="addon_checkbox_1447" data-addon-price="{{ $addon->price }}" data-service-id="325">
                                    <div class="state p-warning">
                                        <label> </label>
                                    </div>
                                </div>
                                </div>
                                <div class="fr-services2-sm-1">
                                <div class="fr-services-list">{{ $addon->title }}</div>
                                <span class="addon_price_1447"> <span class="currency">₱ </span><span class="price">{{ number_format($addon->price, 2) }}</span></span>
                                <p>{{ $addon->description }}</p>
                                </div>
                            </div>
                        @endforeach
                        <div class="container p-4">
                           <div class="form-group">
                              <label>Estimated Finish Date</label>
                              <input type="date" name="estimated_date" class="form-control" id="estimated_date">
                              <span class="danger text-danger">@error('estimated_date'){{ $message }}@enderror</span>
                           </div>
                           <div class="form-group">
                              <label>Location <span style="font-size: 10px;">(Specific Address)</span></label>
                              <input type="text" name="location" class="form-control" id="location">
                              <span class="danger text-danger">@error('location'){{ $message }}@enderror</span>
                           </div>
                           <div class="form-group">
                              <label>Message</label>
                              <textarea type="text" name="message" class="form-control" id="message"></textarea>
                              <span class="danger text-danger">@error('message'){{ $message }}@enderror</span>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-theme">Send Proposal</button>
                     </form>
                  </div>
                  <div class="fl-advert-box">
                    <a href="javascript:void(0)"><img src="../../../images/logo/main-logo.png" width="124" alt="exertio theme" class="img-fluid"></a>				
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
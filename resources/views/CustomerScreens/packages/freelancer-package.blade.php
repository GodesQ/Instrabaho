@extends('layout.layout')

@section('content')
<section class="fr-list-product bg-img">
    <div class="container">
       <div class="row">
          <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
             <div class="fr-list-content">
                <div class="fr-list-srch">
                   <h1>Freelancer Packages</h1>
                </div>
                <div class="fr-list-details">
                   <ul>
                      <li><a href="/">Home</a></li>
                      <li><a href="javascript:void(0)">Freelancer Packages</a></li>
                   </ul>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 <section class="fr-about-plan bg-white">
  <div class="container">
     <div class="row">
        <div class="col-lg-12 col-sm-12 col-xl-12 col-xs-12">
           <div class="heading-panel  section-center">
              <div class="heading-meta">
                 <h2>Freelancer Packages</h2>
                 <p>Choose the best pricing that suites your organizations requirements </p>
              </div>
           </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-xl-12 col-xs-12">
           <div class="exertio-pricing">
              <div class="row">
                  @foreach($packages as $package) 
                     <div class="col-xl-3 col-sm-6 col-md-6 col-xs-12 col-lg-4">
                        <div class="fr-plan-basics {{ $package->name != 'Business' ? ' fr-plan-basics-2' : null }}">
                           <div class="fr-plan-content">
                              <h2>{{ $package->name }}</h2>
                              <!-- <p>Go Pro, Best for the individuals</p> -->
                              <h3>₱ {{ number_format($package->price, 2) }}</h3>
                              <a href="/package_checkout?package_id={{ $package->id }}&package_name={{ $package->name }}"><button data-product-id="785" class="emp-purchase-package btn-loading"> Purchase Now
                              <span class="bubbles"> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> </span>
                              </button></a>
                           </div>
                           <div class="fr-plan-details">
                              <ul>
                                 <li><i class="fa fa-check" aria-hidden="true"></i>{{ $package->name == 'The Unli' ? 'Unlimited' : $package->total_projects }} Project Allowed</li>
                                 <li><i class="fa fa-check" aria-hidden="true"></i>{{ $package->name == 'The Unli' ? 'Unlimited' : $package->total_services }} Services</li>
                                 <li><i class="fa fa-check" aria-hidden="true"></i>{{ $package->name == 'The Unli' ? 'Unlimited' : $package->total_feature_services }} Featured Projects</li>
                                 <li><i class="fas {{ $package->isProfileFeatured ? 'fa-check' : 'fa-times' }}" aria-hidden="true"></i>Featured Profile</li>
                                 <li><i class="fa fa-check" aria-hidden="true"></i>{{ $package->expiry_days }} Days Package Expiry</li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  @endforeach
              </div>
           </div>
        </div>
     </div>
  </div>
   </section>
@endsection
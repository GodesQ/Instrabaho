@extends('layout.layout')

@section('content')
<style>
   #map-canvas {
       height: 200px;
       width: 100%;
   }
</style>
<section class="fr-list-product bg-img">
   <div class="container">
      <div class="row">
         <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="fr-list-content">
               <div class="fr-list-srch">
                  <h1>Services Search</h1>
               </div>
               <div class="fr-list-details">
                  <ul>
                     <li><a href="index.html">Home</a></li>
                     <li><a href="javascript:void(0)">Services Search</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="fr-services-serch bg-gray-light-color">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-xs-12 col-xl-12 col-sm-12 col-md-12">
            <form>
               <div class="fr-serices-content">
                  <ul>
                     <li>
                        <div class="form-group">
                           <input type="text" value="{{ $queries['title'] }}" placeholder="What are you looking for?" class="form-control" name="title" value="">
                        </div>
                     </li>
                     <li>
                        <select class="default-select select2-hidden-accessible" name="categories[]" tabindex="-1" aria-hidden="true">
                           <option value="">Select Category</option>
                           @foreach($service_categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                           @endforeach
                        </select>
                     </li>
                     <li class="d-flex justify-content-center"> 
                        <button type="submit" class="btn btn-sm btn-style mx-1">Search</button>
                        <a href="/search_services" class="btn btn-sm btn-style btn-warning">Clear Result</a>
                     </li>
                  </ul>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
<section class="fr-top-srvices section-padding padding-top-bottom-3  actionbar_space">
   <div class="container">
      <div class="row">
         <div class="col-xl-4 col-xs-12 col-sm-12 col-md-12">
            <div class="service-side position-sticky">
               <div class="heading">
                  <h4>Search Filters</h4>
                  <a href="/search_services">Clear Result</a>
               </div>
               <div class="service-widget">
                  <form action="#">
                     <div class="panel panel-default">
                        <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#search-widget"> Keywords </a> </div>
                        <div id="search-widget" class="panel-collapse collapse show" role="tabpanel">
                           <div class="panel-body" tabindex="1">
                              <div class="form-group">
                                 <input type="text" class="form-control" value="{{ $queries['title'] }}" name="title" placeholder="What are you looking for" value="">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-default">
                        <div class="panel-heading active"> <a role="button" class="collapsed" data-bs-toggle="collapse" href="#freelancer-location">Location </a> </div>
                        <div id="freelancer-location" class="panel-collapse collapse show" role="tabpanel">
                           <div class="panel-body" tabindex="7">
                              <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <div class="form-label font-weight-bold my-50">Address</div>
                                          <input type="text" name="address" id="map-search" class="form-control controls" value="{{ $queries['address'] }}">
                                       </div>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-md-12">
                                       <div id="map-canvas"></div>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <!-- <div class="form-label font-weight-bold my-50">Latitude</div> -->
                                          <input type="hidden" name="latitude" value="{{ $queries['latitude'] }}" class="form-control latitude">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <!-- <div class="form-label font-weight-bold my-50">Longitude</div> -->
                                          <input type="hidden" name="longitude" class="form-control longitude" value="{{ $queries['longitude'] }}">
                                       </div>
                                    </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-default">
                        <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#category-widget"> Search by category </a> </div>
                        <div id="category-widget" class="panel-collapse collapse show" role="tabpanel">
                           <div class="panel-body" tabindex="2">
                              <ul>
                                 @foreach($service_categories as $category)
                                    <li class="">
                                       <div class="pretty p-icon p-thick p-curve">
                                          <input type="checkbox" name="categories[]" {{ in_array($category->id, $queries['categories']) ? 'checked' : null }} value="{{ $category->id }}" id="{{ $category->id }}">
                                          <div class="state p-warning">
                                             <i class="icon fa fa-check" aria-hidden="true"></i>
                                             <label></label>
                                          </div>
                                       </div>
                                       <span>{{ $category->name }}</span>
                                    </li>
                                 @endforeach
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-default">
                        <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#price-widget"> Price </a> </div>
                        <div id="price-widget" class="panel-collapse collapse show" role="tabpanel">
                           <div class="panel-body" tabindex="4">
                              <div class="range-slider">
                                <input type="text" class="services-range-slider" name="my_range" value="" />
                              </div>
                              <div class="extra-controls">
                                 <input type="text" class="services-input-from form-control" value="{{ $queries['price_min'] }}" name="price-min">
                                 <input type="text" class="services-input-to form-control" value="{{ $queries['price_max'] }}" name="price-max">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-default">
                        <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#type-widget"> Type </a> </div>
                        <div id="type-widget" class="panel-collapse collapse show" role="tabpanel">
                           <div class="" tabindex="5">
                              <select name="type" id="" class="select2 form-control">
                                 <option value="">Select Type</option>
                                 <option {{ $queries['type'] == 'simple' ? 'selected' : null }} value="simple">Simple</option>
                                 <option {{ $queries['type'] == 'featured' ? 'selected' : null }} value="featured">Featured</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="submit-btn">
                        <p><i>Select the options and press the Filter Result button to apply the changes  </i></p>
                        <button class="btn btn-theme btn-block" type="submit"> Filter Result</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <div class="col-xl-8 col-xs-12 col-sm-12 col-md-12">
            <div class="row">
               <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                  <div class="services-filter-2">
                     <form class="d-flex justify-content-between align-items-center">
                        <div class="heading-area">
                           <h4 >Found {{ count($services) }} {{ count($services) > 1 ? 'Results' : 'Result' }}  </h4>
                        </div>
                        <div class=" float-right">
                           <ul class="top-filters">
                              <li>
                                 <a href="" class="services-grid-icon protip active list-style" data-pt-position="top" data-pt-scheme="black" data-pt-title="Grid View" data-list-style="grid">
                                 <span></span>
                                 <span></span>
                                 <span></span>
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="row">
                     @forelse($services as $service)
                        @php
                           $images = json_decode($service->attachments);
                        @endphp
                     <div class="col-md-4">
                        <a href="/service/{{ $service->id }}">
                           <div class="badge badge-info p-2 text-uppercase position-relative" style="margin-bottom: -200px; z-index: 10;"></div>
                           <div class="fr-top-contents bg-white-color">
                              <div class="fr-top-product">
                                 <img height="250" width="100%" style="object-fit: cover;" src="../../../images/services/{{ $images[0] }}" alt="" class="img-responsive">
                                 <div class="fr-top-rating"> <a href="" class="save_service protip" data-fid="171" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="355"><i class="fa fa-heart" aria-hidden="true"></i></a> </div>
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
                                 <div class="fr-top-grid"> <a href=""><img src="img/freelancers-imgs/deo-profile.jpg" alt="" class="img-fluid"></a></div>
                                 @if($service->distance)
                                    <p>Distance <span class="style-6"><span class="price">{{ number_format($service->distance, 2) }} k/m</span></span></p>
                                 @endif
                              </div>
                           </div>
                        </a>
                     </div>
                     @empty
                        
                     @endforelse
                  </div>
                  <div class="row">
                     <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                        <div class="fl-navigation">
                           {!! $services->links() !!}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<script src="../../../js/user-location.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>
@endsection
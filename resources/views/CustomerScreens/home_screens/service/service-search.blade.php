@extends('layout.layout')

@section('content')
<style>
   #map-canvas {
       height: 200px;
       width: 100%;
   }
   #services-locations {
      height: 500px;
      width: 100%;
   }
   .labels { color: black; background-color: #FF8075; font-family: Arial; font-size: 11px; font-weight: bold; text-align: center; width: 12px; }
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
                  <form action="#" id="services-filter-form">
                     <div class="panel panel-default">
                        <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#search-widget"> Keywords </a> </div>
                        <div id="search-widget" class="panel-collapse collapse show" role="tabpanel">
                           <div class="panel-body" tabindex="1">
                              <div class="form-group">
                                 <input type="text" class="form-control" id="title" name="title" placeholder="What are you looking for" value="">
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
                                          <input type="text" name="address" id="map-search" class="form-control controls" value="">
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
                                          <input type="hidden" name="latitude" value="" class="form-control latitude">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <!-- <div class="form-label font-weight-bold my-50">Longitude</div> -->
                                          <input type="hidden" name="longitude" class="form-control longitude" value="">
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
                                          <input type="checkbox" id="categories" name="categories[]" value="{{ $category->id }}" id="{{ $category->id }}">
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
                                <input type="text" class="services-range-slider" name="my_range" id="my_range" value="" />
                              </div>
                              <div class="extra-controls">
                                 <input type="text" class="services-input-from form-control" value="" name="price-min">
                                 <input type="text" class="services-input-to form-control" value="" name="price-max">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-default">
                        <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#type-widget"> Type </a> </div>
                        <div id="type-widget" class="panel-collapse collapse show" role="tabpanel">
                           <div class="" tabindex="5">
                              <select name="type" id="type" class="select2 form-control">
                                 <option value="">Select Type</option>
                                 <option value="simple">Simple</option>
                                 <option value="featured">Featured</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <input type="hidden" name="page" id="page_count" value="1">
                     <div class="submit-btn">
                        <p><i>Select the options and press the Filter Result button to apply the changes</i></p>
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
                           <h4 >Found {{ count($services) }} {{ count($services) > 1 ? 'Results' : 'Result' }} </h4>
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
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
                                    View Map
                                </button>
                           </ul>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="row services-data">
                     @include('CustomerScreens.home_screens.service.services')
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="modal fade " id="create" tabindex="-1" role="dialog" aria-labelledby="create" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-body">
                    <div id="services-locations"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../../js/user-location.js"></script>
@endsection

@push('scripts')
   <script>
      $(document).ready(function() {

        $(document).on('click', '.pagination .page-item a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            $('#page_count').val(page);
            fetchServices(page);
        })

        $(document).on('submit', '#services-filter-form', function(event) {
            event.preventDefault();
            fetchServices(1);
        })

        function fetchServices(page) {
            let selected_categories = [];

            $.each($("#categories:checked"), function(){
               selected_categories.push($(this).val());
            });

            let filter_data = {
                title: $('#title').val(),
                address: $('#map-search').val(),
                latitude: $('.latitude').val(),
                longitude: $('.longitude').val(),
                my_range: $('#my_range').val(),
                type: $('#type').val(),
                categories: encodeURIComponent(JSON.stringify(selected_categories)),
            }
            let filter_parameters = `title=${filter_data.title}&address=${filter_data.address}&latitude=${filter_data.latitude}&longitude=${filter_data.longitude}&my_range=${filter_data.my_range}&type=${filter_data.type}&categories=${filter_data.categories}`;
            $.ajax({
                url: "/search_services/fetch_data?page="+page+'&'+filter_parameters,
                success: function (data) {
                  $('.services-data').html(data.view_data);
                  $('.protip-container').remove();
                  setLocations(data.services);
                }
            })
        }

        function setLocations(services) {
            if(services.length == 0) return console.log(services);

            let latEl = document.querySelector( '.latitude' )
            let longEl = document.querySelector( '.longitude' )
            var mapOptions = {
               center: latEl.value == '' ? new google.maps.LatLng( 14.5995124, 120.9842195 ) : new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
               zoom: 12,
               disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
               scrollWheel: true, // If set to false disables the scrolling on the map.
               draggable: true, // If set to false , you cannot move the map around.
            };
            var map = new google.maps.Map(document.getElementById("services-locations"), mapOptions);

            var infoWindow = new google.maps.InfoWindow(); 

            let my_marker = new google.maps.Marker({
               position:  new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
               map: map,
               icon: 'https://img.icons8.com/fluency/48/null/google-maps-new.png'
            })

            let circle = new google.maps.Circle({
               center: latEl.value == '' ? new google.maps.LatLng( 14.5995124, 120.9842195 ) : new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
               radius: 10000,
               strokeColor: '#0000FF',
               strokeOpacity: 1,
               strokeWeight: 2,
               fillColor: '#FFFFFF',
               fillOpacity: 0.4,
               map: map
            })
            
            circle.bindTo('center', my_marker, 'position');
            
            for (i = 0; i <= services.data.length; i++) {
               var data = services.data[i]
               var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);
               
               let marker = new google.maps.Marker({
                  position: myLatlng,
                  map: map,
                  labelContent: data.name, 
                  labelAnchor: new google.maps.Point(7, 30),
                  labelClass: "labels", // the CSS class for the label
                  labelInBackground: true
               });

               (function (marker, data) {
                     google.maps.event.addListener(marker, "click", function (e) {
                        infoWindow.setContent(data.name);
                        infoWindow.open(map, marker);
                     });
               })(marker, data);

            }
         }
      })
   </script>
@endpush


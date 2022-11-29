@extends('layout.layout')

@section('content')

@if(Session::get('fail'))
   @push('scripts')
      <script>
         toastr.error('{{ Session::get("fail") }}', 'Fail');
      </script>
   @endpush
@endif

@if(Session::get('success'))
   @push('scripts')
      <script>
         toastr.success('{{ Session::get("success") }}', 'Follow');
      </script>
   @endpush
@endif

<style>
    :root {
        --building-color: #FF9800;
        --house-color: #0288D1;
        --shop-color: #7B1FA2;
        --warehouse-color: #558B2F;
    }
   #map-canvas {
       height: 200px;
       width: 100%;
   }
   #projects-locations {
      height: 500px;
      width: 100%;
   }
   .labels { color: black; background-color: #FF8075; font-family: Arial; font-size: 11px; font-weight: bold; text-align: center; width: 12px; }
    .property {
    align-items: center;
    background-color: #FFFFFF;
    border-radius: 50%;
    color: #263238;
    display: flex;
    font-size: 14px;
    gap: 15px;
    height: 30px;
    justify-content: center;
    padding: 4px;
    position: relative;
    position: relative;
    transition: all 0.3s ease-out;
    width: 30px;
    }

    .property::after {
    border-left: 9px solid transparent;
    border-right: 9px solid transparent;
    border-top: 9px solid #FFFFFF;
    content: "";
    height: 0;
    left: 50%;
    position: absolute;
    top: 95%;
    transform: translate(-50%, 0);
    transition: all 0.3s ease-out;
    width: 0;
    z-index: 1;
    }

    .property .icon {
    align-items: center;
    display: flex;
    justify-content: center;
    color: #FFFFFF;
    }

    .property .icon svg {
    height: 20px;
    width: auto;
    }

    .property .details {
    display: none;
    flex-direction: column;
    flex: 1;
    }

    .property .address {
    color: #9E9E9E;
    font-size: 10px;
    margin-bottom: 10px;
    margin-top: 5px;
    }

    .property .features {
    align-items: flex-end;
    display: flex;
    flex-direction: row;
    gap: 10px;
    }

    .property .features > div {
    align-items: center;
    background: #F5F5F5;
    border-radius: 5px;
    border: 1px solid #ccc;
    display: flex;
    font-size: 10px;
    gap: 5px;
    padding: 5px;
    }

    /*
    * Property styles in highlighted state.
    */
    .property.highlight {
    background-color: #FFFFFF;
    border-radius: 8px;
    box-shadow: 10px 10px 5px rgba(0, 0, 0, 0.2);
    height: 80px;
    padding: 8px 15px;
    width: auto;
    }

    .property.highlight::after {
    border-top: 9px solid #FFFFFF;
    }

    .property.highlight .details {
    display: flex;
    }

    .property.highlight .icon svg {
    width: 50px;
    height: 50px;
    }

    .property .bed {
    color: #FFA000;
    }

    .property .bath {
    color: #03A9F4;
    }

    .property .size {
    color: #388E3C;
    }

    /*
    * House icon colors.
    */
    .property.highlight:has(.fa-house) .icon {
    color: var(--house-color);
    }

    .property:not(.highlight):has(.fa-house) {
    background-color: var(--house-color);
    }

    .property:not(.highlight):has(.fa-house)::after {
    border-top: 9px solid var(--house-color);
    }

    /*
    * Building icon colors.
    */
    .property.highlight:has(.fa-building) .icon {
    color: var(--building-color);
    }

    .property:not(.highlight):has(.fa-building) {
        background-color: var(--building-color);
    }

    .property:not(.highlight):has(.fa-building)::after {
        border-top: 9px solid var(--building-color);
    }

    /*
    * Warehouse icon colors.
    */
    .property.highlight:has(.fa-warehouse) .icon {
        color: var(--warehouse-color);
    }

    .property:not(.highlight):has(.fa-warehouse) {
        background-color: var(--warehouse-color);
    }

    .property:not(.highlight):has(.fa-warehouse)::after {
        border-top: 9px solid var(--warehouse-color);
    }

    /*
    * Shop icon colors.
    */
    .property.highlight:has(.fa-shop) .icon {
        color: var(--shop-color);
    }

    .property:not(.highlight):has(.fa-shop) {
        background-color: var(--shop-color);
    }

    .property:not(.highlight):has(.fa-shop)::after {
        border-top: 9px solid var(--shop-color);
    }
</style>

<section class="fr-list-product bg-img">
    <div class="container">
       <div class="row">
          <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
             <div class="fr-list-content">
                <div class="fr-list-srch">
                   <h1>Project Search</h1>
                </div>
                <div class="fr-list-details">
                   <ul>
                      <li><a href="index.html">Home</a></li>
                      <li><a href="javascript:void(0)">Project Search</a></li>
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
                   <a href="/search_projects">Clear Result</a>
                </div>
                <div class="service-widget">
                   <form action="#" id="projects-filter-form">
                      <div class="panel panel-default">
                         <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#search-widget"> Keywords </a> </div>
                         <div id="search-widget" class="panel-collapse collapse show" role="tabpanel">
                            <div class="panel-body" tabindex="1">
                               <div class="form-group">
                                  <input type="text" class="form-control" value="" id="title" name="title" placeholder="What are you looking for" value="">
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
                                 <input type="text" class="services-range-slider" id="my_range" name="my_range" value="" />
                               </div>
                               <div class="extra-controls">
                                  <input type="text" class="services-input-from form-control" value="" id="price-min" name="price-min">
                                  <input type="text" class="services-input-to form-control" value="" name="price-max" id="price-max">
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
                            <h4 >Found {{ count($projects) }} {{ count($projects) > 1 ? 'Results' : 'Result' }} </h4>
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
                                <button type="button" class="btn btn-primary view-map-btn" data-toggle="modal" style="display: none;" data-target="#create">
                                    View Map
                                </button>
                            </ul>
                         </div>
                      </form>
                   </div>
                </div>
                <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                   <div class="row projects-data">
                        @include('CustomerScreens.home_screens.project.projects');
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 <div class="modal fade " id="create" tabindex="-1" role="dialog" aria-labelledby="create" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-header bg-primary white">
            <h4 class="modal-title text-white" id="myModalLabel8">Projects Location</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-content">
            <div class="card">
                <div class="card-body">
                    <div id="projects-locations"></div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-left">
                            <button class="btn btn-secondary hide-boundary-btn" type="button">Hide Boundary</button>
                            <button class="btn btn-primary show-boundary-btn" type="button">Show Boundary</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <script src="../../../js/user-location.js"></script>
@endsection

@push('scripts')
<script src="../../../assets/js/custom_js/homescreen/projects_search.js"></script>
@endpush

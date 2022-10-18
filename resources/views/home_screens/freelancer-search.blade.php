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
                   <h1>Freelancer Search</h1>
                </div>
                <div class="fr-list-details">
                   <ul>
                      <li><a href="index.html">Home</a></li>
                      <li><a href="javascript:void(0)">Freelancer Search</a></li>
                   </ul>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 <section class="fr-lance-details section-padding actionbar_space">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xs-12 col-sm-12 col-md-12 col-xl-4">
                <div class="project-sidebar">
                    <div class="heading">
                    <h4>Search Filters</h4>
                    <a href="/search_freelancers">Clear Result</a>
                    </div>
                    <div class="project-widgets">
                    <form action="#">
                        <div class="panel panel-default">
                            <div class="panel-heading active"> <a role="button" class="collapsed" data-bs-toggle="collapse" href="#search-widget"> Search by Keyword </a> </div>
                            <div id="search-widget" class="panel-collapse collapse" role="tabpanel">
                                <div class="panel-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="title" placeholder="Keyword or freelancer name" value="{{ $queries['title'] }}">
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
                            <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#price-widget"> Hourly Rate </a> </div>
                                <div id="price-widget" class="panel-collapse collapse show" role="tabpanel">
                                    <div class="panel-body" tabindex="2">
                                    <div class="range-slider">
                                        <input type="text" class="services-range-slider" name="my_range" value="{{ $queries['my_range'] }}" />
                                    </div>
                                    <div class="extra-controls">
                                        <input type="text" class="services-input-from form-control" value="{{ $queries['price_min'] }}" name="price-min">
                                        <input type="text" class="services-input-to form-control" value="{{ $queries['price_max'] }}" name="price-max">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading active"> <a role="button" class="" data-bs-toggle="collapse" href="#freelancer-skills"> Search By Skills </a> </div>
                            <div id="freelancer-skills" class="panel-collapse collapse show" role="tabpanel" style="overflow: scroll !important;">
                                <div class="panel-body" tabindex="3">
                                    <ul class="main">
                                        @foreach($skills as $skill)
                                            <li class="">
                                                <div class="pretty p-icon p-thick p-curve">
                                                <input {{ in_array($skill->id, $queries['freelancer_skills']) ? 'checked' : null }} type="checkbox" name="skill[]" value="{{ $skill->id }}" id="132">
                                                <div class="state p-warning">
                                                    <i class="icon fa fa-check" aria-hidden="true"></i>
                                                    <label></label>
                                                </div>
                                                </div>
                                                <span>{{ $skill->skill_name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading active"> <a role="button" class="collapsed" data-bs-toggle="collapse" href="#freelance-type"> Type </a> </div>
                            <div id="freelance-type" class="panel-collapse collapse " role="tabpanel">
                                <div class="panel-body" tabindex="6">
                                <ul class="main">
                                    <li class="">
                                        <div class="pretty p-icon p-thick p-curve">
                                            <input {{ in_array("company", $queries['freelance_type']) ? 'checked' : null }} type="checkbox" name="freelance_type[]" value="company" id="154">
                                            <div class="state p-warning">
                                            <i class="icon fa fa-check" aria-hidden="true"></i>
                                            <label></label>
                                            </div>
                                        </div>
                                        <span>Company (3)</span>
                                    </li>
                                    <li class="">
                                        <div class="pretty p-icon p-thick p-curve">
                                            <input {{ in_array("group", $queries['freelance_type']) ? 'checked' : null }} type="checkbox" name="freelance_type[]" value="group" id="153">
                                            <div class="state p-warning">
                                            <i class="icon fa fa-check" aria-hidden="true"></i>
                                            <label></label>
                                            </div>
                                        </div>
                                        <span>Group (1)</span>
                                    </li>
                                    <li class="">
                                        <div class="pretty p-icon p-thick p-curve">
                                            <input {{ in_array("individual", $queries['freelance_type']) ? 'checked' : null }} type="checkbox" name="freelance_type[]" value="individual" id="152">
                                            <div class="state p-warning">
                                            <i class="icon fa fa-check" aria-hidden="true"></i>
                                            <label></label>
                                            </div>
                                        </div>
                                        <span>Individual (3)</span>
                                    </li>
                                    <li class="">
                                        <div class="pretty p-icon p-thick p-curve">
                                            <input {{ in_array("student", $queries['freelance_type']) ? 'checked' : null }} type="checkbox" name="freelance_type[]" value="student" id="198">
                                            <div class="state p-warning">
                                            <i class="icon fa fa-check" aria-hidden="true"></i>
                                            <label></label>
                                            </div>
                                        </div>
                                        <span>Student (1)</span>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        </div>
                        <div class="submit-btn">
                            <p><i>select options and press the filter button to apply changes  </i></p>
                            <input type="hidden" name="sort" value="">
                            <button class="btn btn-theme btn-block" type="submit"> Filter Result</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-8 col-sm-12 col-md-12 col-xl-8">
                <div class="row">
                    <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                    <div class="services-filter-2">
                        <form>
                            <div class="heading-area">
                                <h4>Found {{ count($freelancers) }} Results  </h4>
                            </div>
                            <div class="filters">
                                <ul class="top-filters">
                                <li>
                                    <a href="freelancer-grid.html" class="services-grid-icon protip active list-style" data-pt-position="top" data-pt-scheme="black" data-pt-title="Grid View" data-list-style="grid">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    </a>
                                </li>
                                </ul>
                                <select class="default-select select2-hidden-accessible" name="sort" id="order_by" tabindex="-1" aria-hidden="true">
                                <option value="">Sort by</option>
                                <option value="desc"> Date: Descending</option>
                                <option value="asc"> Name: Ascending</option>
                                </select>			
                            </div>
                        </form>
                    </div>
                    </div>
                    <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            @forelse($freelancers as $freelancer)
                                <div class="col-xl-12 col-lg-12 grid-item">
                                    <div class="fr3-details">
                                    <div class="fr3-job-detail">
                                        <div class="fr3-job-img">
                                            <a href="/freelancer/{{ $freelancer->user_id }}">
                                                @if($freelancer->user->profile_image)
                                                    <img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" alt="profile pic" style="width: 100%; height: 90px; object-fit: cover;">
                                                @else
                                                    <img src="../../../images/user-profile.png" alt="profile pic" style="width: 100%; height: 100px; object-fit: cover;">
                                                @endif
                                            </a>
                                            <p class="mb-2"><i class="fas fa-star colored" aria-hidden="true"></i> No Reviews</p>
                                            <!-- <a class="follow follow-freelancer protip text-danger" style="border: 1px solid rgb(255, 0, 0); padding: 0.3rem 1rem;" data-fid="177" data-pt-position="top" data-pt-scheme="black" data-pt-title="Follow">
                                                 <i class="fas fa-heart mr-50 text-danger" aria-hidden="true"></i> Follow
                                            </a> -->
                                        </div>
                                        <div class="fr3-job-text">
                                            <span class="name"><a href="/freelancer/{{ $freelancer->user_id }}">	<i class="fa fa-check verified protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="Verified" aria-hidden="true"></i>{{ $freelancer->display_name }}</a></span>
                                            <a href="#">
                                                <h3>{{ $freelancer->tagline }}</h3>
                                            </a>
                                            <p class="excerpt">{!! substr($freelancer->description, 0, 70) !!}...</p>
                                            <p class="price-tag"><span class="currency">₱ </span><span class="price">{{ number_format($freelancer->hourly_rate, 2) }}</span><span class="bottom-text"> / hr</span></p>
                                            <ul class="lists d-flex justify-content-between" style="gap: 10px;">
                                                <li style="width: 25%;"> 
                                                    @if($freelancer->distance)
                                                        <div class="font-weight-bold" style="color: #000;">Distance :</div>
                                                        {{ number_format($freelancer->distance, 2) }} km
                                                    @else
                                                        <div class="font-weight-bold" style="color: #000;">Member Since :</div>
                                                        {{ date_format(new DateTime($freelancer->created_at), "F d, Y") }}
                                                     @endif
                                                </li>
                                                <li style="width: 33%;"> 
                                                    <div class="font-weight-bold" style="color: #000;">Location : </div>
                                                    {{ $freelancer->address }}
                                                </li>
                                                <li style="width: 33%;"> 
                                                    <div class="font-weight-bold" style="color: #000;">Freelancer Type : </div>
                                                    {{ $freelancer->freelancer_type }}
                                                </li>
                                            </ul>
                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fr3-product-skills">
                                                    @forelse($freelancer->skills as $skill)
                                                        <a href="">{{ $skill->skill->skill_name }}</a>
                                                    @empty
                                                    <a href="#" class="bg-info text-white">No Skills Found</a>
                                                    @endforelse
                                                 </div>
                                                <a href="/freelancer/{{ $freelancer->user_id }}" class="btn btn-theme btn-sm btn-outline-primary">View Profile <i class="fa fa-chevron-right ml-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fr3-product-icons">
                                        <div class="features-star"> <i class="fa fa-star" aria-hidden="true"></i></div>
                                    </div>
                                    </div>
                                </div>
                            @empty

                            @endforelse
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                               <div class="fl-navigation">
                                  {!! $freelancers->links() !!}
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


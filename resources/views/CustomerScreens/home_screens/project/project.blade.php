@extends('layout.layout')

@section('content')

@if(Session::get('success'))
   @push('scripts')
      <script>
         toastr.success("{{ Session::get('success') }}", 'Success');
      </script>
   @endpush
@endif

@if(Session::get('fail'))
   @push('scripts')
      <script>
         toastr.error("{{ Session::get('fail') }}", 'Fail');
      </script>
   @endpush
@endif

<style>
    #map-canvas {
        height: 300px;
        width: 100%;
    }
</style>

<section class="fr-project-details section-padding actionbar_space">
    <div class="container">
       <div class="row">
          <div class="col-lg-8 col-xl-8 col-sm-12 col-md-12 col-xs-12">
             <div class="fr-project-content">
                <div class="fr-project-list">
                   <div class="fr-project-container">
                      <ul class="fr-project-meta">
                         <li> <i class="far fa-folder"></i>
                            {{ $project->category->name }}
                         </li>
                         <li> <i class="fas fa-map-marker-alt"></i>
                            {{ $project->location }}
                         </li>
                         <li> <i class="far fa-clock"></i>
                            {{ date_format(new DateTime($project->created_at), "F d, Y")}}
                         </li>
                      </ul>
                      <h2>{{ $project->title }}</h2>
                      <div class="fr-project-style">
                        <a href="{{ $save_project ? 'javascript:void(0)' : '/freelancer/save_project/' . $project->id . '/' . $project->employer_id }}" class="mark_fav protip" data-post-id="225"
                           data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Project">
                           <i class="{{ $save_project ? 'fa' : 'far' }} fa-heart text-danger"></i>
                        </a>
                         <a href="#fr-bid-form" class="btn btn-theme scroll"> Send Proposal</a>
                      </div>
                   </div>
                   <div class="fr-project-product-features">
                      <div class="fr-project-product">
                         <ul class="">
                            <li>
                               <div class="short-detail-icon"> <i class="fas fa-id-card-alt"></i> </div>
                               <div class="short-detail-meta"> <small>Freelancer Type </small>
                                    <strong>{{ $project->freelancer_type }}</strong>
                               </div>
                            </li>
                            <li>
                               <div class="short-detail-icon"> <i class="far fa-calendar-check"></i> </div>
                               <div class="short-detail-meta"> <small>Project Duration</small>
                                    <strong>{{ $project->project_duration }}</strong>
                               </div>
                            </li>
                            <li>
                               <div class="short-detail-icon"> <i class="fas fa-bezier-curve"></i> </div>
                               <div class="short-detail-meta"> <small>Level</small>
                                <strong>{{ $project->project_level }}</strong>
                               </div>
                            </li>
                            <li>
                               <div class="short-detail-icon"> <i class="fas fa-headset"></i> </div>
                               <div class="short-detail-meta"> <small>English Level </small>
                                <strong>{{ $project->english_level }}</strong>
                               </div>
                            </li>
                         </ul>
                      </div>
                   </div>
                </div>
                <div class="fl-advert-box">
                    <a href="javascript:void(0)"><img src="../../../images/logo/main-logo.png" width="124" alt="exertio theme" class="img-fluid"></a>
                </div>
                <div class="fr-project-f-des mb-4">
                   <div class="fr-project-des">
                     <h3>Description</h3>
                     {{ $project->description }}
                   </div>
                   <div class="fr-project-skills">
                      <h3> Skills Required</h3>
                      @foreach($project->skills_name as $skill)
                        <a href="#">{{ $skill->skill_name }}</a>
                      @endforeach
                   </div>
                   <div class="fr-project-attachments">
                      <h3>{{ $project->quantity }}</h3>
                      <div class="attacment-box">

                        @php
                           //transform json arrays to real arrays
                           $attachments = json_decode($project->attachments);
                        @endphp

                        @foreach($attachments as $attachment)
                           <div class="attachments">
                              <a href="javascript:void(0)">
                                 <img src="{{ '../../../images/projects/' . $attachment }}" alt="">
                                 <div class="attachment-data">
                                    <h6 title="file-sample_100kB.docx">{{ $attachment }}</h6>

                                 </div>
                              </a>
                              <a target="_blank" href="{{ '../../../images/projects/' . $attachment }}" class="download-icon"><i class="fas fa-eye"></i></a>
                           </div>
                        @endforeach
                   </div>
                   <!-- <div class="fr-project-ids">
                      <p>
                         Project ID: {{ $project->id }}
                      </p>
                   </div> -->
                </div>
             </div>
            <div class="fl-advert-box">
               <a href="javascript:void(0)"><img src="../../../images/logo/main-logo.png" width="124" alt="exertio theme" class="img-fluid"></a>
            </div>
            @if (session()->get('role') == 'freelancer' && $isAlreadySendProposal == false)
            <div class="fr-project-lastest-product">
               <div class="fr-project-place" id="fr-bid-form">
                  <h3> Send Your Proposal</h3>
                    <form method="POST" action="/store_proposal" enctype="multipart/form-data">
                       @csrf
                       <input type="hidden" name="project_id" value="{{ $project->id }}">
                       <input type="hidden" name="employer_id" value="{{ $project->employer_id }}">
                          <div class="row g-3">
                             <div class="col">
                                <div class="form-group">
                                   <label>Your Price <span class="text-danger">*</span></label>
                                   <div class="input-group">
                                      <input type="number" class="form-control" id="bidding-price" name="offer_price" data-smk-msg="Provide your price in numbers only" data-smk-type="number">
                                      <div class="input-group-prepend">
                                         <div class="input-group-text">₱ </div>
                                      </div>
                                   </div>
                                   <span class="text-danger danger">
                                        @error('offer_price')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                             </div>
                             <div class="col">
                                <div class="form-group">
                                   <label> Days to complete <span class="text-danger">*</span></label>
                                   <div class="input-group">
                                      <input type="number" class="form-control" name="estimated_days" data-smk-msg="Dasy to complete in numbers only" data-smk-type="number">
                                      <div class="input-group-prepend">
                                         <div class="input-group-text">Days</div>
                                      </div>
                                   </div>
                                   <span class="text-danger danger">
                                        @error('estimated_days')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                             </div>
                          </div>
                          <div class="form-row">
                             <div class="col-12">
                                <div class="form-group">
                                   <label>Address <span class="text-danger">*</span></label>
                                   <div class="input-group">
                                      <input type="text" multiple class="form-control" id="map-search" name="address">
                                      <div class="input-group-prepend">
                                         <div class="input-group-text"><i class="fa fa-location-arrow"></i></div>
                                      </div>
                                   </div>
                                   <span class="text-danger danger my-1">
                                        @error('address')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                   <br>
                                   <div id="map-canvas"></div>
                                   <input type="hidden" name="latitude" class="latitude">
                                   <input type="hidden" name="longitude" class="longitude">
                                </div>
                             </div>
                          </div>
                          <div class="form-row">
                             <div class="col-12">
                                <label> Cover Letter <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="bid-textarea" name="cover_letter" rows="5"></textarea>
                                <span class="text-danger danger">
                                    @error('cover_letter')
                                        {{ $message }}
                                    @enderror
                                </span>
                             </div>
                             <div class="col-12 my-3">
                                <div class="form-group">
                                   <label>Attachments</label>
                                   <div class="input-group">
                                      <input type="file" class="form-control" name="attachments[]" id="inputGroupFile01">
                                      <div class="input-group-prepend">
                                         <div class="input-group-text"><i class="fa fa-image"></i></div>
                                      </div>
                                   </div>
                                </div>
                             </div>
                             <div class="col-md-12">
                                <button type="submit" class="btn btn-theme btn-loading" id="btn_project_bid" data-post-id="225">Submit Proposal</button>
                             </div>
                          </div>
                    </form>
                 </div>
              </div>
            @endif
            </div>
          </div>
          <div class="col-lg-4 col-xl-4 col-xs-12 col-sm-12 col-md-12">
             <div class="project-sidebar position-sticky">
                <div class="project-price">
                   <div class="card-body">
                      <div class="row">
                         <div class="col">
                            <span class="price-label"> Budget</span>
                            <div class="price">
                              ₱ {{ number_format($project->cost, 2) }}
                            </div>
                         </div>
                         <div class="feature"> <i class="fas fa-wallet"></i> </div>
                      </div>
                      <div class="price-bottom">
                         <small class="price_type ">{{ $project->project_cost_type }}</small>
                      </div>
                   </div>
                </div>
                <div class="fr-project-f-profile">
                   <div class="fr-project-f-product">
                     <div class="fr-project-f-fetured"> <a href=""><img src="../../../images/user/profile/{{ $project->employer->user->profile_image }}" style="height: 100px !important; object-fit: cover !important;" alt="" class="img-fluid"></a> </div>
                   </div>
                   <div class="fr-project-f-user-details">
                      <a href="">
                         <h3><i class="fa fa-check protip" data-pt-position="top" data-pt-scheme="black" data-pt-title=" Verified" aria-hidden="true"></i>{{ $project->employer->display_name }}</h3>
                      </a>
                      <span>Member since {{ date_format(new DateTime($project->employer->created_at), "F d, Y")}}</span>
                   </div>
                   <a href="/employer/view/{{ $project->employer->user_id }}" class="btn-style">View Profile</a>
                </div>
                <div class="fr-project-f-employers">
                   <div class="fr-project-employer-details">
                      <h3> About The Employer</h3>
                   </div>
                   <ul>
                      <li>
                         <div class="fr-project-method"> <i class="fal fa-globe" aria-hidden="true"></i>
                           <span>{{ $project->employer->address }}</span>
                         </div>
                      </li>
                      <li>
                         <div class="fr-project-method"> <i class="fal fa-check-square" aria-hidden="true"></i> <span>{{ $project->employer->tagline }}</span> </div>
                      </li>
                   </ul>
                </div>
                <div class="fl-advert-box">
                  <a href="javascript:void(0)"><img src="../../../images/logo/main-logo.png" width="124" alt="exertio theme" class="img-fluid"></a>
                </div>
                <p class="report-button text-center">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#report-modal"><i class="fas fa-exclamation-triangle"></i>Report Project</a>
                </p>
               </div>
          </div>
       </div>
    </div>
</section>
<div class="modal fade forget_pwd show" id="report-modal" data-backdrop="static" data-keyboard="false" aria-modal="true" role="dialog">
    <div class="modal-dialog">
       <div class="modal-content">
          <form class="modal-from report-form" method="POST" id="report-form">
             <div class="modal-header">
                <h5 class="modal-title">Report this Project</h5>
                <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
             </div>
             <div class="modal-body">
                <div class="fr-report-form">
                   <div class="form-group">
                      <label>Choose Reason</label>
                      <select name="report_category" class="form-control general_select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                         <option value="357">
                            Duplicate
                         </option>
                         <option value="356">
                            Fake
                         </option>
                      </select>
                   </div>
                   <div class="form-group">
                      <label>Provide details</label>
                      <textarea name="report_desc" class="form-control" id="" required="" data-smk-msg="Required field"></textarea>
                   </div>
                   <div class="form-group">
                      <input type="hidden" id="fl_report_nonce" value="bf19104017">
                      <button type="button" id="btn-report" class="btn btn-theme btn-loading btn-report" data-post-id="225 ">Save &amp; Submit<span class="bubbles"> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> </span></button>
                   </div>
                </div>
             </div>
          </form>
       </div>
    </div>
</div>
<script src="../../../js/user-location.js"></script>
@endsection


@push('scripts')
<script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js"></script>
<script>
  $('#region').on('change', function(){
     $('#province').ph_locations({'location_type': 'provinces'});
  });

  $('#region').ph_locations('fetch_list');
</script>
@endpush

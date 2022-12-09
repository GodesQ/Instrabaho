@extends('layout.layout')

@section('content')

<style>
    #map-canvas {
       height: 300px;
       width: 100%;
   }
</style>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @push('scripts')
            <script>
                toastr.error('{{ $error }}', 'Error')
            </script>
        @endpush
    @endforeach
@endif

<section class="add-section-padding">
    <div class="container pt-4">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Send Offer to Freelancer</h3>
                        <div class="my-2 mt-4">
                            <form action="#" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-5 col-sm-12 my-2">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold" style="color: #000 !important;">What Project do you want to offer?</div>
                                            <select name="project_id" id="project_id" class="form-control select2">
                                                <option value="">Select Project</option>
                                                @forelse ($employer->projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                                @empty
                                                    <option value="">No Projects Found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 my-2">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold" style="color: #000 !important;">What is your prefer pay type?</div>
                                            <div class="input-group">
                                                <select name="project_cost_type" class="form-control" id="project_cost_type">
                                                    <option value="Fixed">Fixed</option>
                                                    <option value="Hourly">Hourly</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 my-2">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold" style="color: #000 !important;">How much is your budget?</div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">₱</span>
                                                </div>
                                                <input type="number" min="100" name="offer_price" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 my-2">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold" style="color: #000 !important;">Any Private Message to Freelancer?</div>
                                            <textarea name="private_message" id="private_message" cols="30" rows="10" class="form-control" placeholder="Send Private Message to Freelancer"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="proposal_user_token" value="{{ base64_encode('employer') }}">
                                    <div class="form-footer text-right mt-5">
                                        <input type="hidden" name="freelancer_id" value="{{ $freelancer->id }}">
                                        <input type="hidden" name="employer_id" value="{{ $employer->id }}">
                                        <button class="btn btn-theme" type="submit">Send Offer</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="fr-project-f-profile">
                    <div class="fr-project-f-product">
                      <div class="fr-project-f-fetured"> <a href=""><img src="../../../images/user/profile/{{ $freelancer->user->profile_image }}" style="height: 100px !important; object-fit: cover !important;" alt="" class="img-fluid"></a> </div>
                    </div>
                    <div class="fr-project-f-user-details">
                       <a href="">
                          <h3><i class="fa fa-check protip" data-pt-position="top" data-pt-scheme="black" data-pt-title=" Verified" aria-hidden="true"></i>{{ $freelancer->display_name }}</h3>
                       </a>
                       <span>Member since {{ date_format(new DateTime($freelancer->created_at), "F d, Y")}}</span>
                    </div>
                    <a href="/freelancer/view/{{ $freelancer->display_name }}" class="btn-style">View Profile</a>
                 </div>
                 <div class="fr-project-f-employers">
                    <div class="fr-project-employer-details">
                       <h3> About The Freelancer</h3>
                    </div>
                    <ul>
                       <li>
                          <div class="fr-project-method"> <i class="fal fa-globe" aria-hidden="true"></i>
                            <span>{{ $freelancer->address }}</span>
                          </div>
                       </li>
                       <li>
                          <div class="fr-project-method"> <i class="fal fa-check-square" aria-hidden="true"></i> <span>{{ $freelancer->tagline }}</span> </div>
                       </li>
                    </ul>
                 </div>
            </div>
        </div>
    </div>
</section>

<script src="../../../js/user-location.js"></script>

@endsection

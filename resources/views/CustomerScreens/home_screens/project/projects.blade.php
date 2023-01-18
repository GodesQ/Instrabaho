@forelse($projects as $project)
<div class="col-xxl-4 col-xl-6 col-md-6 my-2">
    <a href="/projects/{{ $project->id }}/{{ $project->title }}">
        <div class="px-3 py-4" style="box-shadow: 10px 10px 5px 0px rgba(181, 230, 250, 0.22);">
            <div class="d-flex justify-content-between align-items-start">
                <div style="width: 30%">
                    @if ($project->employer->user->profile_image)
                        <img class="" src="../../../images/user/profile/{{ $project->employer->user->profile_image }}" alt="profile image" style="width: 55px; height: 55px; border-radius: 50%;">
                    @else
                        <img src="../../../images/user-profile.png" alt="" style="width: 65px; height: 65px; border-radius: 50%;">
                    @endif
                    {{-- <div class="d-flex">
                        @for ($i = 0; $i < round($project->employer->rate); $i++)
                            <i class="fas fa-star my-2" style="color: #04bbff !important; font-size: 9px;" aria-hidden="true"></i>
                        @endfor
                    </div>
                    <div style="font-size: 9px;">{{ $project->employer->total_reviews }} Reviews</div> --}}
                </div>
                <div style="width: 65%" class="fr-project-content">
                    <div class="fr-project-f-des" style="background: transparent !important; padding: 0 !important; min-height: 145px; max-height: 200px;">
                        <div style="margin: 0 !important;" class="h6">
                            <a href="/projects/{{ $project->id }}/{{ $project->title }}" style="color: black; font-weight: 500; font-size: 15px;">{{ strlen($project->title) > 40 ? substr($project->title, 0, 40) . '...' : $project->title }}</a>
                        </div>
                        <div style="color: rgb(99, 99, 99); padding: 0;">
                            {{ $project->employer->user->firstname . ' ' . $project->employer->user->lastname }}
                        </div>
                        <div  class="primary font-weight-normal">₱ {{ number_format($project->cost, 2) }} <span>({{ $project->project_cost_type }})</span></div>
                         <div class="my-2">
                            <div class="font-weight-medium"><i class="feather icon-target warning"></i> Actively Looking for</div>
                            <ul class="fr-project-skills">
                                <!-- convert the json array ids into model and get to fetch in blade -->
                                @foreach($project->project_skills as $skill)
                                    <li class="badge badge-warning p-50 my-50 font-weight-normal" style="background: #004E88 !important;">{{ $skill->skill_name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div style="width: 5%;" class="d-flex justify-content-between flex-row">
                    <a href="" class="secondary h5"><i class="fa fa-bookmark"></i></a>
                </div>
            </div>
            <div class="text-right">
                <a href="/projects/{{ $project->id }}/{{ $project->title }}" class="btn btn-outline-primary">Apply Now <i class="fa fa-send"></i></a>
            </div>
        </div>
    </a>
</div>
 @empty
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="../../../images/illustrations/no-data.png" style="width: 300px;" alt="">
                <h2>No Projects Found</h2>
            </div>
        </div>
    </div>
@endforelse

    <div class="fl-navigation">
        {{ $projects->links() }}
    </div>




@forelse($projects as $project)
    <div class="col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12">
        <div class="fr-right-detail-box">
        <div class="fr-right-detail-content">
            <div class="fr-right-details-products">
                @if($project->project_type == 'featured')
                    <div class="features-star"><i class="fa fa-star" aria-hidden="true"></i></div>
                @endif
                <div class="fr-right-views">
                    <ul>
                    <li><span><a href="employer-detail.html"><i class="fa fa-check" aria-hidden="true"></i>{{ $project->employer->display_name }}</a></span> </li>
                    </ul>
                </div>
                <div class="fr-jobs-price">
                    <div class="style-hd">
                    <span class="style-6"><span class="currency">₱ </span><span class="price">{{ number_format($project->cost, 2) }}</span></span><small class="protip" data-pt-position="top" data-pt-scheme="black" data-pt-title=""><i class="far fa-question-circle" aria-hidden="true"></i></small>
                    </div>
                    <p>({{ $project->project_cost_type }})</p>
                </div>
                <div class="fr-right-details2">
                    <a href="{{ route('project.view', $project->id)}}">
                    <h3 title="{{ $project->title }}">{{ $project->title }}</h3>
                    </a>
                </div>
                <div class="fr-right-product">
                    <ul class="skills">
                        <!-- convert the json array ids into model and get to fetch in blade -->
                        @php $project->setSkills(json_decode($project->skills)) @endphp
                        @php $project->getSkills() @endphp

                        @foreach($project->skills_name as $skill)
                            <li class=""><a href="#">{{ $skill->skill_name }}</a></li>
                        @endforeach

                    </ul>
                </div>
                <div class="fr-right-index">
                    <p>{{ substr($project->description, 0, 200) . '...' }}</p>
                </div>
            </div>
        </div>
        <div class="fr-right-information">
            <div class="fr-right-list">
                <ul>
                    <li>
                        <p class="heading font-weight-bold">Proposals</p>
                        <span>1 Received</span>
                    </li>
                    <li>
                        <p class="heading font-weight-bold">Location</p>
                        <span>{{ $project->location }}</span>
                    </li>
                    @if($project->distance)
                        <li>
                            <p class="heading font-weight-bold">Distance</p>
                            <span>{{ number_format($project->distance, 2) }} km</span>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="fr-right-bid" style="width: 30%;">
                <ul>
                    <li><a href="{{ route('project.view', $project->id)}}" class="btn btn-theme btn-theme-secondary">View Project</a></li>
                </ul>
            </div>
        </div>
        </div>
    </div>
 @empty

@endforelse

<div class="fl-navigation">
    {{ $projects->links() }}
</div>

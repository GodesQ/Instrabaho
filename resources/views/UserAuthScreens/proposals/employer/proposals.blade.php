@if (isset($proposals))
    @forelse ($proposals as $proposal)
        <div class="d-flex justify-content-center my-1">
            <div class="container" style="width: 95% !important;">
                <div class="d-xl-flex p-2"
                    style="gap: 20px; box-shadow: 1px 0px 20px rgb(0 0 0 / 7%); position: relative !important; background: #fff;">
                    <div>
                        @if ($proposal->freelancer->user->profile_image)
                            <img class="rounded"
                                src="../../../images/user/profile/{{ $proposal->freelancer->user->profile_image }}"
                                alt="employer_image" style="height: 100px !important;">
                        @else
                            <img src="../../../images/user-profile.png" alt="" style="height: 100px !important;">
                        @endif
                    </div>
                    <div>
                        <a href="/freelancer/view/{{ $proposal->freelancer->display_name }}" style="color: #003066;">
                            <span
                                class="mr-50">{{ $proposal->freelancer->user->firstname . ' ' . $proposal->freelancer->user->lastname }}</span>
                        </a>
                        <div>
                            @for ($i = 0; $i < $proposal->freelancer->rate; $i++)
                                <span>
                                    <i class="fa fa-star" style="color: #04bbff !important; font-size: 10px;"
                                        aria-hidden="true"></i>
                                </span>
                            @endfor
                            <span class="font-weight-bold" style="font-size: 10px;">(
                                {{ $proposal->freelancer->total_reviews }}
                                {{ $proposal->freelancer->total_reviews > 1 ? 'Reviews' : 'Review' }} )</span>
                        </div>
                        <h3 class="text-secondary">{{ $proposal->freelancer->tagline }}</h3>
                        <p class="font-weight-light">
                            {{ strlen($proposal->freelancer->description) > 150 ? substr($proposal->freelancer->description, 0, 150) . '...' : $proposal->freelancer->description }}
                        </p>
                        <div class="mt-2">
                            <a href="/proposal/info/{{ $proposal->id }}?act=message"
                                class="btn btn-outline-primary">Chat </a>
                            <a href="/proposal/info/{{ $proposal->id }}" class="btn btn-primary">View Proposal</a>
                            @if ($proposal->status == 'pending')
                                <a href="/project/create-contract/proposal/{{ $proposal->id }}"
                                    class="btn btn-success">Hire</a>
                            @endif
                        </div>
                    </div>
                    <div class="badge badge-{{ $proposal->status == 'approved' ? 'success' : 'primary' }} position-absolute"
                        style="top: 10px; right: 20px;">
                        {{ $proposal->status }}
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <img src="../../../images/illustrations/no-data.png" alt="" class=""
                        style="width: 200px !important;">
                    <h2>No Proposals Found</h2>
                </div>
            </div>
        </div>
    @endforelse
    {{-- <div class="sidebar-proposal-container-overlay"></div>
    <div class="sidebar-proposal-container"></div> --}}
    {!! $proposals->links() !!}
@else
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="../../../images/illustrations/find.png" alt="" class=""
                    style="width: 200px !important;">
                <h2>Search Project</h2>
            </div>
        </div>
    </div>
@endif

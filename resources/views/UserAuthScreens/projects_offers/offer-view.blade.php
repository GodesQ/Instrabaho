@extends('layout.user-layout')

@section('title')
    PROJECT OFFER - {{ $project_offer->project->title }}
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="my-1">
                        @if (session()->get('role') == 'freelancer')
                            <a href="/freelancer/proposals" class="btn btn-secondary">Back to Proposals</a>
                        @else
                            <a href="/employer/projects/info/{{ $project_offer->project->title }}" class="btn btn-secondary">Back to Project</a>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if ($project_offer->is_freelancer_approve && $project_offer->status == 'pending')
                                <div class="bs-callout-success callout-bordered my-1" >
                                    <div class="media align-items-stretch">
                                        <div class="d-flex align-items-center bg-success p-2">
                                            <i class="fa fa-thumbs-o-up white font-medium-5"></i>
                                        </div>
                                        <div class="media-body p-1">
                                            <strong>The Worker Approve the Offer!</strong>
                                            <p>It means that you can now create a contract to continue.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <ul class="nav nav-tabs nav-underline no-hover-bg nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab32" data-toggle="tab" href="#active32" aria-controls="active32" role="tab" aria-selected="true">Project Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab32" data-toggle="tab" href="#link32" aria-controls="link32" role="tab" aria-selected="false">Message</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active in" id="active32" aria-labelledby="active-tab32" role="tabpanel">
                                    <div class="container py-2">
                                        <div class="text-right my-1">
                                            @if (session()->get('role') == 'freelancer' && !$project_offer->is_freelancer_approve)
                                                <button id="{{ $project_offer->id }}" class="btn btn-success accept-offer-btn">Accept Offer</button>
                                            @endif

                                            @if(session()->get('role') == 'employer' && $project_offer->is_freelancer_approve && !$project_offer->status == 'pending')
                                                <a href="/project/create-contract/offer/{{ $project_offer->id }}" class="btn btn-success">Hire Worker</a>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div>
                                                <h2>{{ $project_offer->project->title }}</h2>
                                                <h6>{{ $project_offer->project->category->name }}</h6>
                                            </div>
                                            <div>
                                                <h6 class="font-weight-bold">Project Created Date</h6>
                                                <div>{{ date_format( new DateTime($project_offer->project->created_at), 'F d, Y') }}</div>
                                            </div>
                                        </div>
                                        {{-- <div class="my-2">
                                            <h6 class="font-weight-bold">Skills Needed</h6>
                                            @php $project_offer->project->setSkills(json_decode($project_offer->project->skills)) @endphp
                                            @php $project_offer->project->getSkills() @endphp
                                            @foreach($project_offer->project->skills_name as $skill)
                                                <div class="badge badge-warning p-50 mr-1">{{ $skill->skill_name }}</div>
                                            @endforeach
                                        </div> --}}
                                        <div class="my-2">
                                            <h6 class="font-weight-bold">Description</h6>
                                            <p>{{ $project_offer->project->description }}</p>
                                        </div>
                                        <div class="my-1">
                                            <h6 class="font-weight-bold">Project Budget</h6>
                                            <h3> ₱ {{ number_format($project_offer->project->cost, 2) }}</h3>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold">Project Budget Type</h6>
                                            <h6>{{ $project_offer->project->project_cost_type }}</h6>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold">Duration Date</h6>
                                            <h6>{{ date_format(new DateTime($project_offer->project->start_date), 'F d, Y') }} - {{ date_format(new DateTime($project_offer->project->end_date), 'F d, Y') }}</h6>
                                        </div>
                                        <div class="my-1">
                                            <h6 class="font-weight-bold">Attachments</h6>
                                            <div class="d-flex flex-wrap gap-10">
                                                @forelse (json_decode($project_offer->project->attachments) as $attachment)
                                                    <a href="{{ '../../../images/projects/' . $attachment }}" target="_blank" class="d-flex justify-content-between align-items-center p-50 border">
                                                        <img src="../../../images/projects/{{ $attachment }}" style="width: 80px !important; height: 100% !important;" alt="project attachment">
                                                        <div class="mx-1">{{ $attachment }}</div>
                                                    </a>
                                                @empty
                                                    No Attachment
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container py-2">
                                        <h3>Employer Info</h3>
                                        <div class="my-1">
                                            <span class="font-weight-bold">Name :</span> {{ $project_offer->project->employer->user->firstname . ' ' . $project_offer->project->employer->user->lastname }}
                                        </div>
                                        <div class="my-1">
                                            <span class="font-weight-bold">Display Name :</span> {{ $project_offer->project->employer->display_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="link32" aria-labelledby="link-tab32" role="tabpanel">
                                    <div class="wrapper">
                                        <section class="chat-area">
                                            <header class="header">
                                                <div style="width: 60%" class="d-flex align-items-center justify-content-start header-content">
                                                    @if($project_offer->freelancer->user->profile_image)
                                                        <img src="../../../images/user/profile/{{ $receiver->user->profile_image }}" alt="" />
                                                    @else
                                                        <img src="../../../images/user-profile.png" alt="" width="80" height="80" style="object-fit: cover;border-radius: 50px; border: 1px solid black;">
                                                    @endif
                                                    <div class="details">
                                                        <span>{{ $receiver->user->firstname }} {{ $receiver->user->lastname }}</span>
                                                        <p>{{ $receiver->tagline }}</p>
                                                    </div>
                                                </div>
                                            </header>
                                            <div class="chat-box"></div>
                                            <form action="#" class="typing-area">
                                                @csrf
                                                <input type="hidden" value="{{ $project_offer->id }}" id="msg_id" name="msg_id" />
                                                <input type="hidden" value="{{ base64_encode('offer') }}" id="type" name="type">
                                                <input type="text" class="incoming_id" name="incoming_id" value="{{ $incoming_msg_id }}" hidden />
                                                <input type="text" class="outgoing_id" name="outgoing_id" value="{{ $outgoing_msg_id }}" hidden />
                                                <input type="text" name="message" class="input-field" id="message_input" placeholder="Type a message here..."/>
                                                <button><i class="fa fa-send"></i></button>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="../../../js/project-chat.js"></script>
<script>

    window.addEventListener('load', () => {
        let url_string = location.href;
        let url = new URL(url_string);
        var action = url.searchParams.get("act");
        if(action == 'message') {
            $('#link-tab32').click();
        }
    });

    $('.accept-offer-btn').on('click', function () {
        let id = $(this).attr("id");
        let csrf = "{{ csrf_token() }}";
        Swal.fire({
            title: "Accept Offer",
            text: "Are you sure you want to accept the offer?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, accept it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/offer/accept_offer`,
                    method: 'PUT',
                    data: {
                        _token: csrf,
                        id: id,
                    },
                    success: function (response) {
                        if(response.status) {
                            Swal.fire(
                                "Updated!",
                                `${response.message}`,
                                "success"
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire(
                                "Failed!",
                                `${response.message}`,
                                "error"
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                });
            }
        });
    })
</script>
@endpush

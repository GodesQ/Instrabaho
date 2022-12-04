@extends('layout.user-layout')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row my-1">
                                    <div class="col-xl-3 col-lg-2">
                                        <img src="../../../images/user/profile/{{ $proposal->freelancer->user->profile_image }}" alt="" width="80" height="80" style="object-fit: cover;border-radius: 50px; border: 1px solid black;">
                                    </div>
                                    <div class="col-xl-9 col-lg-10">
                                        <h4 class="font-weight-bold">{{ $proposal->freelancer->user->firstname }} {{ $proposal->freelancer->user->lastname }}</h4>
                                        <div class="font-weight-bold">{{ $proposal->freelancer->tagline }}</div>
                                        <div>{{ $proposal->freelancer->location }}</div>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-xl-3 col-lg-4">
                                        <div class="font-weight-bold">Hourly</div>
                                        <h4>₱ {{ number_format($proposal->freelancer->hourly_rate, 2) }}</h4>
                                    </div>
                                    <div class="col-xl-3 col-lg-4">
                                        <div class="font-weight-bold">Gender</div>
                                        <h4>{{ $proposal->freelancer->gender }}</h4>
                                    </div>
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="font-weight-bold">Freelancer Type</div>
                                        <h4>{{ $proposal->freelancer->freelancer_type }}</h4>
                                    </div>
                                    <div class="col-md-12 my-1">
                                        <div class="font-weight-bold">Freelancer Description</div>
                                        <div>{{ $proposal->freelancer->description }}</div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="font-weight-bold">Member Since</div>
                                        <div>{{ date_format(new DateTime($proposal->freelancer->created_at), "F d, Y")}}</div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-12 font-weight-bold">Skills</div>
                                    <div class="col-md-12">
                                        @forelse($proposal->freelancer->skills as $skill)
                                            <li class="badge badge-warning p-50 circle">{{ $skill->skill->skill_name }}</li>
                                        @empty

                                        @endforelse
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <a href="/{{session()->get('role')}}/proposals" class="btn btn-secondary">Back to Proposals</a>
                                    </div>
                                    <div class="col-md-12 col-lg-6 text-lg-right my-2">
                                        @if(session()->get('role') == 'employer' && $proposal->status != 'completed')
                                                <button class="btn btn-success">Hire Freelancer  <i class="fa fa-thumbs-up"></i></button>
                                            @if($proposal->status == 'approved')
                                                <a href="/pay_job/project/{{ $proposal->id }}" class="btn btn-primary">Set to Complete & Pay Job</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="nav nav-tabs nav-underline no-hover-bg" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab31" data-toggle="tab" aria-controls="tab31" href="#tab31" role="tab" aria-selected="true"><i class="fa fa-folder"></i> Application</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab32" data-toggle="tab" aria-controls="tab32" href="#tab32" role="tab" aria-selected="false"><i class="feather icon-message-square"></i> Message</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content px-1 pt-1">
                                    <div class="tab-pane active" id="tab31" role="tabpanel" aria-labelledby="base-tab31">
                                        <div class="row">
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Full Name : <span class="font-weight-normal mx-1">{{ $proposal->freelancer->user->firstname }} {{ $proposal->freelancer->user->lastname }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Display Name : <span class="font-weight-normal mx-1">{{ $proposal->freelancer->display_name }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Tagline : <span class="font-weight-normal mx-1">{{ $proposal->freelancer->tagline }}</span></div>
                                            </div>
                                        </div>
                                        <h3 class="font-weight-bold my-1">Project Info</h3>
                                        <div class="row">
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Title : <span class="font-weight-normal mx-1">{{ $proposal->project->title }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Category : <span class="font-weight-normal mx-1">{{ $proposal->project->category->name }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Level : <span class="font-weight-normal mx-1">{{ $proposal->project->project_level }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Cost Type : <span class="font-weight-normal mx-1">{{ $proposal->project->project_cost_type }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Duration : <span class="font-weight-normal mx-1">{{ $proposal->project->project_duration }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                @php $proposal->project->setSkills(json_decode($proposal->project->skills)) @endphp
                                                @php $proposal->project->getSkills() @endphp
                                                <div class="font-weight-bold">Skills Needed :
                                                    @foreach($proposal->project->skills_name as $skill)
                                                        <div class="badge badge-warning p-50 mx-1">{{ $skill->skill_name }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="font-weight-bold my-1">Proposal Info</h3>
                                        <div class="row">
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Offer Price : <span class="font-weight-normal mx-1" style="font-size: 30px;">₱ {{ number_format($proposal->offer_price, 2) }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Estimated Days : <span class="font-weight-normal mx-1">{{ $proposal->estimated_days }} Days</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Freelancer Address : <span class="font-weight-normal mx-1">{{ $proposal->address }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25">
                                                <div class="font-weight-bold">Project Cost Type : <span class="font-weight-normal mx-1">{{ $proposal->project_cost_type }}</span></div>
                                            </div>
                                            <div class="col-md-12 my-25 mt-2">
                                                <div class="font-weight-bold">Attachments :
                                                    @php
                                                        $attachments = json_decode($proposal->attachments)
                                                    @endphp
                                                    @forelse($attachments as $attachment)
                                                        <a href="./../../images/projects/proposal_attachments/{{ $attachment }}" target="_blank" class="badge badge-secondary p-75">{{ $attachment }}</a>
                                                    @empty
                                                        <span class="font-weight-normal">No Attachment Found</span>
                                                    @endforelse

                                                </div>
                                            </div>
                                            <div class="col-md-12 my-1 p-2 rounded" style="background:#f3f5f8;">
                                                <div class="font-weight-bold h2 my-1">Described Proposal</div>
                                                <div class="font-weight-normal ">@php echo nl2br($proposal->cover_letter); @endphp</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab32" role="tabpanel" aria-labelledby="base-tab32">
                                        <div class="wrapper">
                                            <section class="chat-area">
                                                <header
                                                    class="d-flex justify-content-between align-items-center header"
                                                >
                                                    <div
                                                        style="width: 60%"
                                                        class="d-flex align-items-center header-content"
                                                    >
                                                        <a href="/employer/proposals" class="back-icon"
                                                            ><i class="fa fa-arrow-left"></i
                                                        ></a>
                                                        <img
                                                            src="../../../images/user/profile/{{ $receiver->user->profile_image }}"
                                                            alt=""
                                                        />
                                                        <div class="details">
                                                            <span>{{ $receiver->user->firstname }} {{ $receiver->user->lastname }}</span>
                                                            <p>{{ $receiver->tagline }}</p>
                                                        </div>
                                                    </div>
                                                </header>
                                                <div class="chat-box"></div>
                                                <form action="#" class="typing-area">
                                                    @csrf
                                                    <input type="hidden" value="{{ $proposal->id }}" id="msg_id" name="msg_id" />
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
            $('#base-tab32').click();
        }
    });


    function updateStatus(e) {
        Swal.fire({
            title: "Update Status",
            text: "Are you sure you want to delete this?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/update_proposal_status`,
                    method: 'POST',
                    data: {
                        proposal_id : '{{ $proposal->id }}',
                        status : e.value,
                        project_id : '{{ $proposal->project_id }}',
                        _token: '{{ csrf_token()}}'
                    },
                    success: function (response) {
                        if(response.status == 201) {
                            Swal.fire(
                                "Update!",
                                "Record has been updated.",
                                "success"
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire(
                                "Error!",
                                "Error updating status.",
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
    }
</script>
@endpush

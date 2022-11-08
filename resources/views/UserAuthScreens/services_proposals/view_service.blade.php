@extends('layout.user-layout')
@section('content')
<div class="row">
    <div class="col-xl-4 col-lg-12">
        <div class="container">
            <ul id="progress">
                <li class="{{ $purchased_service->status == 'pending' ? 'active' : null }}">For Approval</li>
                <li class="{{ $purchased_service->status == 'approved' ? 'active' : null }}">Approved</li>
                <li class="{{ $purchased_service->status == 'completed' ? 'active' : null }}">Completed</li>
            </ul>
        </div>
        <div class="card container mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="font-weight-regular mt-2">
                            Owner :
                        </h5>
                        <div class="container">
                            <div class="font-weight-light">
                                <div class="font-weight-bold">
                                    <img style="object-fit: cover;" src="../../../images/user/profile/{{ $purchased_service->freelancer->user->profile_image }}" alt="" class="avatar avatar-sm">
                                    {{ $purchased_service->freelancer->display_name }}
                                </div>
                                <div class="font-weight-light">{{ $purchased_service->freelancer->user->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="font-weight-regular mt-2">
                            Client :
                        </h5>
                        <div class="container">
                            <div class="font-weight-light">
                                <div class="font-weight-bold">
                                    <img style="object-fit: cover;" src="../../../images/user/profile/{{ $purchased_service->employer->user->profile_image }}" alt="" class="avatar avatar-sm">
                                    {{ $purchased_service->employer->display_name }}
                                </div>
                                <div class="font-weight-light">{{ $purchased_service->employer->user->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="font-weight-regular mt-2">
                            Estimated Start Date :
                        </h5>
                        <div class="container">
                            <div class="font-weight-light">
                                <div class="font-weight-bold">
                                    <i class="feather icon-calendar"></i>
                                    {{ date_format(new DateTime($purchased_service->estimated_start_date), "F d, Y") }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="font-weight-regular mt-2">
                            Estimated Finish Date :
                        </h5>
                        <div class="container">
                            <div class="font-weight-light">
                                <div class="font-weight-bold">
                                    <i class="feather icon-calendar"></i>
                                    {{ date_format(new DateTime($purchased_service->estimated_finish_date), "F d, Y") }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid my-2">
                @if(session()->get('role') == 'employer')
                    <a href="/edit_service/{{ $purchased_service->service_id }}" class="btn btn-secondary"><i class="feather icon-log-out"></i> Back to Service</a>
                    <a href="/pay_job/service/{{ $purchased_service->id }}" class="btn btn-primary">Pay Job & Set to Complete</a>
                @else
                    <a href="/edit_service/{{ $purchased_service->service_id }}" class="btn btn-secondary"><i class="feather icon-log-out"></i> Back to Service</a>
                @endif
                @if($purchased_service->status == 'approved')
                    <button type="button" class="btn btn-danger">Cancel Service <i class="fa fa-thumbs-down"></i></button>
                @endif
                @if($purchased_service->status == 'pending')
                    <a href="/service_proposal_information/{{ $purchased_service->id }}" class="btn btn-success">Approved Offer <i class="fa fa-thumbs-up"></i></a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-12">
        <div class="container-fluid">
            <ul class="nav nav-tabs nav-underline no-hover-bg nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="active-tab32" data-toggle="tab" href="#active32" aria-controls="active32" role="tab" aria-selected="true">Service Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link-tab32" data-toggle="tab" href="#link32" aria-controls="link32" role="tab" aria-selected="false">Message</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="linkOpt-tab2" data-toggle="tab" href="#linkOpt2" aria-controls="linkOpt2">Cancel Details</a>
                </li>
            </ul>
            <div class="tab-content px-1 pt-1">
                <div class="tab-pane active in" id="active32" aria-labelledby="active-tab32" role="tabpanel">
                    <div class="card rounded">
                        <div class="card-body">
                            @php $attachments =
                            json_decode($purchased_service->service->attachments) @endphp
                            <div class="row">
                                <div class="col-xl-6 col-lg-12">
                                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            @foreach($attachments as $key => $attachment)
                                            <li
                                                data-target="#carousel-example-generic {{ $loop->first ? 'active' : null }}"
                                                data-slide-to="{{ $key }}"
                                                class="active"
                                            ></li>
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner" role="listbox">
                                            @foreach($attachments as $attachment)
                                            <div
                                                class="carousel-item {{ $loop->first ? 'active' : null }}"
                                            >
                                                <img
                                                    src="../../../images/services/{{ $attachment }}"
                                                    style="
                                                        height: 500px !important;
                                                        width: 100%;
                                                        object-fit: cover;
                                                    "
                                                    alt="First slide"
                                                />
                                            </div>
                                            @endforeach
                                        </div>
                                        <a
                                            class="carousel-control-prev"
                                            href="#carousel-example-generic"
                                            role="button"
                                            data-slide="prev"
                                        >
                                            <span
                                                class="carousel-control-prev-icon"
                                                aria-hidden="true"
                                            ></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a
                                            class="carousel-control-next"
                                            href="#carousel-example-generic"
                                            role="button"
                                            data-slide="next"
                                        >
                                            <span
                                                class="carousel-control-next-icon"
                                                aria-hidden="true"
                                            ></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12">
                                    <div class="container-fluid my-1">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5 class="font-weight-bold mt-2">
                                                    {{ $purchased_service->service->name }}
                                                </h5>
                                                <h6>
                                                    {{ $purchased_service->service->category->name }}
                                                </h6>
                                                <div style="font-size: 15px">
                                                    {{ $purchased_service->service->description }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-lg-12">
                                                <h5 class="font-weight-bold">Offer Details</h5>
                                                <div class="my-1">
                                                    <span class="text-primary">Message:</span> <br>
                                                    @php echo nl2br($purchased_service->message) @endphp
                                                </div>
                                                <div class="my-1">
                                                    <span class="text-primary">Location:</span>
                                                    {{ $purchased_service->location }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="link32" aria-labelledby="link-tab32" role="tabpanel">
                    <div class="container">
                        <div class="wrapper">
                            <section class="chat-area">
                                <header
                                    class="d-flex justify-content-between align-items-center header"
                                >
                                    <div
                                        style="width: 60%"
                                        class="d-flex align-items-center header-content"
                                    >
                                        <a onclick="history.back()" class="back-icon"
                                            ><i class="fa fa-arrow-left"></i
                                        ></a>
                                        <img
                                            src="../../../images/user/profile/{{ $receiver->user->profile_image }}"
                                            alt=""
                                        />
                                        <div class="details">
                                            <span>{{ $receiver->display_name }}</span>
                                            <p>{{ $receiver->tagline }}</p>
                                        </div>
                                    </div>
                                </header>
                                <div class="chat-box"></div>
                                <form action="#" class="typing-area">
                                    @csrf
                                    <input
                                        type="hidden"
                                        value="{{ $purchased_service->id }}"
                                        id="msg_id"
                                        name="msg_id"
                                    />
                                    <input
                                        type="text"
                                        class="incoming_id"
                                        name="incoming_id"
                                        value="{{ $incoming_msg_id }}"
                                        hidden
                                    />
                                    <input
                                        type="text"
                                        class="outgoing_id"
                                        name="outgoing_id"
                                        value="{{ $outgoing_msg_id }}"
                                        hidden
                                    />
                                    <input
                                        type="text"
                                        name="message"
                                        class="input-field"
                                        id="message_input"
                                        placeholder="Type a message here..."
                                    />
                                    <button><i class="fa fa-send"></i></button>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="linkOpt2" aria-labelledby="linkOpt-tab2" role="tabpanel">
                    <div class="d-flex justify-content center align-items-center flex-column card p-2" style="width: 100% !important;">
                        <img src="../../../images/icons/no_data_found.png" alt="" style="width: 300px;" class="img-fluid">
                        <h3 class="font-weight-bold text-primary">No Details Found</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="../../../js/chat.js"></script>
<script>
    // $(document).ready(function () {
    //     $(document).on("click", ".approve-btn", function (e) {
    //         e.preventDefault();
    //         let id = $(this).attr("id");
    //         let csrf = "{{ csrf_token() }}";
    //         Swal.fire({
    //             title: "Com Service?",
    //             text: "Are you sure you want to approved this?",
    //             icon: "question",
    //             showCancelButton: true,
    //             confirmButtonColor: "#3085d6",
    //             cancelButtonColor: "#d33",
    //             confirmButtonText: "Yes",
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 changeStatus('approved', csrf, id);
    //             }
    //         });
    //     });
    // });
</script>
@endpush

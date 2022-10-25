@extends('layout.user-layout') @section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card rounded">
            <div class="card-body">
                @php $attachments =
                json_decode($purchased_service->service->attachments) @endphp
                <div
                    id="carousel-example-generic"
                    class="carousel slide"
                    data-ride="carousel"
                >
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
                                    height: 400px !important;
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
                <div class="container-fluid my-1">
                    <div class="row">
                        <div class="col-lg-10">
                            <h5 class="font-weight-bold">
                                {{ $purchased_service->service->name }}
                            </h5>
                            <h6>
                                {{ $purchased_service->service->category->name }}
                            </h6>
                            <p style="font-size: 8px">
                                {!! $purchased_service->service->description !!}
                            </p>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-lg-12">
                            <h5 class="font-weight-bold">Customer Details</h5>
                            <div class="my-1">
                                <span class="text-primary">Name:</span>
                                {{ $purchased_service->employer->user->firstname }}
                                {{ $purchased_service->employer->user->lastname }}
                            </div>
                            <div class="my-1">
                                <span class="text-primary">Email:</span>
                                {{ $purchased_service->employer->user->email }}
                            </div>
                            <div class="my-1">
                                <span class="text-primary">Contact No:</span>
                                {{ $purchased_service->employer->contactno }}
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-lg-12">
                            <h5 class="font-weight-bold">Approval Details</h5>
                            <div class="my-1">
                                <span class="text-primary">Message:</span>
                                {{ $purchased_service->message }}
                            </div>
                            <div class="my-1">
                                <span class="text-primary">Location:</span>
                                {{ $purchased_service->location }}
                            </div>
                            <div class="my-1">
                                <span class="text-primary"
                                    >Estimated Date:</span
                                >
                                {{ date_format(new DateTime($purchased_service->estimated_date), "F d, Y") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="wrapper">
            <section class="chat-area">
                <header
                    class="d-flex justify-content-between align-items-center header"
                >
                    <div
                        style="width: 60%"
                        class="d-flex align-items-center header-content"
                    >
                        <a href="/purchased_service/ongoing" class="back-icon"
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
                    @if(session()->get('role') == 'employer')
                        <div
                            style="width: 40%; text-align: right"
                            class="header-content header-content-buttons"
                        >
                            <button class="btn btn-solid btn-outline-success">
                                Completed
                            </button>
                            <button class="btn btn-solid btn-outline-danger">
                                Cancel
                            </button>
                        </div>
                    @endif
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
@endsection 

@push('scripts')
<script src="../../../js/chat.js"></script>
@endpush

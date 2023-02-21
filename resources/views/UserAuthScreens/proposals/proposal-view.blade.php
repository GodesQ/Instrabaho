@extends('layout.user-layout')


@section('title')
    {{ $proposal->project->title }}
@endsection

@section('content')
<<<<<<< HEAD
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 rounded">
                            <div class="card">
                                <div class="card-header font-weight-bold text-uppercase"
                                    style="padding: 1.6rem 1rem; border-bottom: 1px solid lightgray;">
                                    <h2 class="font-weight-normal">ALL INFORMATION</h2>
                                </div>
                                <div class="card-body" style="background: #fefefe !important;">
                                    <div class="row">
                                        <div class="col-md-12 my-25">
                                            <div class="font-weight-bold">Full Name : <span class="font-weight-normal mx-1">{{ $proposal->freelancer->user->firstname }}
                                                    {{ $proposal->freelancer->user->lastname }}</span></div>
                                        </div>
                                        <div class="col-md-12 my-25">
                                            <div class="font-weight-bold">Display Name : <span
                                                    class="font-weight-normal mx-1">{{ $proposal->freelancer->display_name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 my-25">
                                            <div class="font-weight-bold">Title : <span
                                                    class="font-weight-normal mx-1">{{ $proposal->project->title }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 my-25">
                                            <div class="font-weight-bold">Cost Type : <span
                                                    class="font-weight-normal mx-1">{{ $proposal->project->project_cost_type }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 my-25">
                                            <div class="font-weight-bold">Duration : <span
                                                    class="font-weight-normal mx-1">{{ date_format(new DateTime($proposal->project->start_date), 'F d, Y') }}
                                                    -
                                                    {{ date_format(new DateTime($proposal->project->end_date), 'F d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 my-25">
                                            <div class="font-weight-bold">Offer Price : <span
                                                    class="font-weight-normal mx-1" style="font-size: 22px;">₱
                                                    {{ number_format($proposal->offer_price, 2) }}</span></div>
                                        </div>
                                        <div class="col-md-12 my-25">
                                            <div class="font-weight-bold">Address : <span
                                                    class="font-weight-normal mx-1">{{ $proposal->address }}</span></div>
                                        </div>
                                        <div class="col-md-12 my-25">
                                            <div class="font-weight-bold">Project Cost Type : <span
                                                    class="font-weight-normal mx-1">{{ $proposal->project_cost_type }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 my-25 mt-2">
                                            <div class="font-weight-bold">Attachments :
                                                @php $attachments = json_decode($proposal->attachments) @endphp
                                                @forelse($attachments as $attachment)
                                                    <a href="./../../images/projects/proposal_attachments/{{ $attachment }}"
                                                        target="_blank"
                                                        class="badge badge-secondary p-75">{{ $attachment }}</a>
                                                @empty
                                                    <span class="font-weight-normal">No Attachment Found</span>
                                                @endforelse
                                            </div>
                                        </div>
                                        @if ($proposal->cover_letter)
                                            <div class="col-md-12 my-1 p-2 rounded" style="background:#f3f5f8;">
                                                <div class="font-weight-bold h2 my-1">Described Proposal</div>
                                                <div class="font-weight-normal ">@php echo nl2br($proposal->cover_letter); @endphp</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wrapper">
                                <section class="chat-area">
                                    <header class="header">
                                        <div style="width: 60%"
                                            class="d-flex align-items-center justify-content-start header-content">
                                            @if ($proposal->freelancer->user->profile_image)
                                                <img src="../../../images/user/profile/{{ $receiver->user->profile_image }}"
                                                    alt="" />
                                            @else
                                                <img src="../../../images/user-profile.png" alt="" width="80"
                                                    height="80"
                                                    style="object-fit: cover; border-radius: 50px; border: 1px solid black;">
                                            @endif
                                            <div class="details">
                                                <span>{{ $receiver->user->firstname }}
                                                    {{ $receiver->user->lastname }}</span>
                                                <p>{{ $receiver->tagline }}</p>
                                            </div>
                                        </div>
                                    </header>
                                    <div class="chat-box"></div>
                                    <form action="#" class="typing-area">
                                        @csrf
                                        <input type="hidden" value="{{ $proposal->id }}" id="msg_id" name="msg_id" />
                                        <input type="hidden" name="receiver_user_id" value="{{ $receiver->user->id }}"
                                            id="receiver_user_id">
                                        <input type="hidden" name="sender_user_id" value="{{ session()->get('id') }}"
                                            id="sender_user_id">
                                        <input type="hidden" value="{{ base64_encode('proposal') }}" id="type"
                                            name="type">
                                        <input type="text" class="incoming_id" name="incoming_id"
                                            value="{{ $incoming_msg_id }}" hidden />
                                        <input type="text" class="outgoing_id" name="outgoing_id"
                                            value="{{ $outgoing_msg_id }}" hidden />
                                        {{-- <textarea name="message" class="form-control" cols="100" rows="2" id="message_input"></textarea> --}}
                                        <input type="text" name="message" class="input-field" id="message_input"
                                            placeholder="Type a message here..." />
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
@endsection

@push('scripts')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="../../../js/project-chat.js"></script>
@endpush

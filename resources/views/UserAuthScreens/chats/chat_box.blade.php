@extends('layout.user-layout')

@section('title', 'Chats')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="chat-header">
                                        <div class="active-chat-header chat-header-tab">Projects</div>
                                        <div class="chat-header-tab">Services</div>
                                    </div>
                                    <div class="chat-body">
                                        <ul class="chat-list"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="default-chat-container">
                                <div class="default-chat-content">
                                    <img class="default-chat-image" src="../../../images/chat-message.gif" alt="" >
                                    <h3 class="default-chat-message">Your Messages</h3>
                                    <h5 class="default-chat-submessage mb-2">Send private photos and messages.</h5>
                                    <button class="default-chat-button btn btn-primary py-1 px-1" >Recent Message</button>
                                </div>
                            </div>
                            <div class="wrapper">
                                <section class="chat-area">
                                    <header class="header">
                                        <div style="width: 60%"
                                            class="d-flex align-items-center justify-content-start header-content">
                                                <img src="../../../images/user-profile.png" alt="" width="80"/>
                                            <div class="details">
                                                <span>James Pogi</span>
                                                <p>FreeLancer</p>
                                            </div>
                                        </div>
                                    </header>
                                    <div class="chat-box"></div>
                                    <form action="#" class="typing-area">
                                        @csrf
                                        <input type="hidden" value="" id="msg_id_input" name="msg_id" />
                                        <input type="hidden" name="receiver_user_id" value="" id="receiver_user_id_input">
                                        <input type="hidden" value="proposal" id="type_input" name="type">
                                        <input type="hidden" id="incoming_id_input" name="incoming_id" value="">
                                        <input type="hidden" id="outgoing_id_input" name="outgoing_id" value="">
                                        <input type="hidden" name="sender_user_id" id="sender_user_id" value="{{ session()->get('id') }}">
                                        <input type="text" name="message" class="input-field" id="message_input" placeholder="Type a message here..." />
                                        <button><i class="fa fa-send"></i></button>
                                    </form>
                                    <input type="hidden" id="chat_type" name="chat_type" value="projects">
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
<script src="../../../app-assets/js/scripts/chat-page.js"></script>
@endpush

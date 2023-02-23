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
                                            <ul class="chat-list">
                                                <li class="chat-list-item">
                                                    <div class="chat-user">
                                                        <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                                        <div class="chat-user-name">
                                                            James "Ultra Full Stack Developer" Garnfil
                                                            <div class="chat-user-message"> Miss na kita baby james</div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="chat-list-item">
                                                    <div class="chat-user">
                                                        <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                                        <div class="chat-user-name">
                                                            Boss James Garfield
                                                            <div class="chat-user-message"> Miss na kita baby james</div>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="chat-list-item">
                                                    <div class="chat-user">
                                                        <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                                        <div class="chat-user-name">
                                                            Boss James Garfield
                                                            <div class="chat-user-message"> Miss na kita baby james</div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="chat-list-item">
                                                    <div class="chat-user">
                                                        <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                                        <div class="chat-user-name">
                                                            Boss James Garfield
                                                            <div class="chat-user-message"> Miss na kita baby james</div>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="chat-list-item">
                                                    <div class="chat-user">
                                                        <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                                        <div class="chat-user-name">
                                                            Boss James Garfield
                                                            <div class="chat-user-message"> Miss na kita baby james</div>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="chat-list-item">
                                                    <div class="chat-user">
                                                        <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                                        <div class="chat-user-name">
                                                            Boss James Garfield
                                                            <div class="chat-user-message"> Miss na kita baby james</div>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="chat-list-item">
                                                    <div class="chat-user">
                                                        <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                                        <div class="chat-user-name">
                                                            Boss James Garfield
                                                            <div class="chat-user-message"> Miss na kita baby james</div>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="chat-list-item">
                                                    <div class="chat-user">
                                                        <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                                        <div class="chat-user-name">
                                                            Boss James Garfield
                                                            <div class="chat-user-message"> Miss na kita baby james</div>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="chat-list-item">
                                                    <div class="chat-user">
                                                        <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                                        <div class="chat-user-name">
                                                            Boss James Garfield
                                                            <div class="chat-user-message"> Miss na kita baby james</div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
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
                                {{-- <div class="wrapper">
                                    <section class="chat-area">
                                        <header class="header">
                                            <div style="width: 60%"
                                                class="d-flex align-items-center justify-content-start header-content">

                                                    <img src="../../../images/user-profile.png" alt="" width="80"/>

                                                <div class="details">
                                                    <span>James Pogi</span>
                                                    <p>Alaga ni Yaya Mia</p>
                                                </div>
                                            </div>
                                        </header>
                                        <div class="chat-box"></div>
                                        <form action="#" class="typing-area">
                                            @csrf
                                            <input type="text" name="message" class="input-field" id="message_input"
                                                placeholder="Type a message here..." />
                                            <button><i class="fa fa-send"></i></button>
                                        </form>
                                    </section>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@push('scripts')
<script src="../../../app-assets/js/scripts/chat-page.js"></script>
@endpush

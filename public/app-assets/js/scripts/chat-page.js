
let chat_header_tabs = document.querySelectorAll('.chat-header-tab');

let default_chat_container = document.querySelector('.default-chat-container');
let default_chat_button = document.querySelector('.default-chat-button');
let wrapper = document.querySelector('.wrapper');
let chat_button = document.querySelector('.chat-button');

const chat_form = document.querySelector(".typing-area"),
incoming_id = document.querySelector("#incoming_id_input").value,
outgoing_id = document.querySelector("#outgoing_id_input").value,
receiver_user_id = document.querySelector('#receiver_user_id_input').value,
sender_user_id = document.querySelector('#sender_user_id').value,
inputField = document.querySelector(".input-field"),
sendBtn = document.querySelector("button"),
type = document.querySelector('#type_input').value;

const token =  document.querySelector('input[name="_token"]').value;
const msg_id = document.querySelector('#msg_id_input').value;
let output = '';


chat_header_tabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
        chat_header_tabs.forEach(single_tab => {
            single_tab.classList.remove('active-chat-header');
        });

        this.classList.add('active-chat-header');
    })
})

// Hide the content of the wrapper by default
wrapper.style.display = 'none';

function myFunction() {
  // Display the content of the wrapper and hide the button
  wrapper.style.display = 'block';
  default_chat_container.style.display = 'none';

}

default_chat_button.addEventListener('click', myFunction);

let chat_list_items = document.querySelectorAll('.chat-list-item');

chat_list_items.forEach(tab => {
    tab.addEventListener('click', function(e) {
        chat_list_items.forEach(single_tab => {
            single_tab.classList.remove('active-chat-header1');
        })

        this.classList.add('active-chat-header1');
    })
})

function getUserChats() {
    $.ajax({
        url: '/chats/get_users',
        method: 'GET',
        success: function (response) {
            let chat_list = document.querySelector('.chat-list');
            if(response.length > 0) {
                response.forEach(data => {
                    if(data.incoming_user) {
                        chat_list.innerHTML += `<li class="chat-list-item" data-receiver-id="${data?.incoming_user?.user?.id}" id="${data?.msg_id}" data-outgoing-id="${data?.outgoing_user?.id}" data-incoming-id="${data?.incoming_user?.id}" data-type="${data?.message_type}">
                                        <div class="chat-user">
                                            <img src="../../../images/user/profile/${data?.incoming_user?.user?.profile_image}" alt="" class="chat-user-image">
                                            <div class="chat-user-name">
                                                <div class="chat-full-name">${data?.incoming_user?.user?.firstname} ${data?.incoming_user?.user?.lastname}</div>
                                                <div style="font-size: 12px;">${data?.message_type} - (${data?.message_type_data?.project?.title})</div>
                                            </div>
                                        </div>
                                    </li>`;
                    } else {
                        chat_list.innerHTML += `<li class="chat-list-item">
                                        <div class="chat-user">
                                            <img src="../../../images/user-profile.png" alt="" class="chat-user-image">
                                            <div class="chat-user-name">
                                                <div class="chat-full-name">Instrabaho User</div>
                                                <div class="chat-user-message"></div>
                                            </div>
                                        </div>
                                    </li>`;
                    }
                })
            }
            let chat_list_items_content = document.querySelectorAll('.chat-list-item');
            chat_list_items_content.forEach((item) => {
                item.addEventListener('click', openMessage);
            });
        }
    })
}

function openMessage() {
    let chat_list_items_content = document.querySelectorAll('.chat-list-item');
    chat_list_items_content.forEach(list => list.classList.remove('active-user-chat'));
    this.classList.add('active-user-chat');

    let msg_id = this.getAttribute('id');
    let type = this.getAttribute('data-type');
    let receiver_user_id = this.getAttribute('data-receiver-id');
    let incoming_id = this.getAttribute('data-incoming-id');
    let outgoing_id = this.getAttribute('data-outgoing-id');

    document.querySelector('#msg_id_input').value = msg_id;
    document.querySelector('#receiver_user_id_input').value = receiver_user_id;
    document.querySelector('#incoming_id_input').value = incoming_id;
    document.querySelector('#outgoing_id_input').value = outgoing_id;

    wrapper.style.display = 'block';
    default_chat_container.style.display = 'none';
    getMessages(msg_id, type);
}

let chatBox = document.querySelector('.chat-box');

function getMessages(msg_id, type) {
    let sender_user_id = document.querySelector('#sender_user_id').value;
    $.ajax({
        url: `/project_get_chat/${msg_id}/${type}`,
        success: function (response) {
            let messages = response;
            if(messages.length > 0) {
                messages.forEach(message => {
                    if(message.status == 'outgoing') {
                        output += `<div class="chat outgoing">
                                        <div class="details">
                                            <p>${message.message}</p>
                                        </div>
                                    </div>`;
                    } else {
                        output += `<div class="chat incoming">
                                        <div class="details">
                                            <p>${message.message}</p>
                                        </div>
                                    </div>`;
                    }
                });
            }
            chatBox.innerHTML = output;
            scrollToBottom();
            getLiveMessages(sender_user_id);
        },
    });
}

chat_form.onsubmit = (e) => {
    let incoming_id = document.querySelector("#incoming_id_input").value,
    outgoing_id = document.querySelector("#outgoing_id_input").value,
    receiver_user_id = document.querySelector('#receiver_user_id_input').value,
    type = document.querySelector('#type_input').value;
    const msg_id = document.querySelector('#msg_id_input').value;

    e.preventDefault();
    if(message_input.value != '' && message_input.value != null) {
        output +=  `<div class="chat outgoing">
                                    <div class="details">
                                        <p>${message_input.value}</p>
                                    </div>
                                </div>`;
        chatBox.innerHTML = output;
        message = message_input.value;
        message_input.value = '';
        scrollToBottom();

        $.ajax({
            url: `/send_project_chat`,
            data: {
                _token: token,
                message: message,
                msg_id: msg_id,
                outgoing_id: outgoing_id,
                incoming_id: incoming_id,
                type: type,
                receiver_user_id: receiver_user_id,
            },
            method: 'POST',
            success: function (response) {
                if(response.status == 201) {
                    scrollToBottom();
                }
            },
        });
    }
}

function getLiveMessages(sender_user_id) {
    Pusher.logToConsole = false;
    let backendBaseUrl = "http://192.168.100.71:8000";

    var pusher = new Pusher('0a303fc13dbe529739fa', {
        cluster: 'ap1',
        authEndpoint: `${backendBaseUrl}/broadcasting/auth`,
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        }
    });

    var channel = pusher.subscribe('private-project-chats.' + sender_user_id);

    channel.bind('new-project-chats', function(data) {
        let message_data = data.message;
        if (message_data.status == 'outgoing') {
            output += `<div class="chat outgoing">
                            <div class="details">
                                <p>${message_data.message}</p>
                            </div>
                        </div>`;
        } else {
            output += `<div class="chat incoming">
                            <div class="details">
                                <p>${message_data.message}</p>
                            </div>
                        </div>`;
        }
        chatBox.innerHTML = output;
        scrollToBottom();
    });

    // var channel = pusher.subscribe('private-project-chats.' + sender_user_id);
    // channel.bind('new-project-chats', function(data) {
    // });

    channel.bind('pusher:subscription_succeeded', function(members) {});
    channel.bind('pusher:subscription_error', function(data) {});
}

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}

getUserChats();











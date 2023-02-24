
let chat_header_tabs = document.querySelectorAll('.chat-header-tab');

let default_chat_container = document.querySelector('.default-chat-container');
let default_chat_button = document.querySelector('.default-chat-button');
let wrapper = document.querySelector('.wrapper');
let chat_button = document.querySelector('.chat-button');


chat_header_tabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
        chat_header_tabs.forEach(single_tab => {
            single_tab.classList.remove('active-chat-header');
        })

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
            console.log(response);
            let chat_list = document.querySelector('.chat-list');
            if(response.length > 0) {
                response.forEach(data => {
                    if(data.incoming_user) {
                        chat_list.innerHTML += `<li class="chat-list-item" id="${data?.msg_id}" data-type="${data?.message_type}">
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
    let msg_id = this.getAttribute('id');
    let type = this.getAttribute('data-type');
    wrapper.style.display = 'block';
    default_chat_container.style.display = 'none';
    getMessages(msg_id, type);
}

let chatBox = document.querySelector('.chat-box');

function getMessages(msg_id, type) {
    let output = '';
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
        },
    });
}

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}

getUserChats();











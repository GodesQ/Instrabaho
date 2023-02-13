const chat_form = document.querySelector(".typing-area"),
incoming_id = chat_form.querySelector(".incoming_id").value,
outgoing_id = chat_form.querySelector(".outgoing_id").value,
receiver_user_id = chat_form.querySelector('#receiver_user_id').value,
sender_user_id = chat_form.querySelector('#sender_user_id').value,
inputField = chat_form.querySelector(".input-field"),
sendBtn = chat_form.querySelector("button"),
type = chat_form.querySelector('#type').value,
chatBox = document.querySelector(".chat-box");

const token =  document.querySelector('input[name="_token"]').value;
const message_input = document.querySelector('input[name="message"]');
const msg_id = document.querySelector('#msg_id').value;
let message = '';

let output = '';

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

chat_form.onsubmit = (e) => {
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

// message_input.onmouseenter = ()=>{
//     chatBox.classList.add("active");
// }

// chatBox.onmouseleave = ()=>{
//     chatBox.classList.remove("active");
// }

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}


function getChats() {
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

Pusher.logToConsole = false;
let backendBaseUrl = "http://192.168.100.71:8000";
let session_id = 12;

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

getChats();

const chat_form = document.querySelector(".typing-area"),
incoming_id = chat_form.querySelector(".incoming_id").value,
outgoing_id = chat_form.querySelector(".outgoing_id").value,
inputField = chat_form.querySelector(".input-field"),
sendBtn = chat_form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

const token =  document.querySelector('input[name="_token"]').value;
const message_input = document.querySelector('input[name="message"]');
const msg_id = document.querySelector('#msg_id').value;


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
    $.ajax({
        url: `/send_chat`,
        data: {
            _token: token,
            message: message_input.value,
            msg_id: msg_id,
            outgoing_id: outgoing_id,
            incoming_id: incoming_id
        },
        method: 'POST',
        success: function (response) {
            if(response.status == 201) {
                message_input.value = '';
                getChats();
                scrollToBottom();
            }
        },
    });
}

message_input.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }


function getChats() {
    $.ajax({
        url: `/get_chat/${msg_id}`,
        success: function (response) {
            let data = response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
            }

            setTimeout(() =>{
                getChats();
            }, 10000);
        },
    });
}

// call getChats
getChats();

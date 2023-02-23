let chat_header_tabs = document.querySelectorAll('.chat-header-tab');

chat_header_tabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
        chat_header_tabs.forEach(single_tab => {
            single_tab.classList.remove('active-chat-header');
        })

        this.classList.add('active-chat-header');
    })
})

let default_chat_container = document.querySelector('.default-chat-container');
let default_chat_button = document.querySelector('.default-chat-button');
let wrapper = document.querySelector('.wrapper');
let chat_button = document.querySelector('.chat-button');

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


let chat_list_items_content = document.querySelectorAll('.chat-list-item');

chat_list_items_content.forEach((item) => {
  item.addEventListener('click', function(e) {

    let fullname = this.querySelector('.chat-full-name').innerHTML;
    let chat_fullname = document.querySelector('.details span');
    chat_fullname.innerHTML = fullname;

    wrapper.style.display = 'block';
    default_chat_container.style.display = 'none';

  });
});









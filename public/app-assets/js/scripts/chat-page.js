let chat_header_tabs = document.querySelectorAll('.chat-header-tab');

chat_header_tabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
        chat_header_tabs.forEach(single_tab => {
            single_tab.classList.remove('active-chat-header');
        })

        this.classList.add('active-chat-header');
    })
})




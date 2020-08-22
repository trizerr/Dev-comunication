let textMessage = document.getElementById('textMessage');
let send = document.getElementById('send');
let time = new Date;

send.addEventListener("click", function messages() {
    if (textMessage.value !== '') {
        let message_layout = document.getElementById('message_layout');
        $.ajax({
            url: '../message/create',
            type: 'post',
            data: {text: textMessage.value},
            success: function (response) {
                $("#messages").append(response);
                textMessage.value = '';

            }
        });
    }
})

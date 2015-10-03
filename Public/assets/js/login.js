$('.login-form').submit(function(){
    var url = $(this).attr('action');

    var username = $('#username').val();
    var password = $('#password').val();

    $.ajax({
        url : url,
        data : {
            username : username,
            password : password
        },
        dataType : 'json',
        type : 'post',
        success:function(i) {
            if (i.status == 1) {
                window.location.href = i.url;
            } else {
                showAlert('', i.info);
            }
        }
    })
    return false;
})

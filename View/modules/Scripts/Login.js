$("#btnLogin").on("click", function(){
    Login();
});

function messageBox(message){
    $('body').prepend(
        '<div id="messageBox" onclick="hideMessageBox()"></div><div id="messageBoxContent"><p id="messageBoxText">'+ message +'</p></div>');
    $('body').css('overflow-y','hidden');
    $("#messageBox").fadeIn(200, function(){});
    $("#messageBoxContent").fadeIn(200, function(){});
}

function Login() {
    var password = $('#txtPassword').val();
    var email = $('#txtEmail').val();
    $.ajax({
        url: '/login/loginuser',
        method: 'POST',
        data: {password: password, email: email},
        dataType: 'json',
    }).done(function(result){
        if(result == "Senha ou Email incorretos"){
            messageBox(result);
        }else{
            window.location.href = "/";
        }
    });
}

$("#txtEmail").on('keypress',function(e) {
    if(e.which == 13) {
        Login();
        $("#txtEmail").blur();
    }
})

$("#txtPassword").on('keypress',function(e) {
    if(e.which == 13) {
        Login();
        $("#txtPassword").blur();
    }
})

function hideMessageBox(){
    $("#messageBox").fadeOut(200);
    $("#messageBoxContent").fadeOut(200);
    $('body').css('overflow-y','scroll');
}
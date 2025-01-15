function Registrar(){
    var username = $('#txtUsername').val();
    var password = $('#txtPassword').val();
    var confirmPassword = $('#txtConfirmPassword').val();
    var email = $('#txtEmail').val();
    if(email.length < 3){
        messageBox("Insira um email válido");
    } else if(username.length < 4){
        messageBox("O nome de usuário deve possuir de 4 a 20 caracteres");
    }else if(password.length < 5 || password.length > 20){
        messageBox("A senha deve conter de 5 a 20 caracteres.");
    }else if(password == confirmPassword){
        $.ajax({
            url: '/register/createaccount',
            method: 'POST',
            data: {username: username, password: password, email: email},
            dataType: 'json',
        }).done(function(result){
            if(result == "true"){
                messageBox("Conta criada com sucesso<br> Você será redirecionado em alguns segundos");
                setTimeout(Redirect, 2000);
            }else if(result == "email"){
                messageBox("Email já registrado");
            }else{
                messageBox("Usuário já utilizado");
            }      
        });
    }else{
        messageBox("Senhas não coincidem");
    }
}

function Redirect() {
    window.location.href = "/login";
}


$("#btnRegister").on("click", function(){
    Registrar()
});

$("#txtEmail").on('keypress',function(e) {
    if(e.which == 13) {
        Registrar();
        $("#txtEmail").blur();
    }
})

$("#txtUsername").on('keypress',function(e) {
    if(e.which == 13) {
        Registrar();
        $("#txtUsername").blur();
    }
})

$("#txtPassword").on('keypress',function(e) {
    if(e.which == 13) {
        Registrar();
        $("#txtPassword").blur();
    }
})

$("#txtConfirmPassword").on('keypress',function(e) {
    if(e.which == 13) {
        Registrar();
        $("#txtConfirmPassword").blur();
    }
})

function messageBox(message){
    $('body').prepend(
        '<div id="messageBox" onclick="hideMessageBox()"></div><div id="messageBoxContent"><p id="messageBoxText">'+ message +'</p></div>');
    $('body').css('overflow-y','hidden');
    $("#messageBox").fadeIn(200, function(){});
    $("#messageBoxContent").fadeIn(200, function(){});
}

function hideMessageBox(){
    $("#messageBox").fadeOut(200);
    $("#messageBoxContent").fadeOut(200);
    $('body').css('overflow-y','scroll');
}

function confirmingPassword(){
    var password = $('#txtPassword').val();
    var passwordConfirm = $('#txtConfirmPassword').val();
    if(password != passwordConfirm){
        window.document.getElementById("lblPassword").style.color = "red"
        window.document.getElementById("lblConfirmPassword").style.color = "red"
    }else{
        window.document.getElementById("lblPassword").style.color = "white"
        window.document.getElementById("lblConfirmPassword").style.color = "white"
    }
}
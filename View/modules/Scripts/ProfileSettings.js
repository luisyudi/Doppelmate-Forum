$("#btnChangeUsername").on("click", function(){
    var username = $("#txtChangeUsername").val();
    if(username.length > 0){
        $("#usernameAdvice").text("");
        $.ajax({
            url: '/changeusername',
            method: 'POST',
            data: {newUsername: username},
            dataType: 'json',
        }).done(function(result){
            messageBox(result);
            $("#txtChangeUsername").val("");
        });
    }else{
        $("#usernameAdvice").text("Nome de Usuário não pode ser vazio");
    }
});

$("#btnChangePassword").on("click", function(){
    var password = $("#txtChangePassword").val();
    var passwordConfirm = $("#txtChangePasswordConfirm").val();
    if(password == passwordConfirm){
        if(password.length > 5){
            $("#passwordAdvice").text("");
            $.ajax({
                url: '/changepassword',
                method: 'POST',
                data: {newPassword: password},
                dataType: 'json',
            }).done(function(result){
                if(result == true){
                    messageBox("Senha atualizada com sucesso");
                }
                $("#txtChangePassword").val("");
                $("#txtChangePasswordConfirm").val("");
            });
        }else{
            $("#passwordAdvice").text("A senha precisa ter mais de 5 caracteres");
        }
    }else{
        $("#passwordAdvice").text("Senhas não coincidem");
    }
});

$("#btnChangeDescription").on("click", function(){
    var description = $("#txtChangeDescription").val();
    $.ajax({
        url: '/changedescription',
        method: 'POST',
        data: {newDescription: description},
        dataType: 'json',
    }).done(function(result){
       
    });
    messageBox("Descrição do perfil atualizada");
});

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
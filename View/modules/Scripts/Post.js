var text = "";
var enter = new Array();

function Load() {
    document.getElementById("load").src = "../View/modules/Images/heartSolidIcon.svg";
    document.getElementById("load").style.display ="none";
    $("#loader").remove();
    setInterval(1000);
    ResizeScreen();
    ResizeScreen();
}

function ResizeScreen(){
    if( window.innerWidth < 1200){
        $(".postRightSide").css("width", (0.99 * window.innerWidth) - 62);
        $(".postBar").css("width", (0.99 * window.innerWidth) - 62);
        $(".replyBox").css("width", (0.99 * window.innerWidth) - 102);
    }else{
        $(".postRightSide").css("width", 830);
        $(".postBar").css("width", 820);
        $(".replyBox").css("width", 780);
    }
}

window.onresize = ResizeScreen;


function ShowReplyLikes() {
    for (let i = 0; i < checkLike.length; i++) {
        $("#likeImg"+checkLike[i].replyId).attr("src", "../View/modules/Images/heartSolidIcon.svg");
    }
}
ShowReplyLikes();

function Reply(replyId){
    if(logged == false){
        window.location.href= "/login";
    }else{
        if(!CheckIfReplyBoxExists(replyId)){
            $("#post"+replyId).append('<div class="postReplyBox" id="postReplyBox'+replyId+'"><p class="postReplyBoxText">Responder '+ $("#postProfileText"+replyId).text()+'</p><textarea id="txtReplyText'+replyId+'" rows="7" cols="120"></textarea><div onclick="SubmitReply('+replyId+')" class="btnConfirmReply"><p>Enviar</p></div></div>');

            $("#txtReplyText"+replyId).on('keyup',function(e) {
                TextReply(replyId, e);
            })

            createReplyBox.push(replyId);
            CloseOtherReplyBoxes(replyId);
        }
        if(!CheckIfReplyBoxIsOpen(replyId)){
            $("#postReplyBox"+replyId).css("display", "block");
            checkReplyBox.push(replyId);
            CloseOtherReplyBoxes(replyId);
        }else{
            $("#postReplyBox"+replyId).css("display", "none");
            for (let i = 0; i < checkReplyBox.length; i++) {
                if(checkReplyBox[i] == replyId){
                    checkReplyBox[i] = null;
                }
            }
            for (var i = 0; i < enter.length; i++) {
                enter.pop();
            }
        }
    }
}

function CloseOtherReplyBoxes(replyId){
    for (let i = 0; i < checkReplyBox.length; i++) {
        if (checkReplyBox[i] != null && checkReplyBox[i] != replyId) {
            $("#postReplyBox"+checkReplyBox[i]).css("display", "none");
            checkReplyBox[i] = null;
        }
    }
}

function SubmitReply(replyId){
    var txtReply = $("#txtReplyText"+replyId).val();
    var reply = "";
    let start = 0;
    let end = 0;
    var replyToId = replyId;
    var postId = getUrlParameter("id");

    for (let i = 0; i < enter.length; i++) {
        reply = reply + txtReply.substring(start, enter[i]) + "<br>";
        start = enter[i];
        if(i == enter.length - 1){
            reply = reply + txtReply.substring(enter[i], txtReply.length);
        }
    }

    if (enter.length == 0) {
        reply = txtReply;
    }

    if(replyId == 0){
        replyToId = "0";
    }

    if(reply.length > 0){
        $.ajax({
            url: '/createreply',
            method: 'POST',
            data: {reply: reply, replyToId: replyToId, postId: postId},
            dataType: 'json',
        }).done(function(result){
            if(replyId == 0){
                $("#post"+replyId).append('<div id="post'+result[0].postReplyId+'" class="post"><div class="postDate"><p>'+result[0].replyDate+'</p></div><div class="postContent"><div class="postProfileBox"><div style="display: flex; justify-content: center; flex-direction: column"><a href="/profile/'+result[0].userName+'" id="postProfileText'+result[0].postReplyId+'" class="postProfileText">'+result[0].userName+'</a><img src="../'+result[0].userImage+'" alt="Imagem de Perfil" class="postProfileImage"></div></div><div class="postRightSide"><p class="postBody" id="postBody'+ replyId+'">'+result[0].replyText+'</p><div class="postBar"><div class="postLikeBox"><img src="../View/modules/Images/heartIcon.svg" alt="" class="likeImg" id="likeImg'+result[0].postReplyId+'"onclick="LikeReply('+result[0].postReplyId+')"><p class="likeCount" id="likeCount'+result[0].postReplyId+'">'+result[0].postReplyLikes+'</p></div><p class="postSettings">Denunciar</p><p class="postReply" onclick="Reply('+result[0].postReplyId+')">Responder</p></div></div></div></div>');
            }else{
                $("#post"+replyId).append('<div id="post'+result[0].postReplyId+'" class="post"><div class="postDate"><p>'+result[0].replyDate+'</p></div><div class="postContent"><div class="postProfileBox"><div style="display: flex; justify-content: center; flex-direction: column"><a href="/profile/'+result[0].userName+'" id="postProfileText'+result[0].postReplyId+'" class="postProfileText">'+result[0].userName+'</a><img src="../'+result[0].userImage+'" alt="Imagem de Perfil" class="postProfileImage"></div></div><div class="postRightSide"><div class="replyBox"><p class="repliedText">'+$("#postBody"+replyId).text()+'</p></div><p class="postBody" id="postBody'+ replyId+'">'+result[0].replyText+'</p><div class="postBar"><div class="postLikeBox"><img src="../View/modules/Images/heartIcon.svg" alt="" class="likeImg" id="likeImg'+result[0].postReplyId+'"onclick="LikeReply('+result[0].postReplyId+')"><p class="likeCount" id="likeCount'+result[0].postReplyId+'">'+result[0].postReplyLikes+'</p></div><p class="postSettings">Denunciar</p><p class="postReply" onclick="Reply('+result[0].postReplyId+')">Responder</p></div></div></div></div>');
            }
        });
    }
            
    $("#txtReplyText"+replyId).val('');
    reply = "";
    for (var i = 0; i < enter.length; i++) {
        enter.pop();
    }
    Reply(replyId);
}

function CheckIfReplyBoxExists(replyId){
    for (let i = 0; i < createReplyBox.length; i++) {
        if(createReplyBox[i] == replyId){
            return true;
        }
    }
    return false;
}

function CheckIfReplyBoxIsOpen(replyId){
    for (let i = 0; i < checkReplyBox.length; i++) {
        if(checkReplyBox[i] == replyId){
            return true;
        }
    }
    return false;
}

function Report(id) {
    if(logged == false){
        window.location.href= "/login";
    }else{
        CreateReportBox(id);
    }
}

function CreateReportBox(id){
    messageBox(id);
}


function SubmitReport(id) {
    var reportText = $("txtReport").text();
    var reportId = id;
    var type = "reply";
    if(id == 0){
        reportId = getUrlParameter("id");
        type = "post";
    }
    $.ajax({
        url: '/report',
        method: 'POST',
        data: {reportId: reportId, reportText: reportText, type: type},
        dataType: 'json',
    }).done(function(result){
        
    })
    hideMessageBox();
}

function LikePost() {
    if(logged == false){
        window.location.href= "/login";
    }else{
        var likes = parseInt($("#likeCount0").text(), 10);
        if(checkLikePost == false){
            var postId = getUrlParameter("id");
            $("#likeImg0").attr("src", "../View/modules/Images/heartSolidIcon.svg");
            $("#likeCount0").text(likes + 1);
            checkLikePost = true;   
            $.ajax({
                url: '/likepost',
                method: 'POST',
                data: {postId: postId},
                dataType: 'json',
            }).done(function(result){});
        }else{
            var postId = getUrlParameter("id");
            $("#likeImg0").attr("src", "../View/modules/Images/heartIcon.svg");
            $("#likeCount0").text(likes - 1); 
            checkLikePost = false; 
            $.ajax({
                url: '/unlikepost',
                method: 'POST',
                data: {postId: postId},
                dataType: 'json',
            }).done(function(result){});  
        }
    }
    
}

function LikeReply(replyId){
    if(logged == false){
        window.location.href= "/login";
    }else{
        var likes = parseInt($("#likeCount"+replyId).text(), 10);
        var lock = false;
        for (let i = 0; i < checkLike.length; i++) {
            if (checkLike[i].replyId == replyId) {
                $("#likeImg"+checkLike[i].replyId).attr("src", "../View/modules/Images/heartIcon.svg");
                $("#likeCount"+replyId).text(likes - 1);
                checkLike.splice(i, 1);
                lock = true;
                SendUnlikeReply(replyId);
            }
        }
        if(lock == false){
            $("#likeImg"+replyId).attr("src", "../View/modules/Images/heartSolidIcon.svg");
            $("#likeCount"+replyId).text(likes + 1);
            SendLikeReply(replyId);
            checkLike.push({replyId: replyId});
        }  
    }
}

function SendLikeReply(replyId){
    $.ajax({
        url: '/likereply',
        method: 'POST',
        data: {replyId: replyId},
        dataType: 'json',
    }).done(function(result){});   
}

function SendUnlikeReply(replyId){
    $.ajax({
        url: '/unlikereply',
        method: 'POST',
        data: {replyId: replyId},
        dataType: 'json',
    }).done(function(result){});   
}

function TextReply(replyId, e){
    var txtReplyBox = $("#txtReplyText"+replyId).val();
    if (e.key === 'Enter' || e.keyCode === 13) {
        enter.push(txtReplyBox.length);
    }else if(e.key === "Backspace" || e.key === "Delete"){
        for (let i = 0; i < enter.length; i++) {
            if (enter[i] > txtReplyBox.length) {
                enter.splice(i, 1);
            }
        }
    }
}

function messageBox(id){
    $('body').prepend('<div id="messageBox" onclick="hideMessageBox()"></div><div id="messageBoxContent"><p id="messageBoxText">Denunciar</p> <textarea id="txtReport" placeholder="Motivo"></textarea> <div class="btnConfirmReply" onclick="SubmitReport('+id+')"> <p>Enviar</p> </div> </div>');
    $('body').css('overflow-y','hidden');
    $("#messageBox").fadeIn(200, function(){});
    $("#messageBoxContent").fadeIn(200, function(){});
}

function hideMessageBox(){
    $("#messageBox").fadeOut(200);
    $("#messageBoxContent").fadeOut(200);
    $('body').css('overflow-y','scroll');
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
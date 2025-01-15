var tagCount = 0;
var tags = new Array(5);

$("#addTag").on('keypress',function(e) {
    var tag;
    if(e.which == 13) {
        $("#lblLimitTag").text('');
        if(tagCount == 5){
            $("#lblLimitTag").text('Limite de Tags Atingido');
        }
        var txtTag = $("#addTag").val();
        if(txtTag.replace(/ /g,'').length >= 3 && txtTag.replace(/ /g,'').length < 20){
            tag = $.trim(txtTag);
            tag = tag.replace(/  +/g, '-');
            tag = tag.replace(/ +/g, '-');
            tag = tag.toLowerCase();
            addTag(tag);
            $("#addTag").val("");
        }
        console.log(tags);
        console.log(tagCount);
    }
});

function addTag(tag){
    if(tagCount < 5){
        if(checkDoubleTag(tag) == false){
            var added = 0;
            for (let i = 0; i < 5; i++) {
                if(added == 0 && tags[i] == null){
                    tags[i] = tag;
                    $("#postContentTags").append('<div onmouseover="tagIn('+i+')" onmouseout="tagOut('+i+')" class="postTag" id="postTag'+i+'"><p>'+tags[i]+'</p><img onclick="removeTag('+i+')" onmouseover="tagIn('+i+')" id="xIcon'+i+'" class="xIcon" src="../View/modules/Images/xIcon.png"></div>');
                    tagCount++;
                    added = 1;                    
                }
            }
        }else{
            $("#lblLimitTag").text('Tag já adicionada');
        }
    }
}

function checkDoubleTag(tag){
    var check = false;
    for (let i = 0; i < 5; i++) {
        if(tags[i] == tag){
            check = true;
        }
    }
    return check;
}

function tagIn(tagNumber){
    document.getElementById("xIcon"+tagNumber).style.display = "block"; 
    document.getElementById("xIcon"+tagNumber).style.position = "relative";
    document.getElementById("xIcon"+tagNumber).style.float = "left";
    document.getElementById("postContentTags").style.width = document.getElementById("postContentTags").style.width + 30;
}

function tagOut(tagNumber){
    document.getElementById("xIcon"+tagNumber).style.display = "none";
    document.getElementById("postContentTags").style.width = document.getElementById("postContentTags").style.width + 30;
}

function removeTag(tagNumber){
    tags[tagNumber] = null;
    $("#postTag" + tagNumber).remove();
    tagCount = tagCount - 1;
}

$("#btnCreatePost").on("click", function(){
    var title = $('#txtPostTitle').val();
    var description = $('#txtPostDescription').val();
    if(tags[0] == null){
        tags = "null";
    }
    if(title.length > 0 && description.length > 0){
        $.ajax({
            url: '/createnewpost',
            method: 'POST',
            data: {title: title, description: description, tags: tags},
            dataType: 'json',
        }).done(function(result){
            window.location.href = "/post?id=" + result;
        });
    }
});






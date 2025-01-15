$("#btnProfileSettings").on("click", function(){
    window.location.href = "/editprofile";
})

function LikePosts(){
    for (let i = 0; i < likePost.length; i++) {
        $("#likeImg"+likePost[i].postId).attr("src", "../../View/modules/Images/heartSolidIcon.svg");
    }
}
LikePosts();

function PostLike(postId){
    if(logged == false){
        window.location.href= "/login";
    }else{
        var likes = parseInt($("#postLikeCount"+postId).text(), 10);
        var lock = false;
        for (let i = 0; i < likePost.length; i++) {
            if(likePost[i].postId == postId){
                var post = postId;
                lock = true;
                $.ajax({
                    url: '/unlikepost',
                    method: 'POST',
                    data: {postId: post},
                    dataType: 'json',
                }).done(function(result){});  
                $("#likeImg"+postId).attr("src", "../../View/modules/Images/heartIcon.svg");
                $("#postLikeCount"+postId).text(likes - 1); 
                for (let i = 0; i < likePost.length; i++) {
                    if (likePost[i].postId == postId) {
                        likePost.splice(i, 1);
                    }
                }
            }
        }
        if(lock == false){
            var post = postId;
            $.ajax({
                url: '/likepost',
                method: 'POST',
                data: {postId: postId},
                dataType: 'json',
            }).done(function(result){});
            $("#likeImg"+postId).attr("src", "../../View/modules/Images/heartSolidIcon.svg");
            $("#postLikeCount"+postId).text(likes + 1);
            likePost.push({postId: postId});
        }
    }
}

function Load() {
    document.getElementById("load").src = "../View/modules/Images/heartSolidIcon.svg";
    document.getElementById("load").style.display ="none";
    $("#loader").remove();
}
var pageRecent = 1;
var pageTrending = 1;

$("#btnRecent").on("click", function(){
    pageRecent++;
    if(pageRecent == 4){
        window.location.href = "/allposts?sort=date";
    }
    $.ajax({
        url: '/changepage',
        method: 'POST',
        data: {page: pageRecent, type: "recent"},
        dataType: 'json',
    }).done(function(result){
        for (let i = (pageRecent - 1) * 5; i < (pageRecent - 1) * 5 + 5; i++) {
            $("#recentPostBox").append('<div class="post post'+ i%2+'"><a href="/post?id='+result[i].postId +'" class="postTitle">' + result[i].postTitle+'</a><p class="de">de <a href="/profile/'+ result[i].userName +'" class="postUser">'+ result[i].userName +'</a></p></div>')
        }
    });
    if(pageRecent == 3){
        $("#btnRecent").text("Ver todas as postagens");
    }
})



$("#btnTrending").on("click", function(){
    pageTrending++;
    if(pageTrending == 4){
        window.location.href = "/allposts?sort=like";
    }
    $.ajax({
        url: '/changepage',
        method: 'POST',
        data: {page: pageTrending, type: "trending"},
        dataType: 'json',
    }).done(function(result){
        for (let i = (pageTrending - 1) * 5; i < (pageTrending - 1) * 5 + 5; i++) {
            $("#trendingPostBox").append('<div class="post post'+i%2 +'"><a href="/post?id='+result[i].postId +'" class="postTitle">' + result[i].postTitle+'</a><p class="de">de <a href="/profile/'+ result[i].userName +'" class="postUser">'+ result[i].userName +'</a></p></div>')
        }
    });
    if(pageTrending == 3){   
        $("#btnTrending").text("Ver todas as postagens");
    }
})
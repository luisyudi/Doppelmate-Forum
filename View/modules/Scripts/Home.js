var pageRecent = 1;
var pageTrending = 1;

$("#btnNextRecent").on("click", function(){
    pageRecent++;
    $.ajax({
        url: '/changepage',
        method: 'POST',
        data: {page: pageRecent, type: "recent"},
        dataType: 'json',
    }).done(function(result){
       //Mostra mais 5 posts
    });
    if(pageRecent > 2){
        //Troca botão
    }
})

$("#btnTrending").on("click", function(){
    pageTrending++;
    $.ajax({
        url: '/changepage',
        method: 'POST',
        data: {page: pageTrending, type: "trending"},
        dataType: 'json',
    }).done(function(result){
        //Mostra mais 5 posts
    });
    if(pageTrending > 3){   
        //Troca botão
    }
})

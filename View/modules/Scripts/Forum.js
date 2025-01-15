var mobileMenu = false;


$("#search").on('keypress',function(e) {
    if(e.which == 13 && $("#search").val() != "null") {
         Search();
    }
})

$("#btnSearch").on("click", function(){
        Search();
})

function Search(){
    var search = $("#search").val();
    var location = "/search?q=" + search;
    window.location.href = location;
}

$("#menuOption1").on("click", function(){
    window.location.href = "/";
})

$("#menuOption2").on("click", function(){
    window.location.href = "/allposts?sort=date";
})

$("#menuOption3").on("click", function(){
    window.location.href = "/allposts?sort=like";
})

$("#menuOption4").on("click", function(){
    window.location.href = "/newpost";
})

$("#menuOption5").on("click", function(){
    window.location.href = "/btprofile";
})

$("#menuOption6").on("click", function(){
    window.location.href = "/contact";
})

$("#mobileMenu").on("click", function(){
    if(!mobileMenu){
        $("#mobileMenu").css("background-color","#36323c");
        $("#mobileMenu").css({boxShadow: 'inset 0 1px 0 rgba(255, 255, 255, 0.2)'});
        $("#mobileMenu").css({border: 'solid black 1px'});
        $("#menuBox").css("display", "flex");
        mobileMenu = true;
    }else{
        $("#mobileMenu").css("background-color","transparent");
        $("#mobileMenu").css({boxShadow: 'none'});
        $("#mobileMenu").css({border: 'none'});
        $("#menuBox").css("display", "none");
        mobileMenu = false;
    }
})
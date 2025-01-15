<?php
    $login = "false";
    $loginBarButton = '<a class="loginBarButton" href="/register">Registrar</a><a class="loginBarButton barLeftButton" href="/login">Login</a>';
    if(isset($_SESSION['LOGGED_USER'])){
        $login = "true";
        $loginBarButton = '<a class="loginBarButton" href="/logout">Logout</a><a class="loginBarButton barLeftButton" href="/profile/'.$_SESSION["LOGGED_USER"].'">'.$_SESSION["LOGGED_USER"].'</a><p>Bem vindo, </p>';

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/modules/Styles/Forum.css">
    <link rel="stylesheet" href="../View/modules/Styles/CreatePost.css">
    <title>Criar nova postagem</title>
</head>
<body>
    <div id="backgroundFilter"></div>
    <div id="loginBar">
        <?= $loginBarButton?>
    </div>
    <nav>
        <div id="btnForum"><a href="/"><img id="logo" src="../View/modules/Images/Logo2.png" alt=""></a></div>
        <div id="searchBox">
            <input type="text" id="search" autocomplete="off" placeholder="Pesquisar">
            <div id="btnSearch">
                <img id="searchImg" src="../View/modules/Images/searchIcon.svg" alt="">
            </div>
        </div>
        <div id="mobileMenu">
            <img src="../View/modules/Images/bars.svg" alt="">
        </div>
    </nav>
    <div id="menuBox">
        <div class="menuOption" id="menuOption1">
            <a href="/">Home</a>
        </div>
        <div class="menuOption" id="menuOption2">
            <a href="/allposts?sort=date">Recente</a>
        </div>
        <div class="menuOption" id="menuOption3">
            <a href="/allposts?sort=like">Popular</a>
        </div>
        <div class="menuOption" id="menuOption4">
            <a href="/newpost">Novo Post</a>
        </div>
        <div class="menuOption" id="menuOption5">
            <a href="/btprofile">Perfil</a>
        </div>
        <div class="menuOption" id="menuOption6">
            <a href="/contact">Contato</a>
        </div>
    </div>
    <div id="content">
        <div id="createPostContent">
            <div class="postTitle">
                <input id="txtPostTitle" type="text" placeholder="Título">
            </div>
            <div class="postDescription">
                <textarea id="txtPostDescription" cols="118" rows="25" style="resize: vertical;" placeholder="Inserir texto"></textarea>
            </div>
            <div class="postTags">
                <div>
                    <input type="text" id="addTag" placeholder="Adicionar Tags">
                    <p id="lblLimitTag"><p>
                </div>
                <div id="postContentTags">
                    <img class="tagIcon" src="../View/modules/Images/tagIcon.svg" alt=""> <p style="color: #8a8686; font-size: 12px; margin: 26px 0 0 0">Tags:</p>
                </div>
                <div id="btnCreatePost"><a>Criar Post</a></div>

            </div>
        </div>
    </div>
    <div id="footer">
        <p>Doppelmate © Suna Inc. 2022 Todos os direitos reservados</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../../View/modules/Scripts/Forum.js"></script>
    <script src="../View/modules/Scripts/CreatePost.js"></script>
</body>
</html>
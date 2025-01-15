<?php
    $login = "false";
    $loginBarButton = '<a class="loginBarButton" href="/register">Registrar</a><a class="loginBarButton barLeftButton" href="/login">Login</a>';
    session_start();
    if(isset($_SESSION['LOGGED_USER'])){
        $login = "true";
        $loginBarButton = '<a class="loginBarButton" href="/logout">Logout</a><a class="loginBarButton barLeftButton" href="/profile/'.$_SESSION["LOGGED_USER"].'">'.$_SESSION["LOGGED_USER"].'</a><p>Bem vindo, </p>';

    }

    $posts = array();
    $sort = "null";
    if(isset($_POST["posts"])){
        $posts = $_POST["posts"];
        $sort = $_POST["sort"];
    }

    $message = null;
    switch ($sort) {
        case 'p.postDate':
            $message = "Postagens mais recentes";
        break;
        
        case 'p.postLikes':
            $message = "Postagens mais curtidas";
        break;

        case 'tags':
            $message = 'Postagens com a tag "' . (String)$_POST["tag"]. '"';
        break;
        
        default:
            $message = 'Nenhuma postagem encontrada';
        break;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/modules/Styles/Forum.css">
    <link rel="stylesheet" href="../View/modules/Styles/AllPosts.css">
    <link rel="icon" type="image/x-icon" href="../View/modules/Images/Suna_Logo.png">
    <title>Mostrar posts</title>
</head>
<body>
    <div id="backgroundFilter"></div>
    <div id="loginBar">
        <?= $loginBarButton?>
    </div>
    <nav>
        <div id="btnForum"><a href="/"><img id="logo" src="../View/modules/Images/Logo2.png" alt=""></a></div>
        <div id="searchBox">
            <input type="text" id="search" autocomplete="off">
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

        <h1> <?= $message?> </h1>
        <?php 
            for($i = 0; $i < count($posts); $i++){
                echo '<div class="postContent postContent' . ($i % 2) .'">';
                    echo '<div class="postTop">';
                        echo '<a class="post" href="/post?id='.$posts[$i]["postId"].'">'.$posts[$i]["postTitle"].'</a>';
                        echo '<a class="postProfile" href="/profile/'.$posts[$i]["userName"].'">'.$posts[$i]["userName"].'</a>';
                    echo '</div>';
                    echo '<div class="tagsBox">';
                        echo '<img class="tagIcon" src="../View/modules/Images/tagIcon.svg" alt=""> <p style="margin: 8px 0 0 0;  color: #8a8686; font-size: 12px">Tags:</p>';
                        for ($j=0; $j < count($posts[$i]["postTags"]); $j++) { 
                            $comma = ",";
                            if($j == count($posts[$i]["postTags"]) - 1){
                                $comma = "";
                            }
                            echo '<a class="postTag" href="/allposts?tag='.$posts[$i]["postTags"][$j][0].'">'.$posts[$i]["postTags"][$j][0]. $comma.'</a>';
                        }
                    echo '</div>';
                        
                echo '</div>';
            }
        ?>
    </div>

    
    <div id="footer">
        <p>Doppelmate © Suna Inc. 2022 Todos os direitos reservados</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../../View/modules/Scripts/Forum.js"></script>
</body>
</html>
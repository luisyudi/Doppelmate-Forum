<?php
    $login = "false";
    $loginBarButton = '<a class="loginBarButton" href="/register">Registrar</a><a class="loginBarButton barLeftButton" href="/login">Login</a>';
    $mobileLoginBarButton = '';
    session_start();
    if(isset($_SESSION['LOGGED_USER'])){
        $login = "true";
        $loginBarButton = '<a class="loginBarButton" href="/logout">Logout</a><a class="loginBarButton barLeftButton" href="/profile/'.$_SESSION["LOGGED_USER"].'">'.$_SESSION["LOGGED_USER"].'</a><p>Bem vindo, </p>';
        
    }

    $recentPosts = $_POST["recent"];
    $trendingPosts = $_POST["trending"];
    $news = $_POST["news"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="View/modules/Styles/HomeForum.css">
    <link rel="stylesheet" href="View/modules/Styles/Forum.css">
    <link rel="icon" type="image/x-icon" href="../View/modules/Images/Suna_Logo.png">
    <title>Home - Fórum</title>
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

    <div id="mobileSettings">
        
    </div>
    
    <div id="content">
        <div id="rules">
            <div class="newsTitle"><p>Anúncios e Notícias</p></div>
            <?php 
                for ($i=0; $i < count($news); $i++) { 
                    echo '<div class="post post'. $i % 2 .'">';
                        echo '<a href="/post?id=' . $news[$i]["postId"] .'" class="postTitle">' . $news[$i]["postTitle"] . '</a>';
                        echo '<p class="de">de <a href="/profile/'. $news[$i]["userName"] .'" class="postUser">'. $news[$i]["userName"] .'</a></p>';
                    echo '</div>';
                }
            ?>
        </div>
        <div id="posts">
            <div class="postColumn" id="recent">
                <p class="title">Postagens mais recentes</p>
                <div class="postBox" id="recentPostBox"> 
                    <?php 
                        for ($i=0; $i < 5; $i++) { 
                            echo '<div class="post post'. $i % 2 .'">';
                                echo '<a href="/post?id=' . $recentPosts[$i]["postId"] .'" class="postTitle">' . $recentPosts[$i]["postTitle"] . '</a>';
                                echo '<p class="de">de <a href="/profile/'. $recentPosts[$i]["userName"] .'" class="postUser">'. $recentPosts[$i]["userName"] .'</a></p>';
                            echo '</div>';
                        }
                    ?>
                </div>
                <div class="morePostsBox">
                    <p id="btnRecent">Ver mais</p>
                </div>
            </div>
            
            <div class="postColumn" id="trending">
                <p class="title">Postagens mais curtidas</p>
                <div class="postBox" id="trendingPostBox"> 
                    <?php 
                        for ($i=0; $i < 5; $i++) { 
                            echo '<div class="post post'. $i % 2 .'">';
                                echo '<a href="/post?id=' . $trendingPosts[$i]["postId"] .'" class="postTitle">' . $trendingPosts[$i]["postTitle"] . '</a>';
                                echo '<p class="de">de <a href="/profile/'. $trendingPosts[$i]["userName"] .'" class="postUser">'. $trendingPosts[$i]["userName"] .'</a></p>';
                            echo '</div>';
                        }
                    ?>
                </div>
                <div class="morePostsBox">
                    <p id="btnTrending">Ver mais</p>
                </div>
            </div>
        </div>

    </div>
    <div id="footer">
        <p>Doppelmate © Suna Inc. 2022 Todos os direitos reservados</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../../View/modules/Scripts/Forum.js"></script>
    <script src="../../View/modules/Scripts/HomeForum.js"></script>
</body>
</html>
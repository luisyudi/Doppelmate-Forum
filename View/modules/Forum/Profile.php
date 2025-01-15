<?php
    $profilePosts = $_POST["profilePosts"];
    $profileUser = $_POST["profileUser"];
    $profileDescription = $_POST["profileDescription"];
    $userLikes = $_POST["userLikes"];
    $btnProfileSettings = "";
    $login = "false";
    $loginBarButton = '<a class="loginBarButton" href="/register">Registrar</a><a class="loginBarButton barLeftButton" href="/login">Login</a>';
    if(isset($_SESSION['LOGGED_USER'])){
        $login = "true";
        $loginBarButton = '<a class="loginBarButton" href="/logout">Logout</a><a class="loginBarButton barLeftButton" href="/profile/'.$_SESSION["LOGGED_USER"].'">'.$_SESSION["LOGGED_USER"].'</a><p>Bem vindo, </p>';            
            if($_SESSION["LOGGED_USER"] == $profileUser){
                $btnProfileSettings = '<div id="btnProfileSettings"><a id="btnProfileSettingsText">Editar Perfil</a><img src="../../View/modules/Images/gearIcon.svg" id="settingsImg"></div>';
            }
        }
        $profileImage = $_POST["profileImage"];
       

        
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../View/modules/Styles/Forum.css">
    <link rel="stylesheet" href="../../View/modules/Styles/Profile.css">
    <link rel="icon" type="image/x-icon" href="../../View/modules/Images/Suna_Logo.png">
    <title>Perfil de <?= $profileUser?></title>
    <?php
        if(!isset($profileImage)){
            echo '<script>window.location.href="/404"</script>';
        }
    ?>
    
</head>
<body>
    <div id="backgroundFilter"></div>
    <div id="loginBar">
        <?= $loginBarButton?>
    </div>
    <nav>
        <div id="btnForum"><a href="/"><img id="logo" src="../../View/modules/Images/Logo2.png" alt=""></a></div>
        <div id="searchBox">
            <input type="text" id="search" autocomplete="off" placeholder="Pesquisar">
            <div id="btnSearch">
                <img id="searchImg" src="../../View/modules/Images/searchIcon.svg" alt="">
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
        <div id="profileContent">
            <div id="profileBox">
                <div>
                    <h3 id="profileUser"><?= $profileUser?></h3>
                    <img src="../../<?= $profileImage?>" alt="Imagem de Perfil" id="profileImg">
                </div>
                
                <p id="profileDescription"><?= $profileDescription?></p>
                <?= $btnProfileSettings?>
            </div>
            <div id="profilePostsContent">
                <?php
                for ($i=0; $i < count($profilePosts); $i++) { 
                    echo '<div class="profilePost" id="profilePost'.$profilePosts[$i]["postId"].'">';
                        echo '<div class="profilePostLikeBox">';
                            echo '<img src="../../View/modules/Images/heartIcon.svg" alt="Like" onclick="PostLike('.$profilePosts[$i]["postId"].')" class="likeImg" id="likeImg'.$profilePosts[$i]["postId"].'">';
                            echo '<p class="profilePostLikeText" id="postLikeCount'.$profilePosts[$i]["postId"].'">'.$profilePosts[$i]["postLikes"].'</p>';
                        echo '</div>';
                        echo '<div class="profilePostText">';
                            echo '<a class="profilePostTitle" href="/post?id='.$profilePosts[$i]["postId"].'" >'.$profilePosts[$i]["postTitle"].'</a>';
                            echo '<div class="profilePostTagsContent">';
                                echo '<img class="tagIcon" src="../../View/modules/Images/tagIcon.svg" alt=""> <p style="color: #8a8686; font-size: 12px; margin: 10px 0 0 0">Tags:</p>';
                                for ($j=0; $j < count($profilePosts[$i]["postTags"]); $j++) {
                                    $comma = ",";
                                    if($j == count($profilePosts[$i]["postTags"]) - 1){
                                        $comma = "";
                                    }
                                    echo '<a class="postTagText" href="/allposts?tag='.$profilePosts[$i]["postTags"][$j][0].'">'.$profilePosts[$i]["postTags"][$j][0]. $comma .'</a>';
                                }
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <div id="footer">
        <p>Doppelmate © Suna Inc. 2022 Todos os direitos reservados</p>
    </div>

    

    <script type="text/javascript">
        var likePost = [];
        var logged = <?= $login?>;
        <?php 
            for ($i=0; $i < count($userLikes); $i++) { 
                echo 'likePost.push({postId: '.$userLikes[$i].'});';
            }
        ?>

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../../View/modules/Scripts/Forum.js"></script>
    <script src="../../View/modules/Scripts/Profile.js"></script>
    <div id="loader">
        <img onload="Load()" id="load" src="../../View/modules/Images/heartIcon.svg" alt="">
    </div>
</body>
</html>
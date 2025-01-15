<?php
    $login = "false";
    $loginBarButton = '<a class="loginBarButton" href="/register">Registrar</a><a class="loginBarButton barLeftButton" href="/login">Login</a>';
    $likeImg = "heartIcon.svg";
    if(isset($_SESSION['LOGGED_USER'])){
        $login = "true";
        $loginBarButton = '<a class="loginBarButton" href="/logout">Logout</a><a class="loginBarButton barLeftButton" href="/profile/'.$_SESSION["LOGGED_USER"].'">'.$_SESSION["LOGGED_USER"].'</a><p>Bem vindo, </p>';
        if($_POST["postLike"] == "true"){
            $likeImg = "heartSolidIcon.svg";
        }
    }
    $postData = $_POST["postData"];
    $postTags = $_POST["postTags"];
    $postReplies = $_POST["postReplies"];
    $postRepliesLikes = $_POST["postRepliesLikes"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../View/modules/Images/Suna_Logo.png">
    <link rel="stylesheet" href="../View/modules/Styles/Forum.css">
    <link rel="stylesheet" href="../View/modules/Styles/Post.css">
    <title><?= $postData["postTitle"]?> - Discussão</title>
    <?php 
        if(!isset($postData["postId"])){
            echo '<script>window.location.href="/404"</script>';
        }
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var createReplyBox = new Array(<?= count($postReplies)?>);
        var checkReplyBox = new Array(<?= count($postReplies)?>);
        var checkLike = [];
        var logged = <?=$login?>;

        var checkLikePost = <?= $_POST["postLike"]?>;

        for (let i = 0; i < createReplyBox.length; i++) {
            createReplyBox[i] = null;
            checkReplyBox[i] = null;
        }

        <?php 
            for ($i=0; $i < count($postRepliesLikes); $i++) { 
                echo 'checkLike.push({replyId: '.$postRepliesLikes[$i]["postReplyId"].',});';
            }
        ?>
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
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
        <div class="postHead">
            <h1 class="postTitle"><?= $postData["postTitle"]?></h1>
            <div class="postTagsContent">
                <img class="tagIcon" src="../View/modules/Images/tagIcon.svg" alt=""> <p style="margin: 12.5px 0 0 0; color: #8a8686; font-size: 12px">Tags:</p>
                <?php for ($i=0; $i < count($postTags); $i++) { 
                    if($i == count($postTags) - 1){
                        echo '<div class="postTag"><a href="/allposts?tag='.$postTags[$i].'"; class="postTagText">'.$postTags[$i].'</a></div>';
                    }else{
                        echo '<div class="postTag"><a href="/allposts?tag='.$postTags[$i].'"; class="postTagText">'.$postTags[$i]."," .'</a></div>';
                    }
                }?>
            </div>
        </div>

        <div id="post0" class="post">
            <div class="postDate"><p><?= $postData["postDate"]?></p></div>
            <div class="postContent">
                
                <div class="postProfileBox">
                    <div style="display: flex; justify-content: center; flex-direction: column">
                        <a href="/profile/<?= $postData["userName"]?>" id="postProfileText" class="postProfileText"><?= $postData["userName"]?></a>
                        <img src="../<?= $postData["userImage"]?>" alt="Imagem de Perfil" class="postProfileImage">
                    </div>
                </div>

                <div class="postRightSide">
                    <p class="postBody"><?= $postData["postBody"]?></p>
                    <div class="postBar">
                        <div class="postLikeBox">
                            <img src="../View/modules/Images/<?= $likeImg?>" alt="" onclick="LikePost()" class="likeImg" id="likeImg0">
                            <p class="likeCount" id="likeCount0"><?= $postData["postLikes"]?></p>
                        </div>
                        <p class="postSettings" id="postReport" onclick="Report(0)" onclick="postReport()">Denunciar</p>
                        <p class="postReply" onclick="Reply(0)">Responder</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- 
        <div id="report">
            <div id="reportBox">
                <p id="reportLabel"></p>
                <input type="text" id="txtReport">
                <div id="submitReport">Enviar</div>
            </div>
        </div>
        -->

        <?php for ($i=0; $i < count($postReplies); $i++) { 
            echo '<div class="post" id="post'.$postReplies[$i]["postReplyId"].'">';
                echo '<div class="postDate"><p>'.$postReplies[$i]["replyDate"].'</p></div>';
                echo '<div class="postContent">';
                    echo '<div class="postProfileBox">';
                        echo '<div style="display: flex; justify-content: center; flex-direction: column">';
                            echo '<a href="/profile/'.$postReplies[$i]["userName"].'" class="postProfileText" id="postProfileText'.$postReplies[$i]["postReplyId"].'">'.$postReplies[$i]["userName"].'</a>';
                            echo '<img src="../'.$postReplies[$i]["userImage"].'" alt="" class="postProfileImage">';
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="postRightSide">';
                        if($postReplies[$i]["replyLayer"] !== 0){
                            for ($j = 0; $j < count($postReplies); $j++) { 
                                if($postReplies[$j]["postReplyId"] == $postReplies[$i]["replyToId"]){
                                    echo '<div class="replyBox">';
                                    echo '<p class="repliedText">'.$postReplies[$j]["replyText"]."</p>";
                                    echo '</div>';
                                    break;
                                    
                                }
                            }
                        }
                        echo '<p class="postBody" id="postBody'.$postReplies[$i]["postReplyId"].'">'.$postReplies[$i]["replyText"].'</p>';
                        echo '<div class="postBar">';
                            echo '<div class="postLikeBox">';
                                echo '<img src="../View/modules/Images/heartIcon.svg" alt="" onclick="LikeReply('.$postReplies[$i]["postReplyId"].')" class="likeImg" id="likeImg'.$postReplies[$i]["postReplyId"].'">';
                                echo '<p class="likeCount" id="likeCount'.$postReplies[$i]["postReplyId"].'">'.$postReplies[$i]["postReplyLikes"].'</p>';
                            echo '</div>';
                            echo '<p class="postSettings" onclick="Report('.$postReplies[$i]["postReplyId"].')">Denunciar</p>';
                            echo '<p class="postReply" onclick="Reply('.$postReplies[$i]["postReplyId"].')">Responder</p>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }?>
    </div>
    <div id="footer">
        <p>Doppelmate © Suna Inc. 2022 Todos os direitos reservados</p>
    </div>


    <div id="loader">
        <img onload="Load()" id="load" src="../View/modules/Images/heartIcon.svg" alt="">
    </div>
    <script src="../../View/modules/Scripts/Forum.js"></script>
    <script src="../../View/modules/Scripts/Post.js"></script>  
</body>
</html>
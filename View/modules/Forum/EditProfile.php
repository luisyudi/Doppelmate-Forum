<?php
        $login = "false";
        $imageAdvice = "";
        $profileImage = "../../View/modules/Images/shioko.png";
        $loginBarButton = '<a class="loginBarButton" href="/register">Registrar</a><a class="loginBarButton barLeftButton" href="/login">Login</a>';
        if(isset($_SESSION['LOGGED_USER'])){
            $login = "true";
            $loginBarButton = '<a class="loginBarButton" href="/logout">Logout</a><a class="loginBarButton barLeftButton" href="/profile/'.$_SESSION["LOGGED_USER"].'">'.$_SESSION["LOGGED_USER"].'</a><p>Bem vindo, </p>';
    
        }

        if(isset($_POST["profileImage"])){
            $profileImage = $_POST["profileImage"];
        }
        if(isset($_SESSION["imageAdvice"])){
            $imageAdvice = $_SESSION["imageAdvice"];
        }

        $profileDescription = $_POST["profileDescription"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../View/modules/Styles/Forum.css">
    <link rel="stylesheet" href="../../View/modules/Styles/EditProfile.css">
    <link rel="icon" type="image/x-icon" href="../View/modules/Images/Suna_Logo.png">
    <title>Editar Perfil</title>
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
        <div id="settingsContent">

            <div class="settingBox" id="changeImage">
                <div class="settingsLabel"><p>Alterar Imagem de Perfil:</p></div>
                <img src="../<?= $profileImage?>" alt="Imagem de Perfil" id="profileImg">
                <form id="form1" action="/changeimage" method="POST" enctype="multipart/form-data">
                    <input type="file" name="image"><br>
                    <label for=""><?= $imageAdvice?></label>
                    <button class="confirmButton" type="submit" name="submit" value="Upload">Confirmar</button>
                </form>
            </div>

            <div class="settingBox" id="changeUsername">
                <div class="settingsLabel"><p>Alterar Nome de Usuário:</p></div>
                <div class="labelInput">
                    <p class="label">Novo Nome de Usuário:</p>
                    <input type="text" id="txtChangeUsername" >
                    <p id="usernameAdvice"></p>
                </div>
                    
                <div class="confirmButton" id="btnChangeUsername"><p>Confirmar</p></div>
            </div>

            <div class="settingBox" id="changePasswordBox">
                <div class="settingsLabel"><p>Alterar Senha:</p></div>
                <div class="labelInput">
                    <p class="label">Nova senha:</p>
                    <input type="password" id="txtChangePassword" >
                    <p id="passwordAdvice"></p>
                </div>
                <div class="labelInput">    
                    <p class="label">Confirmar senha:</p>
                    <input type="password" id="txtChangePasswordConfirm">
                </div>
                <div class="confirmButton" id="btnChangePassword"><p>Confirmar</p></div>
            </div>

            <div class="settingBox" id="changeDescription">
                <div class="settingsLabel"><p>Alterar Descrição do Perfil:</p></div>
                <textarea name="txtDescription" spellcheck="false" id="txtChangeDescription" cols="45" rows="10"><?= $profileDescription?></textarea>
                <div class="confirmButton" id="btnChangeDescription"><p>Confirmar</p></div>
            </div>
        </div>
    </div>
    <div id="footer">
        <p>Doppelmate © Suna Inc. 2022 Todos os direitos reservados</p>
    </div>


    <?php
        unset($_SESSION["imageAdvice"]);
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../../View/modules/Scripts/Forum.js"></script>
    <script src="../../View/modules/Scripts/ProfileSettings.js"></script>
</body>
</html>
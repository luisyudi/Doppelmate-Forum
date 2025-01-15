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
    <link rel="stylesheet" href="../View/modules/Styles/RegisterLogin.css">
    <title>Criar conta</title>

    
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
        <form id="formRegister" style="height: 400px;">
            <h1>Registrar</h1>
            <div class="formInput">
                <label for="username">Nome de Usuário:</label>
                <input type="text" id="txtUsername" name="username" autocomplete="off">
            </div>
            <p class="lblMessage" id="lblMessageUsername"></p>
                    
            <div class="formInput">
                <label for="email">Email:</label>
                <input type="email" id="txtEmail" name="email" autocomplete="off">
            </div>
            <p class="lblMessage" id="lblMessageEmail"></p>

                
            <div class="formInput">
                <label id="lblPassword" for="password">Senha:</label>
                <input onkeyup="confirmingPassword()" type="password" id="txtPassword" name="password" autocomplete="off">
            </div>
            <p class="lblMessage" id="lblMessagePassword"></p>

            <div class="formInput">
                <label id="lblConfirmPassword" for="confirmPassword">Confirmar Senha:</label>
                <input onkeyup="confirmingPassword()" type="password" id="txtConfirmPassword" name="confirmPassword" autocomplete="off">
            </div>
            <p class="lblMessage" id="lblMessagePassword"></p>

            <div id="btnRegister" class="button">Registrar</div>
        </form>
    </div>
    <div id="footer">
        <p>Doppelmate © Suna Inc. 2022 Todos os direitos reservados</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../../View/modules/Scripts/Forum.js"></script>
    <script src="../View/modules/Scripts/Register.js"></script>
</body>
</html>

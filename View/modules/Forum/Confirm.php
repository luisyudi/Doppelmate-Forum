<?php
    $login = "false";
    $loginBarButton = '<a class="loginBarButton" href="/register">Registrar</a><a class="loginBarButton barLeftButton" href="/login">Login</a>';
    session_start();
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
    <link rel="stylesheet" href="../View/modules/Styles/Home.css">
    <link rel="stylesheet" href="../View/modules/Styles/Forum.css">
    <link rel="stylesheet" href="../View/modules/Styles/RegisterLogin.css">
    <title>Home - Fórum</title>
</head>
<body>
    <div id="backgroundFilter"></div>
    <div id="loginBar">
        <?= $loginBarButton?>
    </div>
    <nav>
        <div id="btnLogo"><a href="/">Logão</a></div>
        <div id="btnForum"><a href="">Fórum</a></div>
    </nav>
    <div id="content" >
        <a style="color: black;">confirmado</a>
    </div>
    <div id="footer">

    </div>

    
</body>
</html>
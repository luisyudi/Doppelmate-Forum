<?php

include 'Controller/AppController.php';
include 'Controller/UserController.php';
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if(strpos($url, "/profile") !== false){
    $profileUser = substr($url, 9, strlen($url) - 7);

    $url = "/profile";
}

switch($url){
    case '/':
        AppController::Home();
        include 'View/modules/Forum/HomeForum.php';
    break;

    case '/changepage':
        AppController::ChangePage();    
    break;

    case '/search':
        AppController::Search();
        include 'View/modules/Forum/Search.php';
    break;

    case '/allposts':
        AppController::showPostsBySort();
        include 'View/modules/Forum/AllPosts.php';
    break;

    case '/login':
        session_start();
        if(isset($_SESSION["LOGGED_USER"])){
            header("Location: /Forum");
        }else{
            include 'View/modules/Forum/Login.php';
        }
    break;

    case '/login/loginuser':
        UserController::Login();
    break;

    case '/register/createaccount':
        UserController::CreateAccount();
    break;

    case '/register':
        session_start();
        if(isset($_SESSION["LOGGED_USER"])){
            header("Location: /Forum");
        }else{
            include 'View/modules/Forum/Register.php';
        }
    break;

    case '/logout':
        UserController::Logout();
        header("Location: /");
    break;

    case '/profile':
        UserController::Profile($profileUser);
        include 'View/modules/Forum/Profile.php';
    break;

    case '/btprofile':
        session_start();
        if(!isset($_SESSION["LOGGED_USER"])){
            header("Location: /login");
        }else{
            header("Location: /profile/". $_SESSION["LOGGED_USER"]);
        }
    break;

    case '/editprofile':
        session_start();
        if(!isset($_SESSION["LOGGED_USER"])){
            header("Location: /login");
        }else{
            UserController::EditProfile();
            include 'View/modules/Forum/EditProfile.php';
        }
    break;

    case '/changeimage':
        if(isset($_POST["submit"]) && isset($_FILES["image"])){
            UserController::ChangeImage();
        }
        header("Location: /editprofile");
    break;

    case '/changeusername':
        UserController::ChangeUsername();
    break;

    case '/changepassword':
        UserController::ChangePassword();
    break;

    case '/changedescription':
        UserController::ChangeDescription();
    break;

    case '/newpost':
        session_start();
        if(!isset($_SESSION["LOGGED_USER"])){
            header("Location: /login");
        }else{
            include 'View/modules/Forum/CreatePost.php';
        }
    break;

    case '/createnewpost':
        AppController::CreateNewPost();
    break;

    case '/likereply':
        UserController::LikeReply();
    break;

    case '/unlikereply':
        UserController::UnlikeReply();
    break;

    case '/likepost':
        UserController::LikePost();
    break;

    case '/unlikepost':
        UserController::UnlikePost();
    break;

    case '/post':
        AppController::ViewPost();
        include 'View/modules/Forum/Post.php';
    break;

    case '/report':
        AppController::Report();
    break;

    case '/createreply':
        AppController::CreateReply();
    break;

    case '/404':
        include 'View/modules/Forum/404.php';
    break;

    case '/contact':
        include 'View/modules/Forum/Contact.php';
    break;

    default: 
        include 'View/modules/Forum/404.php';
    break;
}
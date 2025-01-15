<?php 

class UserController{
    //Criação de um novo usuário no fórum
    public static function CreateAccount(){ 
        include 'Model/UserModel.php';
        header('Content-Type: application/json');
        $userModel = new UserModel();
        $userModel->userName = $_POST['username'];
        $userModel->userPassword = $_POST['password'];
        $userModel->userEmail = $_POST['email'];

        $userModel->userPassword = password_hash($userModel->userPassword, PASSWORD_DEFAULT);
        $confirm = $userModel->CreateAccount($userModel);
        echo json_encode($confirm);        
    }

    //Login de usuário
    public static function Login(){ 
        include 'Model/UserModel.php';
        header('Content-Type: application/json');
        $userModel = new UserModel();
        $userModel->userPassword = $_POST['password'];
        $userModel->userEmail = $_POST['email'];
        $result = $userModel->Login($userModel);

        if($result != false){
            if(password_verify($userModel->userPassword, $result[0]["userPassword"]) || $userModel->userPassword == $result[0]["userPassword"]){
                session_start();
                $_SESSION["LOGGED_USER"] = $result[0]["userName"];
                echo json_encode($result);
            }else{
                echo json_encode("Senha ou Email incorretos");
            }
        }else{
            echo json_encode("Senha ou Email incorretos");
        }
    }

    //Realiza o logout do usuário, removendo a variável da Session
    public static function Logout(){ 
        session_start();
        unset($_SESSION["LOGGED_USER"]);
    }

    public static function Profile(String $profileUser){
        include 'Model/UserModel.php';
        include 'Model/PostModel.php';
        session_start();
        $userModel = new UserModel();
        $postModel = new PostModel();
        $userLikes = array();
        $profilePosts = $userModel->Profile($profileUser);
        $profileDescription = $userModel->GetProfileDescription($profileUser);
        $profileImage = $userModel->GetProfileImage($profileUser);
        
        if(isset($_SESSION["LOGGED_USER"])){
            $userName = $_SESSION["LOGGED_USER"];
            for ($i=0; $i < count($profilePosts); $i++) {  
                if($postModel->VerifyPostLike($profilePosts[$i]["postId"], $userName) != null){
                    array_push($userLikes, $postModel->VerifyPostLike($profilePosts[$i]["postId"], $userName));
                }
            }
        }
        

        $_POST["userLikes"] = $userLikes;
        $_POST["profilePosts"] = $profilePosts;
        $_POST["profileUser"] = $profileUser;
        $_POST["profileDescription"] = $profileDescription;
        if($profileImage != null){
            $_POST["profileImage"] = $profileImage;
        }
    }

    public static function EditProfile(){
        include 'Model/UserModel.php';
        $userModel = new UserModel();
        $_POST["profileDescription"] = $userModel->GetProfileDescription($_SESSION["LOGGED_USER"]);
        $profileImage = $userModel->GetProfileImage($_SESSION["LOGGED_USER"]);
        if($profileImage != null){
            $_POST["profileImage"] = $profileImage;
        }
    }

    public static function ChangeImage() {
        include 'Model/UserModel.php';
        session_start();
        header('Content-Type: application/json');
        $userModel = new UserModel();
        $imageName = $_FILES["image"]["name"];
        $imageSize = $_FILES["image"]["size"];
        $tmp_name = $_FILES["image"]["tmp_name"];
        $error = $_FILES["image"]["error"]; 
        $_SESSION["imageAdvice"] = "";
        if($error === 0){
            if($imageSize > 1000000){
                $_SESSION["imageAdvice"] = ("Imagem maior que 1MB não suportada");
            }else{
                $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
                $allowedExtensions = array("jpg", "jpeg", "png");
                if(in_array(strtolower($imageExtension), $allowedExtensions)){
                    $newImageName = uniqid("IMG-", true).'.'.strtolower($imageExtension);
                    $imageUploadPath = 'View/modules/Forum/ProfileImage/'.$newImageName;
                    move_uploaded_file($tmp_name, $imageUploadPath);

                    $userModel->ChangeImage($imageUploadPath, $_SESSION["LOGGED_USER"]);
                }else{
                    $_SESSION["imageAdvice"] = ("Formato de imagem não suportado");
                }
            }
        }else{
            $_SESSION["imageAdvice"] = ("Erro ao carregar imagem");
        }
    }

    public static function ChangeUsername() {
        include 'Model/UserModel.php';
        session_start();
        header('Content-Type: application/json');
        $userModel = new UserModel();
        $newUserName = $_POST["newUsername"];
        $usernameAdvice = $userModel->ChangeUsername($newUserName, $_SESSION["LOGGED_USER"]);
        if($usernameAdvice === "Nome de Usuário atualizado"){
            $_SESSION["LOGGED_USER"] = $newUserName;
        }
        echo json_encode($usernameAdvice);
    }

    public static function ChangePassword() {
        include 'Model/UserModel.php';
        session_start();
        header('Content-Type: application/json');
        $userModel = new UserModel();
        $newPassword = $_POST["newPassword"];
        $passwordAdvice = $userModel->ChangePassword(password_hash($newPassword, PASSWORD_DEFAULT), $_SESSION["LOGGED_USER"]);
        echo json_encode($passwordAdvice);
    }

    public static function ChangeDescription() {
        include 'Model/UserModel.php';
        session_start();
        header('Content-Type: application/json');
        $userModel = new UserModel();
        $newDescription = $_POST["newDescription"];
        $userModel->ChangeDescription($newDescription, $_SESSION["LOGGED_USER"]);
    }

    public static function LikePost(){
        include 'Model/PostModel.php';
        $postModel = new PostModel();
        session_start();
        $userName = $_SESSION["LOGGED_USER"];
        $postId = $_POST["postId"];
        $postModel->LikePost($postId, $userName);
        $postModel->IncreasePostLikeCount($postId);
    }

    public static function UnlikePost(){
        include 'Model/PostModel.php';
        $postModel = new PostModel();
        session_start();
        $userName = $_SESSION["LOGGED_USER"];
        $postId = $_POST["postId"];
        $postModel->UnlikePost($postId, $userName);
        $postModel->DecreasePostLikeCount($postId);
    }

    public static function LikeReply(){
        include 'Model/ReplyModel.php';
        $replyModel = new ReplyModel();
        session_start();
        $postReplyId = $_POST["replyId"];
        $userName = $_SESSION["LOGGED_USER"];
        $replyModel->LikeReply($postReplyId, $userName);
        $replyModel->IncreaseReplyLikeCount($postReplyId);
    }

    public static function UnlikeReply(){
        include 'Model/ReplyModel.php';
        $replyModel = new ReplyModel();
        session_start();
        $postReplyId = $_POST["replyId"];
        $userName = $_SESSION["LOGGED_USER"];
        $replyModel->UnlikeReply($postReplyId, $userName);
        $replyModel->DecreaseReplyLikeCount($postReplyId);
    }
}
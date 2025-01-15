<?php 

class UserModel{
    public $userId, $userName, $userEmail, $userPassword, $userImage, $postId, $postTitle, $postBody, $postDate, $postLikes, $postReply, $replyLayer, $replyToId, $replyDate;

    //Insere no banco de dados um novo usuário
    public function CreateAccount(UserModel $model){
        $existEmail = $this->VerifyIfAccountExists($model->userEmail);
        $existUsername = $this->VerifyIfUsernameExists($model->userName);
        if($existEmail == false && $existUsername == false){
            try{
                include_once 'ConnectionDAO/ConnectionDAO.php';
                $dao = new ConnectionDAO();
                $sql = "INSERT INTO tblUser (userName, userPassword, userEmail, userImage) VALUES (?, ?, ?, ?)";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $model->userName);
                $stmt->bindValue(2, $model->userPassword);
                $stmt->bindValue(3, $model->userEmail);
                $stmt->bindValue(4, 'View/modules/Forum/ProfileImage/default.jpeg');
                $stmt->execute();
            }catch (\Throwable $e){
                throw $e;
            }
            return "true";
        }else{
            if ($existEmail == true) {
                return "email";
            } else {
                return "username";
            }
        }
    }

    //Verifica se o email já foi cadastrado
    public function VerifyIfAccountExists(String $email){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "select userEmail from tblUser where userEmail = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //Verifica se o usuário já existe
    public function VerifyIfUsernameExists(String $username){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "select userName from tblUser where userName = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $username);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //Login do Usuário
    public function Login(UserModel $model){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "select userName, userPassword from tblUser where userEmail = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $model->userEmail);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function GetUserId(String $userName){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "SELECT userId FROM tblUser WHERE userName = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $userName);
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function Profile(String $profileUser){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        include_once 'Model/PostModel.php';
        try {
            $postModel = new PostModel();
            $dao = new ConnectionDAO();
            $sql = "SELECT postId, postTitle, postBody, postLikes, postDate FROM tblPost WHERE userId = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $this->GetUserId($profileUser));
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $postsData = array();
            for ($i=0; $i < count($posts); $i++) { 
                $postsData[$i] = array(
                    "postId" => $posts[$i]["postId"],
                    "postTitle" => $posts[$i]["postTitle"],
                    "postBody" => $posts[$i]["postBody"],
                    "postLikes" => $posts[$i]["postLikes"],
                    "postDate" => $posts[$i]["postDate"],
                    "postTags" => $postModel->GetPostTags($posts[$i]["postId"]),
                );
            }
            return $postsData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function ChangeUsername(String $newUserName, String $userName){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        if($this->VerifyIfUsernameExists($newUserName) == false){
            try {
                $dao = new ConnectionDAO();
                $sql = "UPDATE tblUser SET userName = ? WHERE userName = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $newUserName);
                $stmt->bindValue(2, $userName);
                $stmt->execute();
                return "Nome de Usuário atualizado";
            } catch (\Throwable $th) {
                throw $th;
            }
        }else{
            return "Usuário já utilizado";
        }
    }

    public function ChangeImage(String $newUserImage, String $userName){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "UPDATE tblUser SET userImage = ? WHERE userName = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $newUserImage);
            $stmt->bindValue(2, $userName);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function ChangePassword(String $newPassword, String $userName){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "UPDATE tblUser SET userPassword = ? WHERE userName = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $newPassword);
            $stmt->bindValue(2, $userName);
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }

    public function ChangeDescription(String $newDescription, String $userName){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "UPDATE tblUser SET userDescription = ? WHERE userName = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $newDescription);
            $stmt->bindValue(2, $userName);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    
    public function GetProfileImage(String $userName){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "SELECT userImage FROM tblUser WHERE userName = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $userName);
            $stmt->execute();
            return (String) $stmt->fetchColumn();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function GetProfileDescription(String $userName){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "SELECT userDescription FROM tblUser WHERE userName = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $userName);
            $stmt->execute();
            $description = $stmt->fetchColumn();
            return $description;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

?>
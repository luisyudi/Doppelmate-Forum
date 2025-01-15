<?php 
    class PostModel{
        public $userId, $userName, $userEmail, $userPassword, $userImage, $postId, $postTitle, $postBody, $postDate, $postLikes, $postReply, $replyLayer, $replyToId, $replyDate;
        public $postTags = array();

        //Cria uma nova postagem
        public function CreateNewPost(PostModel $postModel){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            include_once 'Model/UserModel.php';
            try {
                $userModel = new UserModel();
                $dao = new ConnectionDAO();
                $sql = "INSERT INTO tblPost (postTitle, postBody, postDate, userId) VALUES (?, ?, ?, ?)";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postModel->postTitle);
                $stmt->bindValue(2, $postModel->postBody);
                $stmt->bindValue(3, $postModel->postDate);
                $stmt->bindValue(4, $userModel->GetUserId($postModel->userName));
                $stmt->execute();    
            } catch (\Throwable $th) {
                throw $th;
            }
            if($postModel->postTags != "null"){
                for ($i = 0; $i < count($postModel->postTags); $i++) { 
                    if($postModel->postTags[$i] != null){
                        if(!$this->VerifyIfTagExists($postModel->postTags[$i])){ //Verifica se a tag não existe
                            $this->CreateTag($postModel->postTags[$i]); //Caso a tag ainda não exista, ela é criada
                        }
                        $this->InsertPostTags($postModel->postTags[$i], $this->GetUserId($postModel->userName)); //Solicita a inserção das tags na postagem recém criada
                    }
                }
            }
            return $this->GetPostId($this->GetUserId($postModel->userName));
        }

        //Seleciona o id da postagem
        public function GetPostId(int $userId) {
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT MAX(postId) FROM tblPost WHERE userId = ?"; 
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $userId);
                $stmt->execute();
                return $stmt->fetchColumn();
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        //Insere as tags na postagem recém criada
        public function InsertPostTags(String $tag, int $userId){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "INSERT INTO tblPostTags (postId, tagName) VALUES (?, ?)";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $this->GetPostId($userId));
                $stmt->bindValue(2, $tag);
                $stmt->execute();    
            } catch (\Throwable $th) {
                throw $th;
            }
        }

       
        
    
        //Seleciona todas as informações de um post
        public function GetPostData(int $postId) {
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT u.userId, u.userName, u.userImage, p.postId, p.postTitle, p.postBody, p.postLikes, p.postDate FROM tblUser u INNER JOIN tblPost p ON u.userId = p.userId WHERE p.postId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postId);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        //Seleciona todas as tags de um post
        public function GetPostTags(int $postId) {
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT tagName FROM tblPostTags WHERE postId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postId);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_NUM);
            } catch (\Throwable $th) {
                throw $th;
            }
        }


        public function ReportPost(int $id, int $userName, String $reportText){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "INSERT INTO tblReportPost (userId, postId, reportText) VALUES (?, ?, ?)";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $this->GetUserId($userName));
                $stmt->bindValue(2, $postId);
                $stmt->bindValue(3, $reportText);
                $stmt->execute();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function VerifyPostLike(int $postId, String $userName){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT postId FROM tblPostLikes WHERE postId = ? AND userId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postId);
                $stmt->bindValue(2, $this->GetUserId($userName));
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    return $stmt->fetchColumn();
                }else{
                    return null;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        public function LikePost(int $postId, String $userName){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "INSERT INTO tblPostLikes (userId, postId) VALUES (?, ?)";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $this->GetUserId($userName));
                $stmt->bindValue(2, $postId);
                $stmt->execute(); 
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
    
        public function UnlikePost(int $postId, String $userName){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "DELETE FROM tblPostLikes WHERE userId = ? AND postId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $this->GetUserId($userName));
                $stmt->bindValue(2, $postId);
                $stmt->execute(); 
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function VerifyIfPostIsLiked(String $userName, int $postId){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT userId FROM tblPostLikes WHERE userId = ? AND postId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $this->GetUserId($userName));
                $stmt->bindValue(2, $postId);
                $stmt->execute(); 
                if($stmt->rowCount() > 0) {
                    return "true";
                } else {
                    return "false";
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function IncreasePostLikeCount(int $postId){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "UPDATE tblPost SET postLikes = postLikes + 1 WHERE postId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postId);
                $stmt->execute(); 
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function DecreasePostLikeCount(int $postId){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "UPDATE tblPost SET postLikes = postLikes - 1 WHERE postId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postId);
                $stmt->execute(); 
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        
        //Verifica se a tag já existe
        public function VerifyIfTagExists(String $tag){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT tagName FROM tblTags WHERE tagName = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $tag);
                $stmt->execute();
                if($stmt->rowCount() > 0) {
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        //Cria uma nova tag
        public function CreateTag(String $tag){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "INSERT INTO tblTags (tagName) VALUES (?)";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $tag);
                $stmt->execute();
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
    }
?>
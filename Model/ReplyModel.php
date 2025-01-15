<?php 
    class ReplyModel{
        public $userId, $userName, $userEmail, $userPassword, $userImage, $postId, $postTitle, $postBody, $postDate, $postLikes, $postReply, $replyLayer, $replyToId, $replyDate;

        public function ReportReply(int $id, int $userName, String $reportText){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "INSERT INTO tblReportReply (userId, postId, reportText) VALUES (?, ?, ?)";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $this->GetUserId($userName));
                $stmt->bindValue(2, $postId);
                $stmt->bindValue(3, $reportText);
                $stmt->execute();
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        public function LikeReply(int $postReplyId, String $userName){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "INSERT INTO tblPostReplyLikes (userId, postReplyId) VALUES (?, ?)";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $this->GetUserId($userName));
                $stmt->bindValue(2, $postReplyId);
                $stmt->execute(); 
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function IncreaseReplyLikeCount(int $postReplyId){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "UPDATE tblPostReply SET postReplyLikes = postReplyLikes + 1 WHERE postReplyId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postReplyId);
                $stmt->execute(); 
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function UnlikeReply(int $postReplyId, String $userName){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "DELETE FROM tblPostReplyLikes WHERE userId = ? AND postReplyId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $this->GetUserId($userName));
                $stmt->bindValue(2, $postReplyId);
                $stmt->execute(); 
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function DecreaseReplyLikeCount(int $postReplyId){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "UPDATE tblPostReply SET postReplyLikes = postReplyLikes - 1 WHERE postReplyId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postReplyId);
                $stmt->execute(); 
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function GetAllReplyLikes(String $userName, int $postId){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT rl.postReplyId FROM tblPostReplyLikes rl INNER JOIN tblPostReply r ON rl.postReplyId = r.postReplyId WHERE r.postId = ? AND rl.userId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postId);
                $stmt->bindValue(2, $this->GetUserId($userName));
                $stmt->execute(); 
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function CreateReply(ReplyModel $replyModel){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "INSERT INTO tblPostReply (postId, userId, replyText, replyLayer, replyToId, replyDate) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $replyModel->postId);
                $stmt->bindValue(2, $this->GetUserId($replyModel->userName));
                $stmt->bindValue(3, $replyModel->postReply);
                $stmt->bindValue(4, $replyModel->replyLayer);
                $stmt->bindValue(5, $replyModel->replyToId);
                $stmt->bindValue(6, $replyModel->replyDate);
                $stmt->execute();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function GetCreatedReply(){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT r.postReplyId, u.userId, u.userName, u.userImage, r.replyText, r.replyDate, r.postReplyLikes, r.replyLayer, r.replyToId FROM tblPostReply r INNER JOIN tblUser u ON u.userId = r.userId WHERE r.postReplyId IN (select MAX(r.postReplyId) from tblPostReply) order by r.postReplyId DESC limit 1;";
                $stmt = $dao->connection->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function GetReplyLayer(int $replyToId){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT replyLayer FROM tblPostReply WHERE replyToId = ?";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $replyToId);
                $stmt->execute();
                return $stmt->fetchColumn();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    
        public function GetAllReplies(int $postId){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT r.postReplyId, u.userId, u.userName, u.userImage, r.replyText, r.replyDate, r.postReplyLikes, r.replyLayer, r.replyToId FROM tblPostReply r INNER JOIN tblUser u ON u.userId = r.userId WHERE r.postId = ? ORDER BY r.postReplyLikes DESC";
                $stmt = $dao->connection->prepare($sql);
                $stmt->bindValue(1, $postId);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
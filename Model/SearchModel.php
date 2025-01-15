<?php 
    class SearchModel{
        public function SearchUser($q){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT userImage, userName FROM tblUser WHERE userName LIKE '%".$q."%'";
                $stmt = $dao->connection->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    return null;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        public function SearchPost($q){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT p.postTitle, p.postId, u.userName FROM tblPost p INNER JOIN tblUser u ON p.userId = u.userId WHERE p.postBody LIKE '%".$q."%' OR p.postTitle LIKE '%".$q."%' ORDER BY postDate DESC";
                $stmt = $dao->connection->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    return null;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        public function SearchTag($q){
            include_once 'ConnectionDAO/ConnectionDAO.php';
            try {
                $dao = new ConnectionDAO();
                $sql = "SELECT tagName FROM tblTags WHERE tagName LIKE '%".$q."%'";
                $stmt = $dao->connection->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    return null;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
?>
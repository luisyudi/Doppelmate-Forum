<?php

class HomeModel{
    public $userId, $userName, $userEmail, $userPassword, $userImage, $postId, $postTitle, $postBody, $postDate, $postLikes, $postReply, $replyLayer, $replyToId, $replyDate;
    public $postTags = array();

    public function GetRecentPosts(int $page){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "SELECT p.postTitle, p.postId, u.userName FROM tblPost p INNER JOIN tblUser u ON p.userId = u.userId ORDER BY p.postDate DESC LIMIT 15";
            $stmt = $dao->connection->prepare($sql);
            $stmt->execute();
            $allPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $recentPosts = array();
            for ($i= ($page - 1) * 5; $i < (($page - 1) * 5) + 5; $i++) { 
                $recentPosts[$i] = $allPosts[$i];
            }
            return $recentPosts;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function GetNews(){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "SELECT postTitle, postId, userName FROM tblPost p INNER JOIN tblUser u ON p.userId = u.userId WHERE userName = 'roodorooraada' ORDER BY postDate DESC LIMIT 5";
            $stmt = $dao->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function GetTrendingPosts(int $page){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "SELECT p.postTitle, p.postId, u.userName FROM tblPost p INNER JOIN tblUser u ON p.userId = u.userId ORDER BY p.postLikes DESC LIMIT 15";
            $stmt = $dao->connection->prepare($sql);
            $stmt->execute();
            $allPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $trendingPosts = array();
            for ($i = ($page - 1) * 5; $i < (($page - 1) * 5) + 5; $i++) { 
                $trendingPosts[$i] = $allPosts[$i];
            }
            return $trendingPosts;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getPostsBySort(String $sort, int $page){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "SELECT p.postTitle, p.postId, u.userName FROM tblPost p INNER JOIN tblUser u ON p.userId = u.userId ORDER BY ".$sort." DESC";
            $stmt = $dao->connection->prepare($sql);
            $stmt->execute();
            $allPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $posts = array();
            for ($i = ($page - 1) * 15; $i < ($page - 1) * 15 + 15; $i++) { 
                if(isset($allPosts[$i])){
                    $posts[$i] = $allPosts[$i];
                }else{
                    break;
                }
            }
            return $posts;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function GetAllPostsByTag(String $tag, int $page) {
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "SELECT postId, postTitle, userId FROM tblPost WHERE postId IN (SELECT postId FROM tblPostTags WHERE tagName = ?)";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $tag);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getUserNameById(int $id){
        include_once 'ConnectionDAO/ConnectionDAO.php';
        try {
            $dao = new ConnectionDAO();
            $sql = "SELECT userName FROM tblUser WHERE userId = ?";
            $stmt = $dao->connection->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $post = $stmt->fetchColumn();
            return $post;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    
}


<?php 

class AppController{
    public static function Home(){
        include_once 'Model/HomeModel.php';
        $homeModel = new HomeModel();
        $recentPosts = $homeModel->GetRecentPosts(1);
        $trendingPosts = $homeModel->GetTrendingPosts(1);
        $news = $homeModel->GetNews();
        $_POST["recent"] = $recentPosts;
        $_POST["trending"] = $trendingPosts;
        $_POST["news"] = $news;
    }

    public static function ChangePage(){
        include_once 'Model/HomeModel.php';
        header('Content-Type: application/json');
        $homeModel = new HomeModel();
        $posts = array();
        if($_POST["type"] == "recent"){
            $posts = $homeModel->GetRecentPosts($_POST["page"]);
        }else {
            $posts = $homeModel->GetTrendingPosts($_POST["page"]);
        }
        echo json_encode($posts);
    }


    public static function RecentPosts(){
        include_once 'Model/HomeModel.php';
        header('Content-Type: application/json');
        $homeModel = new HomeModel();
        $page = $_POST["pageRecent"];
        $posts = $homeModel->GetRecentPosts($page);
        echo json_encode($posts);
    }

    public static function TrendingPosts(){
        include_once 'Model/HomeModel.php';
        $homeModel = new HomeModel();
        $page = $_POST["pageTrending"];
        $posts = $homeModel->GetRecentPosts($page);
        echo json_encode($posts);
    }

    
    public static function showPostsBySort(){
        include_once 'Model/HomeModel.php';
        include_once 'Model/PostModel.php';
        $homeModel = new HomeModel();
        $postModel = new PostModel();
        $posts = array();
        $sort = "null";
        $page = "1"; //Inicia variaveis

        if(isset($_GET["page"])){
            $page = $_GET["page"]; 
        }else if(!is_int($page) || $page < 0){
            $page = 1;
        } 

        if(isset($_GET["sort"])){

            if($_GET["sort"] == "date"){
                $sort = "p.postDate";
                $posts = $homeModel->getPostsBySort($sort, $page);
            }else if($_GET["sort"] == "like"){
                $sort = "p.postLikes";
                $posts = $homeModel->getPostsBySort($sort, $page);
            }

        }else if(isset($_GET["tag"])){
            $posts = $homeModel->GetAllPostsByTag($_GET["tag"], $page);
            $sort = "tags";
            for ($i=0; $i < count($posts); $i++) { 
                $posts[$i]["userName"] = $homeModel->getUserNameById($posts[$i]["userId"]);
            }

            $_POST["tag"] = $_GET["tag"];
        }

        for ($i=0; $i < count($posts); $i++) { 
            $posts[$i]["postTags"] =  $postModel->GetPostTags($posts[$i]["postId"]);
        }

        $_POST["posts"] = $posts;
        $_POST["sort"] = $sort;
    }

    public static function Search(){
        include 'Model/SearchModel.php';
        include 'Model/PostModel.php';
        $q = $_GET["q"]; //Termo a ser pesquisado
        $searchModel = new SearchModel();
        $postModel = new PostModel();

        $searchResult = array(
            $searchModel->SearchUser($q),
            $searchModel->SearchPost($q),
            $searchModel->SearchTag($q),
        );
        if(isset($searchResult[1])){
            for ($i=0; $i < count($searchResult[1]); $i++) { 
                $searchResult[3][$i] = $postModel->GetPostTags($searchResult[1][$i]["postId"]);
            }
        }
        
        $_POST["searchResult"] = $searchResult;
        $_POST["q"] = $q;
    }


    public static function CreateNewPost(){
        include 'Model/PostModel.php';
        header('Content-Type: application/json');
        date_default_timezone_set('America/Sao_Paulo');
        session_start();
        $postModel = new PostModel();
        $postModel->userName = $_SESSION["LOGGED_USER"];
        $postModel->postTitle = $_POST['title'];
        $postModel->postBody = $_POST['description'];
        $postModel->postTags = $_POST['tags'];
        $postModel->postDate = date('Y-m-d H:i:s');

        $postId = $postModel->CreateNewPost($postModel);

        echo json_encode($postId);
    }

    public static function Report(){
        include 'Model/PostModel.php';
        $postModel = new PostModel();
        $replyModel = new ReplyModel();
       
        session_start();
        $userName = $_SESSION["LOGGED_USER"];
        $id = $_POST['id'];
        $type = $_POST['type'];
        $reportText = $_POST["reportText"];

        if($type == "post"){
            $postModel->ReportPost($id, $userName, $reportText);
        }else{
            $replyModel->ReportReply($id, $userName, $reportText);
        }
    }

    public static function ViewPost(){
        include 'Model/PostModel.php';
        include 'Model/ReplyModel.php';
        session_start();
        $postModel = new PostModel();
        $replyModel = new ReplyModel();
        $appController = new AppController();

        $postId = $_GET["id"];
        $postData = $postModel->GetPostData($postId);
        $postTags = $postModel->GetPostTags($postId);
        $postReplies = $replyModel->GetAllReplies($postId);
        $tags = array();

        for ($i=0; $i < count($postTags); $i++) {
            for ($j=0; $j < count($postTags[$i]); $j++) { 
                $tags[$i] = $postTags[$i][$j];
            }
        }

        $replies = $appController->OrderReplies($postReplies, $appController); // $replies passa a estar na ordem correta
        $replyLikes = array();
        $isPostLiked = "false";
        
        if(isset($_SESSION["LOGGED_USER"])){
            $replyLikes = $replyModel->GetAllReplyLikes($_SESSION["LOGGED_USER"], $postId); //Verifica se o usuário logado curtiu o post
            $isPostLiked = $postModel->VerifyIfPostIsLiked($_SESSION["LOGGED_USER"], $postId);
        }
        
        # Arruma o formato do horário para o Brasil
        if(isset($postData["postDate"])){
            $postData["postDate"] = $appController->ChangeDateFormat($postData["postDate"]);
        }

        for ($i=0; $i < count($replies); $i++) { 
            $replies[$i]["replyDate"] = $appController->ChangeDateFormat($replies[$i]["replyDate"]);
        }

        
        $_POST["postLike"] = $isPostLiked;
        $_POST["postRepliesLikes"] = $replyLikes;
        $_POST["postReplies"] = $replies;
        $_POST["postData"] = $postData;
        $_POST["postTags"] = $tags;
    }

    public static function CreateReply(){
        include 'Model/ReplyModel.php';
        header('Content-Type: application/json');
        date_default_timezone_set('America/Sao_Paulo');
        session_start();
        $replyModel = new ReplyModel();
        $appController = new AppController();
        $replyModel->postReply = $_POST["reply"];
        $replyModel->userName = $_SESSION["LOGGED_USER"]; 
        $replyModel->replyToId = $_POST["replyToId"];
        $replyModel->postId = $_POST["postId"];
        $replyModel->replyDate = date('Y-m-d H:i:s');

        if($_POST["replyToId"] == "0"){
            $replyModel->replyLayer = 0;
        }else{
            $replyModel->replyLayer = $replyModel->GetReplyLayer($replyModel->replyToId) + 1;
        }

        $replyModel->CreateReply($replyModel);
        $createdReply = $replyModel->GetCreatedReply();

        $createdReply[0]["replyDate"] = $appController->ChangeDateFormat($createdReply[0]["replyDate"]);

        echo json_encode($createdReply);
    }

    public static function ChangeDateFormat(String $date){
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);
        $hour = substr($date, 11, 2);
        $minutes = substr($date, 14, 2);
        return $day."/".$month."/".$year." ".$hour."h".$minutes;
    }

    //O código abaixo organiza as resposta de um post em um array associativo
    public function OrderReplies($postReplies, $appController){
        $final = array_fill(0, count($postReplies), null);
        $pointer = 0;
        $back = 0;

        for ($i = 0; $i < $appController->countLayer(0, $postReplies); $i++) { 
            $final[$pointer] = $postReplies[$appController->getByLayer(0, $i, $postReplies)];
            $pointer++; 
        }
        
        while($back != count($postReplies)){
            if($appController->verifyReplies($final[$back]["postReplyId"], $postReplies)){
                for ($i = 0; $i < $appController->countReplies($final[$back]["postReplyId"], $postReplies); $i++) { 
                    for ($j = count($final) - 1; $j > $back + 1; $j--) {
                        $final[$j] = $final[$j - 1];
                    }
                    $final[$back + 1] = $postReplies[$appController->getRepliesByToId($final[$back]["postReplyId"], $i, $postReplies)];
                }
            }
            $back++;
        }
        return $final;
    }

    public function getByLayer($layerNumber, $funcPointer, $postReplies){
        $array = array();
        for($i = 0; $i < count($postReplies); $i++){
            if($postReplies[$i]["replyLayer"] === $layerNumber){
                array_push($array, $i);
            }
        }
        return $array[$funcPointer];
    }
    public function countLayer($layerNumber, $postReplies){
        $count = 0;
        for($i = 0; $i < count($postReplies); $i++){
            if($postReplies[$i]["replyLayer"] == $layerNumber){
                $count++;
            }
        }
        return $count;
    }

    public function verifyReplies($idNumber, $postReplies){
        for($i = 0; $i < count($postReplies); $i++){
            if($postReplies[$i]["replyToId"] == $idNumber){
                return true;
            }
        }
        return false;
    }
    public function getRepliesByToId($toId, $funcPointer, $postReplies){
        $array = array();
        for ($i=0; $i < count($postReplies); $i++) { 
            if($postReplies[$i]["replyToId"] === $toId){
                array_push($array, $i);
            }
        }
        if(isset($array[0])){
            return $array[$funcPointer];
        }else{
            return false;
        }
    }
    public function countReplies($idNumber, $postReplies){
        $count = 0;
        for($i = 0; $i < count($postReplies); $i++){
            if($postReplies[$i]["replyToId"] === $idNumber){
                $count++;
            }
        }
        return $count;
    }

}
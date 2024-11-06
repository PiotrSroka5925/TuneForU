<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if(isset($_GET['id'])){
        $query = $db->prepare("SELECT * FROM post JOIN user USING (user_id) WHERE post_id = :post_id");
        $query->bindValue(':post_id', $_GET['id'], PDO::PARAM_INT);
        $query->execute();

        $post = $query->fetch();
    }
    else{
        header('Location: '.$protocol.$_SERVER['HTTP_HOST'].'/tuneforu/index.php'); 
    }

?>
<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    $redirectUrl = $protocol.$_SERVER['HTTP_HOST'].'/tuneforu/index.php';

    if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)){
        $query = $db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $query->bindValue(':user_id', $_GET['id'], PDO::PARAM_INT);
        $query->execute();

        $user = $query->fetch();

        if (!$user) {
            header('Location: '.$redirectUrl);
            exit;
        }
    }
    else{
        header('Location: '.$redirectUrl); 
        exit;
    }
?>
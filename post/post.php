<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if(isset($_GET['id'])){

    }
    else{
        header('Location: '.$protocol.$_SERVER['HTTP_HOST'].'/tuneforu/index.php'); 
    }

?>
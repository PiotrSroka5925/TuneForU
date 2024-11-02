<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if(!isset($_SESSION['logged_id']) && isset($_POST['title'])){
        $success = true;

        $title = $_POST['title'];
        if(strlen($title) < 3 || strlen($title) > 50){
            $success = false;
            $_SESSION['title_error'] = "Tytuł musi mieć od 3 do 50 znaków!";
        }

        $text = $_POST['text'];
        if(strlen($title) < 3 || strlen($title) > 500){
            $success = false;
            $_SESSION['text_error'] = "Treść musi mieć od 3 do 500 znaków!";
        }

        if (!empty($_FILES['upload']['name'][0])) {
            if(array_sum($_FILES['upload']['size']) / 1048576 > 10){
                $success = false;
                $_SESSION['data_error'] = "Maksymalny rozmiar plików to 10MB";
            }
        }
    }
?>


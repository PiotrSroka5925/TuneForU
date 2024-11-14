<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

if (isset($_POST['user_id'])) {
    $allValid = true;
    $user_id = $_POST['user_id'];
    
    
    $login = $_POST['login'];
    if (strlen($login) < 4 || strlen($login) > 25) {
        $allValid = false;
        $_SESSION['login_error'] = "Login musi mieć długość od 4 do 25 znaków!";
    }
    if (!ctype_alnum($login)) {
        $allValid = false;
        $_SESSION['login_error'] = "Login może składać się tylko z liter i cyfr!";
    }
   
    $l_query = $db->prepare("SELECT user_id FROM user WHERE login = :login AND user_id != :user_id");
    $l_query->bindValue(':login', $login, PDO::PARAM_STR);
    $l_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $l_query->execute();
    if ($l_query->fetch()) {
        $allValid = false;
        $_SESSION['login_error'] = "Konto z podanym loginem już istnieje!";
    }

 
    $user_name = $_POST['user_name'];
    if (strlen($user_name) < 3 || strlen($user_name) > 25) {
        $allValid = false;
        $_SESSION['user_name_error'] = "Nazwa użytkownika musi mieć od 3 do 25 znaków!";
    }


    $email = $_POST['email'];
    $snt_email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $snt_email != $email) {
        $allValid = false;
        $_SESSION['email_error'] = "Adres email jest niepoprawny!";
    }
    $e_query = $db->prepare("SELECT user_id FROM user WHERE email = :email AND user_id != :user_id");
    $e_query->bindValue(':email', $email, PDO::PARAM_STR);
    $e_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $e_query->execute();
    if ($e_query->fetch()) {
        $allValid = false;
        $_SESSION['email_error'] = "Konto z podanym adresem email już istnieje!";
    }

  
    $query = $db->prepare("SELECT profile_picture FROM user WHERE user_id = :user_id");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    $current_picture = $query->fetchColumn();
    $profile_picture = $current_picture;

  
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
        if ($_FILES['profile_picture']['size'] / 1048576 > 2) { 
            $allValid = false;
            $_SESSION['profile_picture_error'] = "Maksymalny rozmiar pliku to 2MB!";
        } else {
            $tmpFilePath = $_FILES['profile_picture']['tmp_name'];
            if ($tmpFilePath != "") {
                $fileName = $_FILES['profile_picture']['name'];
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowed_extensions = ["xbm", "tif", "pjp", "apng", "svgz", "jpg", "jpeg", "tiff", "jfif", "webp", "png", "bmp", "pjpeg", "avif"];
                
                if (in_array($extension, $allowed_extensions)) {
                    $dir = $_SERVER['DOCUMENT_ROOT'].'/tuneforu/img/profiles/';
                    if (move_uploaded_file($tmpFilePath, $dir . basename($fileName))) {
                        $profile_picture = "/img/profiles/" . $fileName;
                    }
                } else {
                    $allValid = false;
                    $_SESSION['profile_picture_error'] = "Nieprawidłowy typ pliku!";
                }
            }
        }
    }
    
    if (!$allValid) {
        $_SESSION['old_login'] = $login;
        $_SESSION['old_user_name'] = $user_name;
        $_SESSION['old_email'] = $email;
        $_SESSION['old_profile_picture'] = $profile_picture;
        header("Location: /tuneforu/user/edit-user-form.php?error=true&id=" . urlencode($user_id));
        exit();
    }
   
    $query = "UPDATE user SET login = :login, user_name = :user_name, email = :email, profile_picture = :profile_picture WHERE user_id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(":login", $login, PDO::PARAM_STR);
    $stmt->bindValue(":user_name", $user_name, PDO::PARAM_STR);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->bindValue(":profile_picture", $profile_picture, PDO::PARAM_STR);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: /tuneforu/user/edit-user-form.php?error=true&id=" . urlencode($user_id));
        exit();
    } else {
        $_SESSION['general_error'] = "Wystąpił błąd przy aktualizacji danych.";
        header("Location: /tuneforu/user/edit-user-form.phpp?error=true&id=" . urlencode($user_id));
        exit();
    }
}

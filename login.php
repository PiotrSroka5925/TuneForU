<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/tuneforu/database.php');

    if(!isset($_SESSION['logged_id'])){
        if (isset($_POST['login'])){
            $login = filter_input(INPUT_POST, 'login');
            $pass =  filter_input(INPUT_POST, 'password');
    
            //Szukanie loginu
            $query = $db->prepare("SELECT * FROM user WHERE login = :login");
            $query->bindParam(':login', $login, PDO::PARAM_STR);
            $query->execute();
            $queryResult = $query->fetch();
    
            //Szukanie emailu jeśli nie znaleziono loginu
            if (!$queryResult) {
                $query = $db->prepare("SELECT * FROM user WHERE email = :email");
                $query->bindValue(':email', $login, PDO::PARAM_STR);
                $query->execute();
                $queryResult = $query->fetch();
            }
    
            //Sprawdzanie hasła
            if ($queryResult && password_verify($pass, $queryResult['password'])) {
                $_SESSION['logged_id'] = $row['user_id'];
                $_SESSION['logged_login'] = $row['login'];
                $_SESSION['logged_username'] = $row['user_name'];
                $_SESSION['logged_email'] = $row['email'];
                unset($_SESSION['login_error']);
                header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu/index.php');
            } else {
                $_SESSION['login_error'] = "Podane dane logowania są nieprawidłowe!";
                header('Location:'. $_SERVER['HTTP_REFERER']);
            }
        }
    }
    else{
        header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu/index.php');
    }
?>


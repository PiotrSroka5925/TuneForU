<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if(isset($_POST['login']))
    {
        $success = true;

        //WALIDACJA LOGINU
        $login = $_POST['login'];
        if(strlen($login) < 4 || strlen($login) > 25){
            $success = false;
            $_SESSION['login_error'] = "Login musi mieć długość od 4 do 25 znaków!";
        }
        if(!ctype_alnum($login))
        {
            $success = false;
            $_SESSION['login_error'] = "Login może składać się tylko z liter i cyfr!";
        }
        //Sprawdzenie czy istnieje już konto z takim loginem
        $l_query = $db->prepare("SELECT user_id FROM user WHERE login = :login");
        $l_query->bindValue(':login', $login, PDO::PARAM_STR); $l_query->execute();
        $account = $l_query->fetch();
        if($account)
        {
            $success = false;
            $_SESSION['login_error'] = "Konto z podanym loginem już istnieje!";
        }

        //WALIDACJA EMAILA
        $email = $_POST['email'];
        $snt_email = filter_var($email, FILTER_SANITIZE_EMAIL); //usuwanie polskich znaków itp
        if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $snt_email != $email)
        {
            $success = false;
            $_SESSION['email_error'] = "Adres email jest niepoprawny!";
        }
        $e_query = $db->prepare("SELECT user_id FROM user WHERE email = :email");
        $e_query->bindValue(':email', $email, PDO::PARAM_STR); $e_query->execute();
        $account = $e_query->fetch();
        if($account)
        {
            $success = false;
            $_SESSION['email_error'] = "Konto z podanym adresem email już istnieje!";
        }

        //SPRAWDZANIE HASŁA
        $pass1 = $_POST['password1'];
        $pass2 = $_POST['password2'];

        if(strlen($pass1) < 8) {
            $success = false;
            $_SESSION['pass_error'] = "Hasło musi mieć przynajmiej 8 znaków!";
        }

        if($pass2 != $pass1){
            $success = false;
            $_SESSION['pass2_error'] = "Hasła nie są identyczne!";
        }

        //REJESTRACJA
        if($success){
            $query = $db->prepare("INSERT INTO user (login, user_name, password, email) VALUES (:login, :user_name, :password, :email)");
            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->bindValue(':user_name', $login, PDO::PARAM_STR);
            //Hash hasła
            $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
            $query->bindValue(':password', $pass_hash, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->execute();

            header('Location: '.$protocol.$_SERVER['HTTP_HOST'].'/gwork/index.php'); 
        }
    }
?>
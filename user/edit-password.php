<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/tuneforu/database.php');

    if(isset($_SESSION['logged_id'])){
        $success = true;
        $user_id = $_SESSION['logged_id'];
        $pass = $_POST['password'];
        $new_pass_1 = $_POST['password1'];
        $new_pass_2 = $_POST['password2'];

        $query = $db->prepare("SELECT password FROM user WHERE user_id = :user_id");
        $query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $query->execute();
        $queryResult = $query->fetch();


        if (strlen($new_pass_1) < 8) {
            $success = false;
            $_SESSION['new_pass_1_error'] = "Hasło musi mieć przynajmiej 8 znaków!";
        }

        if ($new_pass_1 != $new_pass_2) {
            $success = false;
            $_SESSION['new_pass_error'] = "Hasła różnią się!";
        }

        if (!password_verify($pass, $queryResult['password'])){
            $success = false;
            $_SESSION['pass_error'] = "Niepoprawne hasło!";
        }

        if($success){
            $pass_hash = password_hash($new_pass_1, PASSWORD_DEFAULT);
            $updateQuery = $db->prepare("UPDATE user SET password = :pass WHERE user_id = :user_id");
            $updateQuery->bindValue(':pass', $pass_hash, PDO::PARAM_STR);
            $updateQuery->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $updateQuery->execute();
            header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu/logout.php');
        }
        else{
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
    else{
        header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu/index.php');
    }
?>
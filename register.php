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

            header('Location: '.$protocol.$_SERVER['HTTP_HOST'].'/tuneforu/register.php'); 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuneForU</title>
    <link rel="stylesheet" href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/styles/styleLoginPage.css"?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-black">
    <div class="container-fluid" id="main">
        <div class="row gx-5 m-0" id="row">
            <div class="col-sm-6">
                <div class="d-flex h-100 align-items-center justify-content-center imageColumn">
                    <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white_upscaled.png"?>" class="img-fluid">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="d-flex h-100 flex-column align-items-start justify-content-center formColumn">
                    <h1 class="header">Twój Muzyczny Świat</h1> 

                    <form action="login.php" method="POST" class="loginForm pt-5">
                        <input type="text" name="login" placeholder="Login lub e-mail">
                        <input type="password" name="password" placeholder="Hasło">
                        <input type="submit" value="Zaloguj się">
                    </form>

                    <div class="pt-5">
                        <p class="text-white">Nie masz konta?</p>
                        <button type="button" class="registerButton" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Utwórz konto
                        </button>
                    </div>

                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-black">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Rejestracja</h1>
                                    <button type="button" class="ms-auto border border-0 bg-transparent text-white" data-bs-dismiss="modal" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body d-flex flex-column align-items-center justify-content-center">
                                    <form method="POST" class="loginForm">
                                        <input type="text" name="login" placeholder="Login">
                                        <input type="email" name="email" placeholder="E-mail">
                                        <input type="password" name="password1" placeholder="Hasło">
                                        <input type="password" name="password2" placeholder="Potwierdź Hasło">
                                        <input type="submit" value="Zarejestruj się">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
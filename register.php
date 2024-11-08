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

        $profile_picture = "/img/profiles/default.jpg";
        if(isset($_FILES['profile_picture'])){
            if($_FILES['profile_picture']['size'] / 1048576 > 2){
                $success = false;
                $_SESSION['profile_picture_error'] = "Maksymalny rozmiar pliku to 2MB!";
            }else{
                $tmpFilePath = $_FILES['profile_picture']['tmp_name'];
                if($tmpFilePath != ""){
                    $fileName = $_FILES['profile_picture']['name'];
                    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $extensions = array("xbm", "tif", "pjp", "apng", "svgz", "jpg", "jpeg", "tiff", "jfif", "webp", "png", "bmp", "pjpeg", "avif");
                    if (in_array($extension, $extensions)) {
                        $dir = $_SERVER['DOCUMENT_ROOT'].'/tuneforu/img/profiles/';
                        if ($success && move_uploaded_file($tmpFilePath, $dir . basename($fileName))) {
                            $profile_picture = "/img/profiles/".$fileName;
                        }
                    }
                    else{
                        $success = false;
                        $_SESSION['profile_picture_error'] = "Nieprawidłowy typ pliku!";
                    }  
                }
            }
        }

        //REJESTRACJA
        if($success){
            $query = $db->prepare("INSERT INTO user (login, user_name, password, email, profile_picture) VALUES (:login, :user_name, :password, :email, :profile_picture)");
            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->bindValue(':user_name', $login, PDO::PARAM_STR);
            //Hash hasła
            $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
            $query->bindValue(':password', $pass_hash, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':profile_picture', $profile_picture, PDO::PARAM_STR);
            $query->execute();

            header('Location: '.$protocol.$_SERVER['HTTP_HOST'].'/tuneforu/register.php'); 
            exit();
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

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

    <div class="container-fluid position-relative" id="main">
        <div id="errorDiv" class="position-absolute top-0 start-50 translate-middle-x">
            <?php 
                if(isset($_SESSION['login2_error']))
                {
                    echo '<div class="alert alert-warning d-flex align-items-center mt-3" role="alert">';
                    echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
                    echo $_SESSION['login2_error'];
                    echo '</div>';  
                    unset($_SESSION['login2_error']);
                }
                if(isset($_SESSION['pass_error']))
                {
                    echo '<div class="alert alert-warning d-flex align-items-center mt-3" role="alert">';
                    echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
                    echo $_SESSION['pass_error'];
                    echo '</div>';  
                    unset($_SESSION['pass_error']);
                }
                if(isset($_SESSION['pass2_error']))
                {
                    echo '<div class="alert alert-warning d-flex align-items-center mt-3" role="alert">';
                    echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
                    echo $_SESSION['pass2_error'];
                    echo '</div>';  
                    unset($_SESSION['pass2_error']);
                }
                if(isset($_SESSION['login_error']))
                {
                    echo '<div class="alert alert-warning d-flex align-items-center mt-3" role="alert">';
                    echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
                    echo $_SESSION['login_error'];
                    echo '</div>';  
                    unset($_SESSION['login_error']);
                }
                if(isset($_SESSION['email_error']))
                {
                    echo '<div class="alert alert-warning d-flex align-items-center mt-3" role="alert">';
                    echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
                    echo $_SESSION['email_error'];
                    echo '</div>';  
                    unset($_SESSION['email_error']);
                }
                if(isset($_SESSION['profile_picture_error']))
                {
                    echo '<div class="alert alert-warning d-flex align-items-center mt-3" role="alert">';
                    echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
                    echo $_SESSION['profile_picture_error'];
                    echo '</div>';  
                    unset($_SESSION['profile_picture_error']);
                }
            ?>
        </div>

        <div class="row gx-5 m-0" id="row">
            <div class="col-sm-12 col-md-6">
                <div class="d-flex h-100 align-items-center justify-content-center imageColumn">
                    <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white_upscaled.png"?>" class="img-fluid d-none d-md-block" id="upscaledLogo">
                    <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white.png"?>" class="img-fluid d-md-none d-sm-block">
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="d-flex h-100 flex-column align-items-start justify-content-center formColumn">
                    <h1 class="header">Twój Muzyczny<br>Świat</h1> 

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
                                    <form method="POST" class="loginForm" enctype="multipart/form-data">
                                        <input type="text" name="login" placeholder="Login">
                                        <input type="email" name="email" placeholder="E-mail">
                                        <input type="password" name="password1" placeholder="Hasło">
                                        <input type="password" name="password2" placeholder="Potwierdź Hasło">
                                        <div class="d-flex align-items-center mt-3" id="profilePictureForm">
                                            <img id="profilePicturePreview" src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/profiles/default.jpg"?>" alt="Domyślne zdjęcie profilowe" class="img-fluid rounded-circle">
                                            
                                            <div class="d-flex flex-column ms-2">                                 
                                                <label for="profile_picture" class="custom-file-upload">
                                                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                                                    Wybierz plik
                                                </label>
                                                <span id="profilePictureFileName">Nie wybrano pliku</span>
                                            </div>
                                        </div>
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

    
    <script src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/js/register-profile-picture.js"?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
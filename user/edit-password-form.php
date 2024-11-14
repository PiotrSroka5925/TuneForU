<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php'); 
    $redirectUrl = $protocol.$_SERVER['HTTP_HOST'].'/tuneforu/index.php';

    if (!isset($_SESSION['logged_id'])) {
        header('Location: ' . $redirectUrl);
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuneForU</title>
    <link rel="icon" href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/small_logo.png"?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/styles/styleLoginPage.css"?>">
</head>
<body class="bg-black text-white">
    <div class="container-fluid position-relative" id="main">
        <div id="errorDiv" class="position-absolute top-0 start-50 translate-middle-x">
            
            <?php 
                if(isset($_SESSION['new_pass_1_error']))
                {
                    echo '<div class="alert alert-warning mt-3" role="alert">';
                    echo $_SESSION['new_pass_1_error']; 
                    unset($_SESSION['new_pass_1_error']);
                    echo  '</div>';
                }                                             
            
                if(isset($_SESSION['new_pass_error']))
                {
                    echo '<div class="alert alert-warning mt-3" role="alert">';
                    echo  $_SESSION['new_pass_error'];
                    unset($_SESSION['new_pass_error']);
                    echo '</div>';
                }               
            
                if(isset($_SESSION['pass_error']))
                {
                    echo '<div class="alert alert-warning mt-3" role="alert">';
                    echo  $_SESSION['pass_error'];
                    unset($_SESSION['pass_error']);
                    echo '</div>';  
                }                                                                          
            ?>
        </div>
                       

        <div class="row gx-5 m-0" id="row">
            <div class="col-sm-12 col-md-6">
                <div class="d-flex h-100 align-items-center justify-content-center imageColumn">
                    <a href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/index.php"?>"><img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white_upscaled.png"?>" class="img-fluid d-none d-md-block" id="upscaledLogo"></a>
                    <a href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/index.php"?>" class="img-fluid d-md-none d-sm-block"><img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white.png"?>" class="img-fluid d-md-none d-sm-block"></a>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="d-flex h-100 flex-column align-items-start justify-content-center formColumn">
                    <h1 class="header">Zmień hasło<br>Użytkownika</h1> 

                    <form method="POST" action="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/user/edit-password.php"?>" class="loginForm mt-5" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_GET['id']) ?>">
                   
                        <div>
                            <label for="password" class="form-label text-light">Aktualne hasło</label>
                            <input type="password" name="password" id="password" class="form-control border-0 bg-transparent text-light" required>
                        </div>
                        <hr>
                        <div>
                            <label for="password1" class="form-label text-light">Nowe hasło</label>
                            <input type="password" name="password1" id="password1" class="form-control border-0 bg-transparent text-light" required>
                        </div>
                        <hr>
                        <div>
                            <label for="password2" class="form-label text-light">Powtórz nowe hasło</label>
                            <input type="password" name="password2" id="password2" class="form-control border-0 bg-transparent text-light" required>
                        </div>
                        <hr>
                        <div class="text-center">
                            <input type="submit" class="postSubmitButton mt-3 p-2 w-100" value="Zapisz zmiany">
                        </div>
                    </form>                                                     
                </div>
            </div>
        </div>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/js/register-profile-picture.js"?>"></script>
</body>
</html>
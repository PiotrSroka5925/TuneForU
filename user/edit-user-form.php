<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php'); 
$redirectUrl = $protocol.$_SERVER['HTTP_HOST'].'/tuneforu/index.php';


if (!isset($_SESSION['logged_id'])) {
    header('Location: ' . $redirectUrl);
    exit;
}

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {

    $query = $db->prepare("SELECT login, user_name, email, profile_picture FROM user WHERE user_id = :user_id");
    $query->bindValue(':user_id', $_GET['id'], PDO::PARAM_INT);
    $query->execute();
    $user_data = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user_data) {
        header('Location: ' . $redirectUrl);
        exit;
    }
} else {
    header('Location: ' . $redirectUrl);
    exit;
}

$query = $db->prepare("SELECT * FROM user WHERE user_id = :user_id");
$query->bindParam(':user_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$query->execute();
$user = $query->fetch();
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
                if(isset($_SESSION['general_error']))
                {
                    echo '<div class="alert alert-warning mt-3" role="alert">';
                    echo $_SESSION['general_error']; 
                    unset($_SESSION['general_error']);
                    echo  '</div>';
                }                            

                if(isset($_SESSION['login_error']))
                {
                    echo ' <div class="alert alert-warning mt-3" role="alert">';
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']);
                    echo '</div>';
                }              
            
                if(isset($_SESSION['user_name_error']))
                {
                    echo '<div class="alert alert-warning mt-3" role="alert">';
                    echo  $_SESSION['user_name_error'];
                    unset($_SESSION['user_name_error']);
                    echo '</div>';
                }               
            
                if(isset($_SESSION['email_error']))
                {
                    echo '<div class="alert alert-warning mt-3" role="alert">';
                    echo  $_SESSION['email_error'];
                    unset($_SESSION['email_error']);
                    echo '</div>';  
                }                             
            
                if(isset($_SESSION['profile_picture_error']))
                {
                    echo '<div class="alert alert-warning mt-3" role="alert">';
                    echo $_SESSION['profile_picture_error']; 
                    unset($_SESSION['profile_picture_error']);
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
                    <h1 class="header">Edytuj dane<br>Użytkownika</h1> 

                    <form method="POST" action="/tuneforu/edit-profile.php" class="loginForm" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_GET['id']) ?>">                   
                        <div class="row">
                            <label for="login" class="col-sm-4 col-form-label text-light text-start">Login</label>
                            <div class="col-sm-8 text-center">
                                <input type="text" name="login" id="login" value="<?= htmlspecialchars($user_data['login']) ?>" class="form-control border-0 bg-transparent text-light text-center">
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <label for="user_name" class="col-sm-4 col-form-label text-light text-start">Nazwa użytkownika</label>
                            <div class="col-sm-8 text-center">
                                <input type="text" name="user_name" id="user_name" value="<?= htmlspecialchars($user_data['user_name']) ?>" class="form-control border-0 bg-transparent text-light text-center">
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <label for="email" class="col-sm-4 col-form-label text-light text-start">Email</label>
                            <div class="col-sm-8 text-center">
                                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user_data['email']) ?>" class="form-control border-0 bg-transparent text-light text-center">
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <label for="profile_picture" class="col-sm-4 col-form-label text-light text-start">Zdjęcie profilowe</label>
                            <div class="text-center col-sm-8 d-flex align-items-center justify-content-center">
                                <?php if ($user_data['profile_picture']): ?>
                                    <img src="<?= $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu' . $user_data['profile_picture'] ?>" id="profilePicturePreview" alt="Zdjęcie profilowe" class="profile-picture-preview me-3" style="width: 50px; height: 50px; border-radius: 50%;">
                                <?php endif; ?>
                                <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                            </div>
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
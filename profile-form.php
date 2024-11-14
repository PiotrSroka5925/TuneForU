<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php'); 
$redirectUrl = $protocol.$_SERVER['HTTP_HOST'].'/tuneforu/index.php';

if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)){
   
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuneForU</title>
    <link rel="icon" href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/small_logo.png"?>">
    <link rel="stylesheet" href="styles/styleMainPage.css">
    <link rel="stylesheet" href="styles/fullPage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/styleNavigationPage.css">
</head>
<body class="bg-black text-white">
    <div id="fullpage"></div>
    <div class="container-lg px-0">
    <div class="row">
        <div class="col-2 col-md-3 pe-0">
            <?php 
                require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/navigation.php');
            ?>
        </div>
        <div class="col-10 col-md-6 text-center postBox d-flex align-items-center">
            
            <?php 
                if(isset($_SESSION['general_error']))
                {
                    echo '<div class="alert alert-danger mt-3" role="alert">';
                    echo $_SESSION['general_error']; 
                    unset($_SESSION['general_error']);
                    echo  '</div>';
                }                            

                if(isset($_SESSION['login_error']))
                {
                    echo ' <div class="alert alert-danger mt-3" role="alert">';
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']);
                    echo '</div>';
                }              
            
                if(isset($_SESSION['user_name_error']))
                {
                    echo '<div class="alert alert-danger mt-3" role="alert">';
                    echo  $_SESSION['user_name_error'];
                    unset($_SESSION['user_name_error']);
                    echo '</div>';
                }               
            
                if(isset($_SESSION['email_error']))
                {
                    echo '<div class="alert alert-danger mt-3" role="alert">';
                    echo  $_SESSION['email_error'];
                    unset($_SESSION['email_error']);
                    echo '</div>';  
                }                             
            
                if(isset($_SESSION['profile_picture_error']))
                {
                    echo '<div class="alert alert-danger mt-3" role="alert">';
                    echo $_SESSION['profile_picture_error']; 
                    unset($_SESSION['profile_picture_error']);
                    echo '</div>';
                }                        
            ?>

           
            <div class="edit-profile-form m-auto">
                <form method="POST" action="/tuneforu/edit-profile.php" class="d-flex flex-column" enctype="multipart/form-data">
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
                        <label for="profile_picture" id="profilePictureFileName" class="col-sm-4 col-form-label text-light text-start">Zdjęcie profilowe</label>
                        <div class="col-sm-8 text-center d-flex align-items-center justify-content-center">
                            <?php if ($user_data['profile_picture']): ?>
                                <img src="<?= $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu' . $user_data['profile_picture'] ?>" alt="Zdjęcie profilowe" class="profile-picture-preview me-3" style="width: 50px; height: 50px; border-radius: 50%;">
                            <?php endif; ?>
                            <input type="file" name="profile_picture" id="profilePicturePreview" accept="image/*" class="form-control bg-transparent text-light border-0">
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
    <?php 
        require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/create-footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/full-page-photo.js"></script>
    <script src="js/get-posts.js"></script>
    <script src="js/like-post.js"></script>
    <script src="js/preview-images.js"></script>
    <script src="js/register-profile-picture.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</body>
</html>
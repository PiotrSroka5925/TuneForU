<?php

session_start();
unset($_SESSION['logged_id']);
require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');


if(isset($_SESSION['logged_id'])){
                
    $query = $db->prepare("SELECT * FROM user WHERE user_id = :user_id");
    $query->bindParam(':user_id', $_SESSION['logged_id'], PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch();            
}
  

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="styles/styleNavigationPage.css">
<div class="sidebar bg-black" style="width: 200px;">    
    <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white_upscaled.png"?>" class="img-fluid d-none d-md-block" id="upscaledLogo">                
    <ul class="nav flex-column p-2">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-search"></i> Following
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-bell-fill"></i> Notifications
            </a> 
        </li>
        <li class="nav-item> <?php if(!isset($_SESSION['logged_id'])) echo "d-none" ?>">
            <div class="d-flex">                
                <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu ".$user['profile_picture']?>" class="img-fluid rounded-circle" width="50" height="50" alt="">
                <div class="d-flex flex-column">
                    <span><?=$user['user_name']?></span>
                    <span>@<?=$user['login']?></span>
                </div>
            </div>                       
        </li>    
        <li class="nav-item">
            <button class="btn btn-custom mt-2 ms-1 text-white <?php if(!isset($_SESSION['logged_id'])) echo "disabled"
            ?>" data-bs-toggle="modal">Post</button>
        </li>   
    </ul>   
    
</div>
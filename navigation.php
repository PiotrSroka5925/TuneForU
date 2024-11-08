<?php

session_start();
//unset($_SESSION['logged_id']);
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
<div class="sidebar bg-black">    
    <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white_upscaled.png"?>" class="img-fluid d-none d-md-block" width="200">                
    <ul class="nav flex-column p-2">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-house-door-fill"></i> Główna
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-search"></i> Przeglądaj
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-bell-fill"></i> Powiadomienia
            </a> 
        </li>
        <li class="nav-item m-0 bg-black <?php if(!isset($_SESSION['logged_id'])) echo "d-none" ?>">            
            <div class="dropdown d-flex">
                <button class="btn btn-profile text-white d-flex align-items-center border border-0 mb-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu ".$user['profile_picture']?>" class="img-fluid rounded-circle me-2" width="50" height="50" alt="">
                    <div class="d-flex flex-column text-start">
                        <span><?=$user['user_name']?></span>
                        <span>@<?=$user['login']?></span>
                    </div>
                </button>
                <ul class="dropdown-menu w-100 m-0 rounded-3 border border-white bg-black" aria-labelledby="userDropdown">                   
                    <li>
                        <a class="dropdown-item dropdown-item-bg text-light " href="profile.php">
                            Profil
                        </a>
                    </li>                                      
                                      
                    <li>
                        <a class="dropdown-item dropdown-item-bg text-light " href="logout.php">
                            Wyloguj się
                        </a>
                    </li>
                </ul>
            </div>                    
        </li>  
        <?php if(!isset($_SESSION['logged_id']))    
        echo '
        <li class="nav-item">
            <a href="register.php">
                <button class="btn btn-custom text-white ms-3 fw-bold align-items-center" data-bs-toggle="modal"><i class="bi bi-person-fill"></i> Zaloguj się</button>
            </a>
        </li>   
        ';        
        ?>  
        <li class="nav-item">
            <button class="btn mt-2 ms-3 text-white btn-custom fw-bold <?php if(!isset($_SESSION['logged_id'])) echo "d-none"?>" data-bs-toggle="modal">Post</button>
        </li>         
                
    </ul>   
    
</div>
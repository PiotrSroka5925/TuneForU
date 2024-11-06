<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="styles/styleNavigationPage.css">
<div class="sidebar bg-black" style="width: 200px;">    
    <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white_upscaled.png"?>" class="img-fluid d-none d-md-block" id="upscaledLogo">            
    <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white.png"?>" class="img-fluid d-md-none d-sm-block">
    <ul class="nav flex-column">
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
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-envelope-fill"></i> Profile
            </a>
        </li>    
        <li class="nav-item">
            <button class="btn btn-custom mt-2 ms-1 text-white">Post</button>
        </li>   
    </ul>    
</div>
<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');


    if(isset($_SESSION['logged_id'])){
                    
        $query = $db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $query->bindParam(':user_id', $_SESSION['logged_id'], PDO::PARAM_INT);
        $query->execute();
        $user = $query->fetch();            
    }
?>


<script src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/js/navigation-search-bar.js"?>"></script>

<div class="sidebar bg-black">    
    <div class="mx-auto" style="max-width: 200px;">
        <a href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/index.php"?>">
            <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white_navigation.png"?>" alt="TuneForULogo" class="img-fluid d-none d-sm-block"> 
        </a>               
    </div>    
    <div class="mx-auto" style="width:40px;">   
        <a href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/index.php"?>">
            <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/small_logo.png"?>" alt="TuneForULogo" class="img-fluid d-block d-sm-none mx-auto mb-4" width="40px" height="40px">
        </a>
    </div>

    <ul class="nav flex-column  aling-items-center">
        <li class="nav-item">
            <a class="nav-link d-flex fs-5 align-items-center" href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/index.php"?>">
                <div class="d-flex align-items-center iconDiv" style="width: 40px;">
                    <i class="bi bi-house-door-fill fs-3"></i> 
                </div>
                <span class="d-none d-md-inline">Główna</span>
            </a>
        </li>
        <li class="nav-item">
            <button class="nav-link d-flex fs-5 align-items-center w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="navSearchButton">
                <div class="d-flex align-items-center iconDiv" style="width: 40px;">
                    <i class="bi bi-search fs-3"></i> 
                </div>                
                <span class="d-none d-md-inline">Przeglądaj</span>
            </button>
            <div class="dropdown align-items-center d-flex">                
                <ul class="dropdown-menu w-100 m-0 rounded-4 bg-black" aria-labelledby="userDropdown">                   
                    <li class="w-100 h-100 m-0">                        
                        <input class="rounded-3 w-100 h-100 m-0 p-2" type="search" id="searchBarNavigation" placeholder="Search">
                    </li>                                                         
                </ul>
            </div>   
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center fs-5" href="#">
                <div class="d-flex align-items-center iconDiv" style="width: 40px;">
                    <i class="bi bi-bell-fill fs-3"></i> 
                </div>
                <span class="d-none d-md-inline">Powiadomienia</span>
            </a> 
        </li>
        <?php if(isset($_SESSION['logged_id']))
        echo '
            <li class="nav-item bg-black ">            
            <button class="btn btn-profile text-white d-flex align-items-center border border-0 mb-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="'.$protocol.$_SERVER['HTTP_HOST']."/tuneforu ".$user['profile_picture'].'" alt="ProfilePicture" class="rounded-circle me-2" width="40" height="40" alt="">
                <div class="d-none d-md-flex navWriting flex-column text-start">
                    <span class="fw-bold">'.$user['user_name'].'</span>
                    <span class="text-secondary">@'.$user['login'].'</span>
                </div>
            </button>
            <div class="dropdown align-items-center d-flex">                
                <ul class="dropdown-menu dropdown-menu-blur w-100 m-0 rounded-4" aria-labelledby="userDropdown">                   
                    <li>
                        <a class="dropdown-item dropdown-item-bg text-light" href="'.$protocol.$_SERVER['HTTP_HOST'].'/tuneforu/user/user.php?id='.$user['user_id'].'" >
                            Profil
                        </a>
                    </li>                                      
                    <li>
                        <a class="dropdown-item dropdown-item-bg text-light " href="'.$protocol.$_SERVER['HTTP_HOST'].'/tuneforu/logout.php">
                            Wyloguj się
                        </a>
                    </li>
                </ul>
            </div>                    
        </li>  
        ';
        ?>        
        <?php if(!isset($_SESSION['logged_id']))    
        echo '
        <li class="nav-item">
            <a href="'.$protocol.$_SERVER['HTTP_HOST'].'/tuneforu/register.php'.'">
                <button class="btn btn-custom text-white fw-bold align-items-center" type="button" data-bs-toggle="modal"><i class="bi bi-person-fill navIcon"></i> <span class="navWriting">Zaloguj się</span></button>
            </a>
        </li>   
        ';        
        ?>  
        <li class="nav-item">
            <button class="btn btn-custom text-white fw-bold align-items-center <?php if(!isset($_SESSION['logged_id'])) echo "d-none"?>" data-bs-toggle="modal" data-bs-target="#postModal">
                <i class="bi bi-pencil-fill navIcon"></i>
                <span class="navWriting">Post</span>
            </button>
        </li>         
        
        <div class="modal fade" id="postModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-black h-100">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Opublikuj posta</h1>
                        <button type="button" class="ms-auto border border-0 bg-transparent text-white" data-bs-dismiss="modal" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/post/add-post.php"?>" class="d-flex flex-column" enctype="multipart/form-data">      
                            <input type="text" name="title" placeholder="Tytuł" class="border border-0 outline-0 bg-transparent text-light">
                            <hr>                                                              
                            <textarea name="text" placeholder="Pisz" class="postTextArea border border-0" maxlength="500"></textarea>  
                            <hr>                                                      
                            <div id="file-names-container" class="text-light mb-3 d-flex flex-wrap"></div>
                            
                            <div class="d-flex">
                                <input type="submit" class="postSubmitButton mt-3 w-100 me-2" value="Opublikuj">
                                <div class="mt-3">                                
                                    <label for="profile_picture" class="attachment-icon" style="cursor: pointer;">
                                        <i class="bi bi-paperclip fs-3"></i>                                   
                                        <input type="file" name="upload[]" id="profile_picture" accept="image/*" multiple style="display: none;"> 
                                    </label>                                                                   
                                </div>                                                                                                                                                     
                            </div>                                                     
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </ul>   
</div>
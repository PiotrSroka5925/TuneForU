<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    $redirectUrl = $protocol.$_SERVER['HTTP_HOST'].'/tuneforu/index.php';

    if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)){
        $query = $db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $query->bindValue(':user_id', $_GET['id'], PDO::PARAM_INT);
        $query->execute();

        $user = $query->fetch();

        if (!$user) {
            header('Location: '.$redirectUrl);
            exit;
        }
    }
    else{
        header('Location: '.$redirectUrl); 
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
    <link rel="stylesheet" href="../styles/styleMainPage.css">
    <link rel="stylesheet" href="../styles/fullPage.css">
    <link rel="stylesheet" href="../styles/userPageStyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/styleNavigationPage.css"> 
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
            <div class="col-10 col-md-6 text-center userBox">
                <div class="container">
                    <div class="row userInfo">
                        <div class="col-6">
                            <div class="d-flex justify-content-start align-items-end h-100">
                                <span class="ms-2 fs-4 fw-bold text-break"><?=$user['user_name']?></span>
                                <span class="text-secondary mb-1 text-break" style="font-size: 12px;"> @<?=$user['login']?></span>
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <div class="profilePicBox d-flex justify-content-end mt-2">
                                <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu ".$user['profile_picture']?>" class="profileImage"/>
                            </div>
                        </div>
                    </div>
                        
                    <select name="order" id="orderSelect" class="form-select mt-5" style="width: 50%;">
                            <option value="date" selected>Data dodania</option>
                            <option value="popularity7Days">Popularne - 7 dni</option>
                            <option value="popularity30Days">Popularne - 30 dni</option>
                            <option value="popularity1Year">Popularne - rok</option>
                            <option value="likesAllTime">Nawięcej polubień</option>
                    </select>
                    <div id="postsContainer" class="mt-3">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 editBox">

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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../js/get-user-posts.js"></script>
    <script src="../js//like-post.js"></script>
</body>
</html>
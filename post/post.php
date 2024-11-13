<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    $redirectUrl = $protocol.$_SERVER['HTTP_HOST'].'/tuneforu/index.php';

    if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)){
        $query = $db->prepare("SELECT * FROM post JOIN user USING (user_id) WHERE post_id = :post_id");
        $query->bindValue(':post_id', $_GET['id'], PDO::PARAM_INT);
        $query->execute();

        $post = $query->fetch();

        if (!$post) {
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/styles/fullPage.css"?>">
    <link rel="stylesheet" href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/styles/styleNavigationPage.css"?>">
    <link rel="stylesheet" href="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/styles/styleMainPage.css"?>">
</head>
<body class="bg-black text-white">
    <div id="fullpage"></div>
    <div class="container-lg px-0">
        <div class="row">
            <div class="col-2 col-sm-3 pe-0">
                <?php require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/navigation.php'); ?>
            </div>
            <div class="col-10 col-sm-9 col-lg-7 border-start border-secondary">
                <div class="py-2">
                    <div class="d-flex w-100 align-items-center border-bottom border-secondary pb-2">
                        <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu".$post['profile_picture']?>" alt="profile_picture" class="rounded-circle" width="55">
                        <div class="w-100 d-flex align-items-end">
                            <span class="ms-2 fs-4 fw-bold text-break"><?=$post['user_name']?></span>
                            <span class="text-secondary mb-1 text-break" style="font-size: 12px;"> @<?=$post['login']?></span>
                            <span class="d-block ms-auto"> <?=$post['date']?></span>
                        </div>
                    </div>

                    <div>
                        <span class="fs-4 text-break"><?=$post['title']?></span>
                    </div>  

                    <div class="mt-2">
                        <span class="text-break"><?=$post['text']?></span>
                    </div>  

                    <?php 
                        $data = json_decode($post['data']);
                        if($data != null){
                            echo '<div class="postImages my-2 pe-2">';
                                echo '<div class="row g-2">';
                                    foreach ($data as $url) {
                                        echo '<div class="col-sm-12 col-md-6 col-lg-4 d-flex align-items-center">';
                                        echo '<img src="' . $protocol . $_SERVER['HTTP_HOST'] . "/tuneforu" . $url . '" alt="post_image" class="img-fluid rounded" onclick="displayFullPageImage(this)">';
                                        echo '</div>';
                                    }
                                echo '</div>';
                            echo '</div>';   
                        }                     
                    ?>
                </div>

                <div class="py-2">
                    <div class="d-flex justify-content-evenly border-top border-bottom border-secondary">
                        <div class="interactions">
                            <i class="bi bi-hand-thumbs-up"></i><span><?=$post['likes']?></span>
                        </div>
                        <div class="interactions">
                            <i class="bi bi-chat"></i><span>0</span>
                        </div>
                        <div class="interactions">
                            <?php
                                $postDate = $post['date'];

                                $postDateTime = new DateTime($postDate);
                                $now = new DateTime();

                                $interval = $now->diff($postDateTime);
                                $hoursDiff = ($interval->days * 24) + $interval->h + ($interval->i / 60) + ($interval->s / 3600);

                                if ($hoursDiff > 0) {
                                    $popularity = $post['likes'] / $hoursDiff;
                                } else {
                                    $popularity = 0; 
                                }

                                $popularity;
                                ?>
                            <i class="bi bi-bar-chart"></i><span><?=round($popularity * 10)?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-2">

            </div>
        </div>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/create-footer.php');?>
    
    <script src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/js/full-page-photo.js"?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
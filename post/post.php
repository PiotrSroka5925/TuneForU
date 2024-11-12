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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-black text-white">
    <div class="container">
        <div class="row">
            <div class="col-3">

            </div>
            <div class="col-6">
                <div class="px-3 py-2 border border-secondary">
                    <div class="d-flex w-100 align-items-center border-bottom border-secondary pb-2">
                        <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu".$post['profile_picture']?>" alt="profile_picture" class="rounded-circle" width="55">
                        <div class="w-100 d-flex align-items-center">
                            <span class="ms-2 fs-4 fw-bold text-break"><?=$post['user_name']?></span>
                            <span class="text-secondary align-self-end mb-1 text-break" style="font-size: 12px;"> @<?=$post['login']?></span>
                            <span class="d-block ms-auto"> <?=$post['date']?></span>
                        </div>
                    </div>

                    <div>
                        <span class="fs-4 text-break"><?=$post['title']?></span>
                    </div>  

                    <div class="mt-2">
                        <span class="text-break"><?=$post['text']?></span>
                    </div>  
                </div>
            </div>
            <div class="col-3">

            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
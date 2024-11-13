<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuneForU</title>
    <link rel="icon" href="img/small_logo.png">
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
            <div class="col-10 col-md-6 text-center postBox">
                <div class="d-flex  my-2">
                    <div class="input-group">
                        <input type="search" class="form-control rounded w-50" <?php  if(isset($_GET['search'])) echo 'value="'.$_GET['search'].'"' ?> placeholder="Search" aria-label="Search" aria-describedby="search-addon" id="searchBar"/>
                        <span class="input-group-text border-0 bg-transparent" id="search-addon">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                    <select name="order" id="orderSelect" class="form-select" style="width: 50%;">
                            <option value="date" selected>Data dodania</option>
                            <option value="popularity7Days">Popularne - 7 dni</option>
                            <option value="popularity30Days">Popularne - 30 dni</option>
                            <option value="popularity1Year">Popularne - rok</option>
                            <option value="likesAllTime">Nawięcej polubień</option>
                    </select>
                </div>
                <div id="postsContainer"></div>
            </div>
            <div class="col-12 col-md-3">
                <div class="container">
                    <div class="row mt-4 recommendations">
                        <h4>Who to follow</h4>
                        <div class="container">
                            <div class="row mt-4">
                                <div class="d-flex align-items-center">
                                    <img src="img/profiles/default.jpg" alt="profile-image" class="rounded-circle" width="50" height="50">
                                    <div class="container">
                                        <div class="row">
                                            <span><b>Username</b></span>
                                        </div>
                                        <div class="row">
                                            <span style="color: grey;">@login</span>
                                        </div>
                                    </div>
                                    <button class="btn border-none bg-none bg-transparent fs-5"><i class="bi bi-check-circle-fill text-white"></i></button>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="d-flex align-items-center">
                                    <img src="img/profiles/default.jpg" alt="profile-image" class="rounded-circle" width="50" height="50">
                                    <div class="container">
                                        <div class="row">
                                            <span><b>Username</b></span>
                                        </div>
                                        <div class="row">
                                            <span style="color: grey;">@login</span>
                                        </div>
                                    </div>
                                    <button class="btn border-none bg-none bg-transparent fs-5"><i class="bi bi-check-circle text-white"></i></button>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="d-flex align-items-center">
                                    <img src="img/profiles/default.jpg" alt="profile-image" class="rounded-circle" width="50" height="50">
                                    <div class="container">
                                        <div class="row">
                                            <span><b>Username</b></span>
                                        </div>
                                        <div class="row">
                                            <span style="color: grey;">@login</span>
                                        </div>
                                    </div>
                                    <button class="btn border-none bg-none bg-transparent fs-5"><i class="bi bi-check-circle text-white"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 recommendations">
                        <h4>Trendings</h4>
                        <ul class="hashtagList">
                            <li>#hashtag</li>
                            <li>#hashtag</li>
                            <li>#hashtag</li>
                            <li>#hashtag</li>
                            <li>#hashtag</li>
                        </ul>
                    </div>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</body>
</html>
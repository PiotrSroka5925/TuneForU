<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuneForU</title>
    <link rel="stylesheet" href="styles/styleMainPage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body class="bg-black">
    <div class="container d-flex">
        <div class="col-md-3 menu">
            <img src="img/logo_white.png" alt="logo">
            <div>
                <ul>
                    <a href="#"><li>home</li></a>
                    <a href="#"><li>following</li></a>
                    <a href="#"><li>notifications</li></a>
                    <a href="#"><li>profile</li></a>
                </ul>
            </div>
        </div>
        <div class="col-md-6 text-center postBox">
            <div class="container postContainer">
                <div class="row container postHeader">
                    <div class="row d-flex justify-content-between">
                        <div class="col-sm-3 text-center">
                            <img src="#" alt="profile_pic" width="60" height="60">
                        </div>
                        <div class="col-sm-6 d-flex justify-content-evenly align-items-baseline">
                            <p class="username">username</p>
                            <p class="login">@user login |</p>
                            <p class="pe-5 date">post date</p>
                        </div>
                        <div class="col-sm-3 text-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                            </svg>
                        </div>
                    </div>

                    <div class="row postTitle">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                    </div>  
                </div>

                <div class="row postContent text-start mt-4">
                    <p class="long-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                        Libero ut facilis laboriosam consectetur iste! 
                        Beatae est et placeat veniam vitae doloremque totam 
                        distinctio repellendus recusandae sapiente, assumenda, 
                        sequi nulla facere?
                    </p>
                    <script>
                        var paragraph = document.getElementsByClassName("long-text")[0];
                        var text = paragraph.innerHTML;
                        paragraph.innerHTML = "";
                        var words = text.split(" ");
                        for (i = 0; i < 70; i++) {
                            paragraph.innerHTML += words[i] + " ";
                        }
                        paragraph.innerHTML += "...";
                    </script>
                </div>

                <div class="row d-flex postImages mt-3">
                    <img src="#" alt="post_image">
                    <img src="#" alt="post_image">
                    <img src="#" alt="post_image">
                </div>

                <div class="row d-flex justify-content-between mt-3 postInteractions">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            additional content
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
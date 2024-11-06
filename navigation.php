<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="sidebar bg-black" style="width: 200px;">
    <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu/img/logo_white_upscaled.png"?>" class="img-fluid">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-search"></i> Explore
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-bell-fill"></i> Notifications
            </a> 
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-envelope-fill"></i> Messages
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-bookmark-fill"></i> Bookmarks
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-person-fill"></i> Profile
            </a>
        </li>
    </ul>
    <button class="btn btn-custom mt-4 text-white">Post</button>
</div>
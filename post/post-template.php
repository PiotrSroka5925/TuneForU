<?php
    if(!isset($post)){
        if(isset($_SERVER['HTTP_REFERER']))
            header('Location:'. $_SERVER['HTTP_REFERER']);
        else
            header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu/index.php');

        exit();
    }  
?>

<div class="postContainer">
    <div class="d-flex mt-2">
        <div style="width: 55px"> 
            <img src="<?=$protocol.$_SERVER['HTTP_HOST']."/tuneforu".$post['profile_picture']?>" alt="profile_picture" class="rounded-circle" width="55">
        </div>
        <div class="w-100 mx-2">
            <div class="postHeader">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="username"><?=$post['user_name']?></span>
                        <span class="login"> @<?=$post['login']?>|</span>
                        <span class="pe-5 date"> <?=$post['date']?></span>
                    </div>
                    <div>
                        <i class="bi bi-three-dots"></i>
                    </div>
                </div>

                <div class="postTitle text-start">
                    <?=$post['title']?>
                </div>  
            </div>

            <div class="postContent text-start mt-3 mb-2">
                <span class="long-text w-100">
                    <?php
                        $text = $post['text'];
                        $maxLength = 100;
                        if (strlen($text) > $maxLength) {
                            $text = substr($text, 0, $maxLength) . '...';
                        }
                        
                        echo $text
                    ?>
                </span>
            </div>

            <?php 
                $data = json_decode($post['data']);
                if($data != null){
                    echo '<div class="postImages my-2 pe-3" style="max-width: 550px;">';
                        echo '<div class="row g-2">';
                            $imageCount = count($data);
    
                            if ($imageCount === 1) {
                                echo '<div class="col-12 d-flex align-items-center">';
                                echo '<img src="' . $protocol . $_SERVER['HTTP_HOST'] . "/tuneforu" . $data[0] . '" alt="post_image" class="img-fluid rounded" onclick="displayFullPageImage(this)">';
                                echo '</div>';
                            } elseif ($imageCount === 2) {
                                foreach ($data as $url) {
                                    echo '<div class="col-6 d-flex align-items-center">';
                                    echo '<img src="' . $protocol . $_SERVER['HTTP_HOST'] . "/tuneforu" . $url . '" alt="post_image" class="img-fluid rounded" onclick="displayFullPageImage(this)">';
                                    echo '</div>';
                                }
                            } elseif ($imageCount === 3) {
                                echo '<div class="col-6 d-flex flex-column">';
                                echo '<img style="object-fit: cover;" src="' . $protocol . $_SERVER['HTTP_HOST'] . "/tuneforu" . $data[0] . '" alt="post_image" class="img-fluid rounded h-100 " onclick="displayFullPageImage(this)">';
                                echo '</div>';
                                
                                echo '<div class="col-6">';
                                echo '<div class="row g-2">';
                                
                                echo '<div class="col-12 d-flex align-items-center">';
                                echo '<img src="' . $protocol . $_SERVER['HTTP_HOST'] . "/tuneforu" . $data[1] . '" alt="post_image" class="img-fluid rounded" onclick="displayFullPageImage(this)">';
                                echo '</div>';
                                
                                echo '<div class="col-12 d-flex align-items-center">';
                                echo '<img src="' . $protocol . $_SERVER['HTTP_HOST'] . "/tuneforu" . $data[2] . '" alt="post_image" class="img-fluid rounded" onclick="displayFullPageImage(this)">';
                                echo '</div>';
                                
                                echo '</div>';
                                echo '</div>';
                            } elseif($imageCount > 3){
                                for($i = 0; $i < 4; $i++){
                                    echo '<div class="col-6 d-flex align-items-center">';
                                    echo '<img src="' . $protocol . $_SERVER['HTTP_HOST'] . "/tuneforu" . $data[$i] . '" alt="post_image" class="img-fluid rounded" onclick="displayFullPageImage(this)">';
                                    echo '</div>';
                                }
                            }
                        echo '</div>';
                            if($imageCount > 4){
                                echo '<p class="text-end text-secondary">+' . $imageCount-4 . ' załączniki  <i class="bi bi-paperclip"></i></p>';
                            }
                    echo '</div>';   
                }                     
            ?>

            <div class="my-3">
                <div class="d-flex justify-content-evenly">
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
                        <i class="bi bi-bar-chart"></i><span><?=round($popularity * 100, 2)?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
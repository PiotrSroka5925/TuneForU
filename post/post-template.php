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
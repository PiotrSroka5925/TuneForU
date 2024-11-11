<?php
    if(!isset($post)){
        if(isset($_SERVER['HTTP_REFERER']))
            header('Location:'. $_SERVER['HTTP_REFERER']);
        else
            header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu/index.php');

        exit();
    }  
?>

<p><?=$post['post_id']?></p>
<p><?=$post['title']?></p>
<p><?=$post['date']?></p>
<p><?php var_dump($post['data'])?></p>
<p><?=$post['likes']?></p>
<p><?=$post['user_id']?></p>
<p><?=$post['login']?></p>
<p><?=$post['user_name']?></p>
<p><?=$post['email']?></p>
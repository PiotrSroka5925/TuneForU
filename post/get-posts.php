<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if(isset($_POST['range'])){
        $range = filter_input(INPUT_POST, 'range');
        $order = filter_input(INPUT_POST, 'order');

        $range_length = 5;

        if ($range && $range > 0) {
            $limit_min = ($range - 1) * $range_length;
        } else {
            $limit_min = 0;
        }

        switch ($order){
            case "date":
                $order = "ORDER BY date DESC";
                break;
            case "likesAllTime":
                $order = "ORDER BY likes DESC";
                break;
            default:
                $order = "WHERE date >= NOW() - INTERVAL 30 DAY ORDER BY likes / TIMESTAMPDIFF(HOUR, date, NOW()) DESC";
                break;
        }

        $query = $db->prepare("SELECT * FROM post JOIN user USING (user_id) $order LIMIT {$limit_min}, {$range_length}");
        $query->execute();

        $posts = $query->fetchAll();

        if($posts !=null){
            foreach($posts as $post){
                echo "{$post['post_id']} <br>";
                echo "{$post['title']} <br>";
                echo "{$post['text']} <br>";
                echo "{$post['date']} <br>";
                var_dump($post['data']);
                echo "<br>{$post['likes']} <br>";
                echo "{$post['user_id']} <br>";
                echo "{$post['login']} <br>";
                echo "{$post['user_name']} <br>";
                echo "{$post['email']} <br>";
                echo "{$post['profile_picture']} <br><br>";
            }
        }  
    }
?>
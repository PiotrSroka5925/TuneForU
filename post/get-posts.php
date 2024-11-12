<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if(isset($_POST['range'])){
        $range = filter_input(INPUT_POST, 'range', FILTER_VALIDATE_INT);
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
                require_once("post-template.php");
            }
        }  
    }
?>
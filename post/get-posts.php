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

        $where = "";

        if(isset($_POST['search']) && !empty($_POST['search'])){
            $search = $_POST['search'];    
            $where = "WHERE title LIKE :search";
        }
        
        switch ($order){
            case "date":
                $order = "ORDER BY date DESC";
                break;
            case "likesAllTime":
                $order = "ORDER BY likes DESC";
                break;
            default:
                $where .= (empty($where) ? "WHERE" : " AND") . " date >= NOW() - INTERVAL 30 DAY";
                $order = "ORDER BY likes / TIMESTAMPDIFF(HOUR, date, NOW()) DESC";
                break;
        }

        $queryStr = "SELECT * FROM post JOIN user USING (user_id) $where $order LIMIT :limit_min, :range_length";  

        $query = $db->prepare($queryStr);
        
        if (isset($search)){
            $searchTerm = "%" . $search . "%";
            $query->bindValue(':search', $searchTerm, PDO::PARAM_STR);  
        }
        $query->bindParam(':limit_min', $limit_min, PDO::PARAM_INT);
        $query->bindParam(':range_length', $range_length, PDO::PARAM_INT);

        $query->execute();

        $posts = $query->fetchAll();
        
        if($posts !=null){  
            foreach($posts as $post){
                require_once("post-template.php");
            }
        }  
    }
?>
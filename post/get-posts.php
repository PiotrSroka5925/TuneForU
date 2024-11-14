<?php
    session_start();  
    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');
    $like_user_id = isset($_SESSION['logged_id']) ? $_SESSION['logged_id'] : null;

    if(isset($_POST['range'])){
        $range = filter_input(INPUT_POST, 'range', FILTER_VALIDATE_INT);
        $offset = filter_input(INPUT_POST, 'offset', FILTER_VALIDATE_INT);
        $order = filter_input(INPUT_POST, 'order');

        $range_length = 5;

        if ($range && $range > 0) {
            $limit_min = ($range - 1) * $range_length + $offset;
        } else {
            $limit_min = 0 + $offset;
        }

        $where = "";

        if(isset($_POST['search']) && !empty($_POST['search'])){
            $search = $_POST['search'];    
            $where = "WHERE (title LIKE :search1 OR text LIKE :search2 OR login LIKE :search3 OR user_name LIKE :search4)";
        }

        if(isset($_POST['userId']) && filter_var($_POST['userId'], FILTER_VALIDATE_INT)){
            $user_id = $_POST['userId'];
            $where .= (empty($where) ? "WHERE" : " AND") . " p.user_id = :user_id";
        }
        
        $dateFilter = "";

        switch ($order) {
            case "date":
                $order = "ORDER BY date DESC";
                break;
            case "likesAllTime":
                $order = "ORDER BY likes_count DESC";
                break;
            case "popularity1Year":
                $dateFilter = "date >= NOW() - INTERVAL 1 YEAR";
                $order = "ORDER BY likes_count / TIMESTAMPDIFF(HOUR, date, NOW()) DESC";
                break;
            case "popularity7Days":
                $dateFilter = "date >= NOW() - INTERVAL 7 DAY";
                $order = "ORDER BY likes_count / TIMESTAMPDIFF(MINUTE, date, NOW()) DESC";
                break;
            default:
                $dateFilter = "date >= NOW() - INTERVAL 30 DAY";
                $order = "ORDER BY likes_count / TIMESTAMPDIFF(MINUTE, date, NOW()) DESC";
                break;
        }

        if (!empty($dateFilter)) {
            $where .= (empty($where) ? "WHERE" : " AND") . " " . $dateFilter;
        }
        
        $queryStr = "SELECT p.*, u.*, (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.post_id) AS likes_count FROM post p JOIN user u ON u.user_id = p.user_id $where $order LIMIT :limit_min, :range_length";
        $query = $db->prepare($queryStr);
        
        if (isset($search)){
            $searchTerm = "%" . $search . "%";
            $query->bindValue(':search1', $searchTerm, PDO::PARAM_STR);  
            $query->bindValue(':search2', $searchTerm, PDO::PARAM_STR);
            $query->bindValue(':search3', $searchTerm, PDO::PARAM_STR);
            $query->bindValue(':search4', $searchTerm, PDO::PARAM_STR);
        }

        if(isset($user_id)){
            $query->bindValue(':user_id', $user_id, PDO::PARAM_STR);  
        }

        $query->bindParam(':limit_min', $limit_min, PDO::PARAM_INT);
        $query->bindParam(':range_length', $range_length, PDO::PARAM_INT);

        $query->execute();

        $posts = $query->fetchAll();
        
        $response = [
            'rangeLength' => $range_length,
            'count' => count($posts),
            'content' => ''
        ];
        
        if ($posts != null) {
            ob_start();
            foreach ($posts as $post) {
                require("post-template.php");
            }
            $response['content'] = ob_get_clean();
        }
        
        echo json_encode($response);
    }
?>
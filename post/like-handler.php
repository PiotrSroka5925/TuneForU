<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if (!isset($_SESSION['logged_id'])) {
        echo json_encode(['success' => false, 'message' => 'Musisz być zalogowany, aby polubić post']);
        exit();
    }

    $user_id = $_SESSION['logged_id'];
    $data = json_decode(file_get_contents("php://input"), true);
    $post_id = $data['post_id'];
    $liked = false;

    $query = "SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        $query = "DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $liked = false;
    } else {
        $query = "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $liked = true;
    }

    $query = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = :post_id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $like_count = $stmt->fetchColumn();

    echo json_encode(['success' => true, 'like_count' => $like_count, 'liked' => $liked]);
?>
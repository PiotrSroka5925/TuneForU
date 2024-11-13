<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if (!isset($_SESSION['logged_id'])) {
        echo json_encode(['success' => false, 'message' => 'Musisz być zalogowany, aby polubić post']);
        exit();
    }
?>
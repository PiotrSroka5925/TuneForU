<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/tuneforu/database.php');
    session_unset();
    header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu/index.php');
?>
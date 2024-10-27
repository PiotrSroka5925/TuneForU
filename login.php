<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/tuneforu/database.php');

    if (isset($_POST['login'])){
        $login = filter_input(INPUT_POST, 'login');
        $pass =  filter_input(INPUT_POST, 'password');

        //Szukanie loginu
        $query = $db->prepare("SELECT * FROM user WHERE login = :login");
        $query->bindParam(':login', $login, PDO::PARAM_STR);
        $query->execute();
        $queryResult = $query->fetch();

        //Szukanie emailu jeśli nie znaleziono loginu
        if (!$queryResult) {
            $query = $db->prepare("SELECT * FROM user WHERE email = :email");
            $query->bindValue(':email', $login, PDO::PARAM_STR);
            $query->execute();
            $queryResult = $query->fetch();
        }
    }
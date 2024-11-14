<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if(isset($_SESSION['logged_id']) && isset($_POST['title'])){
        $success = true;

        $title = $_POST['title'];
        if(strlen($title) < 3 || strlen($title) > 50){
            $success = false;
            $_SESSION['title_error'] = "Tytuł musi mieć od 3 do 50 znaków!";
        }

        $text = $_POST['text'];
        if(strlen($text) < 3 || strlen($text) > 500){
            $success = false;
            $_SESSION['text_error'] = "Treść musi mieć od 3 do 500 znaków!";
        }

        $data = array();
        if (!empty($_FILES['upload']['name'][0])) {
            if(array_sum($_FILES['upload']['size']) / 1048576 > 10){
                $success = false;
                $_SESSION['data_error'] = "Maksymalny rozmiar załączników to 10MB!";
            }
            else{
                $dir = $_SERVER['DOCUMENT_ROOT'].'/tuneforu/data/';
                $files_count = count($_FILES['upload']['name']);
                $extensions = array("xbm", "tif", "pjp", "apng", "svgz", "jpg", "jpeg", "tiff", "gif", "svg", "jfif", "webp", "png", "bmp", "pjpeg", "avif");
                
                for ($i = 0; $i < $files_count; $i++) {
                    $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
                    if ($tmpFilePath != "") {
                        $fileName = $_FILES['upload']['name'][$i];
                        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        
                        if (in_array($extension, $extensions)) {
                            if ($success && move_uploaded_file($tmpFilePath, $dir . basename($fileName))) {
                                array_push($data, "/data/".$fileName);
                            }
                        }
                        else{
                            $success = false;
                            $_SESSION['data_error'] = "Nieprawidłowy typ pliku!";
                        }           
                    }
                }
            }
        }

        if ($success) {          
            $date = new DateTime("now", new DateTimeZone("Europe/Warsaw"));
            $formattedDate = $date->format("Y-m-d H:i");
        
            $query = $db->prepare("INSERT INTO post(title, text, date, data, user_id) VALUES (:title, :text, :date, :data, :user_id)");
            $query->execute(array(
                ':title' => $title,
                ':text' => $text,
                ':date' => $formattedDate,
                ':data' => json_encode($data),
                ':user_id' => $_SESSION['logged_id']
            ));
        
            header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/tuneforu/index.php'); 
        }
    }
?>
<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/tuneforu/database.php');

    if(isset($_POST['range'])){
        $range = filter_input(INPUT_POST, 'range');

        $range_length = 5;

        if ($range && $range > 0) {
            $limit_min = ($range - 1) * $range_length;
        } else {
            $limit_min = 0;
        }
    }
?>
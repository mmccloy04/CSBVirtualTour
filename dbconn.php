<?php
    $host = "mmccloy04.webhosting5.eeecs.qub.ac.uk";
    $user = "mmccloy04";
    $pw = "jS94K3CBpcFP9402";
    $db = "mmccloy04";

    $conn = new mysqli($host, $user, $pw, $db);


    if ($conn->connect_error) {
        exit($conn->connect_error);
    } 
?>
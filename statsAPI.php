<?php
header("Content-Type: application/json");
$httpMethod = $_SERVER['REQUEST_METHOD'];


//PATCH request to update stats for page visits
if (($httpMethod === 'PATCH') && (isset($_GET['updatestats']))) { 

    include "dbconn.php";

    parse_str(file_get_contents('php://input'), $_DATA);

    $stats_ref = $_DATA['stats_ref'];
    $date_time = $_DATA['date_time'];

    $updateSQL = "UPDATE website_stats 
    SET count = count + 1, last_updated='$date_time'
    WHERE stats_ref='$stats_ref' ";

    $result = $conn->query($updateSQL);

    if (!$result) {
        http_response_code(400);
        exit($conn->error);
    } else {
        http_response_code(200);
    }
}


?>
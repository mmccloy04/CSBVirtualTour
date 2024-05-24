<?php
header("Content-Type: application/json");
$httpMethod = $_SERVER['REQUEST_METHOD'];

//GET request to bring back information for given location
//used to bring back floor level for given location (used in foyers to know which floor to enter lift on)
if (($httpMethod === 'GET') && (isset($_GET['location_code']))) { 

    include "dbconn.php";
    $location_code = $_GET['location_code'];

    $checkSQL = 
    "SELECT location_groups.group_id, location_groups.group_name
    FROM locations
    LEFT JOIN location_groups ON locations.group_id = location_groups.group_id
    WHERE location_code = '$location_code'";
    
    $result = $conn->query($checkSQL);

    if (!$result) {
        exit($conn->error);
    }

    $api_response = array();

    while ($row = $result->fetch_assoc()) {
        array_push($api_response, $row);
    }

    $response = json_encode($api_response);

    if ($response != false) {
        http_response_code(200);
        echo $response;
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Unable to process response!"]);
    }
}

?>
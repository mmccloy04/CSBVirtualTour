<?php
header("Content-Type: application/json");
$httpMethod = $_SERVER['REQUEST_METHOD'];


//GET request to lookup login details (for given user id)
if (($httpMethod === 'GET') && (isset($_GET['user_id']))) { 

    include "dbconn.php";

    $user_id = $_GET['user_id'];

    $checkSQL = 
    "SELECT * FROM users
    LEFT JOIN user_type ON users.type_id = user_type.type_id 
    WHERE (user_id = '$user_id')";
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
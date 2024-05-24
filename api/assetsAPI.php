<?php
header("Content-Type: application/json");
$httpMethod = $_SERVER['REQUEST_METHOD'];

//GET request to bring back asset information for given location
if (($httpMethod === 'GET') && (isset($_GET['location_code']))) { 

    include "dbconn.php";
    $location_code = $_GET['location_code'];
    
    $checkSQL = 
    "SELECT location_code, entity_ref, file_path, 
    CONCAT(rotation_x, ' ', rotation_y, ' ', rotation_z) as rotation,
    CONCAT(position_x, ' ', position_y, ' ', position_z) as position,
    entity_text
    FROM locations_assets
    LEFT JOIN assets ON locations_assets.asset_id = assets.asset_id 
    LEFT JOIN locations ON locations_assets.location_id = locations.location_id
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
};

//GET request to bring back asset information for given entity ref
if (($httpMethod === 'GET') && (isset($_GET['entity_ref']))) { 

    include "dbconn.php";
    $entity_ref = $_GET['entity_ref'];

    $checkSQL = 
    "SELECT location_code, entity_ref, concat(location_code, '_', entity_ref) as ref, file_path, 
    CONCAT(rotation_x, ' ', rotation_y, ' ', rotation_z) as rotation,
    CONCAT(position_x, ' ', position_y, ' ', position_z) as position,
    entity_text
    FROM locations_assets
    LEFT JOIN assets ON locations_assets.asset_id = assets.asset_id 
    LEFT JOIN locations ON locations_assets.location_id = locations.location_id
    WHERE entity_ref = '$entity_ref' 
    ";
    
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
};

?>
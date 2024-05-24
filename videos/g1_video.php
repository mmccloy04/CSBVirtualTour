<!-- VIDEO PAGE LINKED TO FROM G1.PHP, USER DIRECTED BACK TO G1.PHP ONCE VIDEO FINISHES -->

<!--PHP TO GET ASSETS FROM DATABASE-->
<?php
session_start();

//extract the location code from the page name 
$current_page = $_SERVER["SCRIPT_NAME"];
$without_file_extension = strtok($current_page, '.');
$folder_name_length = strlen(strtok($without_file_extension, '/'));
$location_code = substr($without_file_extension, $folder_name_length+2); //2 for the slash before and after

$location_code = "g1";

//GET request to bring back asset information from database
$endpoint = "https://mmccloy04.webhosting5.eeecs.qub.ac.uk/api/assetsAPI.php?location_code=$location_code";
$resource = file_get_contents($endpoint);
$data = json_decode($resource, true);  

//no returned results
if ((sizeof($data) === 0)) {
    echo " <div class='uk-text-muted'>Error</div>";
    $password = "Error";
 } else {
    //var_dump($data);
    foreach ($data as $row) {
    //ASSIGNING ENTITY INFO TO DYNAMIC VARIABLES
    //Adapted/sourced from https://www.php.net/manual/en/language.variables.variable.php
    //ASSET FILEPATH
    $url = $row["entity_ref"]."_asset";               //setting variable name for dynamic variable e.g. entity1_src, entity2_src
    $$url = $row["file_path"];                      //asigning value to variable from current row of array
    $_POST[$$url] = $row["file_path"];   
    //POSITION
    $pos = $row["entity_ref"]."_position";          //setting variable name for dyanmic variable e.g. entity1_position, entity2_position
    $$pos = $row["position"];                       //asigning value to variable from current row of array
    $_POST[$$pos] = $row["position"];  
    //ROTATION
    $rot = $row["entity_ref"]."_rotation";           //setting variable name for dyanmic variable e.g. entity1_rotation, entity2_rotation
    $$rot = $row["rotation"];                       //asigning value to variable from current row of array
    $_POST[$$rot] = $row["rotation"];  
    //TEXT
    $rot = $row["entity_ref"]."_text";           //setting variable name for dyanmic variable e.g. entity1_text, entity2_text
    $$rot = $row["entity_text"];                       //asigning value to variable from current row of array
    $_POST[$$rot] = $row["entity_text"];   
    }
  }          
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/qublogo.png" /> <!--Queens logo sourced from https://www.stickpng.com/img/icons-logos-emojis/russell-group-universities/queens-university-belfast-logo -->
    <title>EEECS VR Tour</title>
    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>
  </head>

  <body>
    <a-scene>

      <!--ASSETS-->
      <a-assets>
        <video id="linked_video" crossorigin="anonymous"
          src="<?php echo "$linked_video_asset" ?>"
          autoplay="true" loop="false" onloadstart="this.playbackRate = 3;" onended="videoEnded()">
        </video>
      </a-assets>
 
      <!--CAMERA AND CONTROLS-->
      <a-entity>
        <a-camera position="1 1 0" id="myCamera" zoom="0.8"
          cursor="rayOrigin: mouse" 
          wasd-controls-enabled="false"
          raycaster="objects: a-plane, a-box, a-sphere, a-image, a-entity">
        </a-camera>
      </a-entity>
    
      <!--VIDEOSPHERE-->
      <a-videosphere id="videosphere" 
        src="#linked_video"
        rotation="<?php echo "$linked_video_rotation"?>">
      </a-videosphere>
      
    </a-scene> 
    
    <!--SCRIPT TO REDIRECT TO DESIRED LOCATION PAGE ONCE VIDEO ENDED-->      
    <script>    
      function videoEnded() {
        location.href="../locations/g1.php";
       }
    </script>    
    
  </body>   
  
</html>

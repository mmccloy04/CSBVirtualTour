<!-- VARIATION OF L0.PHP - SHOWING HOW VIDEOS CAN BE EMBEDDED WITHIN THE PAGE
THIS OPTION HAS SIX DIFFERENT VIDEOSPHERES FOR THE SIX DIFFERENT VIDEOS-->

<!--PHP TO GET ASSETS FROM DATABASE-->
<?php
session_start();

//extract the location code from the page name 
$current_page = $_SERVER["SCRIPT_NAME"];
$without_file_extension = strtok($current_page, '.');
$folder_name_length = strlen(strtok($without_file_extension, '/'));
$location_code = substr($without_file_extension, $folder_name_length+2); //2 for the slash before and after

$location_code = "l0"; //hardcoded as page was renamed when taken out of main tour
$_SESSION['lift_level'] = "g"; //hardcoded lift level to ground floor. in the tour this done in the locations that connect to the lift (e.g. g3.php), however as this page has been taken out of the main tour this value has been hardcoded. 

//GET request to bring back asset information from database
$endpoint = "https://mmccloy04.webhosting5.eeecs.qub.ac.uk/api/assetsAPI.php?location_code=$location_code";
$resource = file_get_contents($endpoint);
$data = json_decode($resource, true);  

if ((sizeof($data) === 0)) {
    echo " <div class='uk-text-muted'>Error</div>";
 } else {
    foreach ($data as $row) {
    //ASSIGNING ENTITY INFO TO DYNAMIC VARIABLES
    //Adapted/sourced from https://www.php.net/manual/en/language.variables.variable.php#:~:text=%24a%20%3D%20'hello'%3B,by%20using%20two%20dollar%20signs.
    //ASSET FILEPATH
    $url = $row["entity_ref"]."_asset";             //setting variable name for dynamic variable e.g. entity1_asset, entity2_asset
    $$url = $row["file_path"];                      //asigning value to variable from current row of array
    $_POST[$$url] = $row["file_path"];   
    //POSITION
    $pos = $row["entity_ref"]."_position";          //setting variable name for dynamic variable e.g. entity1_position, entity2_position
    $$pos = $row["position"];                       //asigning value to variable from current row of array
    $_POST[$$pos] = $row["position"];  
    //ROTATION
    $rot = $row["entity_ref"]."_rotation";           
    $$rot = $row["rotation"];                       
    $_POST[$$rot] = $row["rotation"];  
    //TEXT
    $rot = $row["entity_ref"]."_text";           
    $$rot = $row["entity_text"];                       
    $_POST[$$rot] = $row["entity_text"];      
    }

    //ASSIGNING VIDEOS
    $_POST["video_1_asset"] = $l1_linked_video_groundtosecond_asset;
    $_POST["video_1_rotation"] = $l1_linked_video_groundtosecond_rotation;
    $_POST["video_2_asset"] = $l1_linked_video_groundtofirst_asset;
    $_POST["video_2_rotation"] = $l1_linked_video_groundtofirst_rotation;
    $_POST["video_3_asset"] = $l4_linked_video_firsttoground_asset;
    $_POST["video_3_rotation"] = $l4_linked_video_firsttoground_rotation;
    $_POST["video_4_asset"] = $l4_linked_video_firsttosecond_asset;
    $_POST["video_4_rotation"] = $l4_linked_video_firsttosecond_rotation;
    $_POST["video_5_asset"] = $l7_linked_video_secondtoground_asset;
    $_POST["video_5_rotation"] = $l7_linked_video_secondtoground_rotation;
    $_POST["video_6_asset"] = $l7_linked_video_secondtofirst_asset;
    $_POST["video_6_rotation"] = $l7_linked_video_secondtofirst_rotation;

    //ASSIGNING INITIAL SKY/ASSETS BASED ON CURRENT FLOOR LEVEL
    switch ($_SESSION['lift_level']) {
      case "g":
        $_POST["sky_asset"] = $sky_g_asset;
        $_POST["sky_rotation"] = $sky_g_rotation;
        $_POST["link_asset"] = $link_g_asset;
        $_POST["link_position"] = $link_g_position;
        $_POST["link_text"] = $link_g_text;
        break;
      case "1":
        $_POST["sky_asset"] = $sky_1_asset;
        $_POST["sky_rotation"] = $sky_1_rotation;
        $_POST["link_asset"] = $link_1_asset;
        $_POST["link_position"] = $link_1_position;
        $_POST["link_text"] = $link_1_text;
        break;
      case "2":
        $_POST["sky_asset"] = $sky_2_asset;
        $_POST["sky_rotation"] = $sky_2_rotation;
        $_POST["link_asset"] = $link_2_asset;
        $_POST["link_position"] = $link_2_position;
        $_POST["link_text"] = $link_2_text;
        break;
    }
  }          
?>

<!--PASSING DATABASE VALUES TO JAVASCRIPT
Sourced/adapted from https://stackoverflow.com/questions/4287357/access-php-variable-in-javascript -->
<script type="text/javascript">
  var lift_level = <?php echo json_encode($_SESSION['lift_level']); ?>;
  console.log(lift_level);

  var sky_g_asset = <?php echo json_encode("$sky_g_asset"); ?>;
  var sky_g_rotation = <?php echo json_encode("$sky_g_rotation"); ?>;
  var link_g_asset = <?php echo json_encode("$link_g_asset"); ?>;
  var link_g_position = <?php echo json_encode("$link_g_position"); ?>;
  var link_g_text = <?php echo json_encode("$link_g_text"); ?>;
  
  var sky_1_asset = <?php echo json_encode("$sky_1_asset"); ?>;
  var sky_1_rotation = <?php echo json_encode("$sky_1_rotation"); ?>;
  var link_1_asset = <?php echo json_encode("$link_1_asset"); ?>;
  var link_1_position = <?php echo json_encode("$link_1_position"); ?>;
  var link_1_text = <?php echo json_encode("$link_1_text"); ?>;
  
  var sky_2_asset = <?php echo json_encode("$sky_2_asset"); ?>;
  var sky_2_rotation = <?php echo json_encode("$sky_2_rotation"); ?>;
  var link_2_asset = <?php echo json_encode("$link_2_asset"); ?>;
  var link_2_position = <?php echo json_encode("$link_2_position"); ?>;
  var link_2_text = <?php echo json_encode("$link_2_text"); ?>;
  
  
</script>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/qublogo.png" /> <!--Queens logo sourced from https://www.stickpng.com/img/icons-logos-emojis/russell-group-universities/queens-university-belfast-logo -->
    <title>EEECS VR Tour</title>
    <link rel="stylesheet" href="../css/style.css" />
    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>
   
    <script src="https://cdn.jsdelivr.net/gh/donmccurdy/aframe-extras@v6.1.1/dist/aframe-extras.misc.min.js"></script> <!-- script for hand controls and animation sourced from https://www.youtube.com/watch?v=vQ85u3dzmZY and https://github.com/c-frame/aframe-super-hands-component-->
    <script src="https://unpkg.com/super-hands@^3.0.3/dist/super-hands.min.js"></script> <!-- script for superhands sourced from https://github.com/c-frame/aframe-super-hands-component-->
    <script src="https://unpkg.com/aframe-event-set-component@5.x.x/dist/aframe-event-set-component.min.js"></script> <!-- script for event set component sourced from https://aframe.io/docs/1.5.0/guides/building-a-360-image-gallery.html -->
    
    <!-- CUSTOM COMPONENT
    Registering a custom component to have one entity face another entity (used to make objects face the user)
    Sourced from https://stackoverflow.com/questions/66508949/a-frame-make-model-face-the-viewer-center-of-the-screen-or-canvas -->
    <script>
      AFRAME.registerComponent("look-at", {
        schema: { type: "selector" },
        init: function () {},
        tick: function () {
          this.el.object3D.lookAt(this.data.object3D.position);
        },
      });
    </script>
    
    <!--CONTROLLER COMPONENT
    Used to support all the controller components, while providing the hand and overriding the model.
    Sourced from aframe.io/docs/1.5.0/introduction/interactions-and-controllers.html#creating-custom-controllers -->
    <script>
      AFRAME.registerComponent("custom-controls", {
        schema: {
          hand: { default: "" },
          model: { default: "customControllerModel.gltf" },
        },
        update: function () {
          var hand = this.data.hand;
          var el = this.el;
          var controlConfiguration = {
            hand: hand,
            model: false,
            orientationOffset: { x: 0, y: 0, z: hand === "left" ? 90 : -90 },
          };
          // Build on top of controller components.
          el.setAttribute("vive-controls", controlConfiguration);
          el.setAttribute("oculus-touch-controls", controlConfiguration);
          el.setAttribute("windows-motion-controls", controlConfiguration);
          // Set a model.
          el.setAttribute("gltf-model", this.data.model);
        },
      });
    </script>


    <!-- COMPONENT TO ONLY SHOW VR BUTTON IF HEADSET CONNECTED (IE HIDE ON LAPTOP/MOBILE DEVICES)
    Sourced/adapted from https://stackoverflow.com/questions/73669445/how-to-hide-vr-button-unless-vr-headset-is-present-on-a-frame-scene 
    If using A-frame 1.5.0 update from vr-mode-ui to xr-mode-ui , with this also allowing you to specify which buttons to show ie AR/VR both
    Add in this.el.setAttribute('xr-mode-ui', 'XRMode', 'vr'); to hide AR button  https://aframe.io/docs/1.5.0/components/xr-mode-ui.html?#properties_xrmode-->
    <script>
      AFRAME.registerComponent('vr-mode-ui-if-headset', {
        dependencies: ['vr-mode-ui'],
        init: function () {
          //if headset not connected then dont display any vr/ar/fullscreen button 
          if (!AFRAME.utils.device.checkHeadsetConnected()) {
            this.el.setAttribute('vr-mode-ui', 'enabled', false);
            console.log('no VR headset');
          //if headset is connected, display VR button only (not AR)
          } else {
            this.el.setAttribute('vr-mode-ui', 'enabled', true);
            console.log('VR headset connected');
          }
        }
      })
    </script> 
  </head>
  
  <body>
    <!--scene linked to component to check if VR headset is connected, VR button will be displayed if so-->
    <a-scene vr-mode-ui-if-headset>

     <!--ASSETS-->
     <a-assets>
        <video id="video1" crossorigin="anonymous"
          src="<?php echo $_POST["video_1_asset"] ?>"
          autoplay="true" loop="false" onloadstart="this.playbackRate = 9;" onended="videoEnded()">
        </video>
        <video id="video2" crossorigin="anonymous"
          src="<?php echo $_POST["video_2_asset"] ?>"
          autoplay="true" loop="false" onloadstart="this.playbackRate = 9;" onended="videoEnded()">
        </video>     
        <video id="video3" crossorigin="anonymous"
          src="<?php echo $_POST["video_3_asset"] ?>"
          autoplay="true" loop="false" onloadstart="this.playbackRate = 9;" onended="videoEnded()">
        </video>
        <video id="video4" crossorigin="anonymous"
          src="<?php echo $_POST["video_4_asset"] ?>"
          autoplay="true" loop="false" onloadstart="this.playbackRate = 9;" onended="videoEnded()">
        </video>
        <video id="video5" crossorigin="anonymous"
          src="<?php echo $_POST["video_5_asset"] ?>"
          autoplay="true" loop="false" onloadstart="this.playbackRate = 9;" onended="videoEnded()">
        </video>
        <video id="video6" crossorigin="anonymous"
          src="<?php echo $_POST["video_6_asset"] ?>"
          autoplay="true" loop="false" onloadstart="this.playbackRate = 9;" onended="videoEnded()">
        </video>  
      </a-assets>
    
       <!--CAMERA AND CONTROLS
        Right hand implements hand controls with superhands, adapted/sourced from https://github.com/c-frame/aframe-super-hands-component 
        Left hand (controller) has laser/raycaster, adapted/sourced from https://aframe.io/docs/1.5.0/components/oculus-touch-controls.html 
        and https://aframe.io/docs/1.5.0/components/laser-controls.html -->
      <a-entity>
        <a-camera position="1 1 0" id="myCamera" 
          cursor="rayOrigin: mouse" 
          wasd-controls-enabled="false"
          raycaster="objects: a-plane, a-box, a-sphere, a-image, a-entity">
        </a-camera>
        <a-entity sphere-collider="objects: a-plane, a-box, a-sphere" super-hands hand-controls="hand: right"></a-entity>  
        <a-entity 
          oculus-touch-controls="hand: left" laser-controls="hand: left" 
          raycaster="objects: a-plane, a-box, a-sphere, a-image, a-entity"
          thumbstick-logging></a-entity> 
      </a-entity>

      <!--BACKGROUND-->
      <a-sky id="sky" 
        src="<?php echo $_POST["sky_asset"] ?>" 
        rotation="<?php echo $_POST["sky_rotation"] ?>" >
      </a-sky>  

      <!--SPHERE LINKING TO FOYER -->
      <a-sphere id="foyer" radius="1" 
        src="<?php echo $_POST["link_asset"] ?>" 
        position="<?php echo $_POST["link_position"] ?>"
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text id="sphereText" font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="<?php echo $_POST["link_text"]  ?>" position="0 -1.4 0" ></a-text>
      </a-sphere>
      
      <!--LIFT BUTTONS-->
      <a-entity id="buttons">
        <a-plane id="secondfloor" position="-4 -0.2 -1.5" rotation="0 75 0" color="#8C8C8C" 
            event-set__enter="_event: mouseenter; color: #A6A6A6"
            event-set__leave="_event: mouseleave; color: #8C8C8C">
            <a-text font="kelsonsans" value="2" width="10" position="0 0 0" align="center" color="#FFFFFF"></a-text>
        </a-plane>
        <a-plane id="firstfloor" position="-4 -1.3 -1.5" rotation="0 75 0" color="#8C8C8C"
            event-set__enter="_event: mouseenter; color: #A6A6A6"
            event-set__leave="_event: mouseleave; color: #8C8C8C">
            <a-text font="kelsonsans" value="1" width="10" position="0 0 0" align="center" color="#FFFFFF"></a-text>
        </a-plane>
        <a-plane id="groundfloor" position="-4 -2.4 -1.5" rotation="0 75 0" color="#8C8C8C"
            event-set__enter="_event: mouseenter; color: #A6A6A6"
            event-set__leave="_event: mouseleave; color: #8C8C8C">
            <a-text font="kelsonsans" value="G" width="10" position="0 0 0" align="center" color="#FFFFFF"></a-text>
        </a-plane>
      </a-entity>

      <!--VIDEOSPHERES-->           
      <a-videosphere id="videosphere1" 
        src="#video1" 
        rotation="<?php echo $_POST["video_1_rotation"]?>"
        visible="false">
      </a-videosphere>

      <a-videosphere id="videosphere2" 
        src="#video2" 
        rotation="<?php echo $_POST["video_2_rotation"]?>"
        visible="false">
      </a-videosphere>

      <a-videosphere id="videosphere3" 
        src="#video3" 
        rotation="<?php echo $_POST["video_3_rotation"]?>"
        visible="false">
      </a-videosphere>

      <a-videosphere id="videosphere4" 
        src="#video4" 
        rotation="<?php echo $_POST["video_4_rotation"]?>"
        visible="false">
      </a-videosphere>

      <a-videosphere id="videosphere5" 
        src="#video5" 
        rotation="<?php echo $_POST["video_5_rotation"]?>"
        visible="false">
      </a-videosphere>

      <a-videosphere id="videosphere6" 
        src="#video6" 
        rotation="<?php echo $_POST["video_6_rotation"]?>"
        visible="false">
      </a-videosphere>

    </a-scene>
  </body>


  <script> 

    //USER ENTERS VR MODE
    //enter-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('enter-vr', function () {
      localStorage.setItem("vrMode",true);
      console.log("entered vr mode");
    });

    
    //USER EXITS VR MODE
    //exit-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('exit-vr', function () {
      localStorage.setItem("vrMode",false);
      console.log("exited vr mode");
    });

  
    //NAVIGATE TO OTHER PAGES (LOCATIONS)
    document
      .querySelector("#foyer")
      .addEventListener("click", e => {
        if (lift_level == "g") {
          //location.href = "../locations/g5.php"     //link disabled to separate page from main tour
        } else if (lift_level == "1") {
          //location.href = "../locations/f3.php"       //link disabled to separate page from main tour
        } else if (lift_level == "2") {
          //location.href = "../locations/s3.php"       //link disabled to separate page from main tour
        }
        ;
    });


    //CLICKED THE BUTTON TO GO TO THE GROUND FLOOR
    document
    .querySelector("#groundfloor")
      .addEventListener("click", e => {
          //first floor to ground
          if (lift_level == "1") {
            document.querySelector('#sky').setAttribute('visible', 'false')
            document.querySelector('#foyer').setAttribute('visible', 'false')
            document.querySelector('#buttons').setAttribute('visible', 'false')
            document.querySelector('#videosphere3').setAttribute('visible', 'true') 
            lift_level = "g"; //update lift level to be g
            let video = document.querySelector("#video3");
            video.play();
          //second floor to ground
          } else if (lift_level == "2") {
            document.querySelector('#sky').setAttribute('visible', 'false')
            document.querySelector('#foyer').setAttribute('visible', 'false')
            document.querySelector('#buttons').setAttribute('visible', 'false')
            document.querySelector('#videosphere5').setAttribute('visible', 'true') 
            lift_level = "g"; //update lift level to be g
            let video = document.querySelector("#video5");
            video.play();
          };  
    });

    //CLICKED THE BUTTON TO GO TO THE FIRST FLOOR
    document
    .querySelector("#firstfloor")
      .addEventListener("click", e => {
          //ground floor to first  
          if (lift_level == "g") {
            document.querySelector('#sky').setAttribute('visible', 'false')
            document.querySelector('#foyer').setAttribute('visible', 'false')
            document.querySelector('#buttons').setAttribute('visible', 'false')
            document.querySelector('#videosphere2').setAttribute('visible', 'true') 
            lift_level = "1"; //update lift level to be 1
            let video = document.querySelector("#video2");
            video.play();
          //second floor to first
          } else if (lift_level == "2") {
            document.querySelector('#sky').setAttribute('visible', 'false')
            document.querySelector('#foyer').setAttribute('visible', 'false')
            document.querySelector('#buttons').setAttribute('visible', 'false')
            document.querySelector('#videosphere6').setAttribute('visible', 'true') 
            lift_level = "1"; //update lift level to be 1
            let video = document.querySelector("#video6");
            video.play();    
          }   
    });

    //CLICKED THE BUTTON TO GO TO THE SECOND FLOOR
    document
      .querySelector("#secondfloor")
      .addEventListener("click", e => {
        //first floor to second
          if (lift_level == "1") {
            document.querySelector('#sky').setAttribute('visible', 'false')
            document.querySelector('#foyer').setAttribute('visible', 'false')
            document.querySelector('#buttons').setAttribute('visible', 'false')
            document.querySelector('#videosphere4').setAttribute('visible', 'true')
            lift_level = "2"; //update lift level to be 2 
            let video = document.querySelector("#video4");
            video.play();
         //ground floor to second
          } else if (lift_level == "g") {
            document.querySelector('#sky').setAttribute('visible', 'false')
            document.querySelector('#foyer').setAttribute('visible', 'false')
            document.querySelector('#buttons').setAttribute('visible', 'false')
            document.querySelector('#videosphere1').setAttribute('visible', 'true') 
            lift_level = "2"; //update lift level to be 2
            let video = document.querySelector("#video1");
            video.play();
          };  
    });

    
    //ONCE VIDEO ENDED
    function videoEnded() {
      console.log(lift_level);

      if (lift_level == "g") {
      document.querySelector('#sky').setAttribute('src', sky_g_asset)
      document.querySelector('#sky').setAttribute('rotation', sky_g_rotation)
      document.querySelector('#foyer').setAttribute('src', link_g_asset)
      document.querySelector('#foyer').setAttribute('position', link_g_position)
      document.querySelector('#sphereText').setAttribute('value', link_g_text)
      }
      else if (lift_level == "1") {
      document.querySelector('#sky').setAttribute('src', sky_1_asset)
      document.querySelector('#sky').setAttribute('rotation', sky_1_rotation)
      document.querySelector('#foyer').setAttribute('src', link_1_asset)
      document.querySelector('#foyer').setAttribute('position', link_1_position)
      document.querySelector('#sphereText').setAttribute('value', link_1_text)
      }
      else if (lift_level == "2") {
      document.querySelector('#sky').setAttribute('src', sky_2_asset)
      document.querySelector('#sky').setAttribute('rotation', sky_2_rotation)
      document.querySelector('#foyer').setAttribute('src', link_2_asset)
      document.querySelector('#foyer').setAttribute('position', link_2_position)
      document.querySelector('#sphereText').setAttribute('value', link_2_text)
      }

      //hide videospheres
      document.querySelector('#videosphere1').setAttribute('visible', 'false')
      document.querySelector('#videosphere2').setAttribute('visible', 'false')
      document.querySelector('#videosphere3').setAttribute('visible', 'false')
      document.querySelector('#videosphere4').setAttribute('visible', 'false')
      document.querySelector('#videosphere5').setAttribute('visible', 'false')
      document.querySelector('#videosphere6').setAttribute('visible', 'false')
      document.querySelector('#sky').setAttribute('visible', 'true')
      document.querySelector('#foyer').setAttribute('visible', 'true')
      document.querySelector('#buttons').setAttribute('visible', 'true')
    }

  </script>
    
 
</html>

<!-- LIFT_L1.PHP, LIFT_L4.PHP AND LIFT_L7.PHP REPRESENT THE DIFFERENT FLOORS WITHIN THE LIFT. 
THIS VERSION OF THE LIFT DOESNT HAVE VIDEOS SHOWING THE TRANSITION BETWEEN FLOORS-->

<!--PHP TO GET ASSETS FROM DATABASE-->
<?php
//EXTRACT THE LOCATION CODE (FROM THE PAGE NAME)
$current_page = $_SERVER["SCRIPT_NAME"];
$without_file_extension = strtok($current_page, '.');
$folder_name_length = strlen(strtok($without_file_extension, '/'));
$location_code = substr($without_file_extension, $folder_name_length+2); //2 for the slash before and after

$location_code = "l4"; //hardcoded as page was renamed when taken out of main tour

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
  }          
?>

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
          <video id="sky_video" crossorigin="anonymous" src="<?php echo "$sky_asset" ?>"
            autoplay="true" loop="false" >
          </video>
      </a-assets>  

      <!--CAMERA AND CONTROLS
        Right hand implements hand controls with superhands, adapted/sourced from https://github.com/c-frame/aframe-super-hands-component 
        Left hand (controller) has laser/raycaster, adapted/sourced from https://aframe.io/docs/1.5.0/components/oculus-touch-controls.html 
        and https://aframe.io/docs/1.5.0/components/laser-controls.html -->
      <a-entity>
        <a-camera position="1 1 0" id="myCamera" zoom="0.8"
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
      <a-sky 
        src="#sky_video" 
        rotation="<?php echo "$sky_rotation" ?>"
        onloadstart="this.playbackRate = 1.5;">
      </a-sky> 

      <!--SPHERES LINKING TO OTHER LOCATIONS -->
      <a-sphere id="f3" radius="1" 
        src="<?php echo "$f3_link_asset" ?>" 
        position="<?php echo "$f3_link_position" ?>"  
        rotation="<?php echo "$f3_link_rotation" ?>" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="<?php echo "$f3_link_text" ?>" position="0 -1.4 0" ></a-text>
      </a-sphere>
       
      <!--LIFT BUTTONS
      Buttons change colour on hover (except the button for the floor you're currently on) -->
      <a-plane id="secondfloor" position="-4.1 -0.2 -1.5" rotation="0 70 0" color="#808080"
          event-set__enter="_event: mouseenter; color: #A6A6A6"
          event-set__leave="_event: mouseleave; color: #808080">
          <a-text font="kelsonsans" value="2" width="10" position="0 0 0" align="center" color="#FFFFFF"></a-text>
      </a-plane>
            
      <a-plane id="firstfloor" position="-4.1 -1.3 -1.5" rotation="0 70 0" color="#A6A6A6">
          <a-text font="kelsonsans" value="1" width="10" position="0 0 0" align="center" color="#FFFFFF"></a-text>
      </a-plane>

      <a-plane id="groundfloor" position="-4.1 -2.4 -1.5" rotation="0 70 0" color="#808080"
          event-set__enter="_event: mouseenter; color: #A6A6A6"
          event-set__leave="_event: mouseleave; color: #808080">
          <a-text font="kelsonsans" value="G" width="10" position="0 0 0" align="center" color="#FFFFFF"></a-text>
      </a-plane>
      
    </a-scene>
  </body>

 
  <script> 

    //USER ENTERS VR MODE
    //enter-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('enter-vr', function () {
      localStorage.setItem("vrMode",true);
      console.log("entered vr mode");
      document.querySelector('#secondfloor').setAttribute('position', '-6.1 -0.2 -1.5');
      document.querySelector('#firstfloor').setAttribute('position', '-6.1 -1.3 -1.5');
      document.querySelector('#groundfloor').setAttribute('position', '-6.1 -2.4 -1.5');
    });

    
    //USER EXITS VR MODE
    //exit-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('exit-vr', function () {
      localStorage.setItem("vrMode",false);
      console.log("exited vr mode");
      document.querySelector('#secondfloor').setAttribute('position', '-4.1 -0.2 -1.5');
      document.querySelector('#firstfloor').setAttribute('position', '-4.1 -1.3 -1.5');
      document.querySelector('#groundfloor').setAttribute('position', '-4.1 -2.4 -1.5');
    });

  
    //NAVIGATE TO OTHER PAGES (LOCATIONS)  
    document
      .querySelector("#f3")
      .addEventListener("click", e => {
      //  location.href = "../locations/f3.php";      //link disabled to separate page from main tour
    });

    document
      .querySelector("#groundfloor")
      .addEventListener("click", e => {
       location.href = "lift_l1.php";                  //goes straight to lift on desired floor (no video of transition)
    });

    document
      .querySelector("#secondfloor")
      .addEventListener("click", e => {         
       location.href = "lift_l7.php";                 //goes straight to lift on desired floor (no video of transition)
    });
  </script>
    
 
</html>

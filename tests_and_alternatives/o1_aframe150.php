<!-- THIS PAGE SHOWS AN EXAMPLE OF HOW THE CODE WAS UPDATED TO RUN ON A-FRAME 1.5.0, IN THIS CASE FOR O1.PHP) -->

<!--JAVASCRIPT TO CHECK VALUES OF LOCAL STORAGE VARIABLES
Adapted from: https://stackoverflow.com/questions/27765666/passing-variable-through-javascript-from-one-html-page-to-another-page   -->
<script>
  console.log("Tasks Completed: " + localStorage.getItem("tasksCompleted"));
</script>

<?php
//EXTRACT THE LOCATION CODE (FROM THE PAGE NAME)
$current_page = $_SERVER["SCRIPT_NAME"];
$without_file_extension = strtok($current_page, '.');
$folder_name_length = strlen(strtok($without_file_extension, '/'));
$location_code = "o1"; //hardcoded as page was renamed when taken out of main tour

//GET request to bring back asset information from database
$endpoint = "https://mmccloy04.webhosting5.eeecs.qub.ac.uk/api/assetsAPI.php?location_code=$location_code";
$resource = file_get_contents($endpoint);
$data = json_decode($resource, true);  

if ((sizeof($data) === 0)) {
    echo " <div class='uk-text-muted'>Error</div>";
 } else {
    foreach ($data as $row) {
    //ASSIGNING ENTITY INFO TO DYNAMIC VARIABLES
    //Adapted/sourced from https://www.php.net/manual/en/language.variables.variable.php
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
    <link rel="stylesheet" href="/css/style.css" />
    <script src="https://aframe.io/releases/1.5.0/aframe.min.js"></script>
    
    <script>delete AFRAME.components["grabbable"];</script> <!--removing grabbable from above script for aframe 1.5.0 due to conflict with superhands component. Sourced from https://github.com/c-frame/aframe-super-hands-component/issues/238-->
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
    
    <!--COMPONENT TO DETECT WHEN THE STUDENT CARD HITS THE READER
    Sourced/adapted from https://stackoverflow.com/questions/53673673/aframe-sphere-collider-trigger-function-on-collision-->
    <script>
    AFRAME.registerComponent('collide', {
      init: function() {
       //MAKE SCANNER GREEN AND G1 SPHERE VISIBLE 
       this.el.addEventListener('hit', (e) => {
        //timeout function sourced/adapted fromhttps://stackoverflow.com/questions/68295433/a-frame-trigger-function-when-two-objects-touch
        setTimeout(() => {
          document.querySelector('#scanner').setAttribute('color', 'green')
        }, 300)
        setTimeout(() => {
            document.querySelector('#g1').setAttribute('visible', 'true') 
        }, 400)
                  })
        this.el.addEventListener('hitend', (e) => {
          console.log('hitend')
          document.querySelector('#scanner').setAttribute('color', 'black') 
          document.querySelector('#g1').setAttribute('visible', 'false') 
        })
      }
    })
    </script>

    <!-- COMPONENT TO ONLY SHOW VR BUTTON IF HEADSET CONNECTED (IE HIDE ON LAPTOP/MOBILE DEVICES)
    Sourced/adapted from https://stackoverflow.com/questions/73669445/how-to-hide-vr-button-unless-vr-headset-is-present-on-a-frame-scene 
    Updated from to xr-mode-ui based on a-frame 1.5.0, with this also allowing you to specify which buttons to showie AR/VR both
    https://aframe.io/docs/1.5.0/components/xr-mode-ui.html?#properties_xrmode-->
    <script>
      AFRAME.registerComponent('xr-mode-ui-if-headset', {
        dependencies: ['xr-mode-ui'],
        init: function () {
          //if headset not connected then dont display any vr/ar/fullscreen button 
          if (!AFRAME.utils.device.checkHeadsetConnected()) {
            this.el.setAttribute('xr-mode-ui', 'enabled', false);
            console.log('no VR headset');
          //if headset is connected, display VR button only (not AR)
          } else {
            this.el.setAttribute('xr-mode-ui', 'enabled', true);
            this.el.setAttribute('xr-mode-ui', 'XRMode', 'vr'); //hide AR button 
            console.log('VR headset connected');
          }
        }
      })
    </script> 
  </head>
  
  <body>
    <!--scene linked to component to check if VR headset is connected, VR button will be displayed if so-->
    <a-scene xr-mode-ui-if-headset>

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
        src="<?php echo "$sky_asset" ?>"   
        rotation="<?php echo "$sky_rotation" ?>" >
      </a-sky>
    
      <!--SPHERES LINKING TO OTHER LOCATIONS -->
      <a-sphere id="o4" radius="1" 
        src="<?php echo "$o4_link_asset" ?>" 
        position="<?php echo "$o4_link_position" ?>"  
        rotation="<?php echo "$o4_link_rotation" ?>" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="<?php echo "$o4_link_text" ?>" position="0 -1.5 0" ></a-text>
      </a-sphere>
      
      <a-sphere id="g1" radius="1" visible="false"
        src="<?php echo "$g1_link_asset" ?>" 
        position="<?php echo "$g1_link_position" ?>"  
        rotation="<?php echo "$g1_link_rotation" ?>" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="<?php echo "$g1_link_text" ?>" position="0 -1.4 0" ></a-text>
      </a-sphere>

      <!--PLAY VIDEO ICON-->
      <a-box id="video" 
        src="<?php echo "$video_info_asset" ?>" 
        position="<?php echo "$video_info_position" ?>"  
        rotation="<?php echo "$video_info_rotation" ?>" 
        event-set__enter="_event: mouseenter; _target: #videoText; visible: true"
        event-set__leave="_event: mouseleave; _target: #videoText; visible: false">
        <a-text id="videoText" value="<?php echo "$video_info_text" ?>" position="0.05 1.5 -0.05" 
        align="center" color="#FFFFFF" width="7" font="kelsonsans" visible="false" look-at="#myCamera"
        geometry="primitive: plane; height: 0; width: 0" material="color: #333333"></a-text>
      </a-box>

      <!--TASK-->
      <a-box id="task"
        src="<?php echo "$task_info_asset" ?>" 
        position="<?php echo "$task_info_position" ?>"  
        rotation="<?php echo "$task_info_rotation" ?>" 
        event-set__enter="_event: mouseenter; _target: #taskText; visible: true"
        event-set__leave="_event: mouseleave; _target: #taskText; visible: false">
        <a-text id="taskText" value="<?php echo "$task_info_text" ?>" position="0.05 -2 -0.05" 
        align="center" color="#FFFFFF" width="7" font="kelsonsans" visible="false" look-at="#myCamera"
        geometry="primitive: plane; height: 0; width: 0" material="color: #333333"></a-text>
      </a-box>

       <!--CARD AND SCANNER - CARD VISIBLE STRAIGHTAWAY, ANIMATION COMPONENT USED TO SCAN CARD ON READER
       LINKED TO COMPONENT TO MAKE SCANNER GREEN AND SPHERE APPEAR WHEN OBJECTS COLLIDE-->
      <a-box id="scanner" class="collidable"  sphere-collider="" height="9" width="1.2" depth="1.2" position="12.1 -4.6 -28"  color="black"></a-box>
      <a-box id="card" 
        src="<?php echo "$student_card_asset"?>" 
        position="<?php echo "$student_card_position"?>"
        rotation="<?php echo "$student_card_position"?>"
        width="4" height="2" depth="2" visible="true" look-at="#myCamera"
        animation=""
        animation__mousedown="property: position; to: 12.1 -2.1 -28; dur: 2000; easing: linear; loop: false; startEvents: mousedown" 
        collide
        grabbable></a-box> 
   
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


    //CHECK IF PREVIOUSLY SCANNED STUDENT CARD 
        if (localStorage.getItem("tasksCompleted") >= "1") {
          document.querySelector("#scanner").setAttribute('color', 'green');
          document.querySelector("#g1").setAttribute('visible', 'true');
          document.querySelector("#card").setAttribute('position', '12.1 -2.1 -28');
        }

        
    //MARK TASK AS COMPLETED WHEN SCAN CARD (INCREASE JS LOCAL STORAGE VARIABLE)
    document
      .querySelector("#card")
        .addEventListener("click", e => {
          //Use of local storage variable adapted from: https://stackoverflow.com/questions/27765666/passing-variable-through-javascript-from-one-html-page-to-another-page      
            if (localStorage.getItem("tasksCompleted")>= "1") {
            } else {
              localStorage.setItem("tasksCompleted","1");
            }
            console.log("Tasks Completed: " + localStorage.getItem("tasksCompleted"));
      });


   //NAVIGATE TO OTHER PAGES (LOCATIONS) 
    document
      .querySelector("#o4")
      .addEventListener("click", e => {
        //location.href = "o4.php";   //link to main tour disabled as this is just a testing page 
    });
    
    document
      .querySelector("#g1")
      .addEventListener("click", e => {
        //location.href = "g1.php";   //link to main tour disabled as this is just a testing page 
    });


    //LINK TO VIDEO PAGE
    document
      .querySelector("#video")
      .addEventListener("click", e => {
        //location.href = "../videos/o1_video.php";  //link to main tour disabled as this is just a testing page 
    });
       

  </script>
    
 
</html>

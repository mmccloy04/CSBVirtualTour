<!--JAVASCRIPT TO CHECK VALUES OF LOCAL STORAGE VARIABLES
Adapted from: https://stackoverflow.com/questions/27765666/passing-variable-through-javascript-from-one-html-page-to-another-page   -->
<script>
  console.log("Tasks Completed: " + localStorage.getItem("tasksCompleted"));
  console.log("Lift Disabled? " + localStorage.getItem("liftDisabled"));
</script>

<?php
//EXTRACT THE LOCATION CODE (FROM THE PAGE NAME)
$current_page = $_SERVER["SCRIPT_NAME"];
$without_file_extension = strtok($current_page, '.');
$folder_name_length = strlen(strtok($without_file_extension, '/'));
$location_code = substr($without_file_extension, $folder_name_length+2); //2 for the slash before and after

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

<!--PASSING DATABASE VALUES TO JAVASCRIPT
Sourced/adapted from https://stackoverflow.com/questions/4287357/access-php-variable-in-javascript -->
<script type="text/javascript">
  const audioFile = <?php echo json_encode("$audio_file_asset"); ?>;
  const task_position = <?php echo json_encode("$audio_info_position"); ?>;
  const audio_position = <?php echo json_encode("$task_info_position"); ?>;
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
          <video id="sky_video" crossorigin="anonymous" src="<?php echo "$sky_asset" ?>"
            autoplay="true" loop="false" >
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
      <a-sky 
        src="#sky_video" 
        rotation="<?php echo "$sky_rotation" ?>"
        onloadstart="this.playbackRate = 1.5;">
      </a-sky> 
     
      <!--SPHERES LINKING TO OTHER LOCATIONS -->
      <a-sphere id="q1" radius="1" 
        src="<?php echo "$q1_link_asset" ?>" 
        position="<?php echo "$q1_link_position" ?>"  
        rotation="<?php echo "$q1_link_rotation" ?>" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="<?php echo "$q1_link_text" ?>" position="0 -1.5 0" ></a-text>
      </a-sphere>

      <!--TASK -->
      <a-box id="task" scale = "0.8 0.8 0.8"
        src="<?php echo "$task_info_asset" ?>" 
        position="<?php echo "$task_info_position" ?>"  
        rotation="<?php echo "$task_info_rotation" ?>" 
        event-set__enter="_event: mouseenter; _target: #taskText; visible: true"
        event-set__leave="_event: mouseleave; _target: #taskText; visible: false">
        <a-text id="taskText" value="<?php echo "$task_info_text" ?>" position="0.05 2.3 -0.05"
        align="center" color="#FFFFFF" width="6" font="kelsonsans" visible="false" look-at="#myCamera"
        geometry="primitive: plane; height: 0; width: 0" material="color: #333333"></a-text>
      </a-box>

      <!--PLAY AUDIO-->
      <a-box id="audio" scale = "0.8 0.8 0.8"
        src="<?php echo "$audio_info_asset" ?>" 
        position="<?php echo "$audio_info_position" ?>"  
        rotation="<?php echo "$audio_info_rotation" ?>"
        event-set__enter="_event: mouseenter; _target: #audioText; visible: true"
        event-set__leave="_event: mouseleave; _target: #audioText; visible: false">
        <a-text id="audioText" value="<?php echo "$audio_info_text" ?>" position="0.05 1.5 -0.05" 
        align="center" color="#FFFFFF" width="6" font="kelsonsans" visible="false" look-at="#myCamera"
        geometry="primitive: plane; height: 0; width: 0" material="color: #333333" ></a-text>
      </a-box> 
      
    </a-scene>
  </body>

  
  <script> 
  
    //USER ENTERS VR MODE
    //enter-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('enter-vr', function () {
      localStorage.setItem("vrMode",true);
      console.log("entered vr mode");
      document.querySelector('#task').setAttribute('position', '-1.50 -0.50 -7.00');
      document.querySelector('#task').setAttribute('scale', '1 1 1');
      document.querySelector('#audio').setAttribute('position', '-4.75 -0.60 4.75');
      document.querySelector('#audio').setAttribute('scale', '1 1 1');

    });

    
    //USER EXITS VR MODE
    //exit-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('exit-vr', function () {
      localStorage.setItem("vrMode",false);
      console.log("exited vr mode");
      document.querySelector('#task').setAttribute('position', 'task_position');
      document.querySelector('#task').setAttribute('scale', '0.8 0.8 0.8');
      document.querySelector('#audio').setAttribute('position', 'audio_position');
      document.querySelector('#audio').setAttribute('scale', '0.8 0.8 0.8');
    });


    //CHECK IF PREVIOUS TASKS HAVE BEEN COMPLETED (ONLY SHOW TASK BOX AND AUDIO BOX IF SO)
    if (localStorage.getItem("tasksCompleted") >= "6") {
      document.querySelector('#task').setAttribute('visible', 'true')
      document.querySelector('#audio').setAttribute('visible', 'true')
    } else {
      document.querySelector('#task').setAttribute('visible', 'false')
      document.querySelector('#audio').setAttribute('visible', 'false')
    }

    //HOVER OVER TASK BOX
    document
      .querySelector("#task")
      .addEventListener("mouseenter", e => {
         //MARK TASK AS COMPLETED (INCREASE JS LOCAL STORAGE VARIABLE)
         //Adapted from: https://stackoverflow.com/questions/27765666/passing-variable-through-javascript-from-one-html-page-to-another-page      
          if (localStorage.getItem("tasksCompleted") >= "7") {
            localStorage.setItem("liftDisabled", "true");
          } else if (localStorage.getItem("tasksCompleted") == "6") {
            localStorage.setItem("tasksCompleted","7");
            localStorage.setItem("liftDisabled", "true");
          }
          console.log("Tasks Completed: " + localStorage.getItem("tasksCompleted"));
          
          //SET JS LOCAL STORAGE VARIABLE TO DISABLE LIFT
          console.log("Lift Disabled? " + localStorage.getItem("liftDisabled"));
     });


    //NAVIGATE TO OTHER PAGES (LOCATIONS)  
    document
      .querySelector("#q1")
      .addEventListener("click", e => {
        location.href = "q1.php";
    });
  </script>
  

  <script>
    //PLAY/PAUSE AUDIO (stops playing audio once release mouse)
    //Audio file with event listener, sourced/adapted from https://stackoverflow.com/questions/69470562/how-do-i-get-audio-to-play-when-i-hover-over-an-image 
    //Fire alarm audio clip downloaded from https://pixabay.com/sound-effects/search/fire-alarm/ 
      var audioimg = document.getElementById("audio");
      const audio = new Audio(audioFile);
      function play() {
        audio.play();
        audio.loop = true;
      }
      function stop() {
        audio.pause();
      }
      if (localStorage.getItem("tasksCompleted") >= "6") {
          
      audioimg.addEventListener('mousedown', play);
      audioimg.addEventListener('mouseup', stop);
      }
  </script>

 
</html>

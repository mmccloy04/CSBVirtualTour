<!--THIS PAGE SHOWS THE IDENTIFIED ISSUE WITH THE VIDEO FILE PREVIOUSLY USED AS THE BACKGROUND FOR S4.PHP -->

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
$location_code = "s4"; //hardcoded as page was renamed when taken out of main tour

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
  var task_text = <?php echo json_encode("$task_info_text"); ?>;
  const audioFile = <?php echo json_encode("$audio_file_asset"); ?>;
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
        <a-camera position="0 1 0" id="myCamera" 
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
      <a-sphere id="s3" radius="1" 
        src="<?php echo "$s3_link_asset" ?>" 
        position="<?php echo "$s3_link_position" ?>"  
        rotation="<?php echo "$s3_link_rotation" ?>" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="<?php echo "$s3_link_text" ?>" position="0 -1.5 0" ></a-text>
      </a-sphere>
      
      <!--PLAY AUDIO-->
      <a-box id="audio" 
        src="<?php echo "$audio_info_asset" ?>" 
        position="<?php echo "$audio_info_position" ?>"  
        rotation="<?php echo "$audio_info_rotation" ?>"
        event-set__enter="_event: mouseenter; _target: #audioText; visible: true"
        event-set__leave="_event: mouseleave; _target: #audioText; visible: false">
        <a-text id="audioText" value="<?php echo "$audio_info_text" ?>" position="0.05 1.5 -0.05" 
        align="center" color="#FFFFFF" width="7" font="kelsonsans" visible="false" look-at="#myCamera"
        geometry="primitive: plane; height: 0; width: 0" material="color: #333333" ></a-text>
      </a-box> 
      
      <!--TASK-->
      <a-box id="task"
        src="<?php echo "$task_info_asset" ?>" 
        position="<?php echo "$task_info_position" ?>"  
        rotation="<?php echo "$task_info_rotation" ?>" 
        event-set__enter="_event: mouseenter; _target: #taskText; visible: true"
        event-set__leave="_event: mouseleave; _target: #taskText; visible: false">
        <a-text id="taskText" value="<?php echo "$task_info_text" ?>" position="0.05 1.8 0" 
        align="center" color="#FFFFFF" width="7" font="kelsonsans" visible="false" look-at="#myCamera"
        geometry="primitive: plane; height: 0; width: 0" material="color: #333333"></a-text>
      </a-box>

      <!-- INTERACTIVE SCENARIO-->     
     <a-entity id="interactive_scenario" position="0.1 0.1 -0.4" visible="false"> 

       <!--Table - change position for VR mode e.g. height 0.75 -->
       <a-box
          position="0 0 -1"
          width="4.5"
          height="0.5"
          depth="1.5"
          color="grey"
        ></a-box>

        <!--boxes-->
        <a-box
          id="box1"
          grabbable
          draggable
          droppable
          position="-1.25 0.5 -0.75"
          rotation="0 -90 0"
          scale="0.3 0.3 0.3"
          color="orange"
          animation__mousedown="property: rotation; to: 0 0 0 ; dur: 1000; startEvents: mousedown" >
            <a-text id="text1" font="kelsonsans" value="First" width="5" position="0 0 0.5" align="center" color="#000000"></a-text>     
        </a-box>

         <a-box
          id="box2"
          grabbable
          draggable
          droppable
          position="-0.5 0.5 -0.75"
          rotation="90 0 0"
          scale="0.3 0.3 0.3"
          color="green"
          animation__mousedown="property: rotation; to: 0 0 0 ; dur: 1000; startEvents: mousedown" >
            <a-text id="text2" font="kelsonsans" value="Floor" width="5" position="0 0 0.5" align="center" color="#000000"></a-text>     
        </a-box>

          <a-box 
          id="box3"
          grabbable
          draggable
          droppable
          position="0.25 0.5 -0.75"
          rotation="90 0 90"
          scale="0.3 0.3 0.3"
          color="blue"
          animation__mousedown="property: rotation; to: 0 0 0 ; dur: 1000; startEvents: mousedown" >
            <a-text id="text3" font="kelsonsans" value="Learning" width="5" position="0 0 0.5" align="center" color="#000000"></a-text>     
        </a-box>

        <a-box 
          id="box4"
          grabbable
          draggable
          droppable
          position="1 0.5 -0.75"
          rotation="0 90 0"
          scale="0.3 0.3 0.3"
          color="red"
          animation__mousedown="property: rotation; to: 0 0 0 ; dur: 1000; startEvents: mousedown" >
            <a-text id="text4" font="kelsonsans" value="Lab" width="5" position="0 0 0.5" align="center" color="#000000"></a-text>     
        </a-box>
   </a-entity>     
  
    </a-scene>
  </body>

   
  <script> 

    //USER ENTERS VR MODE
    //enter-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
      document.querySelector('a-scene').addEventListener('enter-vr', function () {
      console.log("entered vr mode");
      document.querySelector('#taskText').setAttribute('value',  task_text + '\n(Hint: To rotate the boxes, you can either click them using the laser, or squeeze them with your right hand).');
      document.querySelector('#taskText').setAttribute('geometry',  'primitive: plane; height: 0; width: 0'); //resizes based on length of text 
      document.querySelector('#taskText').setAttribute('position', '0.05 2.1 0');
      document.querySelector('#interactive_scenario').setAttribute('position', '0.1 1 -0.25'); 
    });

    
    //USER EXITS VR MODE
    //exit-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('exit-vr', function () {
      console.log("exited vr mode");
      document.querySelector('#taskText').setAttribute('value',  task_text)
      document.querySelector('#taskText').setAttribute('geometry',  'primitive: plane; height: 0; width: 0');  //resizes based on length of text
      document.querySelector('#taskText').setAttribute('position', '0.05 1.8 0');
      document.querySelector('#interactive_scenario').setAttribute('position', '0.1 0.1 -0.4');
    });


    //CHECK IF PREVIOUS TASKS HAVE BEEN COMPLETED (ONLY SHOW TASK BOX IF SO)
    if (localStorage.getItem("tasksCompleted") >= "4") {
      document.querySelector('#task').setAttribute('visible', 'true')
    } else {
      document.querySelector('#task').setAttribute('visible', 'false')
    }


    //SHOW INTERACTIVE SCENARIO WHEN CLICK ON TASK BOX 
    document
      .querySelector("#task")
      .addEventListener("click", e => {
        document.querySelector('#interactive_scenario').setAttribute('visible', 'true')
    });


    //NAVIGATE TO OTHER PAGES (LOCATIONS) 
    document
      .querySelector("#s3")
      .addEventListener("click", e => {
        //location.href = "s3.php";   //link to main tour disabled as this is just a testing page 
    }); 


    //CLICK TO ROTATE FINAL BOX 
    document
      .querySelector("#box4")
        .addEventListener("click", e => {
          //MARK TASK AS COMPLETED (INCREASE JS LOCAL STORAGE VARIABLE)
          //Adapted from: https://stackoverflow.com/questions/27765666/passing-variable-through-javascript-from-one-html-page-to-another-page     
            if (localStorage.getItem("tasksCompleted") >= "5") {
            } else {
              localStorage.setItem("tasksCompleted","5");
            }
            console.log("Tasks Completed: " + localStorage.getItem("tasksCompleted"));
    });
  </script>
  
  <script>
  //PLAY/PAUSE AUDIO (stops playing audio once release mouse)
  //Audio file with event listener, sourced/adapted from https://stackoverflow.com/questions/69470562/how-do-i-get-audio-to-play-when-i-hover-over-an-image 
    var audioimg = document.getElementById("audio");
    const audio = new Audio(audioFile);
    function play() {
      audio.play();
      audio.loop = true;
    }
    function stop() {
      audio.pause();
    }
    audioimg.addEventListener('mousedown', play);
    audioimg.addEventListener('mouseup', stop);
  </script>
 
</html>
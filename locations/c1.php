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

  <!--PASSING DATABASE VALUES TO JAVASCRIPT
  Sourced/adapted from https://stackoverflow.com/questions/4287357/access-php-variable-in-javascript -->
  <script type="text/javascript">
    var info_position = <?php echo json_encode("$info_1_position"); ?>;
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

    <!--The below scripts are sourced from the following example: https://aframe.io/docs/1.5.0/guides/building-a-360-image-gallery.html -->
    <script src="https://unpkg.com/aframe-template-component@3.x.x/dist/aframe-template-component.min.js"></script>
    <script src="https://unpkg.com/aframe-layout-component@4.x.x/dist/aframe-layout-component.min.js"></script>
    <!--<script src="https://unpkg.com/aframe-proxy-event-component@2.1.0/dist/aframe-proxy-event-component.min.jss"></script>-->
    
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
  
   <!-- TEMPLATE TO BE REUSED 
    Sourced/adapted from https://aframe.io/docs/1.5.0/guides/building-a-360-image-gallery.html -->
    <script id="link" type="text/html">
      <a-entity class="link"
        geometry="primitive: plane; height: 1; width: 1.3"
        material="shader: flat; src: ${thumb}"
        sound="on: click; src: #click-sound"
        event-set__mouseenter="scale: 1.1 1.1 1"
        event-set__mouseleave="scale: 1 1 1"
        event-set__click="_target: #info_box; _delay: 300; material.src: ${src}"
        proxy-event="event: click; to: #info_box 60; as: fade"></a-entity>
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
        <audio id="click-sound" src="<?php echo "$audio_file_asset" ?>" crossorigin="anonymous"></audio>
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
        src="<?php echo "$sky_asset" ?>"  
        rotation="<?php echo "$sky_rotation" ?>" >
      </a-sky>
      
      <!--SPHERES LINKING TO OTHER LOCATIONS -->
      <a-sphere id="g6" radius="1" 
        src="<?php echo "$g6_link_asset" ?>" 
        position="<?php echo "$g6_link_position" ?>"  
        rotation="<?php echo "$g6_link_rotation" ?>" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="<?php echo "$g6_link_text" ?>" position="0 -1.4 0" ></a-text>
      </a-sphere>
      
      <!--TASK-->
      <a-box id="task"
        src="<?php echo "$task_info_asset" ?>" 
        position="<?php echo "$task_info_position" ?>"  
        rotation="<?php echo "$task_info_rotation" ?>" 
        event-set__enter="_event: mouseenter; _target: #taskText; visible: true"
        event-set__leave="_event: mouseleave; _target: #taskText; visible: false">
        <a-text id="taskText" value="<?php echo "$task_info_text" ?>" position="0 2.1 0"
        align="center" color="#FFFFFF" width="7" font="kelsonsans" visible="false" look-at="#myCamera"
        geometry="primitive: plane; height: 0; width: 0" material="color: #333333"></a-text>
      </a-box>
     
       <!--INFO BOXES WITH AUDIO (CLICK SOUND)
        Sourced/adapted from https://aframe.io/docs/1.5.0/guides/building-a-360-image-gallery.html 
        The images for the information panels have been adapted/sourced from the following links:
        https://qubstudentcloud.sharepoint.com/:p:/r/sites/stu-seeecs/_layouts/15/Doc.aspx?sourcedoc=%7B3A09014E-3A4F-48F0-8C78-A1870D22AB4D%7D&file=EEECS-Student-IT%20GettingStarted-2023-24.pptx&action=edit&mobileredirect=true
        https://qubstudentcloud.sharepoint.com/sites/stu-seeecs/SitePages/IT/Student-induction-information.aspx  
        https://selfservice.eeecs.qub.ac.uk/ -->
      <a-plane id="info_box" width="7.4" height="4.35" visible="false"
        src="<?php echo "$info_1_asset" ?>" 
        position="<?php echo "$info_1_position" ?>"  
        rotation="<?php echo "$info_1_rotation" ?>">
        <!--passing images to asset template-->
        <!--layout component sourced/adapted from https://www.npmjs.com/package/aframe-layout-component -->
        <a-entity id="links" layout="type: line; margin: 1.5" position= "-2.3 -2 1" rotation="-20 0 0">
            <a-entity id="link1" template="src: #link" data-src="<?php echo "$info_1_asset" ?>"  data-thumb="<?php echo "$thumb_1_asset" ?>" scale="1.1 1.1 1"></a-entity>
            <a-entity id="link2" template="src: #link" data-src="<?php echo "$info_2_asset" ?>"  data-thumb="<?php echo "$thumb_2_asset" ?>"></a-entity>
            <a-entity id="link3" template="src: #link" data-src="<?php echo "$info_3_asset" ?>"  data-thumb="<?php echo "$thumb_3_asset" ?>"></a-entity>
            <a-entity id="link4" template="src: #link" data-src="<?php echo "$info_4_asset" ?>"  data-thumb="<?php echo "$thumb_4_asset" ?>"></a-entity>
        </a-entity>
      </a-plane>  

    </a-scene>
  </body>

  <script>  

    //USER ENTERS VR MODE
    //enter-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('enter-vr', function () {
      localStorage.setItem("vrMode",true);
      console.log("entered vr mode");
      document.querySelector('#info_box').setAttribute('position', '-6 1.8 1.7');
    });
    

    //USER EXITS VR MODE  (set back to default values - ie values before entered VR mode)
    //exit-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('exit-vr', function () {
      localStorage.setItem("vrMode",false);
      console.log("exited vr mode");
      document.querySelector('#info_box').setAttribute('position', info_position);
    });

    
    //CHECK IF PREVIOUS TASKS HAVE BEEN COMPLETED (ONLY SHOW TASK BOX IF SO)
    if (localStorage.getItem("tasksCompleted") >= "2") {
      document.querySelector('#task').setAttribute('visible', 'true')
    } else {
      document.querySelector('#task').setAttribute('visible', 'false')
    }

    //CLICK ON TASK BOX TO SHOW INFO PANELS
    document
      .querySelector("#task")
      .addEventListener("click", e => {
         //MARK TASK AS COMPLETED (INCREASE JS LOCAL STORAGE VARIABLE)       
          if (localStorage.getItem("tasksCompleted") >= "3") {
          } else if (localStorage.getItem("tasksCompleted") == "2") {
            localStorage.setItem("tasksCompleted","3");
          }
          console.log("Tasks Completed: " + localStorage.getItem("tasksCompleted"));
          //SHOW INTERACTIVE SCENARIO
          if (localStorage.getItem("tasksCompleted") >= "3") {
          document.querySelector('#info_box').setAttribute('visible', 'true') 
          };
    });
    

    //MAKE CURRENTLY SELECTED LINK PANEL SLIGHTLY LAGER  
    document
      .querySelector("#link1")
      .addEventListener("click", e => {
        document.querySelector('#link1').setAttribute('scale', "1.1 1.1 1")
        document.querySelector('#link2').setAttribute('scale', "1 1 1")
        document.querySelector('#link3').setAttribute('scale', "1 1 1")
        document.querySelector('#link4').setAttribute('scale', "1 1 1")
    });
    document
      .querySelector("#link2")
      .addEventListener("click", e => {
        document.querySelector('#link1').setAttribute('scale', "1 1 1")
        document.querySelector('#link2').setAttribute('scale', "1.1 1.1 1")
        document.querySelector('#link3').setAttribute('scale', "1 1 1")
        document.querySelector('#link4').setAttribute('scale', "1 1 1")
    });
    document
      .querySelector("#link3")
      .addEventListener("click", e => {
        document.querySelector('#link1').setAttribute('scale', "1 1 1")
        document.querySelector('#link2').setAttribute('scale', "1 1 1")
        document.querySelector('#link3').setAttribute('scale', "1.1 1.1 1")
        document.querySelector('#link4').setAttribute('scale', "1 1 1")
    });
    document
      .querySelector("#link4")
      .addEventListener("click", e => {
        document.querySelector('#link1').setAttribute('scale', "1 1 1")
        document.querySelector('#link2').setAttribute('scale', "1 1 1")
        document.querySelector('#link3').setAttribute('scale', "1 1 1")
        document.querySelector('#link4').setAttribute('scale', "1.1 1.1 1")
    });


    //NAVIGATE TO OTHER PAGES (LOCATIONS)
    document
      .querySelector("#g6")
      .addEventListener("click", e => {
        location.href = "g6.php";
    });

  </script>
    
</html>

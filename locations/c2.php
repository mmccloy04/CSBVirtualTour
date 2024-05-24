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
    $password = "Error";
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

<!--PHP TO GET STUDENT/STAFF NUMBER AND PASSWORD FROM DATABASE-->
<?php  
    $id = 2; //generic standard user
    //bring row for user id 2 from database
    $endpoint = "https://mmccloy04.webhosting5.eeecs.qub.ac.uk/api/userAPI.php?user_id=$id";
    $resource = file_get_contents($endpoint);
    $data = json_decode($resource, true);

    //no returned results
    if ((sizeof($data) === 0)) {
        echo " <div class='uk-text-muted'>Error</div>";
        $password = "Error";
    } else {
    //assign returned result to variable
        foreach ($data as $row) {
            $student_staff_number = $row["student_staff_number"];  
            $password = $row["password"];    
        }
    }
    $_POST["student_staff_number"] = $student_staff_number;
    $_POST["password"] = $password;
?>

  <!--PASSING DATABASE VALUES TO JAVASCRIPT
  Sourced/adapted from https://stackoverflow.com/questions/4287357/access-php-variable-in-javascript -->
  <script type="text/javascript">
    var task_text = <?php echo json_encode("$task_info_text"); ?>;
    var computer_position = <?php echo json_encode("$computer_position"); ?>  
    var db_password = <?php echo json_encode($_POST["password"]); ?>;
    var screen_2_asset = <?php echo json_encode("$screen_2_asset"); ?>;
    var screen_2_text = <?php echo json_encode("$screen_2_text"); ?>;
    var screen_3_asset = <?php echo json_encode("$screen_3_asset"); ?>;
    var screen_3_text = <?php echo json_encode("$screen_3_text"); ?>;
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
    
    <script src="../../../js/keyboard.min.js"></script> <!--keyboard script sourced from https://github.com/WandererOU/aframe-keyboard/tree/master/dist -->
    
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
     
    <!--COMPONENT TO ALLOW BOXES TO HAVE DIFFERENT IMAGES ON EACH SIDE
    Adapted/sourced from: https://stackoverflow.com/questions/69339884/a-frame-is-there-a-way-to-make-an-image-show-up-on-only-one-side-of-a-shape -->
    <script>
    AFRAME.registerComponent("box-side-img", {
      schema: {
        img: {type: "selector"}
      },
      init: function() {
        // wait until the entity is loaded
        this.el.addEventListener("loaded", evt => {
          // grab the mesh
          const mesh = this.el.getObject3D("mesh");
          // load the texture
          this.el.sceneEl.systems.material.loadTexture(this.data.img, {
              src: this.data.img
            },
            // when loaded, create 6 materials for each side
            function textureLoaded(texture) {
              var cubeMaterial = [
                new THREE.MeshBasicMaterial({map: texture}),
                new THREE.MeshBasicMaterial({color: 'white'}),
                new THREE.MeshBasicMaterial({color: '#222222'}),
                new THREE.MeshBasicMaterial({color: '#222222'}),
                new THREE.MeshBasicMaterial({color: '#222222'}),
                new THREE.MeshBasicMaterial({color: '#222222'})
              ];
              // apply the new material + clean up the old one
              var oldMaterial = mesh.material;
              mesh.material = cubeMaterial;
              oldMaterial.dispose()
            });
        });
      }
    })
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
        <img id="password_icon" src="<?php echo "$password_info_asset" ?>" crossorigin="anonymous">
      </a-assets>
      
      <!--CAMERA AND CONTROLS
        Right hand implements hand controls with superhands, adapted/sourced from https://github.com/c-frame/aframe-super-hands-component 
        Left hand (controller) has laser/raycaster, adapted/sourced from https://aframe.io/docs/1.5.0/components/oculus-touch-controls.html 
        and https://aframe.io/docs/1.5.0/components/laser-controls.html -->
      <a-entity>
        <a-camera position="1 1 0" id="myCamera" 
          cursor="rayOrigin: mouse" 
          wasd-controls-enabled="false"
          raycaster="">
        </a-camera>
        <a-entity sphere-collider="objects: a-plane, a-box, a-sphere" super-hands hand-controls="hand: right"></a-entity>  
        <a-entity 
          oculus-touch-controls="hand: left" laser-controls="hand: left" 
          raycaster=""
          thumbstick-logging></a-entity> 
      </a-entity>

      <!--BACKGROUND-->
      <a-sky zoom="0.8"
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
        value="<?php echo "$g6_link_text" ?>" position="0 -1.5 0" ></a-text>
      </a-sphere>
      
      <!--PLAY AUDIO-->
      <a-box id="audio" 
        src="<?php echo "$audio_info_asset" ?>" 
        position="<?php echo "$audio_info_position" ?>"  
        rotation="<?php echo "$audio_info_rotation" ?>"
        event-set__enter="_event: mouseenter; _target: #audioText; visible: true"
        event-set__leave="_event: mouseleave; _target: #audioText; visible: false">
        <a-text id="audioText" value="<?php echo "$audio_info_text" ?>" position="0.05 1.5 0.05" 
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
        <a-text id="taskText" value="<?php echo "$task_info_text" ?>" position="0.05 1.3 -0.05" 
        align="center" color="#FFFFFF" width="6" font="kelsonsans" visible="false" look-at="#myCamera"
        geometry="primitive: plane; height: 0; width: 0" material="color: #333333"></a-text>
      </a-box>
    
      <!--PASSWORD BOX-->
      <a-box id="password" 
        position="<?php echo "$password_info_position" ?>"  
        rotation="<?php echo "$password_info_rotation" ?>" 
        animation__mousedown="property: rotation; to: 0 0 0 ; dur: 1000; startEvents: mousedown" 
        box-side-img="img: #password_icon" visible="false" >
        <a-text value="<?php echo $_POST["password"]; ?>" width="5" align="center" position="-0.7 0 0" color="black" look-at="#myCamera"></a-text>
      </a-box>
      
      <!--COMPUTER (GRABBABLE)
      Keyboard sourced/adapted from https://wandererou.github.io/aframe-keyboard/ and https://wandererou.github.io/aframe-keyboard/examples/basic/index.html -->
      <a-plane id ="computer"
          grabbable draggable droppable
          src="<?php echo "$computer_asset" ?>" 
          position="<?php echo "$computer_position" ?>"  
          rotation="<?php echo "$computer_rotation" ?>" 
          width="14" height="9" look-at="#myCamera" visible="false"
          animation="property=rotation; from: 0 0 0; to 360 360 0; dur:20000; startEvents:click;">
        
          <!--keyboard and keyboard input-->
          <a-entity id="keyboard" position="-4.8 -5 3" rotation="-40 0 0" scale="20 20 20" a-keyboard=""></a-entity>
          <a-text id="username" font="kelsonsans" value="<?php echo ($_POST["student_staff_number"]); ?>" width="7" position="-3.35 -0.3 1" text="" color="#000000"></a-text>
          <a-text id="input" font="kelsonsans" value="" width="7" position="-3.35 -1.6 1" text="" color="#000000"></a-text>

          <!--computer screen-->
          <a-plane id="screen" 
            src="<?php echo "$screen_1_asset" ?>" 
            position="<?php echo "$screen_1_position" ?>"  
            rotation="<?php echo "$screen_1_rotation" ?>" 
            width="13.7" height="8.7">
            <a-text id="failed_login"
              value="Incorrect password. Please try again." position="0 -2.2 1" 
              align="center" color="#FF0000" width="6" font="kelsonsans" visible="false">
            </a-text>
          </a-plane>

          <!--instructions-->
          <a-text id="instructions"
            value="<?php echo "$screen_1_text" ?>" position="0 5.3 1" 
            align="center" color="#FFFFFF" width="9" font="kelsonsans"
            geometry="primitive: plane; height: 1.5; width: 12.5">
          </a-text>

          <a-plane id="classes" 
            src="<?php echo "$classes_asset" ?>" 
            position="<?php echo "$classes_position" ?>"  
            rotation="<?php echo "$classes_rotation" ?>" 
            width="2.4" height="2" visible="false"
            event-set__enter="_event: mouseenter; scale: 1.5 1.5 1.5"
            event-set__leave="_event: mouseleave; scale: 1 1 1">
          </a-plane>
          
          <a-plane id="timetable" 
            src="<?php echo "$timetable_asset" ?>" 
            position="<?php echo "$timetable_position" ?>"  
            rotation="<?php echo "$timetable_rotation" ?>" 
            width="1.2" height="1.2" visible="false"
            event-set__enter="_event: mouseenter; scale: 3 3 3" 
            event-set__leave="_event: mouseleave; scale: 1 1 1">
          </a-plane>
        
          <!--TASK 2-->
          <a-plane id="task2" 
            src="<?php echo "$task2_info_asset" ?>" 
            position="<?php echo "$task2_info_position" ?>"  
            rotation="<?php echo "$task2_info_rotation" ?>" 
            width="2" height="1.5" visible="false"
            event-set__enter="_event: mouseenter; _target: #task2Text; visible: true"
            event-set__leave="_event: mouseleave; _target: #task2Text; visible: false">
            <a-text id="task2Text" value="<?php echo "$task2_info_text" ?>" position="0 2.5 1.5"
              align="center" color="#FFFFFF" width="10" font="kelsonsans" visible="false"
              geometry="primitive: plane; height: 0; width: 0" material="color: #333333">
            </a-text>
          </a-plane>

      </a-plane>
      
    </a-scene>
  </body>
 
  <script> 

    //USER ENTERS VR MODE
    //enter-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('enter-vr', function () {
      localStorage.setItem("vrMode",true);
      console.log("entered vr mode");
      document.querySelector('#taskText').setAttribute('value',  task_text + '\n(Hint: you can grab the computer/keyboard with your right hand to move them!).');
      document.querySelector('#taskText').setAttribute('geometry',  'primitive: plane; height: 0; width: 0'); //resizes based on length of text 
      document.querySelector('#taskText').setAttribute('position', '0.05 1.7 -0.05');
      document.querySelector('#computer').setAttribute('position', '1.5 2.5 9');
    });
    

    //USER EXITS VR MODE (set back to default values - ie values before entered VR mode)
    //exit-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
    document.querySelector('a-scene').addEventListener('exit-vr', function () {
      localStorage.setItem("vrMode",false);
      console.log("exited vr mode");
      document.querySelector('#taskText').setAttribute('value',  task_text)
      document.querySelector('#taskText').setAttribute('geometry',  'primitive: plane; height: 0; width: 0');  //resizes based on length of text
      document.querySelector('#taskText').setAttribute('position', '0.05 1.3 -0.05'); 
      document.querySelector('#computer').setAttribute('position', computer_position); 
    });


    //CHECK IF PREVIOUS TASKS HAVE BEEN COMPLETED (ONLY SHOW TASK BOX IF SO)
    if (localStorage.getItem("tasksCompleted") >= "3") {
      document.querySelector('#task').setAttribute('visible', 'true')
    } else {
      document.querySelector('#task').setAttribute('visible', 'false')
    }


    //SHOW COMPUTER, KEYBOARD AND PASSWORD BOX WHEN CLICK TASK BOX (IF PREVIOUS TASKS COMPLETED)
    document
      .querySelector("#task")
      .addEventListener("click", e => {

      //SHOW INTERACTIVE SCENARIO
      if (localStorage.getItem("tasksCompleted") >= "3") {
        document.querySelector('#computer').setAttribute('visible', 'true') 
        document.querySelector('#password').setAttribute('visible', 'true') 
        }
      });


    //NAVIGATE TO OTHER PAGES (LOCATIONS)
    document
      .querySelector("#g6")
      .addEventListener("click", e => {
        location.href = "g6.php";
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
    

  <script>
  //PROCESS KEYBOARD INPUT
  //Example sourced/adapted from https://wandererou.github.io/aframe-keyboard/ and https://wandererou.github.io/aframe-keyboard/examples/basic/index.html 
  //key codes - 06 is submit, 8 is delete, 13 is enter, 16 is shift, 18 is alt 

  var input = ''
  function updateInput(e) {
    var code = parseInt(e.detail.code)
    switch(code) { 
    /* 8 is the delete key which takes 1 off the input */
    case 8:
      input = input.slice(0, -1)
      break
    /*added in below clear button to set input to blank*/
    case 24:
      input = ''
      break
    /* 06 is the submit key */
    case 06:
      var keyboard = document.querySelector('#keyboard')
      document.querySelector('#input').setAttribute('value', input)
      //keyboard.parentNode.removeChild(keyboard)     //hides keyboard after pressing submit 

      //ADDED IN TO CHECK INPUTTED PASSWORD AGAINST DATABASE PASSWORD  
       if (db_password == input) {
          console.log('Login Successful')
          //alert('Login Successful')
          document.querySelector('#input').setAttribute('visible', 'false')             //hide input box 
          document.querySelector('#username').setAttribute('visible', 'false')  
          document.querySelector('#screen').setAttribute('src', screen_2_asset)         //change to QSIS screen 
          document.querySelector('#instructions').setAttribute('value', screen_2_text)  //update instructions 
          setTimeout(() => {
            document.querySelector('#classes').setAttribute('visible', 'true')          //show classes icon 
          }, 200); 
       } else {
          console.log('Incorrect Password')
          //alert('Incorrect Password. Please try again.')
          //Show error message for 5 seconds
          document.querySelector('#failed_login').setAttribute('visible', 'true')
          setTimeout(() => {
            document.querySelector('#failed_login').setAttribute('visible', 'false');
          }, 5000); 
       }
      return
    default:
      input = input + e.detail.value
      break
    }
    document.querySelector('#input').setAttribute('value', input) /*removed underscore*/
  }
  document.addEventListener('a-keyboard-update', updateInput)
  </script>


  <script>
  //SHOW SCREEN 3 WHEN CLICK CLASSES BOX 
      document
        .querySelector("#classes")
        .addEventListener("click", e => {
          document.querySelector('#classes').setAttribute('visible', 'false')           //hide classes icon 
          document.querySelector('#screen').setAttribute('src', screen_3_asset)         //change to timetable screen 
          document.querySelector('#instructions').setAttribute('value', screen_3_text)  //update instructions 
          setTimeout(() => {
            document.querySelector('#timetable').setAttribute('visible', 'true')        //show timetable icon 
            document.querySelector('#task2').setAttribute('visible', 'true')            //show next task box 
          }, 200);

          //MARK TASK AS COMPLETED (INCREASE JS LOCAL STORAGE VARIABLE)
          //Adapted from: https://stackoverflow.com/questions/27765666/passing-variable-through-javascript-from-one-html-page-to-another-page      
          if (localStorage.getItem("tasksCompleted") >= "4") {
          } else if (localStorage.getItem("tasksCompleted") == "3"){
            localStorage.setItem("tasksCompleted","4");
          }
          console.log("Tasks Completed: " + localStorage.getItem("tasksCompleted"));
      });
     
  </script>

</html>


<!-- ALL OF THE CODE FOR THE QUICK TOUR IS INCLUDED WITHIN THIS PAGE -->

<?php
//GET request to bring back asset information from database
$entity_ref = "sky"; //want to bring back the 360 background images/videos used as the sky for each location
$endpoint = "https://mmccloy04.webhosting5.eeecs.qub.ac.uk/api/assetsAPI.php?entity_ref=$entity_ref";
$resource = file_get_contents($endpoint);
$data = json_decode($resource, true);  

if ((sizeof($data) === 0)) {
    echo " <div class='uk-text-muted'>Error loading assets.</div>";
 } else {
    foreach ($data as $row) {
    //ASSIGNING ENTITY INFO TO DYNAMIC VARIABLES
    //Adapted/sourced from https://www.php.net/manual/en/language.variables.variable.php
    //ASSET FILEPATH
    $url = $row["ref"]."_asset";                  //setting variable name for dynamic variable e.g. o1_sky_asset, o4_sky_asset
    $$url = $row["file_path"];                    //asigning value to variable from current row of array
    $_POST[$$url] = $row["file_path"];    
    //ROTATION
    $rot = $row["ref"]."_rotation";           
    $$rot = $row["rotation"];                       
    $_POST[$$rot] = $row["rotation"];  
    //TEXT
    $rot = $row["ref"]."_text";           
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
    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>

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
    
    <!--HOTSPOT COMPONENTS
    Sourced/adapted from https://medium.com/detaux/how-to-create-a-virtual-tour-using-a-frame-164941fea573 -->    
    <script>
      AFRAME.registerComponent("hotspots", {
        init: function () {
          this.el.addEventListener("reloadspots", function (evt) {
            //get the entire current spot group and scale it to 0
            var currspotgroup = document.getElementById(evt.detail.currspots);
            currspotgroup.setAttribute("scale", "0 0 0");

            //get the entire new spot group and scale it to 1
            var newspotgroup = document.getElementById(evt.detail.newspots);
            newspotgroup.setAttribute("scale", "1 1 1");
          });
        },
      });
      AFRAME.registerComponent("spot", {
        schema: {
          linkto: { type: "string", default: "" },
          spotgroup: { type: "string", default: "" },
        },
        init: function () {
          //make the icon look at the camera all the time
          this.el.setAttribute("look-at", "#myCamera");

          var data = this.data;

          this.el.addEventListener("click", function () {
            //set the skybox source to the new image as per the spot
            var sky = document.getElementById("skybox");
            sky.setAttribute("src", data.linkto);

            var spotcomp = document.getElementById("spots");
            var currspots = this.parentElement.getAttribute("id");
            //create event for spots component to change the spots data
            spotcomp.emit("reloadspots", {
              newspots: data.spotgroup,
              currspots: currspots,
            });
          });
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
        <img id="hotspot" src="https://cdn.glitch.com/2087dfa6-bd02-4451-a189-36095a66f386%2Fup-arrow.png?1545397127546" crossorigin="anonymous"/>
        <img id="button" src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/liftbutton.png" crossorigin="anonymous"/>
        
        <!--360 IMAGE/VIDEOS FOR SKY FOR EACH LOCATION-->
        <img id="o1" src="<?php echo "$o1_sky_asset" ?>" rotation="<?php echo "$o1_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="g1" src="<?php echo "$g1_sky_asset" ?>" rotation="<?php echo "$g1_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="g3" src="<?php echo "$g3_sky_asset" ?>" rotation="<?php echo "$g3_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="g5" src="<?php echo "$g5_sky_asset" ?>" rotation="<?php echo "$g5_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="g6" src="<?php echo "$g6_sky_asset" ?>" rotation="<?php echo "$g6_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="c1" src="<?php echo "$c1_sky_asset" ?>" rotation="<?php echo "$c1_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="c2" src="<?php echo "$c2_sky_asset" ?>" rotation="<?php echo "$c2_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="f2" src="<?php echo "$f2_sky_asset" ?>" rotation="<?php echo "$f2_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="f3" src="<?php echo "$f3_sky_asset" ?>" rotation="<?php echo "$f3_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="q1" src="<?php echo "$q1_sky_asset" ?>" rotation="<?php echo "$q1_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="q4" src="<?php echo "$q4_sky_asset" ?>" rotation="<?php echo "$q4_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="q5" src="<?php echo "$q5_sky_asset" ?>" rotation="<?php echo "$q5_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="q6" src="<?php echo "$q6_sky_asset" ?>" rotation="<?php echo "$q6_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="s1" src="<?php echo "$s1_sky_asset" ?>" rotation="<?php echo "$s1_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="s2" src="<?php echo "$s2_sky_asset" ?>" rotation="<?php echo "$s2_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="s4" src="<?php echo "$s4_sky_asset" ?>" rotation="<?php echo "$s4_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="m1" src="<?php echo "$m1_sky_asset" ?>" rotation="<?php echo "$m1_sky_rotation" ?>" crossorigin="anonymous"/>
        <img id="m2" src="<?php echo "$m2_sky_asset" ?>" rotation="<?php echo "$m2_sky_rotation" ?>" crossorigin="anonymous"/>

        <video id="o4" src="<?php echo "$o4_sky_asset" ?>" rotation="<?php echo "$o4_sky_rotation" ?>" crossorigin="anonymous"
        onloadstart="this.playbackRate = 3;" autoplay="true" loop="true"></video>
        <video id="o5" src="<?php echo "$o5_sky_asset" ?>" rotation="<?php echo "$o5_sky_rotation" ?>" crossorigin="anonymous"
        onloadstart="this.playbackRate = 3;" autoplay="true" loop="true"></video>
        <video id="f1" src="<?php echo "$f1_sky_asset" ?>" rotation="<?php echo "$f1_sky_rotation" ?>" crossorigin="anonymous"
        onloadstart="this.playbackRate = 3;" autoplay="true" loop="true"></video>
        <video id="q2" src="<?php echo "$q2_sky_asset" ?>" rotation="<?php echo "$q2_sky_rotation" ?>" crossorigin="anonymous"
        onloadstart="this.playbackRate = 3;" autoplay="true" loop="true"></video>
        <video id="q3" src="<?php echo "$q3_sky_asset" ?>" rotation="<?php echo "$q3_sky_rotation" ?>" crossorigin="anonymous"
        onloadstart="this.playbackRate = 3;" autoplay="true" loop="true"></video>
        <video id="s3" src="<?php echo "$s3_sky_asset" ?>" rotation="<?php echo "$s3_sky_rotation" ?>" crossorigin="anonymous"
        onloadstart="this.playbackRate = 3;" autoplay="true" loop="true"></video>
        <video id="l1" src="<?php echo "$l1_sky_asset" ?>" rotation="<?php echo "$l1_sky_rotation" ?>" crossorigin="anonymous"
        onloadstart="this.playbackRate = 3;" autoplay="true" loop="true"></video>
        <video id="l4" src="<?php echo "$l4_sky_asset" ?>" rotation="<?php echo "$l4_sky_rotation" ?>" crossorigin="anonymous"
        onloadstart="this.playbackRate = 3;" autoplay="true" loop="true"></video>
        <video id="l7" src="<?php echo "$l7_sky_asset" ?>" rotation="<?php echo "$l7_sky_rotation" ?>" crossorigin="anonymous"
        onloadstart="this.playbackRate = 3;" autoplay="true" loop="true"></video>
      </a-assets>

      <!--CAMERA AND CONTROLS
      Both hands have controllers,adapted/sourced from https://aframe.io/docs/1.5.0/components/oculus-touch-controls.html 
      Left hand has laser/raycaster, adapted/sourced from https://aframe.io/docs/1.5.0/components/laser-controls.html-->
      <a-entity>
        <a-camera position="1 1 0" id="myCamera" 
          cursor="rayOrigin: mouse" 
          wasd-controls-enabled="false"
          raycaster="objects: a-plane, a-box, a-sphere, a-image, a-entity">
        </a-camera>
        <a-entity 
          oculus-touch-controls="hand: left" laser-controls="hand: left" 
          raycaster="objects: a-plane, a-box, a-sphere, a-image, a-entity"
          thumbstick-logging></a-entity> 
        <a-entity oculus-touch-controls="hand: right" thumbstick-logging></a-entity> 
      </a-entity>

      <!--SKY -->
      <a-sky id="skybox" src="#o1"></a-sky>
      
      <!--ENTITIES-->      
      <a-entity id="spots" hotspots="">
  
      
        <!--LOCATION o1-->
        <a-entity 
            id="group-o1" 
            position="" 
            rotation="" 
            scale="" 
            visible="">
          <a-image
            spot="linkto:#o4;spotgroup:group-o4"
            position="9 -1 0.4"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#g1;spotgroup:group-g1"
            position="-10 1 0.15"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>
        
        
        <!--LOCATION o4-->
        <a-entity
          id="group-o4"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#o1;spotgroup:group-o1"
            position="-8 2.3 -0.1"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#o5;spotgroup:group-o5"
            position="1.8 1 -10"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>

                
        <!--LOCATION o5--> 
        <a-entity
          id="group-o5"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#o4;spotgroup:group-o4"
            position="1.8 0.8 -10"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>


        <!--LOCATION g1--> 
        <a-entity
          id="group-g1"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#o1;spotgroup:group-o1"
            position="8.5 1 3"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#g3;spotgroup:group-g3"
            position="-10 0.7 1"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#g5;spotgroup:group-g5"
            position="-3.7 0.7 10"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>


        <!--LOCATION g3--> 
        <a-entity
          id="group-g3"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#g1;spotgroup:group-g1"
            position="14 0.7 1.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#g5;spotgroup:group-g5"
            position="8 0.7 15"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#g6;spotgroup:group-g6"
            position="-8 0.7 17.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#l1;spotgroup:group-l1"
            position="-9.5 0.7 14.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#m1;spotgroup:group-m1"
            position="-11 2.5 4.2"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>
        
        
        <!--LOCATION g5-->
        <a-entity
          id="group-g5"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#g1;spotgroup:group-g1"
            position="-9 0.7 3"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#g3;spotgroup:group-g3"
            position="-1 0.7 11"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#g6;spotgroup:group-g6"
            position="10 0.7 -4" 
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#l1;spotgroup:group-l1"
            position="10 0.7 3.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>


      <!--LOCATION g6-->
      <a-entity
          id="group-g6"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#g3;spotgroup:group-g3"
            position="-12 0.5 -1"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#g5;spotgroup:group-g5"
            position="-8 0.5 -10"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#l1;spotgroup:group-l1"
            position="-10 0.5 2"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#c1;spotgroup:group-c1"
            position="10 0.5 3"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#c2;spotgroup:group-c2"
            position="3.5 0.5 -9"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>
        
        
        <!--LOCATION c1--> 
        <a-entity
          id="group-c1"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#g6;spotgroup:group-g6"
            position="13 0.5 1.7"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>

                
        <!--LOCATION c2--> 
        <a-entity
          id="group-c2"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#g6;spotgroup:group-g6"
            position="-12 0.8 5.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>



      <!--LOCATION l1--> 
      <a-entity
          id="group-l1"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#l1;spotgroup:group-l1"
            position="1.5 -4 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#button"
            look-at="">
            <a-text font="kelsonsans" value="G" width="12" position="0 0 0.05" align="center" color="#3B3B3B"></a-text>
          </a-image>
          <a-image
            spot="linkto:#l4;spotgroup:group-l4"
            position="1.5 -2 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#button"
            look-at="">
            <a-text font="kelsonsans" value="1" width="12" position="0 0 0.05" align="center" color="#FFFFFF"></a-text>
          </a-image>
          <a-image
            spot="linkto:#l7;spotgroup:group-l7"
            position="1.5 0 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#button"
            look-at="">
            <a-text font="kelsonsans" value="2" width="12" position="0 0 0.05" align="center" color="#FFFFFF"></a-text>
          </a-image>
          <a-image
            spot="linkto:#g5;spotgroup:group-g5"
            position="-10 0.5 -0.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>

        
      <!--LOCATION l4--> 
      <a-entity
          id="group-l4"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#l1;spotgroup:group-l1"
            position="1 -4 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#button"
            look-at="">
            <a-text font="kelsonsans" value="G" width="12" position="0 0 0.05" align="center" color="#FFFFFF"></a-text>
          </a-image>
          <a-image
            spot="linkto:#l4;spotgroup:group-l4"
            position="1 -2 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#button"
            look-at="">
            <a-text font="kelsonsans" value="1" width="12" position="0 0 0.05" align="center" color="#3B3B3B"></a-text>
          </a-image>
          <a-image
            spot="linkto:#l7;spotgroup:group-l7"
            position="1 0 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#button"
            look-at="">
            <a-text font="kelsonsans" value="2" width="12" position="0 0 0.05" align="center" color="#FFFFFF"></a-text>
          </a-image>
          <a-image
            spot="linkto:#f3;spotgroup:group-f3"
            position="-10 0.5 -0.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>
        

        
      <!--LOCATION l7--> 
      <a-entity
          id="group-l7"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#l1;spotgroup:group-l1"
            position="1.5 -4 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#button"
            look-at="">
            <a-text font="kelsonsans" value="G" width="12" position="0 0 0.05" align="center" color="#FFFFFF"></a-text>
          </a-image>
          <a-image
            spot="linkto:#l4;spotgroup:group-l4"
            position="1.5 -2 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#button"
            look-at="">
            <a-text font="kelsonsans" value="1" width="12" position="0 0 0.05" align="center" color="#FFFFFF"></a-text>
          </a-image>
          <a-image
            spot="linkto:#l7;spotgroup:group-l7"
            position="1.5 0 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#button"
            look-at="">
            <a-text font="kelsonsans" value="2" width="12" position="0 0 0.05" align="center" color="#3B3B3B"></a-text>
          </a-image>
          <a-image    
            spot="linkto:#s3;spotgroup:group-s3"
            position="-10 0.5 -0.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>


        <!--LOCATION m1--> 
        <a-entity
          id="group-m1"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#f1;spotgroup:group-f1"
            position="-8 3 7.7"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#g3;spotgroup:group-g3"
            position="-12 -5.5 -0.7"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
      </a-entity>

      
        <!--LOCATION m2--> 
        <a-entity
          id="group-m2"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#s1;spotgroup:group-s1"
            position="-9.5 3 6.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#f1;spotgroup:group-f1"
            position="-12 -5.5 -3"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
      </a-entity>


         <!--LOCATION f1--> 
         <a-entity
          id="group-f1"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#m1;spotgroup:group-m1"
            position="14 -1.5 3"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        <a-image
            spot="linkto:#m2;spotgroup:group-m2"
            position="13 2.5 -4.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#f2;spotgroup:group-f2"
            position="-11 1.3 2"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#f3;spotgroup:group-f3"
            position="4 0.8 -13"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>


     <!--LOCATION f2--> 
     <a-entity
          id="group-f2"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#f1;spotgroup:group-f1"
            position="14 1.2 -1"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
      </a-entity>


     <!--LOCATION f3--> 
     <a-entity
          id="group-f3"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#q1;spotgroup:group-q1"
            position="-8.5 0.3 -7"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        <a-image
            spot="linkto:#f1;spotgroup:group-f1"
            position="12 0.8 5.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#l4;spotgroup:group-l4"
            position="7 0.5 -5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>


        
     <!--LOCATION q1--> 
     <a-entity
          id="group-q1"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#f3;spotgroup:group-f3"
            position="-10 0.5 -0.7"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#q2;spotgroup:group-q2"
            position="1.5 0 8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#q3;spotgroup:group-q3"
            position="13 0.6 0.9"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
      </a-entity>


     <!--LOCATION q2--> 
     <a-entity
          id="group-q2"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#q1;spotgroup:group-q1"
            position="-4.5 0 6.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
      </a-entity>


     <!--LOCATION q3--> 
     <a-entity
          id="group-q3"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#q1;spotgroup:group-q1"
            position="7.5 0.3 -10"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#q4;spotgroup:group-q4"
            position="0 0.7 10"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
      </a-entity>


      <!--LOCATION q4--> 
     <a-entity
          id="group-q4"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#q3;spotgroup:group-q3"
            position="-10 1 0"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#q5;spotgroup:group-q5"
            position="10 0 0.3"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
      </a-entity>


    <!--LOCATION q5--> 
     <a-entity
          id="group-q5"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#q4;spotgroup:group-q4"
            position="9 0 1.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#q6;spotgroup:group-q6"
            position="-7 -0.5 3.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
      </a-entity>


     <!--LOCATION q6--> 
     <a-entity
          id="group-q6"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
        <a-image
            spot="linkto:#q5;spotgroup:group-q5"
            position="3 0.3 9"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
      </a-entity>


       <!--LOCATION s1 -7 1 -5--> 
       <a-entity
          id="group-s1"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >   
          <a-image
            spot="linkto:#s3;spotgroup:group-s3"
            position="-9 0.7 -5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#m2;spotgroup:group-m2"
            position="10.5 0 -1.8"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>

                
        <!--LOCATION s2--> 
        <a-entity
          id="group-s2"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#s3;spotgroup:group-s3"
            position="9 0.7 -4.2"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>


         <!--LOCATION s3--> 
         <a-entity
          id="group-s3"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#s1;spotgroup:group-s1"
            position="10 0.7 0"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#s2;spotgroup:group-s2"
            position="4 0.7 10"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#l7;spotgroup:group-l7"
            position="3.2 0.7 -13"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
          <a-image
            spot="linkto:#s4;spotgroup:group-s4"
            position="-7.5 0.7 -1.3"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>

                
        <!--LOCATION s4--> 
        <a-entity
          id="group-s4"
          scale="0 0 0"
          position=""
          rotation=""
          visible=""
        >
          <a-image
            spot="linkto:#s3;spotgroup:group-s3"
            position="-10 0.7 7.5"
            rotation=""
            scale=""
            visible=""
            material=""
            geometry=""
            src="#hotspot"
            look-at=""
          ></a-image>
        </a-entity>


        
      </a-entity>

      
    </a-scene>
  </body>

    
  <script> 
  
  //USER ENTERS VR MODE
  //enter-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
  document.querySelector('a-scene').addEventListener('enter-vr', function () {
    console.log("entered vr mode");
  });
  
  
  //USER EXITS VR MODE
  //exit-vr functionality sourced from https://aframe.io/docs/0.5.0/core/scene.html#events
  document.querySelector('a-scene').addEventListener('exit-vr', function () {
    console.log("exited vr mode");
  });

  </script>
</html>



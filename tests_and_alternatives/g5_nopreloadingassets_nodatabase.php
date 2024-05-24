<!--USED TO COMPARE HARD CODING ASSETS (THIS PAGE) VS LOADING THEM FROM THE DATABASE (G5.PHP)-->

<!--JAVASCRIPT TO CHECK VALUES OF LOCAL STORAGE VARIABLES
Adapted from: https://stackoverflow.com/questions/27765666/passing-variable-through-javascript-from-one-html-page-to-another-page   -->
<script>
  console.log("Lift Disabled? " + localStorage.getItem("liftDisabled"));
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
        src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/g5.jpg"  
        rotation="0 -130 0" >
      </a-sky> 
      
      <!--SPHERES LINKING TO OTHER LOCATIONS -->
      
      <a-sphere id="g1" radius="1" 
        src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/g1.jpg"
        position="4 1.5 -12"  
        rotation="0 0 0" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="Reception" position="0 -1.4 0" ></a-text>
      </a-sphere>
  
      <a-sphere id="g3" radius="1" 
        src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/g3.jpg"
        position="-7 1.5 -8"  
        rotation="0 0 0" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="Ground Floor Foyer" position="0 -1.4 0" ></a-text>
      </a-sphere>
 
      <a-sphere id="g6" radius="1" 
        src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/g6.jpg"
        position="0.6 1.2 10"  
        rotation="0 0 0" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="This way to the\nComputer Lab and\nTechnician's Desk" position="0 -1.5 0" ></a-text>
      </a-sphere>

      <a-sphere id="lift" radius="1" 
      src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/lift.jpg"
        position="-10 1.4 6.2"  
        rotation="0 0 0" 
        event-set__enter="_event: mouseenter; scale: 1.2 1.2 1.2"
        event-set__leave="_event: mouseleave; scale: 1 1 1">
        <a-text id="liftText" font="kelsonsans" align="center" look-at="#myCamera" width="7" 
        value="Lift" position="0 -1.4 0" ></a-text>
      </a-sphere>

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
    

    //UPDATE LIFT TEXT TO INDICATE WHEN ITS DISABLED  
    if (localStorage.getItem("liftDisabled") == "true") {
    document.querySelector('#liftText').setAttribute('value', "Lift Disabled")
    }


    //LIFT LINK
    document
      .querySelector("#lift")
      .addEventListener("click", e => {
        //only enabled link if lift is not disabled
        if (localStorage.getItem("liftDisabled") == "false") {
      //location.href = "l0.php";   //link to main tour disabled as this is just a testing page 
        }
    });


    //NAVIGATE TO OTHER PAGES (LOCATIONS) 
      document
        .querySelector("#g1")
        .addEventListener("click", e => {
          //location.href = "g1.php";   //link to main tour disabled as this is just a testing page 
      });
      document
        .querySelector("#g3")
        .addEventListener("click", e => {
          //location.href = "g3.php";   //link to main tour disabled as this is just a testing page 
      }); 
      document
        .querySelector("#g6")
        .addEventListener("click", e => {
          //location.href = "g6.php";   //link to main tour disabled as this is just a testing page 
      });

  </script>
    
 
</html>

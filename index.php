<!--JAVASCRIPT TO SET INITIAL VALUES FOR LOCAL STORAGE VARIABLES 
Adapted from: https://stackoverflow.com/questions/27765666/passing-variable-through-javascript-from-one-html-page-to-another-page   -->
<script>
  localStorage.setItem("tasksCompleted", "0");
  console.log("Tasks Completed: " + localStorage.getItem("tasksCompleted"));
  localStorage.setItem("liftDisabled", "false");
  console.log("Lift Disabled? " + localStorage.getItem("liftDisabled"));
  localStorage.setItem("vrMode",false);
  console.log("VR Mode? " + localStorage.getItem("vrMode"));
</script>

<!--PHP TO GET ASSETS FROM DATABASE-->
<?php
//PATCH request to update page stats
$date = date_default_timezone_set("GMT");
$endpoint = "https://mmccloy04.webhosting5.eeecs.qub.ac.uk/api/statsAPI.php?updatestats";
$patchdata = http_build_query(
    array(
      'stats_ref' => "total_visits",
      'date_time' => date('y-m-d H:i:s') 
    )
);
$opts = array(
    'http' => array(
        'method' => 'PATCH',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $patchdata
    )
);
$context = stream_context_create($opts);
$resource = file_get_contents($endpoint, false, $context);


//Extract the location code from the page name 
$current_page = $_SERVER["SCRIPT_NAME"];
$location_code = substr(strtok($current_page, '.'), 1); //1 to remove slash before

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
    //Adapted/sourced from https://www.php.net/manual/en/language.variables.variable.php#:~:text=%24a%20%3D%20'hello'%3B,by%20using%20two%20dollar%20signs.
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
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EEECS VR Tour</title>
    <link rel="icon" href="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/qublogo.png" /> <!--Queens logo sourced from https://www.stickpng.com/img/icons-logos-emojis/russell-group-universities/queens-university-belfast-logo -->
    <!-- Links to UIkit CSS Framework and my own stylesheet-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/css/uikit.min.css" /> 
    <link href="./css/style.css" rel="stylesheet">
    <!-- UIkit JS, link to javascript files also required by the framework -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit-icons.min.js"></script>
</head>


<body>

    <!--HEADER-->
    <!-- Images sourced from: https://www.qub.ac.uk/schools/eeecs/ -->
    <div class="hide-mobile">
        <button class="btn--one uk-align-right uk-padding-remove" href="https://www.qub.ac.uk/schools/eeecs/">EEECS HOME</button>
        <div class="uk-section-1">
            <img src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/qubheader.png">
        </div>
     </div>
    <div class="hide-nonmobile">
        <div class="uk-section-1-mobile">
            <img src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/qubheader_mobile.jpg">
            <a class="btn--one uk-padding-remove" href="https://www.qub.ac.uk/schools/eeecs/">&nbsp;&nbsp;&nbsp;EEECS HOME</a>
        </div>
    </div>

    <!--MAIN CONTENT-->
    <div class="uk-section-2">
        <div class="uk-container">
            <div class="hide-mobile" id="hide-mobile"><h2 class="uk-heading-one">EEECS Virtual Tour</h2></div>
            <div class="hide-nonmobile" id="hide-nonmobile"><h2 class="uk-heading-one-mobile">EEECS Virtual Tour</h2></div>
            <b>This page tells you all you need to know to access the 360° Virtual Tour of the Computer Science Building at Queen's University Belfast.
            There are two versions of the tour - the Interactive Tour and the Quick Tour. You can access both of these tours on various devices including a desktop, laptop, mobile device or you can use a VR headset for a more immersive experience.
            Please see further information below.</b>


         <!-- GRID-->
        <div class="uk-container uk-margin-top">
            <div class="uk-grid-match uk-child-width-1@s uk-text-center" uk-grid>

            <!--INTERACTIVE TOUR-->
            <div>
                <div class='uk-card uk-card-default uk-card-hover'>
                    <div class='uk-card-header'>  
                        <div class="hide-mobile" id="hide-mobile"><h2 class="uk-heading-two">INTERACTIVE TOUR</h2></div>
                        <div class="hide-nonmobile" id="hide-nonmobile"><h2 class="uk-heading-two-mobile">INTERACTIVE TOUR</h2></div>
                    </div>
                    <div class='uk-card-body'>
                        The interactive tour includes audio and videos to enrich your experience as you travel through the Computer Science Building. To move between locations, simply click on the spheres. 
                        With the interactive tour, you can either navigate through the buiding freely, or select the task boxes to follow pre-defined user journey with various challenges to complete along the way.
                        Please note you wont be able to view the next task until you have completed all of the previous tasks, so if you choose this option, make sure to keep an eye out for the task boxes and complete each task fully! Your completed tasks will be reset to zero when you navigate back to this instructions page. 
                        Whichever option you choose, you will have to complete the first task to be able to enter the building.
                        <br>Throughout the tour you will see various icons, their functionality has been outlined below:<br><br>



                        <!--ICONS FOR THE INTERACTIVE TOUR-->
                        <div>
                            <div class="uk-grid-match uk-child-width-1-4@s uk-padding-remove" uk-grid>

                                <div>
                                    <div class="uk-card uk-card-body">
                                        <img src="<?php echo "$audio_info_asset" ?>" width="60px"><br><br>
                                        <?php echo "$audio_info_text" ?>
                                    </div>
                                </div>

                                <div>
                                    <div class="uk-card uk-card-body">
                                        <img src="<?php echo "$video_info_asset" ?>" width="60px"><br><br>
                                        <?php echo "$video_info_text" ?>
                                    </div>
                                </div>

                                <div>
                                    <div class="uk-card uk-card-body">
                                        <img src="<?php echo "$task_info_asset" ?>" width="62px"><br><br>
                                        <?php echo "$task_info_text" ?>         
                                    </div>
                                </div>

                                <div>
                                    <div class="uk-card uk-card-body">
                                        <img src="<?php echo "$exit_info_asset" ?>" width="62px"><br><br>
                                        <?php echo "$exit_info_text" ?>       
                                    </div>
                                </div>

                            </div>
                        </div>
            
            
                    </div>
                <div class='uk-card-footer'>
                    <a class="btn--one" href="/locations/o1.php">Start the Interactive Tour</a><br>
                </div>
            </div>
        </div>






            <!--QUICK TOUR-->
            <div>
                <div class='uk-card uk-card-default uk-card-hover'>
                    <div class='uk-card-header'>  
                        <div class="hide-mobile" id="hide-mobile"><h2 class="uk-heading-two">QUICK TOUR</h2></div>
                        <div class="hide-nonmobile" id="hide-nonmobile"><h2 class="uk-heading-two-mobile">QUICK TOUR</h2></div>
                    </div>
                    <div class='uk-card-body'>
                        There is also the option to do the Quick Tour - this does not have any of the additional functionality such as audio, videos and tasks, however it provides a quicker option for example if you just want to have a look around or are looking for a specific room. There is no pre-defined user journey for this tour, you can explore the building in any order you like.<br><br>
                    
                        <!--ICON FOR THE QUICK TOUR-->
                        <div>
                            <div class="uk-grid-match uk-child-width-1-3@s uk-padding-remove" uk-grid>
                                <div>
                                    <div class="uk-card uk-card-body">
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-card uk-card-body">
                                        <img src="<?php echo "$hotspot_info_asset" ?>" width="60px"><br><br>
                                        <?php echo "  $hotspot_info_text" ?> 
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-card uk-card-body">        
                                    </div>
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <div class='uk-card-footer'>
                        <a class="btn--one" href="/hotspot.php">Start the Quick Tour</a>
                    </div>
                </div>
            </div>



            <!--DEVICES AND NAVIGATION-->
            <!--Toggle functionality sourced/adapted from https://getuikit.com/v2/docs/toggle.html and https://stackoverflow.com/questions/51923969/uikit-toggle-element-to-be-hidden-by-default -->
            <div>
                <div class='uk-card uk-card-default uk-card-hover'>
                    <div class='uk-card-header'>  
                        <div class="hide-mobile" id="hide-mobile"><h2 class="uk-heading-two">DEVICES & NAVIGATION</h2></div>
                        <div class="hide-nonmobile" id="hide-nonmobile"><h2 class="uk-heading-two-mobile">DEVICES & NAVIGATION</h2></div>
                    </div>
                    <div class='uk-card-body'>
                    Click on the headings below to learn more about navigation on different types of devices.<br><br>
 
                        <div>
                            <div class="uk-grid-match uk-child-width-1-3@s" uk-grid>
                                <div>
                                    <div class='uk-card'>
                                        <div class='uk-card-header'> 
                                            <a href="#toggle-animation1" class="btn--one" uk-toggle="target: #toggle-animation1; cls: uk-hidden">Desktops and Laptops</a><br>
                                        </div>
                                        <div class='uk-card-body'>
                                            <!-- Image sourced from: https://www.freepik.com/premium-ai-image/laptop-with-red-background-purple-screen-that-says-samsung-it_46782166.htm -->
                                            <img src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/laptop.jpg" class="uk-height-medium">
                                        </div>
                                        <div class="uk-card-footer">
                                            <div class="uk-hidden" id="toggle-animation1">
                                            Look around by scrolling with your mouse or trackpad. To hover over an item, place the cursor over the object. To click, please do so using your mouse or trackpad.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class='uk-card'>
                                        <div class='uk-card-header'> 
                                            <a href="#toggle-animation2" class="btn--one" uk-toggle="target: #toggle-animation2; cls: uk-hidden">Mobile Devices</a><br>
                                        </div>
                                        <div class='uk-card-body'>
                                            <!-- Image sourced/adapted from: https://www.freepik.com/free-photo/modern-office-desk-composition-with-technological-device_3387617.htm#fromView=search&page=1&position=1&uuid=0f3b19a8-953e-4fa2-a06e-676f78f6b7f1 -->
                                            <img src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/phonetablet.jpg" class="uk-height-medium">
                                        </div>
                                        <div class="uk-card-footer">
                                            <div class="uk-hidden" id="toggle-animation2">
                                            When using a mobile device such as a phone or tablet, you can look around by physically moving the device to point it in different directions (this works best standing up). Alternatively, you can look in different directions by scrolling your finger on the screen.
                                            Your device will simulate the VR experience, for example if you laid your device down on the table it would point up at the ceiling in the VR experience. It is therefore recommended to have your device upright during the tour.
                                            Note that navigation on mobile touchscreen devices is done using finger controls, rather than a mouse for example. When asked to hover, hold your finger down over the item. When asked to click, press your finger down on the item and release it whilst it is still over the item.                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class='uk-card'>
                                        <div class='uk-card-header'> 
                                            <a href="#toggle-animation3" class="btn--one" uk-toggle="target: #toggle-animation3; cls: uk-hidden">VR Headsets</a><br>
                                        </div>
                                        <div class='uk-card-body'>
                                            <!-- Image sourced from: https://www.shutterstock.com/image-photo/young-woman-using-virtual-reality-viewer-2141754123 -->
                                            <img src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/vrheadset.jpg" class="uk-height-medium">
                                        </div>
                                        <div class="uk-card-footer">
                                            <div class="uk-hidden" id="toggle-animation3">
                                            After you have selected the button to start the tour, please select the "VR" icon in the bottom right of the screen to enter VR mode.
                                            Once in the experience, you can look around simply by turning your head in different directions. To interact with the experience, you will primarily need to use your left hand which is accompanied by a laser to aid you clicking on items. To hover over an item, you can simply direct the laser over it. To click, you will need to direct the laser of the item whilst also pulling the trigger on the left controller.
                                            For the interactive tour, your right controller will appear as a hand in the experience. This can be used for additional functionality such as to grab items. You will be prompted when to use your right controller.
                                            If the VR experience crashes during your tour, you can exit out of VR mode at any point by selecting the home button on your controller. For example, on the Meta Quest 2, the 'Oculus Home' button is on the right controller, denoted by the Oculus symbol. It is recommended to then refresh the page in the browser before re-entering VR mode.                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
                


            </div>
        </div>
    </div>


    <!--FOOTER-->
    <!-- Images sourced from: https://www.qub.ac.uk/schools/eeecs/ 
    <div class="hide-mobile">
        <div class="uk-section-3"><img src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/qubfooter3.png" class="uk-height-small"></div>
    </div>
    <div class="hide-nonmobile">
        <div class="uk-section-3-mobile"><img src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/qubfooter3.png" class="uk-height-small"></div>
    </div>
-->


    <div class="uk-section-3">
        <img src="https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/qubfooter.png" class="uk-height-small">
        <p class="uk-align-right">Queen's University Belfast 2024</p>
    </div>

</body>

</html>




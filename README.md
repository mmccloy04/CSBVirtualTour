Author: Michaela McCloy
Last updated: 24 May 2024

## This README.md document provides an overview of this project and how its been built.

The implemented system consists of two VR tours of the Computer Science Building at Queens University Belfast, namely the Quick Tour and the Interactive Tour, which can be accessed at the following link: https://mmccloy04.webhosting5.eeecs.qub.ac.uk/

Both tours have been built in A-Frame, a web framework for building up VR experiences through a combination of html entities and javascript libraries, and enable users to move through different locations, made up of 360-degree images or videos. The Interactive tour has more functionality and interactivity, with the option for users to complete interactive tasks, and play videos and audio. The Interactive Tour has a separate web page for each location and for the linked videos. In contrast, the Quick Tour offers a simpler option, users can still move between different locations but there is no additional functionality. All of the code for this tour is included in one file. 

 A summary of the code folders and files is provided below:

← `index.html`: This is the initial landing page for the site. It provides users with key information about the tours, including the various icons and how to navihgate on different devices. This webpage is styled using CSS, utilising the mystyle.css stylesheet. There are buttons on the index page which link to hotspot.php (the Quick Tour), and o1.php within the locations folder (the start of the Interactive Tour).

← `hotspot.php`: This file contains all of the code for the Quick Tour, which has been built using hotspots. There is a separate entity for each location. Each location (entity) has an associated 360-degree image or video as the background, as well as associated spots which users can click on to navigate between locations. The names of entities within the hotspot.php file correspond to the location codes, for example o1 is the location code for outside the front of the CSB. 

← `locations`: This folder contains the different locations pages for the Interactive Tour. The names of the pages correspond to the location codes. As a minimum, each of these pages has a 360-degree image or video as the background and at least one sphere, with these spheres allowing users to navigate between locations (pages). Some pages are more complex than others, for example:
← o1.php, g1.php, c1.php, c2.php, s4.php, q1.php, q2.php and o5.php all contain interactive tasks, with task box entities for these.
← c2.php, s4.php and q2.php contain box entities with audio icons that the user can click and hold down to play the associated audio clips. 
← g1.php, g3.php, and o1.php contain box entities with video icons, when users click on these they will be re-directed to a separate videos page.
All of the pages in the locations folder are currently used within the Inteactive Tour.

← `videos`: The videos folder contains pages for the linked videos in the Interactive Tour (ie the pages that users are re-directed to when they click on the video icons). There are currently three pages namely g1_video.php, g3_video.php and o1_video.php for the three linked videos in the Interactive Tour. These show: how to exit the building out of hours, the ground floor foyer when it is busy and students coming out of the building. Users are re-directed back to the relevant locations page once the video has finished. All of the pages in the videos folder are currently used within the Inteactive Tour.

← `assets`: The assets folder contains assets for the tours, broken up into four subfolders. `assets/locations` contains 360° images and/or short 360° videos used as the background for each location. `assets/videos` contains longer videos which aren’t used as a location background but instead show a particular task, process or action, for example the lift moving between floors. `assets/images` includes all non 360° images which are used within the tour, including images for the audio, video, task and exit icons, and images used in the interactive scenarios such as images of the computer screen used in the computer lab (c2.php). `assets/audio` contains audio files used within the tour, this includes the audio clips played when holding down the audio icon (used within c2.php, q2.php and s4.php) and the click sound used in c1.php. Not all of the assets within the assets folder are currently used within the tours.

← `css`: The css folder contains two CSS files, mystyle.css for styling the index page and style.css for styling the pages in the VR tours. 

← `js`: The js folder contains javascript code, this is primarily code which has been re-used from other authors and this has been sourced appropriately. Files within this folder are linked to within the relevant locations pages. For example, the physics system and force-pushable components are used in q1.php and the keyboard is used in c2.php. There is also javaScript code for each location at the bottom of the pages within the locations folder. 

← `api`: This is a separate folder for API implementation and consists of a file for the database connection object (dbconn.php) as well as files for the different API calls, outlined below. Within these files, REST API verbs have been used to read (GET) and update (PATCH) records from the back-end database, with the database queried using SQL.
← userAPI: A constrained GET request is used to return login details from the users table for a given user id. 
← assetsAPI: A constrained GET request is used to bring back asset information for a given location code or entity reference.
← locationGroupAPI: A constrained GET request is used to bring back the location group (e.g. “First Floor”) for a given location code.
← statsAPI: A PATCH request is used to update the website_stats table, specifically increasing the count column by 1 and updating the last_updated value to the current date and time. This request is performed for a given stats_ref value. Currently, this is implemented to update the row for “total_visits” each time a user visits index.php. 

← `sql`: The sql folder contains an export of the SQL database within the mmccloy04.sql file. 

← `tests_and_alternatives` and `lift_alternatives`: These folders contain alternative pages and pages used for testing; it was decided to separate out the lift files into the lift_alternatives folder, given there were numerous files of which some inter-relate. None of the pages within these folders are currently used within the tours - some were originally part of the tours but were replaced and moved to these folders following testing, whilst others were specifically created for testing purposes. Please note that sphere links have been disabled within these pages to separate them from the main tour.

The code has been clearly commented throughout and links have been included to indicate where any work from other authors has been sourced/adapted from.

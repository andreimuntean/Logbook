<?php
include 'inc/user.inc.php';
session_start();

  if(!isset($_SESSION['user'])){
    header("Location: index.php");
    die();
  }else{
    $user = unserialize($_SESSION['user']);
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>MyLogbook</title>
  <meta charset="UTF-8">
  <meta name="description" content="Landing Page">
  <meta name="keywords" content="landing, homepage">
  <meta name="author" content="Pranav Bahuguna">
  <link href="css/style.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="js/notify.min.js"></script>
  <script src="js/scripts.js"></script>
</head>

<body style="height:100vh">

  <div class="contentContainer">
    <div class="header">
      <h2 style="float:left; margin-top:9px">
        <span style="color:#43BE64; font-weight:bold">My</span>Logbook
      </h2>
      <input class="searchBar" placeholder="Search MyLogbook" size="40">
      <img id="logoutButton" class="navbarIconRight" src="assets/logbook-page/placeholder-icon-green.jpg">
      <img class="navbarIconRight" src="assets/logbook-page/placeholder-icon-green.jpg">
      <img class="navbarIconRight" src="assets/logbook-page/placeholder-icon-green.jpg">
      <h3 style="float:right; margin-right:10px; margin-top:20px; color:#EEF3F8; font-size:13px"><?php echo $user->getUsername();?></h3>
      <img class="navbarProfilePic" src="assets/logbook-page/profile-pic.png">
    </div>
  </div>

  <div class="overallContainer" style="background-color:#2d3239;
    height:calc(100% - 115px); padding: 5px 0 5px 0">
    <div class="contentContainer" style="height:100%; padding:0">

      <div class="logbookSelectionPane" id="logbookSelectionPane"
        style="float:left; height:100%">

        <div class="logbookContainer">
          <button type="button" class="logbookButton" id="createLogbookButton"
            onclick="toggleLogbookSettings(true); createNewLogbook = true;">New Logbook...
          </button>
        </div>

      </div>

      <div class="logbookEditor" style="float:right; height:100%">

        <div id="logbookEditorSpace" style="min-height:calc(100% - 85px)"></div>

        <button type="button" class="logbookButton"
          id="createLogbookEntryButton" onClick="createLogbookEntry()">
          New Logbook Entry...</button>

      </div>

    </div>
  </div>

  <div class="contentContainer" align="center">
    <p class="verySmall" style="margin-top:2px; margin-bottom:2px;">&copy;
      2015 Z5 | <a>Terms</a> <a>Privacy</a> <a>About</a>
    </p>
  </div>

  <!-- These divs contain the logbook settings popup and opacity blanket. They
       are not visible until a new logbook is created. -->
  <div class="blanket", id="blanket", style="display:none"></div>
  <div class="popUp", id="settings", style="display:none; top:calc(25% - 100px); left:calc(50% - 250px)">

    <div style="height:40px; line-height:40px; padding-top:10px; padding-bottom:10px">

      <h2 style="float:left">Settings</h2>
      <button class="closeButton" type="button" style="background-color: #E2E2E2"
        onClick="toggleLogbookSettings(false)">
      </button>

    </div>

    <div style="height:300px">

      <div style="height:300px; width:200px; float:left">

        <p class="large">Name</p>
        <p class="large">Visibility</p>
        <p class="large">Group logbook</p>
        <h3 style="font-size:28px; margin-top:0.66em">General info:</h2>
        <div style="margin-left:20px">
          <p class="large">Created on: </p>
          <p class="large">Last updated: </p>
          <p class="large">Entries: </p>
        </div>

      </div>

      <div style="height:300px; width:300px; float:right;">

        <form>
          <input style="height:28px; margin-top:5px; margin-bottom:9px;
            padding-left:8px; font-size:16px" placeholder="LogbookName" size=34>
          <select style="font-size:18px; margin-bottom:16px">
            <option value="public">Public</option>
            <option value="private">Private</option>
          </select>
          <br>
          <input type="checkbox" style="height:18px; width:18px; margin:0"
            value="group">
        </form>

      </div>

    </div>

    <div style="height:34px; width:500px; padding-top:8px; padding-bottom:10px; position:relative; bottom:0px">

      <button class="navbarButton1 redGradient" style="float:left; margin:0" onclick=
        "toggleLogbookSettings(false)">Cancel</button>
      <button class="navbarButton1 greenGradient", style="float:right; margin:0" onclick=
        "saveLogbookSettings();">Save</button>

    </div>

  </div>

</body>

</html>

<?php
  include 'inc/db.inc.php';
  include 'inc/user.inc.php';
  include 'inc/logbook.inc.php';

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
  <meta name="description" content="Logbook Page">
  <meta name="keywords" content="logbook, editor">
  <meta name="author" content="Z5">
  <link href="css/style.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="js/notify.min.js"></script>
  <script language="JavaScript" src="js/scripts.js"></script>
  <script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="js/nicescroll.min.js"></script>
  <script type="text/javascript">
  tinyMCE.init({
    mode: "none",
    theme : "simple"
  });
  </script>
</head>

<body style="height:100vh">

  <div class="contentContainer">
    <div class="header">

      <h2 style="float:left; margin-top:9px">
        <span style="color:#43BE64; font-weight:bold">My</span>Logbook</h2>
      <input class="searchBar" placeholder="Search MyLogbook" size="40">
      <button type="button" class="navbarButton1 greenGradient" id ="sign-out-button">Sign Out</button>
      <h3 style="float:right; margin-right:10px; margin-top:20px; color:#EEF3F8; font-size:16px"><b><?php echo $user->getUsername();?></b></h3>
      <?php
      	if($user->getProfilePic()==""){
      ?>
      <img class="navbarProfilePic" src="assets/logbook-page/profile-pic.png" onclick="togglePopUp(true, 'profileSettings')">

      <?php
      	}else{
      ?>
      	<img class="navbarProfilePic" src="assets/profile-pics/<?php echo $user->getProfilePic(); ?>" onclick="togglePopUp(true, 'profileSettings')">
      <?php
      	}
      ?>

    </div>
  </div>

  <div class="overallContainer" style="background-color:#2d3239;
    height:calc(100% - 115px); padding: 5px 0 5px 0">
    <div class="contentContainer" style="height:100%; padding:0">

      <div class="logbookSelectionPane" id="logbookSelectionPane"
        style="float:left; height:100%">

        <div class="logbookContainer">
          <button type="button" class="logbookButton"
            id="createLogbookButton" onclick="togglePopUp(true, 'settings');
            createNewLogbook = true;">New Logbook...
          </button>
        </div>

<?php
	// displaying logbooks
	$db = DB::getInstance();
	$userID = $user->getID();
	foreach ($db->query("SELECT * FROM `accesses` WHERE `user_id` = $userID") as $row) {
    $logbook = new Logbook($row['logbook_id']);
    echo "<script>createLogbook('".$logbook->name."', '".$logbook->id."')</script>";
  }
?>

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
      2015 Z5 | <a href="terms.php">Terms</a> <a href="faq.php">FAQ</a>
      <a href="about.php">About</a>
    </p>
  </div>

  <!-- These divs contain the logbook settings popup and opacity blanket. They
       are not visible until a new logbook is created. -->
  <div class="blanket", id="blanket"></div>

  <!-- Logbook settings popup -->
  <div class="popUp", id="settings">

    <div style="height:40px; line-height:40px; padding-top:10px; padding-bottom:10px">

      <h2 style="float:left">Settings</h2>
      <button class="closeButton" type="button" style="background-color: #E2E2E2"
        onClick="togglePopUp(false, 'settings')">
      </button>

    </div>

    <div style="width:480px; font-size:16px">

      <form>

        <div>
          <label for="logbookName" style="width:120px"><b>Name</b></label>
          <input id='logbookName' style="height:28px; padding-left:8px;
            margin-left:10px; font-size:16px" size=30>
        </div>

        <div>
          <label for="visibility" style="width:120px"><b>Visibility</b></label>
          <select id='visibility' style="font-size:16px; margin-left:10px;">
            <option value="0">Public</option>
            <option value="1">Private</option>
          </select>
        </div>

      </form>

    </div>

    <div style="height:40px; line-height:40px; padding-top:10px; padding-bottom:10px">

      <h3 style="float:left">General info</h3>

    </div>

    <div style="font-size:16px">

      <div>
        <label for="createdOn" style="width:120px"><b>Created on</b></label>
        <p id='createdOn' style="margin-left:10px"></p>
      </div>

      <div>
        <label for="lastUpdated" style="width:120px"><b>Last updated</b></label>
        <p id='lastUpdated' style="margin-left:10px"></p>
      </div>

      <div>
        <label for="entryNum" style="width:120px"><b>Entries</b></label>
        <p id='entryNum' style="margin-left:10px"></p>
      </div>

      <div>
        <label for="logbookUsers" style="width:120px"><b>Users</b></label>
        <p id='logbookUsers' style="margin-left:10px"></p>
      </div>

    </div>

    <div style="height:34px; width:500px; padding-top:8px; padding-bottom:10px; position:relative; bottom:0px">

      <button class="navbarButton1 redGradient" style="float:left; margin:0"
        onclick="deleteLogbook()">Delete</button>
      <button class="navbarButton1 greenGradient", style="float:right; margin:0"
        onclick="saveLogbookSettings()">Save</button>

    </div>

  </div>

  <!-- Profile settings popup -->
  <div class="popUp", id="profileSettings">

    <div style="height:40px; line-height:40px; padding-top:10px; padding-bottom:10px">

      <h2 style="float:left">Profile Settings</h2>
      <button class="closeButton" type="button" style="background-color: #E2E2E2"
        onClick="togglePopUp(false, 'profileSettings')">
      </button>

    </div>

    <div style="width:500px; font-size:16px">

      <form id="profileSettingsForm" enctype="multipart/form-data">

        <div>
          <label for="profilePicturePreview" style="width:100px"><b>Picture</b></label>
          <img id='profilePicturePreview' style="margin-bottom:18px; vertical-align:top;
            position:relative; left:calc(50% - 165px); height:120px; width:120px"
            src=" 
    <?php
      	if($user->getProfilePic()==""){
      
      echo "assets/logbook-page/profile-pic.png";

	}else{
		echo 'assets/profile-pics/'.$user->getProfilePic();
	}
?>
      ">
        </div>

        <div style="height:52px">
          <input type="file" id="upload-profile-pic" name="image" style=
	          "visibility:hidden; width:1px; height:1px">
          <button type="button" class="greyGradient" style="margin:0 0 18px 0;
            padding:0; position:relative; left:calc(50% - 65px); width:120px"
            onclick="document.getElementById('upload-profile-pic').click();
            return false" id="profile-pic-button">Change profile picture</button>
        </div>

        <div>
          <label for="profileName" style="width:100px"><b>Username</b></label>
          <input id='profileName' disabled value="<?php echo $user->getUsername();?>" style="height:28px; padding-left:8px; 
            margin-left:10px; font-size:16px" size=30>
        </div>

        <div>
          <label for="profileEmail" style="width:100px"><b>Email</b></label>
          <input id='profileEmail' disabled value="<?php echo $user->getEmail();?>" style="height:28px; padding-left:8px;
            margin-left:10px; font-size:16px" size=30>
        </div>

        <div>
          <label for="profilePassword" style="width:100px"><b>Password</b></label>
          <input type='password' id='profilePassword' style="height:28px; padding-left:8px;
            margin-left:10px; font-size:16px" size=30>
        </div>

    </div>

    <div style="height:34px; width:500px; padding-top:8px; padding-bottom:10px; position:relative; bottom:0px">

      <button class="navbarButton1 redGradient" style="float:left; margin:0"
        onclick="togglePopUp(false, 'profileSettings')">Cancel</button>
      <button id ="saveButton" class="navbarButton1 greenGradient", style="float:right; margin:0"
        onclick="togglePopUp(false, 'profileSettings')">Save</button>

    </div>

  </div>

</body>

</html>

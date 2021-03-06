<?php
include 'inc/db.inc.php';
include 'inc/user.inc.php';
include 'inc/logbook.inc.php';
session_start();
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
</head>

<body style="height:100vh">

  <div class="contentContainer">
   
    <div class="header">
<?php 
if(isset($_SESSION['user']))
{
  $user = unserialize($_SESSION['user']);

?>
      <h2 style="float:left; margin-top:9px">
      <a href='home.php'> <span style="font-weight:bold">My</span><span style="color:#9B9EA2 !important;">Logbook</span></a></h2>
      <input class="searchBar" placeholder="Search MyLogbook" size="40">
      <button type="button" class="navbarButton1 greenGradient" id ="sign-out-button">Sign Out</button>
      <h3 style="float:right; margin-right:10px; margin-top:20px; color:#EEF3F8; font-size:16px"><b><?php echo $user->getUsername();?></b></h3>
      <img class="navbarProfilePic" src="assets/logbook-page/profile-pic.png" onclick="togglePopUp(true, 'profileSettings')">
<?php }else{?>
<h2 style="float:left; margin-top:9px">
        <span style="color:#43BE64; font-weight:bold">My</span>Logbook</h2>
      <input class="searchBar" placeholder="Search MyLogbook" size="40">
      <button type="button" class="navbarButton1 greenGradient" id ="sign-out-button">Sign Out</button>
      <h3 style="float:right; margin-right:10px; margin-top:20px; color:#EEF3F8; font-size:16px"><b><?php echo $user->getUsername();?></b></h3>
      <img class="navbarProfilePic" src="assets/logbook-page/profile-pic.png" onclick="togglePopUp(true, 'profileSettings')">

<?php }?>

    </div>
  </div>

  <div class="overallContainer" style="background-color:#2d3239;
    height:calc(100% - 115px); padding: 5px 0 5px 0">
    <div class="contentContainer" style="height:100%; padding:0">

      <div class="logbookSelectionPane" id="logbookSelectionPane"
        style="float:left; height:100%">

<?php
	// displaying logbooks
	$db = DB::getInstance();
  if(isset($_GET['user'])){
  	$userID = $_GET['user'];
    if(User::userExists($userID)){
  	  foreach ($db->query("SELECT * FROM `logbooks` WHERE `user_id` = $userID AND `privacy` = 0") as $row) {
  		  echo "<script>createLogbook('".$row['name']."', ".$row['id'].")</script>";
      }
    }
    else{
      echo "<script>$.notify('Something wrong with the user...', 'warn');</script>";
    }
  }
  elseif(isset($_GET['logbook'])){
    $logbookID = $_GET['logbook'];
    if(Logbook::logbookExists($logbookID)){
      $logbook = new Logbook($logbookID);
      if($logbook->isPublic()){
        echo "<script>createLogbook('".$logbook->name."', ".$logbookID."); jQuery(document).ready(function(){jQuery('.logbookButton').click()})</script>";
      }else{
        echo "<script>$.notify('Something wrong with the logbook...', 'warn');</script>";
      }
    }else{
      echo "<script>$.notify('Something wrong with this logbook...', 'warn'); console.log('".$logbookID."');</script>";
    }
  }
  else{
    header("Location: index.php");
    die();
  }


?>

      </div>

      <div class="logbookEditor" style="float:right; height:100%">

        <div id="logbookEditorSpace" style="min-height:calc(100% - 85px)"></div>

       

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

      <form>

        <div>
          <label for="profilePicture" style="width:100px"><b>Picture</b></label>
          <img id='profilePicture' style="margin-bottom:18px; vertical-align:top;
            position:relative; left:calc(50% - 165px); height:120px; width:120px"
            src="assets/logbook-page/profile-pic.png">
        </div>

        <div style="height:52px">
          <button type="button" class="greyGradient" style="margin:0 0 18px 0;
            padding:0; position:relative; left:calc(50% - 60px); width:120px"
            id="profile-pic-button">Change profile picture</button>
        </div>

        <div>
          <label for="profileName" style="width:100px"><b>Username</b></label>
          <input id='profileName' style="height:28px; padding-left:8px;
            margin-left:10px; font-size:16px" size=30>
        </div>

        <div>
          <label for="profileEmail" style="width:100px"><b>Email</b></label>
          <input id='profileEmail' style="height:28px; padding-left:8px;
            margin-left:10px; font-size:16px" size=30>
        </div>

        <div>
          <label for="profilePassword" style="width:100px"><b>Password</b></label>
          <input id='profilePassword' style="height:28px; padding-left:8px;
            margin-left:10px; font-size:16px" size=30>
        </div>

    </div>

    <div style="height:34px; width:500px; padding-top:8px; padding-bottom:10px; position:relative; bottom:0px">

      <button class="navbarButton1 redGradient" style="float:left; margin:0"
        onclick="togglePopUp(false, 'profileSettings')">Cancel</button>
      <button class="navbarButton1 greenGradient", style="float:right; margin:0"
        onclick="togglePopUp(false, 'profileSettings')">Save</button>

    </div>

  </div>

 //signin
  <div class="popUp", id="signIn">

    <div style="height:40px; line-height:40px; padding-top:10px; padding-bottom:10px">

      <h2 style="float:left">Sign in</h2>
      <button class="closeButton" type="button" style="background-color: #E2E2E2"
        onClick="togglePopUp(false, 'signIn')">
      </button>

    </div>

    <div style="height:88px; width:480px; font-size:16px">

      <form>

        <div class="form">
          <label for="username" style="width:100px"><b>Username</b></label>
          <input style="height:28px; padding-left:8px; margin-left:10px;
            font-size:16px" id="sign-in-username" size=30>
        </div>

        <div class="form">
          <label for="password" style="width:100px"><b>Password</b></label>
          <input type="password" style="height:28px; padding-left:8px; margin-left:10px;
            font-size:16px" id="sign-in-password" size=30>
        </div>

      </form>

    </div>

    <div style="height:34px; width:500px; padding-top:8px; padding-bottom:10px; position:relative; bottom:0px">

      <button class="navbarButton1 redGradient" style="float:left; margin:0"
        onclick="togglePopUp(false, 'signIn')">Cancel</button>
      <button class="navbarButton1 greenGradient", id = "sign-in-button" style="float:right; margin:0"
        >Sign in</button>

    </div>

  </div>
<script>
$(document).ajaxStop(function(){
  $(".editButton").hide();
})
  
</script>
</body>

</html>

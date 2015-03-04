<?php
  session_start();
  if(isset($_SESSION['user'])){
    header("Location: home.php");
    die();
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

<body>

  <div class="contentContainer">
    <div class="header">
      <h2 style="float:left; margin-top:9px">
        <span style="color:#43BE64; font-weight:bold">My</span>Logbook
      </h2>
      <input class="searchBar" placeholder="Search MyLogbook" size="40">
      <button type="button" class="navbarButton1 greyGradient">Sign In</button>
    </div>
  </div>

  <div class="overallContainer" style="background-color:#2d3239; height:390px">
    <div class="contentContainer">

      <div class="bigThing" style="width:600px; float:left">
        <h1 style="color:#EEF3F8">Lorem ipsum dolor sit amet.</h1>
        <p>Wot the fok did ye just say 2 me m8? i dropped out of newcastle
          primary skool im the sickest bloke ull ever meet & ive nicked ova 300
          chocolate globbernaughts frum tha corner shop. im trained in street
          fitin' & im the strongest foker in tha entire newcastle gym.</p>
      </div>

      <div class="bigThing" style="width:350px; float:right">
        <form action = "inc/register.php" method='post'>
          <input required type = "text" name = "username" class="signUp" placeholder="Username" size=35>
          <input required type = "text" name = "email" class="signUp" placeholder="Email" size=35>
          <input required type = "password" name = "password" class="signUp" placeholder="Password" size=35>
          <button type="button" id="signUpButton" style="margin-bottom:10px"
            class="greenGradient">Sign up for MyLogbook</button>
        </form>
        <p class="verySmall">By clicking "Sign up for MyLogbook", you
          agree to our <a>terms of service</a> and <a>privacy policy</a>.</p>
      </div>

    </div>
  </div>

  <div class="contentContainer" style="height:800px" align="center">

    <div class="bigThing">
      <h2>Why you'll love MyLogbook.</h2>
      <p>Something something pootis pootis pootis</p>
    </div>

    <div class="contentContainer-90">
      <div class="bigThing" style="height:800px">

        <div class="advert" style="float:left">
          <img src="assets/landing-page/spurdo_face.png"
            style="width:137px; height:105px; margin-top:10px">
          <h3>Lorem ipsum dolor sit amet</h3>
          <p class="small">Flip floppity wib wab gensheru alaris sydomir padp
            amsa mfpomva pqmena xzmncan knaosjfna kjsanfojka snuais</p>
        </div>

        <div class="advert" style="float:right">
          <img src="assets/landing-page/spurdo_face.png"
            style="width:137px; height:105px; margin-top:10px">
          <h3>Lorem ipsum dolor sit amet</h3>
          <p class="small">Flip floppity wib wab gensheru alaris sydomir padp
            amsa mfpomva pqmena xzmncan knaosjfna kjsanfojka snuais</p>
        </div>

        <div class="advert" style="float:left">
          <img src="assets/landing-page/spurdo_face.png"
            style="width:137px; height:105px; margin-top:10px">
          <h3>Lorem ipsum dolor sit amet</h3>
          <p class="small">Flip floppity wib wab gensheru alaris sydomir padp
            amsa mfpomva pqmena xzmncan knaosjfna kjsanfojka snuais</p>
        </div>

        <div class="advert" style="float:right">
          <img src="assets/landing-page/spurdo_face.png"
            style="width:137px; height:105px; margin-top:10px">
          <h3>Lorem ipsum dolor sit amet</h3>
          <p class="small">Flip floppity wib wab gensheru alaris sydomir padp
            amsa mfpomva pqmena xzmncan knaosjfna kjsanfojka snuais</p>
        </div>

      </div>
    </div>

    <div class="bigThing" style="height:800px">
      <h2>Lorem ipsum spurdo sparde</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adispiscing elit</p>
    </div>

    <p class="verySmall" style="margin-bottom:8px;">&copy;
      2015 Z5 | <a>Terms</a> <a>Privacy</a> <a>About</a>
    </p>

  </div>

</body>

</html>
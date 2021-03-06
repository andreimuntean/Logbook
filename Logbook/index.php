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
       <a href='index.php'> <span style="font-weight:bold">My</span><span style="color:#9B9EA2 !important;">Logbook</span></a></h2>
      </h2>
      <input class="searchBar" placeholder="Search MyLogbook" size="40">
      <button type="button" class="navbarButton1 greyGradient"
        onclick="togglePopUp(true, 'signIn')">Sign In</button>
    </div>
  </div>

  <div class="overallContainer" style="background-color:#2d3239; height:390px">
    <div class="contentContainer">

      <div class="bigThing" style="width:600px; float:left">
        <h1 style="color:#EEF3F8">An innovative approach to logbooks.</h1>
        <p>Instantly accessible by computer or mobile device, MyLogbook is an
           indispensible tool for the modern programmer to plan their projects
           before realising them. Start now by signing up.</p>
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
    </div>

    <div class="contentContainer-90">
      <div class="bigThing" style="height:600px">

        <div class="advert" style="float:left">
          <img src="assets/landing-page/Interconnectivity_Graphic.png"
            style="width:250px; height:150px; margin-top:10px">
          <h3>Interconnectivity</h3>
          <p class="small">Access and edit your programming logs anywhere and
            everywhere, whether at college, work, home or even on the go.</p>
        </div>

        <div class="advert" style="float:right">
          <img src="assets/landing-page/Group_Graphic.png"
            style="width:250px; height:150px; margin-top:10px">
          <h3>Group Sharing</h3>
          <p class="small">Share your logbooks with others. Collabarate using
            each others plans on team projects to build further than ever.</p>
        </div>

        <div class="advert" style="float:left">
          <img src="assets/landing-page/Keyboard_Graphic.png"
            style="width:250px; height:150px; margin-top:10px">
          <h3>Simple, Clean UI</h3>
          <p class="small">Our uncluttered, tidy log editor and automatic
            formatting options for logs make a welcome change from untidy,
            indecipherable scribbles of the old.</p>
        </div>

        <div class="advert" style="float:right">
          <img src="assets/landing-page/Burning_Page_Graphic.png"
            style="width:250px; height:150px; margin-top:10px">
          <h3>Data Backup</h3>
          <p class="small">All of your data is backed up safely and securely on
            our servers, protecting them from physical harm. Never lose your
            logs again.</p>
        </div>

      </div>
    </div>

    <div class="bigThing" style="height:900px">
      <h2 style="margin-bottom:60px">Testimonials</h2>
      <div class="testimonial">
        <div style="float:left">
          <img src="assets/Testimonials/Andrei_Testimonial.png" class="testimonial">
        </div>
        <div style="float:left; width:761px; margin-top:11px">
          <p><em>MyLogbook is so incredibly useful. I no longer need to worry
            about accidently leaving my logbook at home and being unable to get
            it marked as I can now access it from any computer.</em><p>
          <p style="color:#FFFFFF">- Andrei Muntean, First Year Student</p>
        </div>
      </div>
      <div class="testimonial">
        <div style="float:left">
          <img src="assets/Testimonials/Hikmet_Testimonial.png" class="testimonial">
        </div>
        <div style="float:left; width:761px; margin-top:11px">
          <p><em>What I love about MyLogbook is that I can share a logbook with
            other members of my group. That way, we can view each others notes
            and collaborate far more effectively on group projects.</em><p>
          <p style="color:#FFFFFF">- Hikmet Haciyev, First Year Student</p>
        </div>
      </div>
      <div class="testimonial">
        <div style="float:left">
          <img src="assets/Testimonials/Pranav_Testimonial.png" class="testimonial">
        </div>
        <div style="float:left; width:761px; margin-top:11px">
          <p><em>I can definitely say that having a proper user interface to
            write down my logs as well as a proper folder system for several
            logbooks makes my work far easier. It makes it far easier to show my
            work to teaching assistants marking it.</em><p>
          <p style="color:#FFFFFF">- Pranav Bahuguna, First Year Student</p>
        </div>
      </div>
      <div class="testimonial">
        <div style="float:left">
          <img src="assets/Testimonials/Seb_Testimonial.png" class="testimonial">
        </div>
        <div style="float:left; width:761px; margin-top:11px">
          <p><em>MyLogbook is the best! It is far more versatile, especially since
            I can search for other logbooks and users to see how they approached
            a problem. It is also far more secure as there is no way of someone
            else copying off your work if you make your logbooks private! 10/10
            would definitely recommend.</em><p>
          <p style="color:#FFFFFF">- Sebastian Costin, First Year Student</p>
        </div>
      </div>
    </div>

    <h2>Meet the Z5 team</h2>
    <div class="bigThing" style="height:600px">
      <img style="width:720px; height:540px" src="assets/landing-page/Z5Team2.png">
    </div>

    <p class="verySmall" style="margin-bottom:8px;">&copy;
      2015 Z5 | <a>Terms</a> <a>FAQ</a> <a>About</a>
    </p>

  </div>

  <!-- These divs contain the logbook settings popup and opacity blanket. They
       are not visible until a new logbook is created. -->
  <div class="blanket", id="blanket"></div>
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

</body>

</html>

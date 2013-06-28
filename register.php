<?php
ob_start();
session_start();
if (isset($_SESSION['username'])){
header("location:account.php");
die();
}

include_once("config.php");

if (isset($_POST['username'])){
$loginusername = mysql_real_escape_string($_POST['username']);
$loginpassword = mysql_real_escape_string($_POST['password']);
$passwordconfirm = mysql_real_escape_string($_POST['passwordconfirm']);

if ($loginpassword != $passwordconfirm){
  $msg = "The passwords do not match!";
  $color = "red";
}else{
$hashedpass = md5($loginusername."_".$loginpassword);

$sql="SELECT * FROM track_accounts WHERE username='$loginusername'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);

if ($count > 0){
$msg = "Username already exists";
$color = "red";
}else{
$color = "green";
mysql_query("INSERT INTO  `track_accounts` (`username` ,`password`) VALUES ('$loginusername',  '$hashedpass');");
$_SESSION['username'] = $loginusername;
$_SESSION['password'] = $hashedpass;


  $msg = "Registration success. You may now <a href='account.php'>continue to your account.</a>";
}
}

}//isset


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
     <?php include ("title.php"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 80px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }


      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="bootstrap/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="bootstrap/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="bootstrap/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="bootstrap/ico/favicon.png">
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="muted">Crypto Track</h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="login.php">Login</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>

      <!-- Jumbotron -->
      <div class="jumbotron">
    <!--    <h1>Crypto Track</h1>-->

      <form class="form-signin" method="post" action="register.php">
        <h2 class="form-signin-heading">Register</h2>
        We don't really need much information, just a simple account will do!
              <?php
if ($msg != ""){
  echo "<font color=\"$color\"><center><b>$msg</b></center></font>";
}
?>
        <input type="text" id="username" name="username" class="input-block-level" placeholder="Username">
        <input type="password" id="password" name="password" class="input-block-level" placeholder="Password">
        <input type="password" id="passwordconfirm" name="passwordconfirm" class="input-block-level" placeholder="Confirm Password">
        <button class="btn btn-large btn-primary" type="submit">Register</button>
      </form>


      </div>

      <hr>


      <hr>

      <div class="footer">
        <?php include("footer.php"); ?>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap-transition.js"></script>
    <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/js/bootstrap-typeahead.js"></script>

  </body>
</html>

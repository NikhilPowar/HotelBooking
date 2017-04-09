<html>
<head>
	<title>About Us</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="form.css">
  <link rel="stylesheet" type="text/css" href="pagelayout.css">
</head>
<body>
<?php
	session_start();
	if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
	require 'header.php';
	if($_SESSION['role']=="customer")
  	require 'sidebar.php';
	else if($_SESSION['role']=="admin")
	  	require 'adminsidebar.php';
	else
		  require 'managersidebar.php';
  require 'config.php';
  echo "<div id='container'>";
  echo "<p><h4 style='text-align:left'>";
  echo "
  <b>ABOUT US:</b><br>
  This is a hotel booking website.<br>
  Our services are available only in select cities at the moment.<br>
  We do look to grow our reach with various cities and hotels.<br>
  Thank you for using our website.<br><br>
  <b>PLEASE NOTE:</b><br>
  All bookings done at our site are genuine.<br>
  Booking once done cannot be cancelled and no refund will be provided.<br>";
  echo "</h4></p>"
?>
</body>
</html>

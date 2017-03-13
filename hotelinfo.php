<?php
  session_start();
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'config.php';
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "select name, price from hoteldetails where hid=?")){
    mysqli_stmt_bind_param($stmt, "i", $hid);
    $hid=(int)$_GET['id'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $price);
    mysqli_stmt_fetch($stmt);
    echo "Hotel : $name <br>Price : $price<br>";
    mysqli_stmt_close($stmt);
  }
  echo "<a href='payment.php?id=$hid'>Book now</a><br>";
  echo "<a href='homepage.php'>Back to Search</a>";
?>

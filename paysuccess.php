<html>
<head>
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
  require 'header.php';
  require 'sidebar.php';
  echo "<div id='container'>";
  session_start();
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'config.php';
  echo'Payment successful.<br>
    Booking Details:<br>
    Hotel name : '.$_SESSION['hname'].'<br>
    From Date : '.$_SESSION['from'].'<br>
    To Date   : '.$_SESSION['to'].'<br>
    Amount Paid : &#8377;'.$_SESSION['totalPrice'].'<br>';
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "insert ignore into history values(?, ?, ?, ?, ?, NOW())")){
    mysqli_stmt_bind_param($stmt, "sissi", $uname, $hid, $from, $to, $totalPrice);
    $uname=$_SESSION['username'];
    $hid=$_SESSION['hid'];
    $from=$_SESSION['from'];
    $to=$_SESSION['to'];
    $totalPrice=$_SESSION['totalPrice'];
    mysqli_stmt_execute($stmt);
  }
  if(!isset($_SESSION['time'])){
    if(mysqli_stmt_prepare($stmt, "select NOW()")){
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $time);
      mysqli_stmt_fetch($stmt);
      $_SESSION['time']=$time;
    }
  }
  echo "Time : ".$_SESSION['time']."
  </div>";
  mysqli_stmt_close($stmt);
?>
</body>
</html>

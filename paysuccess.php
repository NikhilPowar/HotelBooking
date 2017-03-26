<?php
  session_start();
  require 'config.php';
  echo'Payment successful.<br>
    Booking Details:<br>
    Hotel name : '.$_SESSION['hname'].'<br>
    From Date : '.$_SESSION['from'].'<br>
    To Date   : '.$_SESSION['to'].'<br>
    Amount Paid : '.$_SESSION['totalPrice'].'<br>
    <a href="homepage.php">Click Here</a> to return home.
  ';
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "insert ignore into history values(?, ?, ?, ?, ?)")){
    mysqli_stmt_bind_param($stmt, "sissi", $uname, $hid, $from, $to, $totalPrice);
    $uname=$_SESSION['username'];
    $hid=$_SESSION['hid'];
    $from=$_SESSION['from'];
    $to=$_SESSION['to'];
    $totalPrice=$_SESSION['totalPrice'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
?>

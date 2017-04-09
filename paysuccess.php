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
  require 'phpmailer\PHPMailer_5.2.4\class.phpmailer.php';
  echo "<div id='container'>";
  session_start();
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'config.php';
  echo'<p><h4 style="text-align:left;">Payment successful.<br>
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
  </h4></p>";

  $mail = new PHPMailer;

  $mail->IsSMTP();
  $mail->Mailer = "smtp";
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'vjtihotelbooking@gmail.com';
  $mail->Password = 'vjtihotelbooking123';
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->SetFrom('vjtihotelbooking@gmail.com', 'Hotel Booking');
  $mail->AddReplyTo('vjtihotelbooking@gmail.com', 'Hotel Booking');
  $mail->AddAddress($_SESSION['email']);

  $msg = 'Thank you for using our website for your booking.<br>
    Use the printed form of this mail as receipt to be shown at the hotel.<br>
    Booking Details:<br>
    Hotel name : '.$_SESSION['hname'].'<br>
    From Date : '.$_SESSION['from'].'<br>
    To Date   : '.$_SESSION['to'].'<br>
    Amount Paid : &#8377;'.$_SESSION['totalPrice'].'<br>
    Time : '.$_SESSION['time'];

  $mail->Subject = "Payment Success";
  $mail->MsgHTML($msg);
  echo "<p><h4>";
  if(!$mail->Send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo . '</div>';
  } else {
    echo 'Message has been sent to your email-id</div>';
  }
  echo "</h4></p>";
  mysqli_stmt_close($stmt);
?>
</body>
</html>

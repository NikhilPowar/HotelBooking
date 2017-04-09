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
  require 'config.php';

  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $cnum = $cvv = "";
  $cnumErr = $cvvErr ="";
  if(isset($_POST['from']) and isset($_POST['to']) and isset($_POST['totalPrice'])){
    $_SESSION['to']=$_POST['to'];
    $_SESSION['from']=$_POST['from'];
    $_SESSION['totalPrice']=preg_replace('/[^\p{L}\p{N}\s]/u', '', $_POST['totalPrice']);
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["cnum"]) and isset($_POST["cvv"])) {
    $cnum = test_input($_POST["cnum"]);
    if (!preg_match("/^[0-9]*$/",$cnum)) {
      $cnumErr = "Only numbers allowed";
    }
    else if (strlen($cnum)!=16){
      $cnumErr = "Number must be 16-digit";
    }

    $cvv = test_input($_POST["cvv"]);
    if (!preg_match("/^[0-9]*$/",$cvv)) {
      $cvvErr = "Only numbers allowed";
    }else if (strlen($cvv)!=3){
      $cvvErr = "CVV must be 3-digit";
    }

    if($cnumErr=="" and $cvvErr==""){
      header("Location: http://localhost/Project/paysuccess.php");
    }
  }

  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "select name, price from hotels where hid=?")){
    mysqli_stmt_bind_param($stmt, "i", $hid);
    $hid=(int)$_GET['id'];
    $_SESSION['hid']=$hid;
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hname, $price);
    mysqli_stmt_fetch($stmt);
    $_SESSION['hname']=$hname;
    $_SESSION['time']=NULL;
    mysqli_stmt_close($stmt);
  }
  echo "
  <form method='post' action='payment.php?id=$hid'>
  <div class='container'>

    <label><b>Amount Payable</b></label>
    <input type='text' name='totalPrice' value=".$_POST['totalPrice']." readOnly>

    <label><b>Card Number</b></label>
    <span class='error'>*".$cnumErr."</span>
    <input type='text' placeholder='Enter Card Number' name='cnum' required>

    <label><b>CVV Code</b></label>
    <span class='error'>*".$cvvErr."</span>
    <input type='password' placeholder='Enter CVV Code' name='cvv' required>

    <button type='submit'>Pay</button>

    <button type='reset' class='cancelbtn'>Cancel</button>
    </form>
    </div>
  ";
?>

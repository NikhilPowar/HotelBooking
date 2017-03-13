<link rel="stylesheet" type="text/css" href="form.css">
<?php
  session_start();
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $cnum = $cvv = "";
  $cnumErr = $cvvErr ="";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'config.php';
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "select price from hoteldetails where hid=?")){
    mysqli_stmt_bind_param($stmt, "i", $hid);
    $hid=(int)$_GET['id'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $price);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
  }
  echo "<form method='post' action='payment.php?id=$hid'>";
  echo "<div class='container'>
    <label><b>Card Number</b></label>
    <span class='error'>*".$cnumErr."</span>
    <input type='text' placeholder='Enter Card Number' name='cnum' required>

    <label><b>CVV Code</b></label>
    <span class='error'>*".$cvvErr."</span>
    <input type='password' placeholder='Enter CVV Code' name='cvv' required>

    <button type='submit'>Pay</button>

    <button type='button' class='cancelbtn'>Cancel</button>
  ";
?>

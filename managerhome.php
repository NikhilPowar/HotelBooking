<link rel="stylesheet" type="text/css" href="form.css">
<?php
  session_start();
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'config.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, "update hoteldetails set name=?, price=? where manager=?")){
      mysqli_stmt_bind_param($stmt, "sis", $hname, $price, $uname);
      $hname=$_POST['hname'];
      $price=$_POST['price'];
      $uname=$_SESSION['username'];
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      echo "Details updated successfully.<br>";
    }
  }
  echo "Welcome ".$_SESSION['username']."! Your hotel details:<br>";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "select name, price from hoteldetails where manager=?")){
    mysqli_stmt_bind_param($stmt, "s", $uname);
    $uname=$_SESSION['username'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $price);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
  }
    echo '
      <form method="post" action="managerhome.php">
      <div class="container">

      <label><b>Name</b></label>
      <input type="text" name="hname" id="hname" value='.$name.'>

      <label><b>Price</b></label>
      <input type="text" name="price" id="price" value='.$price.'>

      <button type="submit">Update</button>
      </form>
    ';
?>

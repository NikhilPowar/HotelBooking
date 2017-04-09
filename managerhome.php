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
  require 'managersidebar.php';
  session_start();
  echo "<div id='container'>";
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'config.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, "update hotels set name=?, price=? where manager=?")){
      mysqli_stmt_bind_param($stmt, "sis", $hname, $price, $uname);
      $hname=$_POST['hname'];
      $price=$_POST['price'];
      $uname=$_SESSION['username'];
      mysqli_stmt_execute($stmt);
      mysqli_stmt_prepare($stmt, "update hotels set description=? where manager=?");
      mysqli_stmt_bind_param($stmt, "bs", $description, $uname);
      $description=NULL;
      mysqli_stmt_send_long_data($stmt, 0, $_POST['description']);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
    echo "<p><h4>Details updated successfully.<br></p></h4>";
  }
  echo "<p><h4>Welcome ".$_SESSION['username']."! Your hotels details:<br></p></h4>";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "select name, price, hid, description from hotels where manager=?")){
    mysqli_stmt_bind_param($stmt, "s", $uname);
    $uname=$_SESSION['username'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $name, $price, $hid, $description);
    mysqli_stmt_fetch($stmt);
    $_SESSION['hid']=$hid;
    mysqli_stmt_close($stmt);
  }
    echo '
      <form method="post" action="managerhome.php" id="updateHotel">
      <div class="container">

      <label><b>Name</b></label>
      <input type="text" name="hname" id="hname" value='.$name.'>

      <label><b>Price</b></label>
      <input type="text" name="price" id="price" value='.$price.'>

      <label><b>Description</b></label>
      <textarea rows=10 name="description" form="updateHotel">'.$description.'</textarea>

      <button type="submit">Update</button>
      </form>
      </div>
    ';
?>
</body>
</html>

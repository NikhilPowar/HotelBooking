<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="table.css">
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
  echo "
  <table>
    <caption>My Booking History</caption>
    <tr>
      <th>Name</th>
      <th>From</th>
      <th>To</th>
      <th>Price</th>
      <th>Time</th>
    </tr>
  ";
  $stmt = mysqli_stmt_init($conn);
  $conn1 = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
  if(mysqli_stmt_prepare($stmt, "select hid, fromDate, toDate, totalPrice, time from history where uname=? order by time desc")){
    mysqli_stmt_bind_param($stmt, 's', $uname);
    $uname=$_SESSION['username'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hid, $fromDate, $toDate, $totalPrice, $time);
    while(mysqli_stmt_fetch($stmt)){
      $stmt1 = mysqli_stmt_init($conn1);
      if(mysqli_stmt_prepare($stmt1, "select name from hotels where hid=?")){
        mysqli_stmt_bind_param($stmt1, 'i', $id);
        $id=$hid;
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_bind_result($stmt1, $hname);
        mysqli_stmt_fetch($stmt1);
        mysqli_stmt_close($stmt1);
      }
      echo "
        <tr>
          <td>".$hname."</td>
          <td>".$fromDate."</td>
          <td>".$toDate."</td>
          <td>&#8377;".$totalPrice."</td>
          <td>".$time."</td>
        </tr>
      ";
    }
    mysqli_stmt_close($stmt);
    echo "</table><br>";
  }
  echo "</div>";
?>
</body>
</html>

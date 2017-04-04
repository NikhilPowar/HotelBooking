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
  session_start();
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'header.php';
  require 'config.php';
  require 'adminsidebar.php';
  echo "<div id='container'>";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "delete from users where name=?")){
    mysqli_stmt_bind_param($stmt, "s", $name);
    $name=$_GET['user'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
  echo "The user ".$name." has been removed."
?>
</div>
</body>
</html>

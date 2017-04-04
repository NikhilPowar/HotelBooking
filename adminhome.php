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
  require 'adminsidebar.php';
  require 'config.php';
  echo "<div id='container'>";
  echo "
    <script type='text/javascript'>
    function remove(remove_id){
      var val=remove_id;
      self.location='removal.php?user=' + val ;
    }
    </script>
    <table>
      <caption>Users</caption>
      <tr>
        <th>Name</th>
        <th>E-mail</th>
        <th style='width:50px'>Remove</th>
      </tr>
  ";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "select name, email from users where role='customer'")){
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $email);
    while(mysqli_stmt_fetch($stmt)){
      echo "
        <tr>
          <td>".$name."</td>
          <td>".$email."</td>
          <td><button id='".$name."' onclick='remove(this.id)'>Remove</button></td>
        </tr>
      ";
    }
    mysqli_stmt_close($stmt);
  }
  echo "</table>";
?>
</div>
</body>
</html>

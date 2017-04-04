<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="form.css">
  <link rel="stylesheet" href="jquery-ui-themes-1.12.1/themes/overcast/jquery-ui.css">
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
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "select name, price, description, imagepath from hotels where hid=?")){
    mysqli_stmt_bind_param($stmt, "i", $hid);
    $hid=(int)$_GET['id'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $price, $description, $imgpth);
    mysqli_stmt_fetch($stmt);
    $paths = explode(";", $imgpth);
    $num = count($paths);
    echo "Hotel : $name <br>Price per day per room : &#8377;$price<br>Description: $description<br>";
    echo "<style>
    .carousel{
      margin: auto;
      min-height: 300px;
      min-width: 400px;
      padding: 16px 20px;
      width: 50%;
      height: 50%;
    }
    .carousel-inner{
      align: center;
      width: 100%;
      height: 100%;
    }
    img{
      width: 100%;
      height: 100%;
    }
    </style>";

    echo '<div id="images" class="carousel slide" data-ride="carousel">

    <ol class="carousel-indicators">
      <li data-target="#images" data-slide-to="0" class="active"></li>';
      $i=1;
      while($i<$num){
        echo '<li data-target="#images" data-slide-to="'.$i.'"></li>';
        $i=$i+1;
      }
    echo '</ol>

    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="'.$paths[0].'">
      </div>';

      $i=1;
      while($i<$num){
        echo '
        <div class="item">
          <img src="'.$paths[$i].'">
        </div>';
        $i=$i+1;
      }

    echo '
    <a class="left carousel-control" href="#images" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#images" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  </div>';
    mysqli_stmt_close($stmt);
  }
  echo '<br><a href="booking.php?id='.$hid.'">Click here to book</br>';
?>
</body>
</html>

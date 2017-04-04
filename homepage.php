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
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'config.php';
  echo "<script language=JavaScript>
  function reload(form){
    var val=form.state.options[form.state.options.selectedIndex].value;
    self.location='homepage.php?state=' + val ;
  }
  </script>";
  $stmt = mysqli_stmt_init($conn);
  echo "Welcome ".$_SESSION['username']."!<br>
    What kind of hotels are you looking for today?"; ?>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <form-header>
  <h2>Search Hotels</h2>
  </form-header>
  <div class="container">
  <?php
  if(mysqli_stmt_prepare($stmt, "select state from hotels group by state order by state")){
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $state);
    echo "<label><b>State</b></label>";
    echo "<select name='state' id='state' onchange='reload(this.form)' required class='form-control'>";
    echo "<option disabled selected value style='display:none'> -- select a state -- </option>";
    while (mysqli_stmt_fetch($stmt)) {
      if($state==$_GET['state'] or $state==$_POST['state'])
        echo "<option selected value='" . $state . "'>" . $state . "</option>";
      else
        echo "<option value='" . $state . "'>" . $state . "</option>";
    }
    echo "</select>";
  }
  if(isset($_GET['state']) or isset($_POST['city'])){
    if(mysqli_stmt_prepare($stmt, "select city from hotels where state=? group by city order by city")){
      mysqli_stmt_bind_param($stmt, "s", $s);
      if(isset($_GET['state']))
        $s=$_GET['state'];
      else {
        $s=$_POST['state'];
      }
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $city);
      echo "<label><b>City</b></label>";
      echo "<select name='city' required class='form-control'>";
      echo "<option disabled selected value style='display:none'> -- select a city -- </option>";
      while (mysqli_stmt_fetch($stmt)) {
        if($city==$_POST['city'])
          echo "<option selected value='" . $city . "'>" . $city . "</option>";
        else
          echo "<option value='" . $city . "'>" . $city . "</option>";
      }
      echo "</select>";
    }
  }
  else{
    echo "
    <label><b>City</b></label>
    <select name='city' required class='form-control'>
    <option disabled selected value style='display:none'> -- select a city -- </option>
    <option disabled></option>
    </select>";
  }
  echo "<button type='submit'>Search</button>";
  echo "</form>";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $state=$_POST['state'];
    $city=$_POST['city'];
    if(mysqli_stmt_prepare($stmt, "select name, hid, price from hotels where state=? and city=?")){
      mysqli_stmt_bind_param($stmt, "ss", $s, $c);
      $s=$state;
      $c=$city;
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $hotels, $id, $price);
      echo '<style>
      .nav-pills > li > a {
        background-color: #006680;
        color: #eeeeee;
      }
      .nav-pills > li > a:hover {
        background-color: #005266;
        color: #ffffff;
      }</style>';
      echo "</div>";
      echo '
      <br>Results:
      <br><ul class="nav nav-pills nav-stacked col-sm-3">';
      while (mysqli_stmt_fetch($stmt)){
        echo '<li><a href="hotelinfo.php?id='.$id.'"><h4>'.$hotels.'</h4><div class="text-right">&#8377;'.$price.'</div></a></li><br>';
      }
      echo '</ul>';
    }
  }
  mysqli_stmt_close($stmt);
?>
</div>
</body>
</html>

<link rel="stylesheet" type="text/css" href="form.css">
<?php
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
  echo "Welcome ".$_SESSION['username']."! What kind of hotel are you looking for today?"; ?>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <?php
  if(mysqli_stmt_prepare($stmt, "select state from hotel group by state order by state")){
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $state);
    echo "<select name='state' id='state' onchange='reload(this.form)' required>";
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
    if(mysqli_stmt_prepare($stmt, "select city from hotel where state=? group by city order by city")){
      mysqli_stmt_bind_param($stmt, "s", $s);
      if(isset($_GET['state']))
        $s=$_GET['state'];
      else {
        $s=$_POST['state'];
      }
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $city);
      echo "<select name='city' required>";
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
    echo "<select name='city' required>";
    echo "<option disabled selected value style='display:none'> -- select a city -- </option>";
    echo "<option disabled></option>";
    echo "</select>";
  }
  echo "<button type='submit'>Search</button>";
  echo "</form>";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $state=$_POST['state'];
    $city=$_POST['city'];
    if(mysqli_stmt_prepare($stmt, "select name, hid from hotel where state=? and city=?")){
      mysqli_stmt_bind_param($stmt, "ss", $s, $c);
      $s=$state;
      $c=$city;
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $hotel, $id);
      while (mysqli_stmt_fetch($stmt)){
        echo "<a href='hotelinfo.php?id=$id'>$hotel</a><br>";
      }
    }
  }
?>

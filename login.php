<html>
<link rel="stylesheet" type="text/css" href="form.css">
<body>

<?php
  $unameErr = $pswErr = "";
  $uname = $psw = "";
  session_start();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = test_input($_POST["uname"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$uname)) {
      $unameErr = "Only letters and white space allowed";
    }

    $psw = test_input($_POST["psw"]);
    if (!preg_match("/^[a-zA-Z]*$/",$psw)) {
      $pswErr = "Only letters allowed";
    }

    if(strcmp($unameErr, "")==0 and strcmp($pswErr, "")==0){
      $_SESSION['username']=$uname;
      $_SESSION['password']=$psw;
      include 'config.php';
      header("Location: http://localhost/Project/homepage.php");
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<form-header>
<h2>Login Form</h2>
<p align="center"><span class="error">* required field.</span></p>
</form-header>
<form-text>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <div class="container">
    <label><b>Username</b></label>
    <span class="error">* <?php echo $unameErr;?></span>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label><b>Password</b></label>
    <span class="error">* <?php echo $pswErr;?></span>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit">Login</button>

    <button type="button" class="cancelbtn">Cancel</button>

    <a href="signup.php">New User? Sign up here.</a>
  </div>
</form>
</form-text>

</body>
</html>

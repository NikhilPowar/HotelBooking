<html>
<link rel="stylesheet" type="text/css" href="form.css">
<body>

<?php
  $unameErr = $emailErr = $pswErr = $conpswErr = "";
  $uname = $email = $psw = $conpsw = "";
  session_start();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = test_input($_POST["uname"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$uname)) {
      $unameErr = "Only letters and white space allowed";
    }

    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }

    $psw = test_input($_POST["psw"]);
    if (!preg_match("/^[a-zA-Z]*$/",$psw)) {
      $pswErr = "Only letters allowed";
    }

    $conpsw = test_input($_POST["conpsw"]);
    if (strcmp($psw,$conpsw)!=0) {
      $conpswErr = "Password doesn't match";
    }

    if(strcmp($unameErr, "")==0 and strcmp($pswErr, "")==0 and strcmp($conpswErr, "")==0 and strcmp($emailErr, "")==0){
      $_SESSION['username']=$uname;
      $_SESSION['password']=$psw;
      require 'config.php';
      $stmt = mysqli_stmt_init($conn);
      if (mysqli_stmt_prepare($stmt, 'insert into `users` values( ?, ?, ?, "customer")')) {
        mysqli_stmt_bind_param($stmt, 'sss', $name, $pw, $em);
        $name=$uname;
        $pw=$psw;
        $em=$email;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
      }
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
<h2>Sign Up</h2>
<p align="center"><span class="error">* required field.</span></p>
</form-header>
<form-text>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <div class="container">
    <label><b>Username</b></label>
    <span class="error">* <?php echo $unameErr;?></span>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label><b>E-mail</b></label>
    <span class="error">* <?php echo $emailErr;?></span>
    <input type="text" placeholder="Enter E-mail" name="email" required>

    <label><b>Password</b></label>
    <span class="error">* <?php echo $pswErr;?></span>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label><b>Confirm Password</b></label>
    <span class="error">* <?php echo $conpswErr;?></span>
    <input type="password" placeholder="Re-enter Password" name="conpsw" required>

    <button type="submit">Sign Up</button>

    <button type="button" class="cancelbtn">Cancel</button>

    <a href="login.php">Have an account? Login Here.</a>
  </div>
</form>
</form-text>

</body>
</html>

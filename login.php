<html>
<link rel="stylesheet" type="text/css" href="form.css">
<body>

<?php
  $unameErr = $pswErr = $credErr = "";
  $uname = $psw = $role = "";
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

    $role=$_POST["role"];

    if(strcmp($unameErr, "")==0 and strcmp($pswErr, "")==0){
      $_SESSION['username']=$uname;
      $_SESSION['password']=$psw;
      $_SESSION['role']=$role;
      require 'config.php';
      $stmt = mysqli_stmt_init($conn);
      if (mysqli_stmt_prepare($stmt, "select name, password, role from users where name=?")) {
        mysqli_stmt_bind_param($stmt, 's', $name);
        $name=$uname;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $n, $p, $r);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if($n==$uname and $psw==$p and $r==$role){
          if($r=="customer")
            header("Location: http://localhost/Project/homepage.php");
          else if($r=="manager")
            header("Location: http://localhost/Project/managerhome.php");
          else if($r=="admin")
            header("Location: http://localhost/Project/adminhome.php");
        }
        else {
          $credErr = "Invalid credentials.";
        }
      }
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
<h2>Login</h2>
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

    <select name="role">
      <option value="customer">Customer</option>
      <option value="manager">Manager</option>
      <option value="admin">Admin</option>
    </select>

    <button type="submit">Login</button>

    <button type="button" class="cancelbtn">Cancel</button>

    <a href="signup.php">New User? Sign up here.</a><br>
    <span class="error"><?php echo $credErr;?></span>
  </div>
</form>
</form-text>

</body>
</html>

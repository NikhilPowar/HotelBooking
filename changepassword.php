<!doctype html>
<html>
<head>
	<title>Change password</title>
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
	session_start();
	if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
	require 'header.php';
	if($_SESSION['role']=="customer")
  	require 'sidebar.php';
	else if($_SESSION['role']=="admin")
	  	require 'adminsidebar.php';
	else
		  require 'managersidebar.php';
  require 'config.php';
	echo "<div id='container'>";
    $emailErr = $pswErr = $conpswErr = $oldpsw = "";
    $email = $psw = $conpsw = $oldpswErr ="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
      }

			$oldpsw = test_input($_POST["oldpsw"]);
      if (!preg_match("/^[a-zA-Z]*$/",$oldpsw)) {
        $oldpswErr = "Only letters allowed";
      }

      $psw = test_input($_POST["psw"]);
      if (!preg_match("/^[a-zA-Z]*$/",$psw)) {
        $pswErr = "Only letters allowed";
      }

      $conpsw = test_input($_POST["conpsw"]);
      if (strcmp($psw,$conpsw)!=0) {
        $conpswErr = "Password doesn't match";
      }

      if(strcmp($pswErr, "")==0 and strcmp($oldpswErr, "")==0 and strcmp($conpswErr, "")==0 and strcmp($emailErr, "")==0){
				$stmt = mysqli_stmt_init($conn);
				if (mysqli_stmt_prepare($stmt, 'select email, password from users where name=?')) {
					mysqli_stmt_bind_param($stmt, 's', $name);
					$name=$_SESSION['username'];
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $e, $p);
					mysqli_stmt_fetch($stmt);
					if(strcmp($email, $e)!=0){
						$emailErr="E-mail doesn't match.";
					}
					if(strcmp($oldpsw, $p)!=0){
						$oldpswErr="Old password doesn't match.";
					}
					mysqli_stmt_close($stmt);
				}
				if(strcmp($oldpswErr, "")==0 and strcmp($emailErr, "")==0){
	        $stmt = mysqli_stmt_init($conn);
	        if (mysqli_stmt_prepare($stmt, 'update users set password=? where name=?')) {
	          mysqli_stmt_bind_param($stmt, 'ss', $pw, $name);
	          $name=$_SESSION['username'];
	          $pw=$psw;
	          mysqli_stmt_execute($stmt);
	          mysqli_stmt_close($stmt);
						echo "<p><h4 style='text-align:left'>Password changed successfully.</h4></p>";
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
				<div class="container">

        <form action="changepassword.php" method="post">
        <h2 style="text-align: center">Change Your Password</h2>

        <label><b>E-mail</b></label>
        <span class="error">* <?php echo $emailErr;?></span>
        <input type="text" placeholder="Enter E-mail" name="email" required>

        <label><b>Old Password</b></label>
        <span class="error">* <?php echo $oldpswErr;?></span>
        <input type="password" placeholder="Enter Old Password" name="oldpsw" required>

        <label><b>New Password</b></label>
        <span class="error">* <?php echo $pswErr;?></span>
        <input type="password" placeholder="Enter New Password" name="psw" required>

        <label><b>Confirm New Password</b></label>
        <span class="error">* <?php echo $conpswErr;?></span>
        <input type="password" placeholder="Re-enter New Password" name="conpsw" required>

				<button type="submit">Submit</button>

		    <button type="button" class="cancelbtn">Cancel</button>

			</form>
		</div>
</body>
</html>

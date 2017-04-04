<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("location:login.php");
	exit();
}
else{
	$_SESSION = array();
	session_destroy();
	header("location:login.php");
	exit();
}
?>

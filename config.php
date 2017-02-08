<?php
   define('DB_SERVER', 'localhost:3036');
   define('DB_NAME', 'hotelsystem');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'rootpassword');
   define('DB_DATABASE', 'database');
   $con = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   $db = mysqli_select_db($con, DB_NAME);
?>

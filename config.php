<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'dummy');
   define('DB_PASSWORD', 'dummy');
   define('DB_DATABASE', 'hotelbooking');
   $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   if (!$conn) {
     $_SESSION['login']="false";
   }
   else{
     $_SESSION['login']="true";
   }
  ?>

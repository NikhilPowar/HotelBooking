<?php
  session_start();
  include 'config.php';
  $query = "SELECT * FROM `users`";
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    echo "Name: " . $row['name'] . " E-mail: " . $row['email'];
  }
?>

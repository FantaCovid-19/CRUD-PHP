<?php 
  session_start();

  $conn = mysqli_connect(
    'host',
    'user',
    'password',
    'database'
  ) or die(mysqli_erro($mysqli));
?>
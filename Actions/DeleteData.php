<?php
  include('../DataBase/db.php');

  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM dispatched WHERE ids = $id";
    $result = mysqli_query($conn, $query);
  
    if(!$result) {
      die("Query Failed.");
    }

    $_SESSION['message'] = 'Cargamento eliminado exitosamente.';
    $_SESSION['message_type'] = 'danger';

    header('Location: ../index.php');
  }
?>
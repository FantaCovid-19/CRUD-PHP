<?php
  include('../DataBase/db.php');

  if (isset($_POST['save'])) {
    $idload = random_int(1000000, 9999999);
    $charges = $_POST['charger'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $date = $_POST['issueDate'];

    function format_date($original='', $format="%m/%d/%Y") {
      $format = ($format=='date' ? "%m-%d-%Y" : $format);
      $format = ($format=='datetime' ? "%m-%d-%Y %H:%M:%S" : $format);
      $format = ($format=='mysql-date' ? "%Y-%m-%d" : $format);
      $format = ($format=='mysql-datetime' ? "%Y-%m-%d %H:%M:%S" : $format);
      return (!empty($original) ? strftime($format, strtotime($original)) : "" );
    }

    $formatDate = format_date($_POST['issueDate'], 'mysql-date');
    $delivery = date("Y-m-d", strtotime($formatDate."+ 8 days"));

    $test = "RE-" . $idload . "-CL";

    $status = '1';

    $query = "INSERT INTO dispatched (id_load, origin, destination, charger, issue_date, delivery_date, status) VALUES ('$test', '$origin', '$destination', '$charges', '$date', '$delivery', $status);";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
      die("Query Failed.");
    }

    $_SESSION['message'] = 'Cargamento añadido exitosamente.';
    $_SESSION['message_type'] = 'success';
    
    header('Location: ../index.php');
  }
?>
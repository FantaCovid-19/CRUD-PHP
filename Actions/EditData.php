<?php
  include('../DataBase/db.php');

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM dispatched WHERE ids='$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_array($result);
      
      $idLoad = $row['id_load'];
      $origin = $row['origin'];
      $destination = $row['destination'];
      $charger = $row['charger'];
      $inssueDate = $row['issue_date'];
      $deliveryDate = $row['delivery_date'];
      $status = $row['status'];
    }
  }

  function format_date($original='', $format="%m/%d/%Y") {
    $format = ($format=='date' ? "%m-%d-%Y" : $format);
    $format = ($format=='datetime' ? "%m-%d-%Y %H:%M:%S" : $format);
    $format = ($format=='mysql-date' ? "%Y-%m-%d" : $format);
    $format = ($format=='mysql-datetime' ? "%Y-%m-%d %H:%M:%S" : $format);
    return (!empty($original) ? strftime($format, strtotime($original)) : "" );
  }

  if (isset($_POST['update'])) {
    $ids = $_GET['id'];

    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $charger = $_POST['charger'];
    $inssueDate =  $_POST['issueDate'];
    $deliveryDate = $_POST['deliveryDate'];
    $status = $_POST['status'];

    $formatDate_0 = format_date($_POST['issueDate'], 'mysql-date');
    $formatDate_1 = format_date($_POST['deliveryDate'], 'mysql-date');

    $query = "UPDATE dispatched SET origin = '$origin', destination = '$destination', charger = '$charger', issue_date = '$formatDate_0', delivery_date = '$formatDate_1', status = '$status' WHERE ids = $ids";
  
    $result = mysqli_query($conn, $query);

    if (!$result) {
      die("Query Failed.");
    }

    $_SESSION['message'] = 'Cargamento editado exitosamente.'; 
    $_SESSION['message_type'] = 'warning';
    
    header('Location: ../index.php');
  }

  include('../Template/header.php');
?>

<div class='container p-4'>
  <div class='row'>
    <div class='col-md-4 mx-auto'>
      <div class='card card-body'>
        <form action="EditData.php?id=<?php echo $_GET['id']; ?>" method='POST'>
          <div class='form-group'>
            <label class='form-label'><b>ID Cargamento</b></label>
            <input type='text' class='form-control' value='<?php echo $idLoad; ?>' readonly />

            <label class='form-label'><b>Actualizar Origen</b></label>
            <input type='text' class='form-control' name='origin' value='<?php echo $origin; ?>' required />

            <label class='form-label'><b>Actualizar Destino</b></label>
            <input type='text' class='form-control' name='destination' value='<?php echo $destination; ?>' required />

            <label class='form-label'><b>Actualizar Carga</b></label>
            <select class='form-select' name='charger'>
              <?php
                $query = "SELECT * FROM dispatched, charges WHERE dispatched.ids = '$id' AND charges.id = dispatched.charger";
                $result_tasks = mysqli_query($conn, $query);

                while($row = mysqli_fetch_assoc($result_tasks)) {
              ?>
              <option value='<?php echo $charger; ?>' selected><?php echo $row['charges_name']; ?> - Actual</option>
              <?php } ?>

              <?php 
                $query = "SELECT * FROM charges ORDER BY id ASC";
                $result_tasks = mysqli_query($conn, $query);

                while($row = mysqli_fetch_assoc($result_tasks)) {
              ?>
              <option value='<?php echo $row['id']; ?>'><?php echo $row['charges_name']; ?></option>
              <?php }?>
            </select>

            <label class='form-label'><b>Actualizar Fecha de Envio</b></label>
            <input type='date' class='form-control' name='issueDate' value='<?php echo $inssueDate; ?>' required />

            <label class='form-label'><b>Actualizar Fecha de Entrega</b></label>
            <input type='date' class='form-control' name='deliveryDate' value='<?php echo $deliveryDate; ?>' required />

            <label class='form-label'><b>Actualizar Estado de la Carga</b></label>
            <select class='form-select' name='status'>
              <?php
                $query = "SELECT * FROM dispatched, status WHERE dispatched.ids = '$id' AND status.id = dispatched.status";
                $result_tasks = mysqli_query($conn, $query);

                while($row = mysqli_fetch_assoc($result_tasks)) {
              ?>
              <option value='<?php echo $status; ?>' selected><?php echo $row['status_name']; ?> - Actual</option>
              <?php } ?>

              <?php 
                $query = "SELECT * FROM status ORDER BY id ASC";
                $result_tasks = mysqli_query($conn, $query);

                while($row = mysqli_fetch_assoc($result_tasks)) {
              ?>
              <option value='<?php echo $row['id']; ?>'><?php echo $row['status_name']; ?></option>
              <?php } ?>
            </select>

            <br />

            <button class='btn btn-success btn-block' style='display: block; margin-left: auto; margin-right: auto;' name="update">
              Actualizar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
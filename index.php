<?php
  include('./DataBase/db.php');
  include('./Template/header.php'); 
?>

<main class='container p-4'>
  <div class='row justify-content-end'>
    <div class='col-md-3'>
      <form action='./index.php' method='POST'>
        <div class='input-group'>
          <span class='input-group-text'><i class="fas fa-search"></i></span>
          <input type='text' class='form-control' name='idCarga' placeholder='ID Cargamento' />
          <button class='btn btn-success btn-block' name='search'>Buscar</button>
        </div>
      </form>
    </div>
  </div>
  <br />
  <div class='row'>
    <div class='col-md-3'>
      <?php if (isset($_SESSION['message'])) { ?>
        <div class='alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show' role='alert'>
          <?= $_SESSION['message'] ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php session_unset(); } ?>
    
      <div class='card card-body'>
        <form action='./Actions/AddNew.php' method='POST'>
          <div class='form-group'>
            <label class='form-label'><b>Tipo de Carga:</b></label>
            <select class='form-select' name='charger' required>
              <option>Seleciona Tipo de Carga</option>
              <?php 
                $query = 'SELECT * FROM charges ORDER BY id ASC';
                $result_tasks = mysqli_query($conn, $query);

                while($row = mysqli_fetch_assoc($result_tasks)) { 
              ?>
              <option value='<?php echo $row['id'] ?>'><?php echo $row['charges_name']; ?></option>
              <?php } ?>
            </select>

            <label class='form-label'><b>Ingrese Origen:</b></label>
            <input type='text' class='form-control' name='origin' placeholder='Ingresa el Origen' required />

            <label class='form-label'><b>Ingrese Destino:</b></label>
            <input type='text' class='form-control' name='destination' placeholder='Ingrese el Destino' required />

            <label class='form-label'><b>Fecha de Envio:</b></label>
            <input type='date' class='form-control' name='issueDate' required />

            <br />

            <input type='submit' class='btn btn-success btn-block' name='save' style='display: block; margin-left: auto; margin-right: auto;' value='Guardar' />
          </div>
        </form>
      </div>
    </div>
    <div class='col-md-9'>
      <?php if(isset($_POST['search'])) { ?>
      <h3>Busqueda de la ID: <?php echo $_POST['idCarga']; ?></h3>
      <table class='table table-bordered'>
        <thead>
          <tr align='center'>
            <th>#</th>
            <th>ID Cargamento</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Tipo de Carga</th>
            <th>Emision</th>
            <th>Entrega</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
      <?php } ?>
      
      <?php
        if (isset($_POST['search'])) {
          $idCarga = $_POST['idCarga'];

          $query = "SELECT * FROM dispatched, charges, status WHERE dispatched.id_load ='$idCarga' AND charges.id = dispatched.charger AND status.id = dispatched.status ORDER BY dispatched.ids ASC";
          $result_tasks = mysqli_query($conn, $query);

          if (mysqli_num_rows($result_tasks) > 0) {
            while($row = mysqli_fetch_assoc($result_tasks)) {
      ?>
          <tr align='center'>
            <td><?php echo $row['ids']; ?></td>
            <td><?php echo $row['id_load']; ?></td>
            <td><?php echo $row['origin']; ?></td>
            <td><?php echo $row['destination']; ?></td>
            <td><?php echo $row['charges_name']; ?></td>
            <td><?php echo $row['issue_date']; ?></td>
            <td><?php echo $row['delivery_date']; ?></td>
            <td><?php echo $row['status_name']; ?></td>
            <td>
              <a href='./Actions/EditData.php?id=<?php echo $row['ids']; ?>' class='btn btn-secondary'>
                <i class='fas fa-marker'></i>
              </a>
              <a href='./Actions/DeleteData.php?id=<?php echo $row['ids']; ?>' class='btn btn-danger'>
                <i  class='fas fa-trash-alt'></i>
              </a>
            </td>
          </tr>
      <?php }
          } else {
      ?>
          <tr>
            <td colspan='9' align='center'>Cargamento no encontrado verifique la ID del Cargamento</td>
          </tr>
      <?php }
        }
      ?>

      <?php if(isset($_POST['search'])) { ?>
        </tbody>
      </table>
      <?php } ?>

      <h3>Solicitudes de Cargamentos</h3>
      <table class='table table-bordered'>
        <thead>
          <tr align='center'>
            <th>#</th>
            <th>ID Cargamento</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Tipo de Carga</th>
            <th>Emision</th>
            <th>Entrega</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $query = 'SELECT * FROM dispatched, charges, status WHERE charges.id = dispatched.charger AND status.id = dispatched.status ORDER BY dispatched.ids ASC';
            $result_tasks = mysqli_query($conn, $query);

            while($row = mysqli_fetch_assoc($result_tasks)) {
          ?>
          <tr align='center'>
            <td><?php echo $row['ids']; ?></td>
            <td><?php echo $row['id_load']; ?></td>
            <td><?php echo $row['origin']; ?></td>
            <td><?php echo $row['destination']; ?></td>
            <td><?php echo $row['charges_name']; ?></td>
            <td><?php echo $row['issue_date']; ?></td>
            <td><?php echo $row['delivery_date']; ?></td>
            <td><?php echo $row['status_name']; ?></td>
            <td>
              <a href='./Actions/EditData.php?id=<?php echo $row['ids']; ?>' class='btn btn-secondary'>
                <i class='fas fa-marker'></i>
              </a>
              <a href='./Actions/DeleteData.php?id=<?php echo $row['ids']; ?>' class='btn btn-danger'>
                <i  class='fas fa-trash-alt'></i>
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<?php 
  include('./Template/footer.php');
?>
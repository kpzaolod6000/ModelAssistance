<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de Asistencias
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Lista de Asistencias </li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i>¡Proceso Exitoso!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <?php 
        $id_student = $user['cui'];
        $id_asig = 0;
        if ($_GET['idasig']) {
          $id_asig = $_GET['idasig'];
        }
      ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Hora de Asistencia</th>
                  <th>Fecha de Asistencia</th>
                  <th>Docente Responsable</th>
                  <th>Estados</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM assistances_student as2
                    INNER JOIN teachers t ON t.id = as2.id_teacher
                    WHERE as2.id_student = '$id_student' AND as2.id_asignature = '$id_asig'";
                    
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>". $row['hour_assistance']." </td>
                          <td>". $row['created_on']." </td>
                          <td>". $row['names']." ". $row['surnames']."</td>
                        ";

                      switch ($row['states']) {
                        case 'PUNTUAL':
                          echo "<td><i class='fa fa-check btn btn-success'></i> PUNTUAL</td>";
                          break;
                        case 'TARDE':
                          echo "<td><i class='fa fa-circle btn btn-warning'></i> TARDE</td>";
                          break;
                        case 'AUSENTE':
                          echo "<td><i class='fa fa-circle btn btn-danger'></i> AUSENTE</td>";
                          break;
                        case 'JUSTIFICADO':
                          echo "<td><i class='fa fa-circle btn btn-primary'></i> JUSTIFICADO</td>";
                          break;    
                        default:
                          echo "<td>No tiene registro de asistencia</td>";
                          break;
                      }
                      
                      echo "
                        </tr>
                        ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/employee_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.photo').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'employee_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.empid').val(response.empid);
      $('.employee_id').html(response.employee_id);
      $('.del_employee_name').html(response.firstname+' '+response.lastname);
      $('#employee_name').html(response.firstname+' '+response.lastname);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_address').val(response.address);
      $('#datepicker_edit').val(response.birthdate);
      $('#edit_contact').val(response.contact_info);
      $('#gender_val').val(response.gender).html(response.gender);
      $('#position_val').val(response.position_id).html(response.description);
      $('#schedule_val').val(response.schedule_id).html(response.time_in+' - '+response.time_out);
    }
  });
}
</script>
</body>
</html>

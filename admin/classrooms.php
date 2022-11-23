<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>
  
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--/** agrege esta extension para el alerta*/-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Listado de Aulas
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li>Aulas</li>
        <li class="active">Listado</li>
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
              <h4><i class='icon fa fa-check'></i> Éxito!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew_classrooms" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
              <input type = "file" id="upload-excel" class="form-upload hidden multiple" />
              
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>ID</th>
                  <th>Numero de Aula</th>
                  <th>Nombres</th>
                  <th>Creado en</th>
                  <th>Modificado en</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM classroom ORDER BY id DESC";
                    $query = $conn->query($sql);
                    $countT = 0;
                    while($row = $query->fetch_assoc()){
                      // <td>".number_format($row['amount'], 2)."</td>
                      $countT++;
                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".$countT."</td>
                          <td>".$row['nro_class']."</td>
                          <td>".$row['name']."</td>
                          <td>".date('M d, Y', strtotime($row['created_on']))."</td>
                          <td>".date('M d, Y', strtotime($row['modified_on']))."</td>
                          <td>
                            <button class='btn btn-success btn-sm edit_classroom btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Editar</button>
                            <button class='btn btn-danger btn-sm delete_classroom btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Eliminar</button>
                          </td>
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
  <?php include 'includes/modals/classrooms_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit_classroom').click(function(e){
    e.preventDefault();
    $('#edit_classroom').modal('show');
    var id = $(this).data('id');
    getDataClassroomForUpdate(id);
  });

  $('.delete_classroom').click(function(e){
    e.preventDefault();
    $('#delete_classroom').modal('show');
    var id = $(this).data('id');
    getDataClassroomForDelete(id);
  });
});

function getDataClassroomForUpdate(id){
  $.ajax({
    type: 'POST',
    url: 'classrooms_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('#edit_id').val(response.id);
      $('#edit_codes').val(response.code);
      $('#edit_names').val(response.names);
      $('#edit_credit').val(response.credit);
      $('#edit_Pre_requeriments').val(response.pre_requeriments);
    }
  });
}

function getDataClassroomForDelete(id){
  $.ajax({
    type: 'POST',
    url: 'classrooms_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('#delete_id').val(response.id);
      $('.asignature-name').html(response.names);
    }
  });
}
</script>
</body>
</html>


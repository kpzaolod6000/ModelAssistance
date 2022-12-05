<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>
  
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--/*agrege esta extension*/-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Listado de Estudiantes
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li>Estudiantes</li>
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
              <a href="#addnew_students" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
              <a onclick="uploadExcel()" class="btn btn-success btn-sm btn-flat"><i class="fa fa-upload"></i> Cargar</a>
              <input type = "file" id="upload-excel" class="form-upload hidden multiple" />
              
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>ID</th>
                  <th>Cui</th>
                  <th>Nombre Completo</th>
                  <th>Genero</th>
                  <th>Correo</th>
                  <th>Fecha de creación</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM students ORDER BY id DESC";
                    $query = $conn->query($sql);
                    $countS = 0;
                    while($row = $query->fetch_assoc()){
                      // <td>".number_format($row['amount'], 2)."</td>
                      $countS++;
                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".$countS."</td>
                          <td>".$row['cui']."</td>                          
                          <td>".$row['names'].' '.$row['surnames']."</td>
                          <td>".$row['gender']."</td>
                          <td>".$row['email']."</td>
                          <td>".date('M d, Y', strtotime($row['created_on']))."</td>
                          <td>
                            <button class='btn btn-success btn-sm edit_student btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Editar</button>
                            <button class='btn btn-danger btn-sm delete_student btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Eliminar</button>
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
  <?php include 'includes/modals/students_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit_student').click(function(e){
    e.preventDefault();
    $('#edit_student').modal('show');
    var id = $(this).data('id');
    getDataStudentForUpdate(id);
  });

  $('.delete_student').click(function(e){
    e.preventDefault();
    $('#delete_student').modal('show');
    var id = $(this).data('id');
    getDataStudentForDelete(id);
  });
});

function getDataStudentForUpdate(id){
  $.ajax({
    type: 'POST',
    url: 'students_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('.user_cui').html(response.cui);
      $('#edit_id').val(response.id);
      $('#edit_names').val(response.names);
      $('#edit_surnames').val(response.surnames);
      $('#edit_email').val(response.email);

      if (response.gender == "M") {
        console.log("hola")
        $('#edit_gender_m').prop( "checked", true );
      }else if (response.gender == "F") {
        $('#edit_gender_f').prop( "checked", true );
      }else{
        $('#edit_gender_m').prop( "checked", false );
        $('#edit_gender_f').prop( "checked", false );
      }
    }
  });
}

function getDataStudentForDelete(id){
  $.ajax({
    type: 'POST',
    url: 'students_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('#delete_id').val(response.id);
      $('.student-name').html(response.names+' '+response.surnames);
    }
  });
}

function uploadExcel(){
  const input_ = document.getElementById("upload-excel");
  input_.click();

  document.getElementById("upload-excel").addEventListener("change",()=>{
    let filename = document.getElementById("upload-excel").value;
    let idxDot = filename.lastIndexOf(".") + 1;
    let extFile = filename.substr(idxDot, filename.length).toLowerCase();
    if(extFile == "xlsx" || extFile == "csv"){
      let formData = new FormData();
      
      let excel = $("#upload-excel")[0].files[0];
      formData.append('excel',excel);
      
      $.ajax({
        url:'includes/handleExcel/handleExcelStudent.php',
        type:'POST',
        data:formData,
        contentType:false,
        processData:false,
        success:function(resp){
          // console.log(resp)
          let jsonData = JSON.parse(resp);
          const add_count = jsonData.success > 0?  true : false;
          if (add_count) {
            Swal.fire({
              title:"EXITO",
              text:jsonData.success +' estudiantes añadidos satisfactoriamente',
              icon:"success",
              confirmButtonText: "Ok"
            }).then(result => {
              if (result.value) {
                location.reload();
              }else{
                location.reload();
              }
            });
          }else{
            Swal.fire("WARNING","No se agrego ningun estudiante, los estudiantes ya se encuentran registrados","warning");
          }
          // $("#example1").load(location.href + " #example1");
        }
      });

      console.log(filename);
      document.getElementById("upload-excel").value = "";
      return false;
      //
    }else{
      Swal.fire("MENSAJE DE ADVERTENCIA","Solo se aceptan archivos excel\n. Usted subio un archivo de tipo "+ extFile,"warning");
      document.getElementById("upload-excel").value = "";
      // alert("no es un documento excel");
    }
  });
}

</script>
</body>
</html>


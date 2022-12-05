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
      Listado de Horarios
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li>Horarios</li>
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
              <a href="#addnew_schedules" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
              <a onclick="uploadExcel()" class="btn btn-success btn-sm btn-flat"><i class="fa fa-upload"></i> Cargar</a>
              <input type = "file" id="upload-excel" class="form-upload hidden multiple" />
              
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>ID</th>
                  <th>Hora</th>
                  <th>Tipo</th>
                  <th>Dia</th>
                  <th>Asignatura</th>
                  <th>Aula</th>
                  <th>Docente Responsable</th>
                  <th>Creado en</th>
                  <th>Modificado en</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT s.hour_ini , s.hour_end, s.types, s.dates, a.names,c.nro_class,concat(t.names,',',t.surnames) as 'NameTeacher', s.created_on, s.modified_on FROM schedule s INNER JOIN teachers t ON s.id_teacher = t.id INNER JOIN asignatures a ON s.id_asignature = a.id INNER JOIN classroom c ON s.id_classroom = c.id";
                    $query = $conn->query($sql);
                    $countT = 0;
                    while($row = $query->fetch_assoc()){
                      // <td>".number_format($row['amount'], 2)."</td>
                    //   echo $row;
                    // exit;
                      $countT++;
                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".$countT."</td>                        
                          <td>".$row['hour_ini'].' '.$row['hour_end']."</td>
                          <td>".$row['types']."</td>
                          <td>".$row['dates']."</td>
                          <td>".$row['names']."</td>
                          <td>".$row['nro_class']."</td>
                          <td>".$row['NameTeacher']."</td>
                          <td>".date('M d, Y', strtotime($row['created_on']))."</td>
                          <td>".date('M d, Y', strtotime($row['modified_on']))."</td>
                          <td>
                            <button class='btn btn-success btn-sm edit_schedule btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Editar</button>
                            <button class='btn btn-danger btn-sm delete_schedule btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Eliminar</button>
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
  <?php include 'includes/modals/schedules_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit_schedule').click(function(e){
    e.preventDefault();
    $('#edit_schedule').modal('show');
    var id = $(this).data('id');
    getDataTeacherForUpdate(id);
  });

  $('.delete_schedule').click(function(e){
    e.preventDefault();
    $('#delete_schedule').modal('show');
    var id = $(this).data('id');
    getDataTeacherForDelete(id);
  });
});

function getDataTeacherForUpdate(id){
  $.ajax({
    type: 'POST',
    url: 'schedules_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('.user_teacher_cui').html(response.cui);
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

function getDataTeacherForDelete(id){
  $.ajax({
    type: 'POST',
    url: 'schedules_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('#delete_id').val(response.id);
      $('.teacher-name').html(response.names+' '+response.surnames);
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
        url:'includes/handleExcel/handleExcelSchedule.php',
        type:'POST',
        data:formData,
        contentType:false,
        processData:false,
        success:function(resp){
          // console.log(JSON.parse(resp));
          console.log(resp);
          let jsonData = JSON.parse(resp);
          
          if (jsonData.success > 0) {
            Swal.fire({
              title:"EXITO",
              text:jsonData.success +' horario añadidos satisfactoriamente',
              icon:"success",
              confirmButtonText: "Ok"
            }).then(result => {
              if (result.value) {
                location.reload();
              }else{
                location.reload();
              }
            });
            
          } else if(jsonData.success < 0){
            Swal.fire("WARNING","No es un archivo de horarios","warning");
          }
          else{
            Swal.fire("WARNING","No se agrego ningun horarios, el horario ya se encuentran registrados","warning");
          }
          // $("#example1").load(location.href+" #example1>*","");
          // $("#example1").load(" #example1");
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


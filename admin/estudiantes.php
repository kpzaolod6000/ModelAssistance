<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>
  
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--/*agrege esta extension*/-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Asistencia
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
              <a onclick="uploadExcel()" class="btn btn-success btn-sm btn-flat"><i class="fa fa-upload"></i> Cargar</a>
              <input type = "file" id="upload-excel" class="form-upload hidden multiple" />
              
            </div>
            <!-- <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Fecha</th>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  <?php
                    // $sql = "SELECT *, cashadvance.id AS caid, employees.employee_id AS empid FROM cashadvance LEFT JOIN employees ON employees.id=cashadvance.employee_id ORDER BY date_advance DESC";
                    // $query = $conn->query($sql);
                    // while($row = $query->fetch_assoc()){
                    //   echo "
                    //     <tr>
                    //       <td class='hidden'></td>
                    //       <td>".date('M d, Y', strtotime($row['date_advance']))."</td>
                    //       <td>".$row['empid']."</td>
                    //       <td>".$row['firstname'].' '.$row['lastname']."</td>
                    //       // <td>".number_format($row['amount'], 2)."</td>
                    //       <td>
                    //         <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['caid']."'><i class='fa fa-edit'></i> Editar</button>
                    //         <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['caid']."'><i class='fa fa-trash'></i> Eliminar</button>
                    //       </td>
                    //     </tr>
                    //   ";
                    // }
                  ?>
                </tbody>
              </table>
            </div> -->
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/estudiantes_modal.php'; ?>
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
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'cashadvance_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('.date').html(response.date_advance);
      $('.employee_name').html(response.firstname+' '+response.lastname);
      $('.caid').val(response.caid);
      $('#edit_amount').val(response.amount);
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
        url:'includes/handleExcel.php',
        type:'POST',
        data:formData,
        contentType:false,
        processData:false,
        success:function(resp){
          Swal.fire("EXITO",resp,"success");
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


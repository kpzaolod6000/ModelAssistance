<?php

use Google\Service\CloudSearch\Value;

 include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
function test_($array){
  echo $array;
}
?>

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
      Listado de Cursos
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li>Cursos</li>
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
              <a href="#addnew_asignatures" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
              <input type = "file" id="upload-excel" class="form-upload hidden multiple" />
              
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th></th>
                  <th>ID</th>
                  <th>Código</th>
                  <th>Nombres</th>
                  <th>Creditos</th>
                  <th>Pre-requisitos</th>
                  <th>Creado en</th>
                  <th>Modificado en</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM asignatures ORDER BY names ASC";
                    $query = $conn->query($sql);
                    $countT = 0;

                    $sqlAsigStudent = "SELECT s.cui, concat(s.names,',',s.surnames) as NameStudent, ass.id_asignature, ass.groups, ass.nro_matr FROM asignatures a INNER JOIN asig_student ass ON a.id = ass.id_asignature INNER JOIN students s ON ass.id_student = s.id ORDER BY a.names ASC";
                    $queryAsigStudent = $conn->query($sqlAsigStudent);
                    $countAS = 0;
                    $rowAsigStudent = $queryAsigStudent->fetch_all(MYSQLI_ASSOC);
                  
                    $studentList = array();

                    while($row = $query->fetch_assoc()){
                      // <td>".number_format($row['amount'], 2)."</td>
                      $countT++;
                      // echo (int)$row['id'];
                    
                      foreach ($rowAsigStudent as $itemStudent) {
                          //printf("%s (%s)\n", $itemStudent["cui"],$itemStudent["NameStudent"]);
                          if((int) $row['id'] == (int) $itemStudent['id_asignature']){
                            array_push($studentList, $itemStudent);
                          //   $cui = $itemStudent['cui'];
                          // $nameStudent = $itemStudent['NameStudent'];
                          // $groups = $itemStudent['groups'];
                          // $nroMatri = $itemStudent['nro_matr'];
                        }
                      }
                      
                      
                      echo '
                      <tr data-toggle="collapse" data-target="#demo'.$countT.'" class="accordion-toggle">
                          <td><button class="btn btn-primary"><i class="fa fa-user-plus"></i></button></td>
                          <td class="hidden"></td>
                          <td>' . $countT . '</td>
                          <td>' . $row['code'] . '</td>
                          <td>' . $row['names'] . '</td>
                          <td>' . $row['credit'] . '</td>
                          <td>' . $row['pre_requeriments'] . '</td>
                          <td>' . date('M d, Y', strtotime($row['created_on'])) . '</td>
                          <td>' . date('M d, Y', strtotime($row['modified_on'])) . '</td>
                          <td>
                            <button class="btn btn-success btn-sm edit_asignature btn-flat" data-id="' . $row['id'] . '"><i class="fa fa-edit"></i> Editar</button>
                            <button class="btn btn-danger btn-sm delete_asignature btn-flat2" data-id="' . $row['id'] . '"><i class="fa fa-trash"></i> Eliminar</button>
                          </td>
                        </tr>

                        <tr>
                          <td colspan="12" class="hiddenRow">
                            <div class="accordian-body collapse" aria-expanded="false" id="demo'.$countT.'"> 
                            <table class="table table-striped">
                                    <thead>
                                      <tr class="info">
                                        <th>CUI</th>
                                        <th>Nombre Completo</th>
                                        <th>Grupo</th>
                                        <th>Nro.Matricula</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tbody'.$countT.'">
                                    </tbody>
                              </table>
                            </div> 
                          </td>
                        </tr>
                      ';
                      $count_ = 0;
                      foreach ($studentList as $itemStudent) {
                        $cui = $itemStudent['cui'];
                        $nameStudent = $itemStudent['NameStudent'];
                        $groups = $itemStudent['groups'];
                        $nroMatri = $itemStudent['nro_matr'];
                        $count_++;
                        // $txt = "<tr>
                        //   <td>$cui</td>
                        //   <td>$nameStudent</td>
                        //   <td>$groups</td>
                        //   <td>$nroMatri</td></tr>";

                        echo "<script>

                          var tbody$count_ = document.getElementById('tbody$countT');
                          let tr$count_ = document.createElement('tr');
                          
                          let td_cui$count_ = document.createElement('td');
                          td_cui$count_.textContent = '$cui';
                          tr$count_.appendChild(td_cui$count_);
                          let td_nameStudent$count_ = document.createElement('td');
                          td_nameStudent$count_.textContent = '$nameStudent';
                          tr$count_.appendChild(td_nameStudent$count_);
                          let td_groups$count_ = document.createElement('td');
                          td_groups$count_.textContent = '$groups';
                          tr$count_.appendChild(td_groups$count_);
                          let td_nroM$count_ = document.createElement('td');
                          td_nroM$count_.textContent = '$nroMatri';
                          tr$count_.appendChild(td_nroM$count_);
                          tbody$count_.appendChild(tr$count_);
                          </script>
                          ";
                      }
                      // }
                      // <tr>
                      //   <td>'.$studentList[0]['cui'].'</td>
                      //   <td>'.$studentList[0]['NameStudent'].'</td>
                      //   <td>'.$studentList[0]['groups'].'</td>
                      //   <td>'.$studentList[0]['nro_matr'].'</td>
                      // </tr>
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
  <?php include 'includes/modals/asignatures_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit_asignature').click(function(e){
    e.preventDefault();
    $('#edit_asignature').modal('show');
    var id = $(this).data('id');
    getDataAsignatureForUpdate(id);
  });

  $('.delete_asignature').click(function(e){
    e.preventDefault();
    $('#delete_asignature').modal('show');
    var id = $(this).data('id');
    getDataAsignatureForDelete(id);
  });
});

function getDataAsignatureForUpdate(id){
  $.ajax({
    type: 'POST',
    url: 'asignatures_row.php',
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

function getDataAsignatureForDelete(id){
  $.ajax({
    type: 'POST',
    url: 'asignatures_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('#delete_id').val(response.id);
      $('.asignature-name').html(response.names);
    }
  });
}


// function uploadExcel(){
//   const input_ = document.getElementById("upload-excel");
//   input_.click();

//   document.getElementById("upload-excel").addEventListener("change",()=>{
//     let filename = document.getElementById("upload-excel").value;
//     let idxDot = filename.lastIndexOf(".") + 1;
//     let extFile = filename.substr(idxDot, filename.length).toLowerCase();
//     if(extFile == "xlsx" || extFile == "csv"){
//       let formData = new FormData();
      
//       let excel = $("#upload-excel")[0].files[0];
//       formData.append('excel',excel);
      
//       $.ajax({
//         url:'includes/handleExcel/handleExcelTeacher.php',
//         type:'POST',
//         data:formData,
//         contentType:false,
//         processData:false,
//         success:function(resp){
//           let jsonData = JSON.parse(resp);
//           const add_count = jsonData.success > 0?  true : false;

//           if (add_count) {
//             Swal.fire({
//               title:"EXITO",
//               text:jsonData.success +' docentes añadidos satisfactoriamente',
//               icon:"success",
//               confirmButtonText: "Ok"
//             }).then(result => {
//               if (result.value) {
//                 location.reload();
//               }else{
//                 location.reload();
//               }
//             });
            
//           }else{
//             Swal.fire("WARNING","No se agrego ningun docente, los docentes ya se encuentran registrados","warning");
//           }
//           // $("#example1").load(location.href+" #example1>*","");
//           // $("#example1").load(" #example1");
//         }
//       });

//       console.log(filename);
//       document.getElementById("upload-excel").value = "";
//       return false;
//       //
//     }else{
//       Swal.fire("MENSAJE DE ADVERTENCIA","Solo se aceptan archivos excel\n. Usted subio un archivo de tipo "+ extFile,"warning");
//       document.getElementById("upload-excel").value = "";
//       // alert("no es un documento excel");
//     }
//   });
// }

</script>
</body>
</html>
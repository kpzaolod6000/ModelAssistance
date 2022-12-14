<?php
include 'includes/session.php';
require_once('loginGoogle.php');


if (isset($_GET['code'])) {

  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  $gender = $google_account_info->gender;
  $picture = $google_account_info->picture;
  // echo $email;
  // echo $name;
  // echo $gender;
  // echo $picture;

  
  $emailSplit = explode("@", $email);
  $extension = explode(".",$emailSplit[1]);
  if ($extension[0] == "unsa" && $extension[1] == "edu" && $extension[2] == "pe"){

      $sql = "SELECT * FROM teachers WHERE email = '$email'";
      $query = $conn->query($sql);

      if($query->num_rows < 1){
          $_SESSION['error'] = 'No se pudo encontrar la cuenta con esta cuenta de correo institucional';
          // header('location: index.php');
      }
      else{
          $row = $query->fetch_assoc();
          if($row['email'] == $email){
              $_SESSION['teacher'] = $row['id'];
          }
          else{
              $_SESSION['error'] = 'Email incorrecto';
              // header('location: index.php');
          }
      }
      // $client->revokeToken();

  }else{
      $_SESSION['error'] = 'Ingrese con un Correo Institucional';
      // header('location: index.php');
  }
}

?>
<?php include 'includes/session.php'; ?>
<?php 
  include '../timezone.php'; 
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }
?>
<?php include 'includes/header.php'; ?>
<style>
.container {
  padding: 2rem 0rem;
  width: 1400px;
}

h4 {
  margin: 2rem 0rem 1rem;
}

#footer{
    background: linear-gradient(90deg, rgba(15,0,4,1) 0%, rgba(77,1,23,1) 35%, rgba(106,0,31,1) 100%);
}
#footer a{
    color:whitesmoke;
}

.info-student{
  cursor:pointer;
}
.info-schedule{
  cursor:pointer;
}
.info-personal{
  cursor:pointer;
}
.info-asignature{
  cursor:pointer;
}

.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('imgs/loading.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}

.info-asig{
  display: flex;
  align-items: center;
  justify-content: center;
  margin-left: 50px;
  font-size: 40px;
}
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  	<?php include 'includes/navbar.php'; ?>
  	<?php include 'includes/menubar.php'; ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--/*agrege esta extension*/-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
         $id_docent = $_SESSION['teacher'];
         $sqlTeacher = "SELECT * FROM teachers WHERE teachers.id = '$id_docent'";
         $queryTeachers = $conn->query($sqlTeacher);
         $row_class = $queryTeachers->fetch_assoc();

          echo "<h1>"."Panel del Docente ".$row_class['names']." ".$row_class['surnames']."</h1>";
          echo '<input type="text" id="idT" value="'.$id_docent.'" hidden>';
      ?>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"> Panel del Docente</li>
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
  
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <?php
                // $sql = "SELECT * FROM employees";
                // $query = $conn->query($sql);

                // echo "<h3>".$query->num_rows."</h3>";
              ?>

              <h2>Asistencia Personal</h2>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a onclick="editContainer('personal')" class="small-box-footer info-personal">Más información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php
                // $sql = "SELECT * FROM attendance";
                // $query = $conn->query($sql);
                // $total = $query->num_rows;

                // $sql = "SELECT * FROM attendance WHERE status = 1";
                // $query = $conn->query($sql);
                // $early = $query->num_rows;
                
                // $percentage = ($early/$total)*100;

                // echo "<h3>".number_format($percentage, 2)."<sup style='font-size: 20px'>%</sup></h3>";
              ?>
          
              <h2>Asistencia de Estudiantes</h2>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a onclick ="editContainer('student')" class="small-box-footer info-student">Más información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php
                // $sql = "SELECT * FROM attendance WHERE date = '$today' AND status = 1";
                // $query = $conn->query($sql);

                // echo "<h3>".$query->num_rows."</h3>"
              ?>
             
              <h2>Horarios</h2>
            </div>
            <div class="icon">
              <i class="ion ion-clock"></i>
            </div>
            <a onclick ="editContainer('schedule')" class="small-box-footer info-schedule">Más información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <?php
                // $sql = "SELECT * FROM attendance WHERE date = '$today' AND status = 0";
                // $query = $conn->query($sql);

                // echo "<h3>".$query->num_rows."</h3>"
              ?>

              <h2>Cursos</h2>
            </div>
            <div class="icon">
              <i class="ion ion-ios-book"></i>
            </div>  
            <a onclick="editContainer('asignatures')" class="small-box-footer info-asignature">Más información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
    </section>

    <?php
      /**
       * @var mixed HASH
       */
      $username = password_hash("sin username", PASSWORD_DEFAULT);
      $password = password_hash("test", PASSWORD_DEFAULT);
      $hour_ = "hora";
      // echo $password;
      // echo $_SESSION['teacher'];
    ?>
    <?php include 'includes/scriptsJBM.php'; ?>
    <script type="text/javascript">

      var days_ = {Monday:"LUNES", Tuesday:"MARTES", Wednesday: "MIERCOLES", Thursday:"JUEVES", Friday: "VIERNES"};
      var momentNow = moment();
      const momentHour = momentNow.format('HH:MM:SS');
      
      const arrHour = momentHour.split(":");
      var day_= "";
      const hour_ = arrHour[0] +":"+arrHour[1];
      console.log(hour_);
      
      switch (momentNow.format('dddd')) {
        case 'Monday':
          day_ = days_.Friday;
          break;
        case 'Tuesday':
          day_ = days_.Tuesday;
          break;
        case 'Wednesday':
          day_ = days_.Wednesday;
          break;
        case 'Thursday':
          day_ = days_.Thursday;
          break;
        case 'Friday':
          day_ = days_.Friday;
          break;
        default:
          break;
      }
      console.log(day_);
    </script>

    <?php 
      $hour_ = "<script> document.write(hour_) </script>";
      $day_ = "<script> document.write(day_) </script>";
      // echo gettype($hour_);
      // echo gettype($day_);
      $sqlSelectAsig = "SELECT at2.id_asignature FROM asig_teacher at2 
      INNER JOIN schedule_group sg ON at2.id_asignature = sg.id_asignature 
      WHERE '$hour_' BETWEEN sg.hour_ini AND sg.hour_complete 
      AND sg.dates = '$day_'";
      // echo $sqlSelectAsig ;
      $querySelectAsig = $conn->query($sqlSelectAsig);
      $rowSelectAsig = $querySelectAsig->fetch_assoc();
      $id_asignature_filter = $rowSelectAsig['id_asignature'];

      $_SESSION['asig'] = $id_asignature_filter;
      echo '<input type="text" id="id_Asig" value="'.$id_asignature_filter.'" hidden>'
    ?>

    <!-- tabla -->

    <?php
      function activeTime($id_asignature_filter){
        if (!$id_asignature_filter) {
          echo '<div class="info-asig" id = "info-asig" style="display: block;">
                  <p id="date" style="display:flex; align-items: center; justify-content: center;"></p>
                  <p id="time" style="display:flex; align-items: center; justify-content: center;" class="bold"></p>
                  <p style="display:flex; align-items: center; justify-content: center;">Usted no tiene ninguna asignatura en este instante</p>
                </div>';
        }  
      }
      activeTime($id_asignature_filter);
    ?>
    
    <div class="loader" style="display: none;" id="loader"></div>
    <div class="container" style="display: block;" id="container">
        <div class="row">
          <div class="col-12">
            <table class="table table-bordered" id="table-assistances">
               <?php
               if ($id_asignature_filter) {
                 echo '
                  <thead>
                    <tr>
                      <th scope="col">Numero</th>
                      <th scope="col">Apellidos</th>
                      <th scope="col">Nombres</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  ';
               }
                ?>
              <tbody>

                <?php
                  // echo "asignature: " . $id_asignature_filter;

                  $sqlSelectT = "SELECT s.cui, s.surnames , s.names, as2.id_asignature, at2.id_teacher  FROM asig_student as2 
                  INNER JOIN students s ON as2.id_student = s.cui 
                  INNER JOIN asig_teacher at2 ON at2.id_asignature = as2.id_asignature 
                  WHERE as2.id_asignature = '$id_asignature_filter' AND at2.id_teacher = '$id_docent'
                  ORDER BY s.surnames ";

                  // s2.hour_ini, s2.hour_end, 
                  // INNER JOIN schedule s2 ON s2.id_teacher = t.id
                  // AND s2.dates = '$day_'
                  // AND (s2.hour_ini >= '$hour_' AND s2.hour_end <= '$hour_')

                  $count_ = 0;
                  $querySelectT = $conn->query($sqlSelectT);
                  while($rowSelectT = $querySelectT->fetch_assoc()){
                    $count_++;
                    echo '
                    <tr>
                      <th scope="row">'.$count_.'</th>
                      <td>'.$rowSelectT["surnames"].'</td>
                      <td>'.$rowSelectT["names"].'</td>
                      <td>
                        <button id = "btnStudent'.$count_.'" onclick ="editoEstado('.$count_.')" type="button" class="btn btn-success"><i id="student'.$count_.'" class="fa fa-circle" aria-hidden="true"></i> </button>
                        <button type="button" data-toggle="collapse" href="#collapseExample'.$count_.'" aria-expanded="false" aria-controls="collapseExample" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                        <div class="collapse" id="collapseExample'.$count_.'">
                            <div class="card card-body">
                                <div class="input-group-'.$count_.'" id = "input-group-'.$count_.'">
            
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input onclick ="editoEstado('.$count_.')" type="radio" class="custom-control-input rbAss'.$count_.'" id="rbPuntual'.$count_.'" name="estado'.$count_.'" value = "PUNTUAL">
                                        <label class="custom-control-label" for="rbPuntual'.$count_.'">Puntual</label>
                                    </div> 
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input onclick ="editoEstado('.$count_.')" type="radio" class="custom-control-input rbAss'.$count_.'" id="rbTarde'.$count_.'" name="estado'.$count_.'" value = "TARDE">
                                      <label class="custom-control-label" for="rbTarde'.$count_.'">Tarde</label>
                                    </div> 
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input onclick ="editoEstado('.$count_.')" type="radio" class="custom-control-input rbAss'.$count_.'" id="rbAusente'.$count_.'" name="estado'.$count_.'" value = "AUSENTE">
                                      <label class="custom-control-label" for="rbAusente'.$count_.'">Ausente</label>
                                    </div> 
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input onclick ="editoEstado('.$count_.')" type="radio" class="custom-control-input rbAss'.$count_.'" id="rbJustificado'.$count_.'" name="estado'.$count_.'" value = "JUSTIFICADO">
                                      <label class="custom-control-label" for="rbJustificado'.$count_.'">Justificado</label>
                                    </div>
                                    <input type="text" id="id_Student'.$count_.'" value="'.$rowSelectT['cui'].'" hidden>
                                </div>
                            </div>
                        </div>
                      </td>
                    </tr>
                    ';
                  }
                  echo '<input type="text" id="id_Teacher" value="'.$id_docent.'" hidden>'
                ?>
              </tbody>
            </table>
            <?php 
              if ($id_asignature_filter) {
              echo '
                  <div style="display: flex; justify-content: flex-end">
                  <button class="btn btn-primary btn-sm save_assistance btn-flat" >Guardar <i class="fa fa-save"></i></button>
                </div>  
                ';
              }
            ?>
          </div>
        </div>
      </div>
    <!-- /tabla -->  
    
    <script>
        $(function() {
            var interval = setInterval(function() {
            var momentNow = moment();
            $('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));
            // $('#time').html(momentNow.format('hh:mm:ss A'));
            $('#time').html(momentNow.format('hh:mm:ss a'));
          }, 100);
        });
          // info_.textContent = "Usted no tiene ninguna asignatura en este instante";      
    </script>

    <script>
        function editoEstado(numero) {
            var elemento = document.getElementById('student'+numero);
            var checkedpuntual=   document.getElementById("rbPuntual"+numero).checked;
            if(checkedpuntual)
            {
                var elemento = document.getElementById('student'+numero);
                elemento.className="fa fa-check";
                
                var elemento2 = document.getElementById('btnStudent'+numero);
                elemento2.className="btn btn-success";
                return;
            }
            var checkedtarde=   document.getElementById("rbTarde"+numero).checked;
            if(checkedtarde)
            {
                var elemento = document.getElementById('student'+numero);
                elemento.className="fa fa-circle";
                
                var elemento2 = document.getElementById('btnStudent'+numero);
                elemento2.className="btn btn-warning";
                return;
            }
            var checkedAusente=   document.getElementById("rbAusente"+numero).checked;
            if(checkedAusente)
            {
                var elemento = document.getElementById('student'+numero);
                elemento.className="fa fa-circle";
                
                var elemento2 = document.getElementById('btnStudent'+numero);
                elemento2.className="btn btn-danger";
                return;
            }
            var checkedJustificado=   document.getElementById("rbJustificado"+numero).checked;
            if(checkedJustificado)
            {
                var elemento = document.getElementById('student'+numero);
                elemento.className="fa fa-circle";
                
                var elemento2 = document.getElementById('btnStudent'+numero);
                elemento2.className="btn btn-primary";
                return;
            }
        }

        function editContainer(param) {
          const container = document.getElementById('container');
          var info_ = document.getElementById('info-asig');

          if (param == 'student') {

            
            const xhr = new XMLHttpRequest();            
            xhr.onload = function(){
              if (this.status === 200) {
                container.innerHTML = xhr.responseText;
              } else {
                console.warn("Falla de solicitud");
              }
            };
            
            xhr.open('post','assStudents/main.php');
            xhr.send();
            
          }else if(param == 'schedule'){
            const xhr = new XMLHttpRequest();            
            xhr.onload = function(){
              if (this.status === 200) {
                container.innerHTML = xhr.responseText;
              } else {
                console.warn("Falla de solicitud");
              }
            };
            xhr.open('post','assStudents/calendars.php');
            xhr.send();
          }else if(param == 'personal'){
            const xhr = new XMLHttpRequest();
            xhr.onload = function(){
              if (this.status === 200) {
                container.innerHTML = xhr.response;
              } else {

                console.warn("Falla de solicitud");
              }
            };
            xhr.open('post','assStudents/assistanceTeacher.php');
            xhr.send();
            
          }else if(param == 'asignatures'){
            const xhr = new XMLHttpRequest();
            xhr.onload = function(){
              if (this.status === 200) {
                container.innerHTML = xhr.response;
              } else {

                console.warn("Falla de solicitud");
              }
            };
            xhr.open('post','assStudents/asignaturesTeacher.php');
            xhr.send();
          }
          

        }
        
        
    </script>   
    <!-- /footer -->
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- ajax -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
    </div>
      
    <?php include 'includes/footer.php'; ?>
</div>
<script>
$(function() {
  $('.save_assistance').click(function(e){
    e.preventDefault();

    
    var table = document.getElementById("table-assistances");
    var totalRowCount = table.rows.length;
    // var tbodyRowCount = table.tBodies[0].rows.length; // 3
    var selectComp = true;
    var _data_ = [];
    

    for (let index = 1; index < totalRowCount; index++) {
      
      if($("input[type='radio'].rbAss"+index).is(':checked')) {
        const cuiStudent = $("#id_Student"+index).val();
        const idTeacher = $("#id_Teacher").val();
        const idAsig = $("#id_Asig").val();

        const card_type = $("input[type='radio'].rbAss"+index+":checked").val();
        ///**OJO ENVIAR EL ID DE CADA STUDIANTE*/ 
        const dat = { 
          idAsig: idAsig,
          idDocent: idTeacher,
          cuiStudent:cuiStudent,
          action: card_type,
          hour_: hour_
        };
        _data_.push(dat);
      }
      else{
        console.log("unsigned");
        selectComp = false;
        break;
      }
    }

    if (selectComp) {
      setDataAssistance(_data_);
    }else{
      Swal.fire("WARNING","Por favor, Seleccione la asistencia de todos los estudiantes","warning");
    }
  });
});

function setDataAssistance(_data_) {
  var container = document.getElementById('container');
  container.style.display = 'none';
  var loader = document.getElementById('loader');
  loader.style.display = 'block';

  $.ajax({
    type: 'POST',
    url: 'assStudents/assistanceAdd.php',
    data: {_data_ : _data_},
    dataType: 'json',
    success: function(response){
      console.log(response);

      if (response ) {
        Swal.fire("SUCCESS","Asistencia registrada","success");
        loader.style.display = 'none';
      }else{
        Swal.fire("WARNING","Por favor, vuelva a registrar la asistencia","warning");
        elem.style.display = 'block';
      }
    }
  });
};

</script>
<?php include 'modals/assistanceTeacher_modal.php'; ?>
<?php include 'includes/scripts.php'; ?>

<script>
function showModal(e){
  e.preventDefault();
  $('#marcar_save_modal').modal('show');

  const idA = $('.marcar_save').data('id');
  const name = $('.marcar_save').data('name');
  const idTeacher = $("#idT").val();
  
  $('#idAsignature').val(idA);
  $('#idTeacher').val(idTeacher);
  $('.modal-subtitle').html('<h3>'+name+'</h3>');
}

</script>
</body>
</html>

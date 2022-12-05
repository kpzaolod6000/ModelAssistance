<?php
include 'includes/conn.php';
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
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  	<?php include 'includes/navbar.php'; ?>
  	<?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
         $id_docent = $_SESSION['teacher'];
         $sqlTeacher = "SELECT * FROM teachers WHERE teachers.id = '$id_docent'";
         $queryTeachers = $conn->query($sqlTeacher);
         $row_class = $queryTeachers->fetch_assoc();

          echo "<h1>"."Panel del Docente ".$row_class['names']." ".$row_class['surnames']."</h1>"
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
            <a href="employee.php" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
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
          
              <h2>Asistencias de Estudiantes</h2>
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
            <a href="attendance.php" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="attendance.php" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
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
      // echo $password;
      echo $_SESSION['teacher'];
    ?>
    
    <!-- tabla -->
    <div class="container" id="container">
        <div class="row">
          <div class="col-12">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Numero</th>
                  <th scope="col">Apellidos</th>
                  <th scope="col">Nombres</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Tamo Turpo</td>
                  <td>David Ernesto</td>
                  <td>
                    <button id = "btnStudent1" onclick ="editoEstado('1')" type="button" class="btn btn-success"><i id="student1" class="fa fa-check" aria-hidden="true"></i> </button>
                    <button type="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <div class="input-group">
        
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input onclick ="editoEstado('1')" type="radio" class="custom-control-input" id="rbPuntual1" name="estado">
                                    <label class="custom-control-label" for="rbPuntual1">Puntual </label>
                                </div> 
                                  <div class="custom-control custom-radio custom-control-inline">
                                    <input onclick ="editoEstado('1')" type="radio" class="custom-control-input" id="rbTarde1" name="estado">
                                    <label class="custom-control-label" for="rbTarde1">Tarde</label>
                                  </div> 
                                  <div class="custom-control custom-radio custom-control-inline">
                                    <input onclick ="editoEstado('1')" type="radio" class="custom-control-input" id="rbAusente1" name="estado">
                                    <label class="custom-control-label" for="rbAusente1">Ausente</label>
                                  </div> 
                                  <div class="custom-control custom-radio custom-control-inline">
                                    <input onclick ="editoEstado('1')" type="radio" class="custom-control-input" id="rbJustificado1" name="estado">
                                    <label class="custom-control-label" for="rbJustificado1">Justificado</label>
                                  </div> 
                            </div>
                            
                        </div>
                        
                      </div>
                  </td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Pucho Zevallos</td>
                  <td>Kelvin Paul </td>
                  <td>
                    <button type="button" class="btn btn-primary"><i class="fa fa-circle"></i></button>
                    <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                  
                  </td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td> Sihuinta Perez</td>
                  <td>Luis Armando  </td>
                  <td>
                    <button type="button" class="btn btn-primary"><i class="far fa-eye"></i></button>
                    <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                  
                  </td>
                </tr>
              </tbody>
            </table>
            
          </div>
        </div>
      </div>
    <!-- /tabla -->  

    <script>
        function editoEstado(numero) {
            var elemento = document.getElementById('student'+numero);
            var checkedpuntual=   document.getElementById("rbPuntual"+numero).checked;
            if(checkedpuntual)
            {
                var elemento = document.getElementById('student'+numero);
                elemento.className="fa fa-circle";
                
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
          const constainer = document.getElementById('container');
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
          }
          

        }
        
        
    </script>   
    <!-- /footer -->
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
    </div>
      
    <?php include 'includes/footer.php'; ?>
</div>
     
</body>
</html>

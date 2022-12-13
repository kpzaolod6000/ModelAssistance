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

      $sql = "SELECT * FROM students WHERE email = '$email'";
      $query = $conn->query($sql);

      if($query->num_rows < 1){
          $_SESSION['error'] = 'No se pudo encontrar la cuenta con esta cuenta de correo institucional';
          // header('location: index.php');
      }
      else{
          $row = $query->fetch_assoc();
          if($row['email'] == $email){
              $_SESSION['student'] = $row['id'];
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
         $id_docent = $_SESSION['student'];
         $sqlTeacher = "SELECT * FROM students WHERE students.id = '$id_docent'";
         $queryTeachers = $conn->query($sqlTeacher);
         $row_class = $queryTeachers->fetch_assoc();

          echo "<h1>"."Panel del Estudiante ".$row_class['names']." ".$row_class['surnames']."</h1>";
          echo '<input type="text" id="idT" value="'.$id_docent.'" hidden>';
      ?>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"> Panel del Estudiante</li>
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
      console.log(momentHour);
      const arrHour = momentHour.split(":");
      var day_= "";
      const hour_ = arrHour[0] +":"+arrHour[1];
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
      
    </script>

    <?php 
      $hour_ = "<script> document.write(hour_) </script>";
      $day_ = "<script> document.write(day_) </script>";

      $sqlSelectAsig = "SELECT at2.id_asignature FROM asig_teacher at2 
      INNER JOIN schedule_group sg ON at2.id_asignature = sg.id_asignature 
      WHERE '$hour_' BETWEEN sg.hour_ini AND sg.hour_complete 
      AND sg.dates = '$day_'";
      $querySelectAsig = $conn->query($sqlSelectAsig);
      $rowSelectAsig = $querySelectAsig->fetch_assoc();
      $id_asignature_filter = $rowSelectAsig['id_asignature'];

      $_SESSION['asig'] = $id_asignature_filter;
      echo '<input type="text" id="id_Asig" value="'.$id_asignature_filter.'" hidden>'
    ?>
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
</body>
</html>

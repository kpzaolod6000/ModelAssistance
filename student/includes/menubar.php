<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/student.jpg'; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <a><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">REPORTES</li>
        <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Panel de Control</span></a></li>

        <li class="header">CURSOS MATRICULADOS</li>

        <?php 
        $id_student = $user['cui'];
        
        $sql = "SELECT a.id,a.names FROM asig_student as2
        INNER JOIN asignatures a ON as2.id_asignature = a.id 
        WHERE as2.id_student = '$id_student' ORDER BY a.names";

        $query = $conn->query($sql);
        $countS = 0;

        while($row = $query->fetch_assoc()){
          echo '<li style="cursor:pointer;"><a href="assistanceStudent.php?idasig='.$row["id"].'"><i class="fa fa-book"></i><p>'.$row["names"].'</p></a></li>';
        }

        ?>
        
        <!-- <li><a href="assistanceStudent.php"><i class="fa fa-book"></i>P. Paralela y Distribuida</a></li>
        <li><a href="assistanceStudent.php"><i class="fa fa-book"></i>Robotica</a></li>
        <li><a href="assistanceStudent.php"><i class="fa fa-book"></i>Topicos de Seguridad</a></li>
        <li><a href="assistanceStudent.php"><i class="fa fa-book"></i>Trabajo Interdisciplinar III</a></li> -->

        <li class="header">IMPRIMIBLES</li>
        <li><a href="#"><i class="fa fa-files-o"></i> <span>Reporte de Asistencia diaria</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
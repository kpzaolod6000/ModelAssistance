<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $user['names']; ?></p>
          <p><?php echo $user['surnames']; ?></p>
          <a><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">REPORTES</li>
        <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Panel de Control</span></a></li>

        <li class="header">CURSOS MATRICULADOS</li>
        <li><a href="assistanceStudent.php"><i class="fa fa-book"></i>P. Paralela y Distribuida</a></li>
        <li><a href="assistanceStudent.php"><i class="fa fa-book"></i>Robotica</a></li>
        <li><a href="assistanceStudent.php"><i class="fa fa-book"></i>Topicos de Seguridad</a></li>
        <li><a href="assistanceStudent.php"><i class="fa fa-book"></i>Trabajo Interdisciplinar III</a></li>

        <li class="header">IMPRIMIBLES</li>
        <li><a href="#"><i class="fa fa-files-o"></i> <span>Reporte de Asistencia diaria</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
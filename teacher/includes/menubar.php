<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $user['firstname'].' '.$user['lastname']; ?></p>
          <a><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">REPORTES</li>
        <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Panel de Control</span></a></li>

        <li class="header">GESTION DE RECURSOS</li>
        <li><a href="#"><i class="fa fa-calendar"></i> <span>Asistencia</span></a></li>
        <li><a href="#"><i class="fa fa-book"></i> Cursos</a></li>
        <li><a href="#"><i class="fa fa-tablet"></i> Aulas</a></li>
        <li><a href="#"><i class="fa fa-clock-o"></i> Horarios</a></li>

        <li class="header">IMPRIMIBLES</li>
        <li><a href="#"><i class="fa fa-files-o"></i> <span>Reporte de Asistencia diaria</span></a></li>
        <li><a href="#"><i class="fa fa-clock-o"></i> <span>Horarios</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
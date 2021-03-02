  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="<?php echo constant('URL'). $this->GetDatos('photo');?>" 
          class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?php echo $this->GetDatos('user_name');?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <!-- <img src="<?php //echo constant('URL'). $this->GetDatos('photo');?>" class="img-circle elevation-2" alt="User Image"> -->
            <p>

              <!-- <small><?php //echo $_SESSION['cargo'];?> desde <?php //echo $_SESSION['fecha_cargo'];?></small> -->
            </p>
          </li>
          <!-- <li class="user-body bg-default">
            <p>
              <small><strong>Correo: </strong><?php //echo $_SESSION['correo'];?></small>

            </p>
            <p>
              <small><strong>Telefono: </strong><?php //echo $_SESSION['telefono'];?></small>
            </p>
          </li> -->
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Perfil</a>
            <a href="<?php echo constant('URL');?>Login/Logout" class="btn btn-default btn-flat float-right">Salir</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-2">
      <!-- Brand Logo -->
      <a href="<?php echo constant('URL');?>" class="brand-link">
        <!-- <img src="views/img/b.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8"> -->
        <span class="brand-text font-weight-light">Bienes Nacionales</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?php echo constant('URL');?>Home" class="nav-link active">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Inicio
                </p>
              </a>
            </li>
            <li class="nav-item nas-treeview menu-close">
              <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-pen"></i>
                  <p>
                    Registros
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Nucleo" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Nucleo</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Dependencias" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dependencias</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Cargos" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cargos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Personas" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Personas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Marcas" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Marcas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Modelos" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Modelos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Especies" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Especies</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Razas" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Razas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Clasificacion" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Clasificacion</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Bienes" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bienes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo constant('URL');?>Materiales" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Materiales</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview menu-close">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Bienes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Incorporacion" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Incorporacion</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Reasignacion" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Reasignacion</p>
                  </a>
  			        </li>
                <li class="nav-item">
                  <a href="Desincorporacion" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Desincorporacion</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="Reportes" class="nav-link active">
                <i class="nav-icon fas fa-file-pdf"></i>
                <p>
                  Reportes
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview menu-close">
              <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                    Configuracion
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo constant('URL');?>Login/Logout" class="nav-link active">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Salir</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>

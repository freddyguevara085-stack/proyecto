<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Escolar </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?=BASE_URL?>index">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span></a>
            </li>

         <?php
    if (Sessiones::accesoVista('administrador')) {
      ?>


            <!-- Divider -->
            <hr class="sidebar-divider">

             <li class="nav-item ">
                <a class="nav-link" href="<?=BASE_URL?>alumno">
                    <i class="fas fa-solid fa-user-graduate"></i>
                    <span>Alumnos</span></a>
            </li>

          

            <!-- Divider -->
            <hr class="sidebar-divider">

             <li class="nav-item ">
                <a class="nav-link" href="<?=BASE_URL?>docente">
                   <i class="fa-solid fa-chalkboard-user"></i>
                    <span>Docentes</span></a>
            </li>

             <hr class="sidebar-divider">

             <li class="nav-item ">
                <a class="nav-link" href="<?=BASE_URL?>grupo">
                   <i class="fa-solid fa-users"></i>
                    <span>Grupos</span></a>
            </li>

            <hr class="sidebar-divider">

             <li class="nav-item ">
                <a class="nav-link" href="<?= BASE_URL ?>materia">
                    <i class="fas fa-solid fa-book"></i>
                    <span>Materia</span></a>
            </li>

            <hr class="sidebar-divider">

             <li class="nav-item ">
                <a class="nav-link" href="<?= BASE_URL ?>matricula">
                    <i class="fa-solid fa-id-card"></i>
                    <span>Matrícula</span></a>
            </li>

            <hr class="sidebar-divider">

             <li class="nav-item ">
                <a class="nav-link" href="<?= BASE_URL ?>asignacioncomponente">
                    <i class="fa-solid fa-book-open-reader"></i>
                    <span>Asignación Componente</span></a>
            </li>


             <hr class="sidebar-divider">

             <li class="nav-item ">
                <a class="nav-link" href="<?= BASE_URL ?>usuario">
                    <i class="fa-solid fa-user"></i>
                    <span>Usuario</span></a>
            </li>

              <?php 
            
    }

            ?>

          <?php 
          
           if (Sessiones::accesoVista('alumno')) {
          ?>

           <hr class="sidebar-divider">

             <li class="nav-item ">
                <a class="nav-link" href="<?= BASE_URL ?>inscripcionComponente">
                    <i class="fa-solid fa-book-open-reader"></i>
                    <span>Inscripción Componente</span></a>
            </li>

             <li class="nav-item ">
                <a class="nav-link" href="<?= BASE_URL ?>notas">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span>Ver Notas</span></a>
            </li>

            <?php 
           }
            ?>



             <hr class="sidebar-divider">

              <?php
    if (Sessiones::getClave('autenticado')) {
      echo '
      <li class="nav-item">
        <a class="nav-link collapsed" href="' . BASE_URL . 'login/salir">
        <i class="fa-solid fa-right-from-bracket"></i>
          <span>Salir</span>
        </a>
      </li>';
    } else {
      echo '
      <li class="nav-item">
        <a class="nav-link collapsed" href="' . BASE_URL . 'login">
        <i class="fa-solid fa-right-to-bracket"></i>
          <span>Ingresar</span>
        </a>
      </li>';
    }
    ?>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            

           

        </ul>
        <!-- End of Sidebar -->
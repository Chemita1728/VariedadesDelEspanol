<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Variedades Del Español</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>/css/sb-admin-2.min.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>/js/busquedas.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


</head> 

<body id="page-top">
    </html>
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url(); ?>/recursos">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                    </div>
                    <div class="sidebar-brand-text mx-3">Variedades Del Espanol</sup></div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo base_url(); ?>/recursos">
                        <i class="fas fa-home"></i>
                        <span>Pagina Principal</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo base_url(); ?>/recursos/recursos">
                        <i class="fas fa-info"></i>
                        <span>Ver Recursos</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <?php if (session('role') >= 2) { ?>
                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
                            aria-expanded="true" aria-controls="collapseUsuarios">
                            <i class="fas fa-users"></i>
                            <span>Usuarios</span>
                        </a>
                        <div class="collapse" id="collapseUsuarios" >
                            <div class="bg-white py-2 collapse-inner rounded">
                                <!--<h6 class="collapse-header">Ajustes de Usuarios:</h6>-->
                                <a class="collapse-item" href="<?php echo base_url(); ?>/usuarios/usuariosActivos">Usuarios Activos</a>
                                <a class="collapse-item" href="<?php echo base_url(); ?>/usuarios/usuariosNoActivos">Usuarios No Activos</a>
                                <a class="collapse-item" href="<?php echo base_url(); ?>/usuarios/misColaboradores">Mis Colaboradores</a>
                                <a class="collapse-item" href="<?php echo base_url(); ?>/usuarios/nuevoUsuario">Registrar Usuario</a>
                                <a class="collapse-item" href="<?php echo base_url(); ?>/usuarios/registroMasivo">Registrar Masivo</a>
                            </div>
                        </div>
                    </li>
                <?php } ?> 

                <!-- Divider -->
                <hr class="sidebar-divider my-0">
                
                <?php if (session('role') >= 1) { ?>
                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecursos"
                            aria-expanded="true" aria-controls="collapseRecursos">
                            <i class="fas fa-users"></i>
                            <span>Recursos</span>
                        </a>
                        <div class="collapse" id="collapseRecursos" >
                            <div class="bg-white py-2 collapse-inner rounded">
                                <!--<h6 class="collapse-header">Ajustes de Usuarios:</h6>-->
                                <a class="collapse-item" href="<?php echo base_url(); ?>/recursos/nuevoRecurso">Nuevo Recurso</a>    
                                <a class="collapse-item" href="<?php echo base_url(); ?>/recursos/aRevisar/<?php echo session('role'); ?>">Recursos que Revisar</a>    
                            </div>
                        </div>
                    </li>
                <?php } ?> 

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <?php if (session('role') >= 2) { ?>
                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCaracteristicas"
                            aria-expanded="true" aria-controls="collapseCaracteristicas">
                            <i class="fas fa-users"></i>
                            <span>Caracteristicas</span>
                        </a>
                        <div class="collapse" id="collapseCaracteristicas" >
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="<?php echo base_url(); ?>/recursos/nuevaPronunciacion">Agregar Pronunciación</a>
                                <a class="collapse-item" href="<?php echo base_url(); ?>/recursos/nuevaGramatica">Agregar Gramaticas</a>
                            </div>
                        </div>
                    </li>
                <?php } ?> 

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <i class="fas fa-info"></i>
                        <span>Sobre Nosotros</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">
                
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
            <!-- End of Sidebar -->

            <!-- ----------------------------------------- -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <?php if (session('role') == NULL) { ?>
                            <!-- Nav Item - Usuario Anonimo -->
                            <li class="navbar-nav ml-auto dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 medium">Usuario Anonimo</span>
                                    
                                </a>
                                <!-- Dropdown - Usuario Anonimo -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>/usuarios/inicioSesion">Perdir Registro</a>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>/usuarios/inicioSesion">Iniciar Sesión</a>
                                </div>
                            </li> 
                        <?php } ?>   

                        <?php if (session('role') != 0) { ?>
                            <!-- Nav Item - Usuario Registrado -->
                            <li class="navbar-nav ml-auto dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 medium"><?php echo session('nombre'); ?></span>
                                    
                                </a>
                                <!-- Dropdown - Usuario Registrado -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                                    <a class="dropdown-item" href="<?php echo base_url(); ?>/usuarios/datosPersonales">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Datos Personales
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>/usuarios/logout" >
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Cerrar Sesión
                                    </a>
                                </div>
                            </li>
                        <?php } ?>                     

                    </nav>


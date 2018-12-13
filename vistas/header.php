<?php
if (strlen(session_id()) < 1)
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema Control | STC </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- BOOTSTRAP 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <link rel="stylesheet" href="../public/fonts/font-awesome.min.css">
    <!-- TEMA DE LA PLANTILLA -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- SKINS ADMIN TLE PARA CARGAR. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <!-- HOJA DE ESTILO DEL LOGIN PAGE -->
    <link rel="stylesheet" href="../public/css/estilo.css">
    <!-- HOJA DE ESTILO PERSONALIZADO EXTRAS -->
    <link rel="stylesheet" href="../public/css/estilospersonalizados.css">
    <!-- FAVICON Y APPLE TOUCH ICON -->
    <link rel="apple-touch-icon" href="../public/img/icon7-e1491341523797.ico">
    <link rel="shortcut icon" href="../public/img/favicon.ico">
    <!-- FUENTES DE GOOGLE -->
    <link rel="stylesheet" type="text/css" href="../public/fonts/fuentesgoogle.css">
    <!-- LIBRERIA PARA CREAR EDITOR TEXTO EN TEXTAREA -->
    <link rel="stylesheet" href="../public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- LIBRERIAS ALERTAS: JQUERY CONFIRM -->
    <link rel="stylesheet" href="../public/jqueryalert/css/jquery-confirm.min.css">
    <!-- LIBRERIAS ALERTAS: SWEETALERT 2 -->
    <link rel="stylesheet" type="text/css" href="../public/css/sweetalert2.css">
    <!-- LIBRERIA DE BOOSTRAP PARA COMBOBOX (SeleckPicker) -->
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

    <!-- DATATABLES-->
    <link rel="stylesheet" type="text/css" href="../public/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../public/datatables/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../public/datatables/rowGroup.dataTables.min.css">

  </head>

  <body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="escritorio.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>STC</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Sistema</b> Control</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header" style="background-color:#02884c">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                      Desarrollo por EliteSystemConsulting
                      <small>www.youtube.com</small>
                    </p>
                  </li>

                  <!-- Menu Footer-->
                  <li class="user-footer" style="background-color:#00a85d">
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Sistema Siticom</p>
              <a href="#"><i class="fa fa-circle text-success"></i><?php echo $_SESSION['nombre']; ?> Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <br>
            <li class="header">MENU DE NAVEGACION DEL SISTEMA</li>


            <?php
            if ($_SESSION['escritorio']==1)
            {
              echo '<li>
                <a href="escritorio.php">
                  <i class="fa fa-home"></i> <span>Principal</span>
                </a>
              </li>';
            }
            ?>

            <?php
            if($_SESSION['inventarios']==1)
            {
              echo '<li class="treeview">
                  <a href="#">
                    <i class="fa fa-fw fa-th"></i>
                    <span>Catalogo</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">

                    <li><a href="categoria.php"><i class="fa fa-fw fa-cube"></i>Gestionar Categorías</a></li>
                      <li><a href="marca.php"><i class="fa fa-star"></i>Gestionar Marca</a></li>
                        <li><a href="unidadmedida.php"><i class="fa fa-hourglass-start"></i>Gestionar Und. Medida</a></li>
                          <li><a href="producto.php"><i class="fa fa-cart-arrow-down"></i>Gestionar Productos</a></li>
                             <li><a href="tipoproducto.php"><i class="fa fa-fw fa-exclamation"></i>Gestionar Tipo Productos</a></li>
                  </ul>
                </li>';
            }
            ?>

            <?php

              echo '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-laptop"></i>
                      <span>Operaciones</span>
                       <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="proveedor.php"><i class="fa fa-fw  fa-asterisk"></i>Gestionar Proveedores</a></li>
                      <li><a href="cliente.php"><i class="fa fa-fw  fa-asterisk"></i>Gestionar Clientes</a></li>

                    </ul>
                  </li>';

            ?>

            <?php
            if($_SESSION['compras']==1)
            {
              echo '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-fw fa-database"></i>
                      <span>Almacen</span>
                       <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ingreso.php"><i class="fa fa-balance-scale"></i> Reponer Stock</a></li>
                      <li><a href="almacen_general.php"><i class="fa fa-institution"></i>Almacen General</a></li>
                      <li><a href="transferencia.php"><i class="fa fa-exchange"></i>Traspaso</a></li>
                      <li><a href="nota_almacen.php"><i class="fa fa-file-o"></i>Notas de Almacen</a></li>
                      <li><a href="transferencia.php"><i class="fa fa-info"></i>Inventario Inicial</a></li>

                    </ul>
                  </li>';
            }
            ?>
  <!-- <li><a href="transferencia.php"><i class="fa fa-cog"></i>Ajuste de inventario</a></li>
    <li><a href="transferencia.php"><i class="fa fa-info"></i>Kardex de Productos</a></li> -->
            <?php
            if($_SESSION['compras']==1)
            {
              echo '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-clone"></i>
                      <span>Reportes Almacen</span>
                       <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ingreso.php"><i class="fa fa-fw fa-slack"></i>Reporte de Stock General</a></li>
                      <li><a href="ingreso.php"><i class="fa fa-fw fa-slack"></i>Reporte de Stock Valorizado</a></li>
                    </ul>
                  </li>';
            }
            ?>

            <?php
            if($_SESSION['compras']==1)
            {
              echo '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-fw fa-search"></i>
                      <span>Consultas Almacen</span>
                       <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ingreso.php"><i class="fa fa-fw fa-navicon"></i>Reporte de Stock General</a></li>
                      <li><a href="ingreso.php"><i class="fa fa-fw fa-navicon"></i>Reporte de Stock Valorizado</a></li>
                    </ul>
                  </li>';
            }
            ?>
  <!-- <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li> -->


            <?php
            if($_SESSION['ventas']==1)
            {
              echo '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-shopping-cart"></i>
                      <span>Salidas</span>
                       <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="punto_venta.php"><i class="fa fa-circle-o"></i>Punto de Venta</a></li>
                      <li><a href="venta.php"><i class="fa fa-circle-o"></i>Realizar Ventas</a></li>

                    </ul>
                  </li>';
            }
            ?>
  <!-- <li><a href="cliente.php"><i class="fa fa-circle-o"></i> Clientes</a></li> -->


            <?php
            if($_SESSION['accesos']==1)
            {
              echo '<li class="treeview">
                <a href="#">
                  <i class="fa fa-fw fa-expeditedssl"></i> <span>Acceso</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                  <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                </ul>
              </li>'
              ;
            }
            ?>



            <?php

            if($_SESSION['reportes']==1)
            {
              echo '<li class="treeview">
                  <a href="#">
                    <i class="fa fa-clone"></i> <span>Generar Reportes</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                   <ul class="treeview-menu">
                    <li><a href="comprasfecha.php"><i class="fa fa-circle-o"></i> Consulta Ingresos</a></li>
                    <li><a href="ventasfechacliente.php"><i class="fa fa-circle-o"></i> Consulta Ventas</a></li>
                      <li><a target="_blank" href="../reportes/rptarticulos.php"><i class="fa fa-circle-o"></i> Consulta Productos</a></li>
                  </ul>
                </li>'
              ;
            }
            ?>


            <!-- ESTA SECCION NO IRA -->


            <!-- <li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Consulta Ventas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="consultaventas.php"><i class="fa fa-circle-o"></i> Consulta Ventas</a></li>
              </ul>
            </li> -->

            <!-- <li>
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li> -->

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

<?php
session_start();
require 'class/cl_laboratorio.php';
require 'class/cl_presentacion.php';

$c_presentacion = new cl_presentacion();
$c_laboratorio = new cl_laboratorio();

$title = "Registro de Producto - Farmacia - Luna Systems Peru";
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title><?php echo $title; ?></title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css"/>
    <link rel="stylesheet" href="vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css"/>

    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css"/>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet"
          href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css"
          type="text/css"/>
</head>
<body class="fixed-navbar fixed-sidebar">

<!-- Simple splash screen-->
<div class="splash">
    <div class="color-line"></div>
    <div class="splash-title"><h1><?php echo $title; ?></h1>
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>
</div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a
        href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Header -->
<?php include("includes/header.php"); ?>

<!-- Navigation -->
<?php include("includes/navigation.php"); ?>

<!-- Main Wrapper -->
<div id="wrapper">
    <div class="normalheader transition animated fadeIn">
        <div class="hpanel">
            <div class="panel-body">
                <a class="small-header-action" href="#">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>

                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="index.php">Dashboard</a></li>
                        <li>
                            <span>Almacen</span>
                        </li>
                        <li class="active">
                            <span>Producto</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Registro de Producto

            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <form class="form-horizontal" name="frm_reg_producto" id="frm_reg_producto"
                          action="procesos/reg_producto.php" method="post">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">NOMBRE: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control"
                                           name="input_nombre" id="input_nombre"
                                           max-lenght="245" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">PRINCIPIO ACTIVO: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="input_principio_activo"
                                           id="input_principio_activo" max-lenght="245" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">LABORATORIO:</label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="select_laboratorio">
                                        <?php
                                        $a_laboratorio = $c_laboratorio->ver_laboratorios();
                                        foreach ($a_laboratorio as $fila) {
                                            echo '<option value="' . $fila['id_laboratorio'] . '">' . $fila['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <a href="ver_laboratorios.php" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Crear Laboratorio</a>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">PRESENTACION:</label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="select_presentacion">
                                        <?php
                                        $a_presentacion = $c_presentacion->ver_presentaciones();
                                        foreach ($a_presentacion as $fila) {
                                            echo '<option value="' . $fila['id_presentacion'] . '">' . $fila['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <a href="ver_presentaciones.php" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Crear Presentacion</a>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">COSTO: </label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control text-right" name="input_costo"
                                           id="input_costo" max-lenght="15" required/>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">PRECIO: </label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control text-right" name="input_precio"
                                           id="input_precio" max-lenght="9" required/>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer text-right">
                            <button class="btn btn-primary" type="submit" id="registrar_productos" >Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <!-- Right sidebar -->
    <?php include("includes/right_sidebar.php"); ?>

    <!-- Footer-->
    <?php include("includes/footer.php"); ?>

</div>

<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>
<!-- DataTables -->
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DataTables buttons scripts -->
<script src="vendor/pdfmake/build/pdfmake.min.js"></script>
<script src="vendor/pdfmake/build/vfs_fonts.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<!-- App scripts -->
<script src="scripts/homer.js"></script>

</body>

</html>




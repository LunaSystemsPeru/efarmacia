<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_kardex.php';
require 'class/cl_producto.php';
require 'class/cl_presentacion.php';
require 'class/cl_laboratorio.php';

$c_producto = new cl_producto();
$c_kardex = new cl_kardex();

$c_kardex->setIdEmpresa($_SESSION['id_empresa']);
$c_kardex->setIdSurcursal($_SESSION['id_sucursal']);
$c_kardex->setIdProducto(filter_input(INPUT_GET, 'id_producto'));

$c_producto->setIdProducto($c_kardex->getIdProducto());
$c_producto->setIdEmpresa($c_kardex->getIdEmpresa());
$c_producto->obtener_datos();

$c_presentacion = new cl_presentacion();
$c_presentacion->setIdPresentacion($c_producto->getIdPresentacion());
$c_presentacion->obtener_datos();

$c_laboratorio = new cl_laboratorio();
$c_laboratorio->setIdLaboratorio($c_producto->getIdLaboratorio());
$c_laboratorio->obtener_datos();

$title = "Ver Kardex Producto - Farmacia - Luna Systems Peru";
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
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />

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
                            <span>Ventas</span>
                        </li>
                        <li class="active">
                            <span>Empresa</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    <?php echo $c_producto->getNombre() . " - " . $c_presentacion->getNombre() . " - " . $c_laboratorio->getNombre()?>
                </h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        listar Kardex
                    </div>
                    <div class="panel-body">
                        <table id="tabla-clientes" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id.</th>
                                <th>Fecha</th>
                                <th>Lote</th>
                                <th>Tipo</th>
                                <th>Registro</th>
                                <th>Documento</th>
                                <th>C. Ingresa</th>
                                <th>C. Sale</th>
                                <th>Tot. Ingresa</th>
                                <th>Tot. Sale</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a_kardex = $c_kardex->ver_kardex_producto();
                            $item = 1;
                            foreach ($a_kardex as $fila) {
                                ?>
                                <tr>
                                    <td><?php echo $item ?></td>
                                    <td><?php echo $fila['fecha'] ?></td>
                                    <td><?php echo $fila['lote'] . " | " . $fila['vcto'] ?></td>
                                    <td class="text-center"><?php echo $fila['movimiento'] ?></td>
                                    <td class="text-center"><?php echo $fila['id_registro'] ?></td>
                                    <td class="text-center"><?php echo $fila['doc_sunat'] . " / " . $fila['serie_doc'] . " - " . $fila['numero_doc'] ?></td>
                                    <td class="text-right"><?php echo $fila['c_ingresa'] ?></td>
                                    <td class="text-right"><?php echo $fila['c_sale']  ?></td>
                                    <td class="text-right"><?php echo number_format($fila['cu_ingresa'] * $fila['c_ingresa'], 2) ?></td>
                                    <td class="text-right"><?php echo number_format($fila['cu_sale'] * $fila['c_sale'],2) ?></td>
                                </tr>
                                <?php
                                $item++;
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
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

<script>

    $(function () {

        // Initialize Example 1
        $('#tabla-clientes').dataTable({
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Kardex_diario', className: 'btn-sm'},
                {extend: 'pdf', title: 'Kardex_diario', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });

    });

</script>

</body>

</html>




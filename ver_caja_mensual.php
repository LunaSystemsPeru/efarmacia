<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_caja_diaria.php';
$c_caja = new cl_caja_diaria();
$c_caja->setIdEmpresa($_SESSION['id_empresa']);

$title = "Ver Caja Mensual - Farmacia - Luna Systems Peru";
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
                    Caja Mensual
                </h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">

            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="col-md-7 m-b-md">

                        </div>
                        <div class="col-md-5 ">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <select class="form-control">
                                            <option>Seleccionar Año</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control">
                                            <option>Seleccionar Periodo</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        listar Clientes
                    </div>
                    <div class="panel-body">
                        <table id="tabla-cajas" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Sucursal</th>
                                <th>Apertura</th>
                                <th>Ingresos</th>
                                <th>Egresos</th>
                                <th>Cierre</th>
                                <th>Sistema</th>
                                <th>Diferencia</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $caja = $c_caja->ver_caja_mensual(date("Ym"));
                            foreach ($caja as $fila) {
                                $m_ingreso = $fila['venta_dia']  + $fila['venta_cobro'] + $fila['otros_ingresos'];
                                $m_egresos = $fila['venta_devolucion']  + $fila['compra_egreso'] + $fila['gastos_varios'];
                                $m_diferencia = $fila['m_sistema'] - $fila['m_cierre'];
                                ?>
                                <tr>
                                    <td><?php echo $fila['fecha'] ?></td>
                                    <td><?php echo $fila['nombresede'] ?></td>
                                    <td class="text-right"><?php echo number_format($fila['m_apertura'],2) ?></td>
                                    <td class="text-right"><?php echo number_format($m_ingreso,2) ?></td>
                                    <td class="text-right"><?php echo number_format($m_egresos,2) ?></td>
                                    <td class="text-right"><?php echo number_format($fila['m_cierre'],2) ?></td>
                                    <td class="text-right"><?php echo number_format($fila['m_sistema'],2) ?></td>
                                    <td class="text-right"><?php echo number_format($m_diferencia, 2) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm" title="Ver Detalle de Caja"><i class="fa fa-bar-chart"></i></button>
                                    </td>
                                </tr>
                                <?php
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
        $('#tabla-cajas').dataTable({
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Caja_Mensual', className: 'btn-sm'},
                {extend: 'pdf', title: 'Caja_Mensual', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });

    });

</script>

</body>

</html>




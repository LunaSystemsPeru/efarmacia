<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_venta_productos.php';
$c_producto = new cl_venta_productos();
$c_producto->setIdEmpresa($_SESSION['id_empresa']);

if (filter_input(INPUT_GET, 'periodo')) {
    $c_producto->setPeriodo(filter_input(INPUT_GET, 'periodo'));
    $a_precios = $c_producto->ver_utilidad_periodo();
} else {
    $a_precios = $c_producto->ver_utilidad();
}

$title = "Ver utilidad por Productos - Farmacia - Luna Systems Peru";
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
                    Utilidad Venta este año - productos agrupados por precio
                </h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        listar Clientes
                    </div>
                    <div class="panel-body">
                        <table id="tabla-clientes" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id.</th>
                                <th>Producto - Medicamento</th>
                                <th>Cant. Venta</th>
                                <th>Precio Venta Un.</th>
                                <th>Precio Vendido Un.</th>
                                <th>Dif Precio</th>
                                <th>Costo Unit.</th>
                                <th>Utilidad</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total_utilidad = 0;
                            foreach ($a_precios as $fila) {
                                $difprecio = ($fila['preventa'] - $fila['precio']) * $fila['cvendido'];
                                $label_dif = "";
                                $label_ganacia = "";
                                if ($difprecio == 0) {
                                    $label_dif = '<span class="badge badge-primary">'.number_format($difprecio, 2).'</span>';
                                } elseif ($difprecio > 0) {
                                    $label_dif = '<span class="badge badge-danger">'.number_format($difprecio * -1, 2).'</span>';
                                } else {
                                    $label_dif = '<span class="badge badge-success">'.number_format($difprecio * -1, 2).'</span>';
                                }
                                $utilidad = ($fila['precio'] - $fila['costo']) * $fila['cvendido'];
                                $total_utilidad += $utilidad;
                                if ($utilidad == 0) {
                                    $label_ganacia = '<span class="badge badge-primary">'.number_format($utilidad, 2).'</span>';
                                } else if ($utilidad > 0) {
                                    $label_ganacia = '<span class="badge badge-success">'.number_format($utilidad, 2).'</span>';
                                } else {
                                    $label_ganacia = '<span class="badge badge-danger">'.number_format($utilidad, 2).'</span>';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $fila['id_producto']?></td>
                                    <td><?php echo $fila['nombre'] . " - " . $fila['laboratorio'] . " - " . $fila['presentacion']?></td>
                                    <td class="text-right"><?php echo $fila['cvendido']?></td>
                                    <td class="text-right"><?php echo number_format($fila['preventa'], 2)?></td>
                                    <td class="text-right"><?php echo number_format($fila['precio'], 2)?></td>
                                    <td class="text-right"><?php echo $label_dif?></td>
                                    <td class="text-right"><?php echo number_format($fila['costo'], 2)?></td>
                                    <td class="text-right"><?php echo $label_ganacia?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7"> Total</td>
                                <td class="text-right"><?php echo number_format($total_utilidad, 2)?></td>
                            </tr>
                            </tfoot>
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
            "order": [[ 1, "asc" ]],
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Utilidad_Venta', className: 'btn-sm'},
                {extend: 'pdf', title: 'Utilidad_Venta', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });

    });

</script>

</body>

</html>




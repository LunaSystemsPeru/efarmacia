<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_producto.php';
$c_producto = new cl_producto();
$c_producto->setIdEmpresa($_SESSION['id_empresa']);

$title = "Ver Reporte de Medicamentos - Farmacia - Luna Systems Peru";
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
                   Reporte de Medicamentos (Vencidos, por Vencer y sin Stock)
                </h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">

        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            <a class="closebox"><i class="fa fa-times"></i></a>
                        </div>
                        Grafica de Stock por Laboratorio (S/)
                    </div>
                    <div class="panel-body">
                        <div>
                            <canvas id="grafica_laboratorios_actual" height="70"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        listar medicamentos vencidos y por vencer hasta 4 meses
                    </div>
                    <div class="panel-body">
                        <table id="tabla-clientes" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id.</th>
                                <th>Nombre</th>
                                <th>Laboratorio</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                                <th>F. Venc.</th>
                                <th>Dias Faltantes.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a_productos = $c_producto->verVencidos();
                            foreach ($a_productos as $fila) {
                                $label = "label-success";
                                if ($fila['faltantes'] < 0) {
                                    $label = "label-warning";
                                }
                                ?>
                                <tr>
                                    <td><?php echo $fila['id_producto']?></td>
                                    <td><?php echo $fila['nombre'] . " - " . $fila['presentacion']?></td>
                                    <td class="text-center"><?php echo $fila['laboratorio']?></td>
                                    <td class="text-center"><?php echo $fila['cantidad']?></td>
                                    <td class="text-center"><?php echo $fila['precio']?></td>
                                    <td class="text-right"><?php echo $fila['vcto']?></td>
                                    <td class="text-center"><span class="label <?php echo $label?>"><?php echo $fila['faltantes']?></span></td>
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

        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        listar medicamentos sin stock
                    </div>
                    <div class="panel-body">
                        <table id="tabla-stock" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id.</th>
                                <th>Nombre</th>
                                <th>Laboratorio</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a_productos = $c_producto->verSinStock();
                            foreach ($a_productos as $fila) {
                                ?>
                                <tr>
                                    <td><?php echo $fila['id_producto']?></td>
                                    <td><?php echo strtoupper($fila['nombre']) . " - " . $fila['presentacion']?></td>
                                    <td class="text-center"><?php echo $fila['laboratorio']?></td>
                                    <td class="text-center"><?php echo $fila['cantidad']?></td>
                                    <td class="text-right"><?php echo $fila['precio']?></td>
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
<script src="vendor/chartjs/Chart.min.js"></script>
<!-- App scripts -->
<script src="scripts/homer.js"></script>

<script>

    $(function () {

        // Initialize Example 1
        $('#tabla-clientes').dataTable({
            "order": [[5, "asc"]],
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Medicamentos_Vencidos', className: 'btn-sm'},
                {extend: 'pdf', title: 'Medicamentos_Vencidos', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });

        // Initialize Example 1
        $('#tabla-stock').dataTable({
            "order": [[3, "asc"],[1, "asc"]],
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Medicamentos_Sin_Stock', className: 'btn-sm'},
                {extend: 'pdf', title: 'Medicamentos_Sin_Stock', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });

        $.getJSON("data/data_productos.php?tipo=1", function (result) {
            var laboratorio = Array();
            var total = Array();

            $.each(result, function (key, val) {
                laboratorio.push(val.nombre);
                total.push(val.total_actual);
            })

            new Chart(document.getElementById("grafica_laboratorios_actual"),
                {
                    "type": "bar",
                    "data": {
                        "labels": laboratorio,
                        "datasets": [{
                            "label": "Stock Actual S/",
                            "data": total,
                            "borderColor": "rgb(54, 162, 235)",
                            "backgroundColor": "rgba(54, 162, 235, 0.4)"
                        }]
                    },
                    "options": {
                        "scales": {
                            "yAxes": [{
                                "ticks": {
                                    "beginAtZero": true,
                                    "autoSkip": false,
                                    "maxRotation": 90,
                                    "minRotation": 90
                                }
                            }]
                        }
                    }
                });
        });
    });

</script>

</body>

</html>




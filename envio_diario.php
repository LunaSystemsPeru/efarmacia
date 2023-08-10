<?php
session_start();

require 'class/cl_venta.php';

if (!isset($_SESSION['id_empresa'])) {
    header("Location: login.php");
}
$title = "Inicio - Farmacia - Luna Systems Peru";

$c_venta = new cl_venta();
$aray_fechas = $c_venta->verFechasPendientes();
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
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

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
          href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css"
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
        href="https://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
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
                            <span>Inicio</span>
                        </li>
                        <li class="active">
                            <span>---</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    inicio

            </div>
        </div>
    </div>


    <div class="content">


        <div class="row">
            <div class="col-lg-3">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            <a class="closebox"><i class="fa fa-times"></i></a>
                        </div>
                        Datos Generales
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="tabla-fechas" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($aray_fechas as $fila) {
                                    ?>
                                    <tr>
                                        <td><a href="javascript:enviardoc('<?php echo $fila['fecha'] ?>')"><?php echo $fila['fecha'] ?></a></td>
                                        <td><?php echo $fila['cantidad'] ?></td>
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

            <div class="col-lg-3">
                hola
                <div id="modal_detalle">

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

<script src="vendor/chartjs/Chart.min.js"></script>

<!-- App scripts -->
<script src="scripts/homer.js"></script>

<script>
    function enviardoc (fecha) {
        var parametros = {
            fecha: fecha,
            id_empresa : 3
        };
        $.ajax({
            data: parametros, //datos que se envian a traves de ajax
            url: 'greenter/generates/resumen-activos.php', //archivo que recibe la peticion
            type: 'get', //método de envio
            beforeSend: function () {
                $("#modal_detalle").html("Procesando, espere por favor...");
            },
            success: function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                $("#modal_detalle").html(response);
            }
        });
    }
</script>

</body>

</html>




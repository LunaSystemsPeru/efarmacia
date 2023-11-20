<?php
session_start();

if (!isset($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_sucursal.php';
$cl_sucursal = new cl_sucursal();
$cl_sucursal->setIdEmpresa($_SESSION['id_empresa']);


$title = "Reportes de Inventario - Farmacia - Luna Systems Peru";
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
                    Reporte de Inventario
                </h2>
            </div>
        </div>
    </div>


    <div class="content">


        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default collapsed">
                    <div class="panel-heading">
                        <h4 class="panel-title">Seleccionar Tienda</h4>
                    </div>
                    <form>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Tienda</label>
                                <select class="form-control" id="select-tienda">
                                    <?php
                                    foreach ($cl_sucursal->verFilas() as $item) {
                                        ?>
                                        <option value="<?php echo $item['id_sucursal'] ?>"><?php echo $item['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="panel panel-default collapsed">
                    <div class="panel-heading">
                        <h4 class="panel-title">Generar Reportes</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <button class="btn btn-success" onclick="verStockValorizado()"><i class="fa fa-file-excel-o"></i> Stock Valorizado</button>
                        </div>
                        <!--
                        <div class="form-group">
                            <button class="btn btn-success"><i class="fa fa-file-excel-o"></i> Resumen Productos Vendidos</button>
                        </div>
                        -->
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
    function verStockValorizado() {
        var tiendaid = $("#select-tienda").val();
        $.post("reports/xls_mis_productos.php", {tiendaid: tiendaid, empresaid: '3'}, function (data) {
           
            67// alert(data);
            jsondata = JSON.parse(data);
            var archivo = jsondata.name;
            window.location.href = "reports/" + archivo + '?v=' + Date.now();
        });
    }

</script>

</body>
</html>
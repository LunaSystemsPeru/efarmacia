<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_producto_sucursal.php';
$c_producto = new cl_producto_sucursal();
$c_producto->setIdEmpresa($_SESSION['id_empresa']);
$c_producto->setIdSucursal($_SESSION['id_sucursal']);
$title = "Ver Mis Productos - Farmacia - Luna Systems Peru";
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
    <!--<link rel="stylesheet"
          href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css"
          type="text/css"/>-->
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
                    Mis Productos
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
                            <div class="btn-group">
                                <a href="ver_reporte_medicamentos.php" class="btn btn-success"><i class="fa fa-search"></i> Ver Medic. Vencidos</a>
                            </div>
                            <div class="btn-group">
                                <a href="procesos/precios_mimsa.php" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Ver Precios MIMSA</a>
                            </div>
                        </div>
                        <div class="col-md-5 ">
                            <form class="form-horizontal">
                                <div class="form-group">

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>



            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <table id="table-productos" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id.</th>
                                <th>Descripcion</th>
                                <th>Cantidad.</th>
                                <th>P. Vta.</th>
                                <th>Lote Actual</th>
                                <th>Estado</th>
                                <th width="15%">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a_productos = $c_producto->ver_productos();
                            foreach ($a_productos as $fila) {
                                if ($fila['cantidad'] < 1) {
                                    $color_texto = "text-info font-bold";
                                    $label_estado = '<label class="label label-info">sin Stock</label>';
                                } else {
                                    if ($fila['faltantes'] >= 120) {
                                        $color_texto = "text-primary";
                                        $label_estado = '<label class="label label-success">Normal</label>';
                                    } else if ($fila['faltantes'] < 120 && $fila['faltantes'] > 5) {
                                        $color_texto = "text-warning font-bold";
                                        $label_estado = '<label class=" label label-warning">por Vencer</label>';
                                    } else {
                                        $color_texto = "text-danger font-bold";
                                        $label_estado = '<label class="label label-danger">Vencido</label>';
                                    }
                                }
                                ?>
                                <tr>
                                    <td><?php echo $fila['id_producto']?></td>
                                    <td ><p class="<?php echo $color_texto?>"><?php echo $fila['nombre'] . " - " . $fila['npresentacion'] . " - " . $fila['nlaboratorio']?></p></td>

                                    <td class="text-right"><p class="<?php echo $color_texto?>"><?php echo $fila['cantidad']?></p></td>
                                    <td class="text-right"><p class="<?php echo $color_texto?>"><?php echo $fila['precio']?></p></td>
                                    <td class="text-center"><p class="<?php echo $color_texto?>"><?php echo $fila['vcto'] . " | " . $fila['lote']?></p></td>
                                    <td class="text-center"><?php echo $label_estado?></td>
                                    <td class="text-center">
                                        <a href="<?php echo "mod_producto.php?id_producto=" . $fila['id_producto']. "&id_empresa=" . $_SESSION['id_empresa']; ?>"><button class="btn btn-success btn-sm" title="Editar Producto"><i class="fa fa-edit"></i></button></a>
                                        <a href="ver_productos_compra.php?id_producto=<?php echo $fila['id_producto'] ?>" class="btn btn-success btn-sm" title="Ver Historial de Compra"><i class="fa fa-cart-arrow-down"></i></a>
                                        <a href="ver_kardex_producto.php?id_producto=<?php echo $fila['id_producto'] ?>" class="btn btn-info btn-sm" title="Ver Kardex"><i class="fa fa-bars"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" title="Eliminar Producto" onclick="eliminar('<?php echo $fila['id_producto']?>')"><i class="fa fa-trash"></i></button>
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
        $('#table-productos').dataTable({
            "order": [[1, "asc"]],
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'mis_productos', className: 'btn-sm'},
                {extend: 'pdf', title: 'mis_productos', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });

    });

    function eliminar(codigo) {

        swal({
            title: "Eliminar Producto",
            text: "Esta seguro de eliminar este Producto?",
            type: "warning",
            showCancelButton: true,
            //cancelButtonClass: 'btn-secondary ',
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Eliminar",
            cancelButtonText: "No, cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                window.location.href = 'procesos/del_producto.php?id_producto=' + codigo;
            }
        });
    }

</script>
</body>

</html>




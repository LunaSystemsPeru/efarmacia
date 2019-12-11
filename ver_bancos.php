<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_banco.php';
$c_banco = new cl_banco();
$c_banco->setIdEmpresa($_SESSION['id_empresa']);

$title = "Ver mis Bancos - Farmacia - Luna Systems Peru";
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
    <link rel="stylesheet" href="http://webapplayers.com/homer_admin-v2.0/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
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
                            <span>Bancos</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Bancos
                </h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">

            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        listar Bancos
                    </div>
                    <div class="panel-body">
                        <div class="btn-group">
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalregistrar"><i class="fa fa-plus"> </i> Nuevo Banco</button>
                        </div>

                        <div class="modal fade" id="modalregistrar" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-horizontal" method="post" action="procesos/reg_banco.php">
                                        <div class="color-line"></div>
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Agregar Banco</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Nombre: </label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control"
                                                           name="input_nombre" id="input_nombre" maxlength="245"
                                                           required/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Cuenta: </label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control"
                                                           name="input_cuenta" id="input_cuenta"  maxlength="45"
                                                           required/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Saldo: </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control text-right"
                                                           name="input_saldo" id="input_saldo" maxlength="10"
                                                           required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="tabla-cajas" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Cod</th>
                                <th>Nombre</th>
                                <th>Cuenta</th>
                                <th>Saldo</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a_bancos = $c_banco->verFilas();
                            $item = 0;
                            foreach ($a_bancos as $fila) {
                                $item ++;
                                ?>
                                <tr>
                                    <td><?php echo $item ?></td>
                                    <td><?php echo $fila['nombre'] ?></td>
                                    <td class="text-center"><?php echo $fila['cuenta'] ?></td>
                                    <td class="text-right"><?php echo number_format($fila['saldo'], 2) ?></td>
                                    <td class="text-center">
                                        <a href="ver_movimientos_banco.php?id_banco=<?php echo $fila['id_banco'] ?>" class="btn btn-success btn-sm" title="Ver Detalle de Caja"><i class="fa fa-bar-chart"></i></a>
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




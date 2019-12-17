<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_ajuste.php';
require 'class/cl_varios.php';
$c_varios = new cl_varios();
$c_ajuste = new cl_ajuste();
$c_ajuste->setIdEmpresa($_SESSION['id_empresa']);

$title = "Ver Ajustes de Mercaderia - Farmacia - Luna Systems Peru";
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
                            <span>Movimientos Almacen</span>
                        </li>
                        <li class="active">
                            <span>Ajustes de Mercaderia</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Ajustes de Mercaderia
                </h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">

        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body">
                    <div class="col-md-7 m-b-md">
                        <div class="btn-group">
                            <a href="reg_ajuste.php" class="btn btn-success">Nuevo Ajuste</a>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#modalbuscar">Buscar Documento</button>
                        </div>

                        <div class="modal fade" id="modalbuscar" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-horizontal">
                                        <div class="color-line"></div>
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">buscar Documento de ingreso</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Tipo Documento: </label>
                                                <div class="col-lg-10">
                                                    <select class="form-control">
                                                        <option value="1">NOTA DE VENTA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Numero: </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control"
                                                           name="input_numero" id="input_numero" maxlength="8"
                                                           required/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Proveedor: </label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control"
                                                           name="input_cliente" id="input_cliente" maxlength="245"
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

        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <table id="tabla-ingresos" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="10%">Id.</th>
                                <th width="11%">Fecha</th>
                                <th width="30%">Usuario</th>
                                <th width="10%">Cant. tot. Sist.</th>
                                <th width="10%">Cant. tot. Enc.</th>
                                <th width="10%">Total Diferencias S/</th>
                                <th width="11%">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a_ajustes = $c_ajuste->verFilas();
                            foreach ($a_ajustes as $fila) {
                                ?>
                                <tr>
                                    <td><?php echo $fila['id_inventario']?></td>
                                    <td class="text-center"><?php echo $fila['fecha']?></td>
                                    <td><?php echo $fila['username'] ?></td>
                                    <td><?php echo "0"?></td>
                                    <td class="text-center"><?php echo "0"?></td>
                                    <td class="text-right"><?php echo $fila['monto']?></td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm" title="Ver Documento" onclick="obtener_detalle('<?php echo $fila['id_inventario']?>')"><i class="fa fa-eye"></i></button>
                                        <button class="btn btn-danger btn-sm" title="Eliminar Documento"><i class="fa fa-close"></i></button>
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

        <div class="modal fade" id="modal_ver_detalle" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="color-line"></div>
                    <div class="modal-header text-center">
                        <h4 class="modal-title">Ver detalle de Inventario</h4>
                    </div>
                    <div class="modal-body" id="modal_detalle">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
        $('#tabla-ingresos').dataTable({
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Ajustes_201912', className: 'btn-sm'},
                {extend: 'pdf', title: 'Ajustes_201912', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });

    });

</script>

<script>
    function obtener_detalle(id_inventario) {
        var parametros = {
            id_ajuste: id_inventario
        };
        $.ajax({
            data: parametros, //datos que se envian a traves de ajax
            url: 'modals_php/m_inventario_productos.php', //archivo que recibe la peticion
            type: 'post', //método de envio
            beforeSend: function () {
                $("#modal_detalle").html("Procesando, espere por favor...");
                $("#modal_ver_detalle").modal('toggle');
            },
            success: function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                $("#modal_detalle").html(response);
            }
        });
    }
</script>
</body>

</html>




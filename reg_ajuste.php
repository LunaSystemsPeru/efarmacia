<?php
session_start();

if (!isset($_SESSION['id_empresa'])) {
    header("Location: login.php");
}
$_SESSION['productos_ajuste'] = array();

$title = "Registro de Ajuste de Mercaderia - Farmacia - Luna Systems Peru";
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
    <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css">
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
                        <li><span>Almacen</span></li>
                        <li class="active"><span>Ajuste</span></li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">Registro de Ajuste de Mercaderia</h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="hpanel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Buscar Productos</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" name="frm_buscar">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Buscar</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="input_producto" name="input_producto">
                                    <input type="hidden" name="hidden_id_producto" id="hidden_id_producto"/>
                                    <input type="hidden" name="hidden_descripcion_producto" id="hidden_descripcion_producto"/>
                                </div>
                                <div class="col-md-2">
                                    <a href="reg_producto.php" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Crear Producto</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Cant. Actual</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-center" id="input_cactual" name="input_cactual" readonly>
                                </div>
                                <label class="col-md-1 control-label">Costo Compra</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-right" id="input_costo" name="input_costo" required readonly>
                                </div>
                                <label class="col-md-1 control-label">Precio Venta</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-right" id="input_precio" name="input_precio" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Cant. Nueva</label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control text-center" id="input_cnueva" name="input_cnueva" required>
                                </div>
                                <label class="col-md-1 control-label">Lote</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-center" id="input_lote" name="input_lote" required>
                                </div>
                                <label class="col-md-1 control-label">Fecha Vcto.</label>
                                <div class="col-md-3">
                                    <input type="date" class="form-control text-center" id="input_vencimiento" name="input_vencimiento" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success btn-sm" id="btn_add_producto" onclick="addProductos()" disabled="true"><i class="fa fa-plus"></i> Guardar Item</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>

            <div class="col-md-12">
                <!-- begin panel -->
                <div class="hpanel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Ver Productos Agregados</h4>
                    </div>
                    <div class="panel-body">
                        <table id="tabla-detalle" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="4%">Item</th>
                                <th width="30%">Producto</th>
                                <th width="15%">Lote - Vencimiento</th>
                                <th width="11%">C. Actual.</th>
                                <th width="11%">C. Nueva.</th>
                                <th width="11%">Diferencia.</th>
                                <th width="10%">Costo</th>
                                <th width="10%">Venta</th>
                                <th width="11%">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end panel -->
            </div>

            <div class="col-md-12">
                <!-- begin panel -->
                <div class="hpanel">
                    <div class="panel-footer text-right">
                        <button class="btn btn-success" type="submit" id="btn_guardar_formulario" onclick="enviar_formulario()">Guardar Ingreso</button>
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
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script lang="javascript">
    function cargar_editar_proveedor() {
        window.open("mod_proveedor.php?id=" + $("#input_id_proveedor").val());
    }

    $(function () {
        //autocomplete
        $("#input_producto").autocomplete({
            source: "ajax_post/buscar_mis_productos.php",
            minLength: 2,
            select: function (event, ui) {
                event.preventDefault();
                $('#input_cactual').val(ui.item.cantidad);
                $('#input_precio').val(ui.item.precio);
                $('#input_costo').val(ui.item.costo);
                $('#input_lote').val(ui.item.lote);
                $('#input_vencimiento').val(ui.item.vcto);
                $('#hidden_id_producto').val(ui.item.id);
                $('#hidden_descripcion_producto').val(ui.item.nombre + " | " + ui.item.presentacion + " | " + ui.item.laboratorio);
                $('#hidden_lote_producto').val(ui.item.vcto + " - " + ui.item.lote);
                $('#input_producto').val(ui.item.nombre + " | " + ui.item.presentacion + " | " + ui.item.laboratorio);
                $('#btn_add_producto').prop("disabled", false);
                $('#input_cnueva').focus();
            }
        });
    });
</script>

<script>
    function enviar_formulario() {
        var contar_filas = $("#tabla-detalle tr").length;
        console.log(contar_filas);
        //enviar form
        if (contar_filas > 1) {
            document.location.href = "procesos/reg_ajuste.php";
        } else {
            swal("FALTA COMPLETAR DATOS");
        }
    }

    function addProductos() {
        var input_id_producto = $('#hidden_id_producto').val()
        var input_descripcion_producto = $('#hidden_descripcion_producto').val()
        var input_costo_producto = $('#input_costo').val()
        var input_precio_producto = $('#input_precio').val()
        var input_cnueva_producto = $('#input_cnueva').val()
        var input_cactual_producto = $('#input_cactual').val()
        var input_lote_producto = $('#input_lote').val()
        var input_vcto_producto = $('#input_vencimiento').val()

        if (input_costo_producto == '' || parseFloat(input_costo_producto) == 0) {
            swal("Falta indicar costo del producto")
            return;
        }
        if (input_precio_producto == '' || parseFloat(input_precio_producto) == 0) {
            swal("Falta indicar precio del producto")
            return;
        }

        if (input_cnueva_producto == '') {
            swal("Falta indicar cantidad del producto")
            return;
        }

        if (input_lote_producto == '') {
            swal("Falta indicar el lote del producto")
            return;
        }

        if (input_vcto_producto == '') {
            swal("Falta indicar el vencimiento del producto")
            return;
        } else {
            var first = new Date(input_vcto_producto);
            var second = new Date();

            if (first < second) {
                swal("Fecha de vencimiento es menor a fecha actual, revisar!")
                return;
            }
        }


        $.ajax({
            data: {
                input_id_producto: $('#hidden_id_producto').val(),
                input_descripcion_producto: $('#hidden_descripcion_producto').val(),
                input_costo_producto: $('#input_costo').val(),
                input_precio_producto: $('#input_precio').val(),
                input_cnueva_producto: $('#input_cnueva').val(),
                input_cactual_producto: $('#input_cactual').val(),
                input_lote_producto: $('#input_lote').val(),
                input_vcto_producto: $('#input_vencimiento').val()
            },
            url: 'ajax_post/add_productos_ajuste.php',
            type: 'GET',
            //dataType: 'json',
            beforeSend: function () {
                //$('#body_detalle_pedido').html("");
                $('table tbody').html("");
            },
            success: function (r) {
                //swal(r);
                $('table tbody').append(r);
                clean();
                //$('#body_detalle_pedido').html(r);
            },
            error: function () {
                swal('Ocurrio un error en el servidor ..');
                $('table tbody').html("");
                //$('#body_detalle_pedido').html("");
            }
        });
    }

    function clean() {
        $('#hidden_id_producto').val('');
        $('#input_producto').val('');
        $('#input_costo').val('0.00');
        $('#input_precio').val('0.00');
        $('#input_cactual').val('');
        $('#input_lote').val('');
        $('#input_vencimiento').val('');
        $('#input_cnueva').val('');
        $('#hidden_descripcion_producto').val('');
        $('#btn_add_producto').prop("disabled", true);
        $('#btn_guardar_formulario').prop("disabled", false);
        $('#input_cactual').prop("readonly", true);
        $('#input_costo').prop("readonly", true);
        $('#input_precio').prop("readonly", true);
        $('#input_producto').focus();
    }
</script>

</body>

</html>




<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}
$_SESSION['productos_ingreso'] = array();

require 'class/cl_documentos_sunat.php';
$c_documentos = new cl_documentos_sunat();

$title = "Registro de Ingreso de Mercaderia - Farmacia - Luna Systems Peru";
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
                        <li><span>Almacen</span></li>
                        <li class="active"><span>Ingresos</span></li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">Registro de Ingreso de Mercaderia</h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">
            <form class="form-horizontal" name="frm_ingreso" id="frm_ingreso" method="POST" action="procesos/reg_ingreso.php">
                <div class="col-md-4">
                    <!-- begin panel -->
                    <div class="hpanel">
                        <div class="panel-heading">
                            <h4 class="panel-title">Datos del Documento</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Fecha</label>
                                <div class="col-md-8">
                                    <input type="date" id="input_fecha" name="input_fecha" class="form-control text-center" value="<?php echo date("Y-m-d") ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Sucursal</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-center" value="<?php echo $_SESSION['nombre_sucursal'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Documento</label>
                                <div class="col-md-8">
                                    <select id="select_documento" name="select_documento" class="form-control">
                                        <?php
                                        $a_documentos = $c_documentos->ver_documentos();
                                        foreach ($a_documentos as $fila) {
                                            echo '<option value="' . $fila['id_documento'] . '">' . $fila['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Ser / Nro</label>
                                <div class="col-md-4">
                                    <input class="form-control text-center" value="" id="input_serie" name="input_serie" placeholder="Serie" required>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control text-center" value="" id="input_numero" name="input_numero" placeholder="Numero" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Total</label>
                                <div class="col-md-8">
                                    <input class="form-control text-center" value="0.00" id="input_total" name="input_total" readonly>
                                    <input type="hidden" id="input_total_hidden" name="input_total_hidden" value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <div class="col-md-8">
                    <!-- begin panel -->
                    <div class="hpanel">
                        <div class="panel-heading">
                            <h4 class="panel-title">Datos del Documento</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Proveedor</label>
                                <div class="col-md-4">
                                    <input class="form-control text-center" value="" id="input_ruc_proveedor" name="input_ruc_proveedor" placeholder="Ingrese RUC" required>
                                    <input type="hidden" id="hidden_id_proveedor" name="hidden_id_proveedor">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-info btn-sm" href="reg_proveedor.php" target="_blank"><i class="fa fa-plus"></i> Reg. Proveedor</a>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="btn_editar_proveedor" class="btn btn-success btn-sm" onclick="cargar_editar_proveedor()" disabled=true><i class="fa fa-edit"></i> Edit. Proveedor</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Razon Social</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="input_razon_social" name="input_razon_social" readonly="true" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Direccion</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="input_direccion" name="input_direccion" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Sub Total</label>
                                <div class="col-md-2">
                                    <input class="form-control text-center" value="0.00" id="input_subtotal" name="input_subtotal" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">IGV</label>
                                <div class="col-md-2">
                                    <input class="form-control text-center" value="0.00" id="input_igv" name="input_igv" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
            </form>

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
                                    <input class="form-control" id="input_producto" name="input_producto" placeholder="Ingrese Medicamento">
                                    <input type="hidden" name="hidden_id_producto" id="hidden_id_producto"/>
                                    <input type="hidden" name="hidden_descripcion_producto" id="hidden_descripcion_producto"/>
                                </div>
                                <a href="reg_producto.php" target="_blank" class="btn btn-info"><i class="fa fa-plus"></i> Reg Producto</a>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Cant. Actual</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-center" id="input_cactual" name="input_cactual" readonly>
                                </div>
                                <label class="col-md-1 control-label">Costo Compra</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-right" id="input_costo" name="input_costo" required>
                                </div>
                                <label class="col-md-1 control-label">Precio Venta</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-right" id="input_precio" name="input_precio" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Cant. Compra</label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control text-center" id="input_ccompra" name="input_ccompra" required>
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
                                <th width="11%">Cant.</th>
                                <th width="10%">Costo</th>
                                <th width="10%">Venta</th>
                                <th width="10%">Parcial</th>
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
<script lang="javascript">
    function cargar_editar_proveedor() {
        window.open("mod_proveedor.php?id=" + $("#input_id_proveedor").val());
    }

    $(function () {
        //autocomplete
        $("#input_ruc_proveedor").autocomplete({
            source: "ajax_post/buscar_proveedores.php",
            minLength: 2,
            select: function (event, ui) {
                event.preventDefault();
                $('#hidden_id_proveedor').val(ui.item.id);
                $('#input_ruc_proveedor').val(ui.item.ruc);
                $('#input_razon_social').val(ui.item.razon_social);
                $('#input_direccion').val(ui.item.direccion);
                $('#input_producto').focus();
            }
        });

        $("#input_producto").autocomplete({
            source: "ajax_post/buscar_productos.php",
            minLength: 2,
            select: function (event, ui) {
                event.preventDefault();
                /*$('#input_cactual').val(ui.item.cantidad);
                $('#input_precio').val(ui.item.precio);
                $('#input_costo').val(ui.item.costo);*/
                $('#hidden_id_producto').val(ui.item.id);
                $('#hidden_descripcion_producto').val(ui.item.nombre + " - " + ui.item.presentacion + " - " + ui.item.laboratorio);
                $('#input_producto').val(ui.item.nombre + " - " + ui.item.presentacion + " - " + ui.item.laboratorio);

                $('#input_ccompra').focus();
                $.get("ajax_post/datos_producto.php?idproduc=" + ui.item.id, function (data) {
                    console.log(data);
                    var json = JSON.parse(data);
                    if (json.estado) {
                        $('#input_cactual').val(json.cantidad);
                        $('#input_precio').val(json.precio);
                        $('#input_costo').val(json.costo);
                        $('#input_lote').val(json.lote);
                        $('#input_vencimiento').val(json.fecha);
                        $('#btn_add_producto').prop("disabled", false);
                        $('#input_costo').prop("readonly", false);
                        $('#input_precio').prop("readonly", false);
                    } else {
                        $('#btn_add_producto').prop("disabled", false);
                        $('#input_costo').focus();
                        $('#input_cactual').val("");
                        $('#input_precio').val("");
                        $('#input_costo').val("");
                    }
                });


            }
        });
    });
</script>

<script>
    function enviar_formulario() {
        var id_proveedor = $("#hidden_id_proveedor").val();
        var serie = $("#input_serie").val();
        var numero = $("#input_numero").val();
        var contar_filas = $("#tabla-detalle tr").length;
        console.log(contar_filas);
        //enviar form
        if (id_proveedor !== "" && serie !== "-" && numero !== "" && contar_filas > 1) {
            //document.frm_ingreso.submit();
            document.getElementById("frm_ingreso").submit();
            return false;
        } else {
            alert("FALTA COMPLETAR DATOS");
        }
    }

    function addProductos() {
        var costo = $('#input_costo').val();
        var precio = $('#input_precio').val();
        var cantidad = $('#input_ccompra').val();
        var lote = $('#input_lote').val();
        var vcto = $('#input_vencimiento').val();
        if (costo != "" & precio != "" & cantidad != "" & lote != "" & vcto != "") {
            $.ajax({
                data: {
                    input_id_producto: $('#hidden_id_producto').val(),
                    input_descripcion_producto: $('#hidden_descripcion_producto').val(),
                    input_costo_producto: $('#input_costo').val(),
                    input_precio_producto: $('#input_precio').val(),
                    input_cantidad_producto: $('#input_ccompra').val(),
                    input_lote_producto: $('#input_lote').val(),
                    input_vcto_producto: $('#input_vencimiento').val()
                },
                url: 'ajax_post/add_productos_ingresos.php',
                type: 'GET',
                //dataType: 'json',
                beforeSend: function () {
                    //$('#body_detalle_pedido').html("");
                    $('table tbody').html("");
                },
                success: function (r) {
                    //alert(r);
                    $('table tbody').append(r);
                    clean();
                    //$('#body_detalle_pedido').html(r);
                },
                error: function () {
                    alert('Ocurrio un error en el servidor ..');
                    $('table tbody').html("");
                    //$('#body_detalle_pedido').html("");
                }
            });
        } else {
            alert("Faltan ingresar datos");
        }
    }

    function eliminar_item(id_producto) {
        $.ajax({
            data: {
                input_id_producto: id_producto
            },
            url: 'ajax_post/del_productos_ingresos.php',
            type: 'GET',
            //dataType: 'json',
            beforeSend: function () {
                //$('#body_detalle_pedido').html("");
                $('table tbody').html("");
            },
            success: function (r) {
                //alert(r);
                $('table tbody').append(r);
                clean();
                //$('#body_detalle_pedido').html(r);
            },
            error: function () {
                alert('Ocurrio un error en el servidor ..');
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
        $('#input_ccompra').val('');
        $('#input_lote').val('');
        $('#input_vencimiento').val('');
        $('#input_cactual').val('');
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




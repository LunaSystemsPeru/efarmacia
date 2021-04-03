<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

$_SESSION['productos_venta'] = array();

require 'class/cl_documentos_empresa.php';

$c_mis_documentos = new cl_documentos_empresa();
$c_mis_documentos->setIdEmpresa($_SESSION['id_empresa']);
$c_mis_documentos->setIdSucursal($_SESSION['id_sucursal']);

$title = "Registro de Venta de Mercaderia - Farmacia - Luna Systems Peru";
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
    <link href="vendor/toast/build/jquery.toast.min.css" rel="stylesheet">
    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css"/>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css">

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
                        <li><span>Ventas</span></li>
                        <li class="active"><span>Ventas</span></li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">Registro de Venta</h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">
            <div class="col-md-8">
                <!-- begin panel -->
                <div class="hpanel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Buscar Productos</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" name="frm_buscar">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Buscar</label>
                                <div class="col-md-10">
                                    <input class="form-control" id="input_producto" name="input_producto">
                                    <input type="hidden" name="hidden_id_producto" id="hidden_id_producto"/>
                                    <input type="hidden" name="hidden_costo" id="hidden_costo"/>
                                    <input type="hidden" name="hidden_descripcion_producto" id="hidden_descripcion_producto"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Cant. Actual</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-center" id="input_cactual" name="input_cactual" readonly>
                                </div>
                                <label class="col-md-2 control-label">Lote</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-center" id="input_lote" name="input_lote" readonly>
                                </div>
                                <label class="col-md-1 control-label">Fecha Vcto.</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control text-center" id="input_vencimiento" name="input_vencimiento" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Cant. Venta</label>
                                <div class="col-md-2">
                                    <input onkeypress="nextElement(event,'btn_add_producto')" type="number" value="1" class="form-control text-center" id="input_cventa" name="input_cventa" required readonly>
                                </div>
                                <label class="col-md-2 control-label">Precio Venta</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-right" id="input_precio" name="input_precio" readonly>
                                </div>
                                <div class="col-md-2 col-md-offset-1">
                                    <button type="button" class="btn btn-success btn-sm" id="btn_add_producto" onclick="addProductos()" disabled="true"><i class="fa fa-plus"></i> Agregar Item</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- end panel -->

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
                                <th width="40%">Producto</th>
                                <th width="11%">Cant.</th>
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

            <div class="col-md-4">
                <div class="widget padding-0 white-bg">
                    <div class="bg-primary pv-15 text-center " style="height: 90px; text-align: center; padding-top: 3px">
                        <h1 class="mv-0 font-400" id="lbl_suma_pedido">S/ 0.00</h1>
                        <div class="text-uppercase">Suma Pedido</div>
                    </div>
                    <br>
                    <div class="padding-20 text-center">
                        <form role="form" class="form-horizontal" name="frm_venta" id="frm_venta" action="procesos/reg_venta.php" method="post">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Doc.</label>
                                <div class="col-md-9">
                                    <select onchange="obtenerDatos()" class="form-control" name="select_documento" id="select_documento">
                                        <?php
                                        $a_mis_documentos = $c_mis_documentos->ver_documentos();
                                        foreach ($a_mis_documentos as $fila) {
                                            echo '<option value="'.$fila['id_documento'].'">'.$fila['nombre'].'</option>';
                                        }
                                        if (isset($a_mis_documentos[0]))
                                        $c_mis_documentos->setIdDocumento($a_mis_documentos[0]["id_documento"]);
                                        $c_mis_documentos->obtener_datos();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">S - N</label>
                                <div class="col-lg-3">
                                    <input id="input_serie" type="text"   class="form-control text-center" value="<?php echo $c_mis_documentos->getSerie();?>"  readonly>
                                </div>
                                <div class="col-lg-5">
                                    <input id="input_numero" type="text"  class="form-control text-center" value="<?php echo $c_mis_documentos->getNumero();?>"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Fecha</label>
                                <div class="col-lg-6">
                                    <input id="input_fecha" type="text" placeholder="dd/mm/aaaa" name="input_fecha" class="form-control text-center" value="<?php echo date("Y-m-d"); ?>" readonly>
                                </div>
                            </div>
                            <div id="error_documento">
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Cliente</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control text-center" onkeypress="nextElement(event,'button_comprobar')" Placeholder="Nro Documento" id="input_documento_cliente" name="input_documento_cliente" required>
                                </div>
                                <div class="col-lg-1">
                                    <button id="button_comprobar" onclick="comprobarCliente()" class="btn btn-success" type="button" >Comprobar</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Nombre Cliente" class="form-control" id="input_cliente" name="input_cliente" >
                                    <input type="hidden" id="hidden_id_cliente" name="hidden_id_cliente" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Direccion" class="form-control" id="input_direccion" name="input_direccion" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="hidden" id="hidden_total" name="hidden_total">
                                    <button type="button" class="btn btn-lg btn-primary" id="btn_finalizar_pedido" disabled onclick="enviar_formulario()">Guardar</button>
                                </div>
                            </div>
                        </form>
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
<script src="vendor/toast/build/jquery.toast.min.js"></script>
<script src="scripts/ventas.functions.js"></script>
<script src="scripts/validar-documento-cliente.js"></script>

<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>

<!-- App scripts -->
<script src="scripts/homer.js"></script>
<script lang="javascript">

</script>

<script lang="javascript">
    $(function () {
        //autocomplete
        $("#input_cliente").autocomplete({
            source: "ajax_post/buscar_clientes.php",
            minLength: 2,
            select: function (event, ui) {
                event.preventDefault();
                $('#hidden_id_cliente').val(ui.item.id);
                $('#input_documento_cliente').val(ui.item.ruc);
                $('#input_cliente').val(ui.item.razon_social);
                $('#input_direccion').val(ui.item.direccion);
            }
        });

        $("#input_producto").autocomplete({
            source: "ajax_post/buscar_mis_productos.php",
            minLength: 2,
            select: function (event, ui) {
                event.preventDefault();
                $('#hidden_id_producto').val(ui.item.id);
                $('#hidden_descripcion_producto').val(ui.item.nombre + " - " + ui.item.presentacion + " - " + ui.item.laboratorio);
                $('#input_producto').val(ui.item.nombre + " - " + ui.item.presentacion + " - " + ui.item.laboratorio);

                $('#input_cactual').val(ui.item.cantidad);
                $('#input_precio').val(ui.item.precio);
                $('#hidden_costo').val(ui.item.costo);
                $('#input_lote').val(ui.item.lote);
                $('#input_vencimiento').val(ui.item.vcto);

                $('#btn_add_producto').prop("disabled", false);
                $('#btn_finalizar_pedido').prop("disabled", false);
                $('#input_precio').prop("readonly", false);
                $('#input_cventa').prop("readonly", false);
                $('#input_cventa').focus();
            }
        });
    });
</script>


<script>
function nextElement(e, idElement) {
    if (e.keyCode==13)
    $( "#"+idElement ).focus();
}
</script>


</body>

</html>




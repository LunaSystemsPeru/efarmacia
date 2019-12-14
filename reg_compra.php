<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_documentos_sunat.php';
$c_documentos = new cl_documentos_sunat();

$title = "Registro de Documento de Compra - Farmacia - Luna Systems Peru";
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
                        <li><span>Compras</span></li>
                        <li class="active"><span>Doc. Compra</span></li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">Registro de Documento de Compra</h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="hpanel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Datos del Documento</h4>
                    </div>
                    <form class="form-horizontal" name="frm_compra" method="POST" action="procesos/reg_compra.php">
                    <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Fecha</label>
                                <div class="col-md-2">
                                    <input type="date" id="input_fecha" name="input_fecha" class="form-control text-center" value="<?php echo date("Y-m-d") ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Proveedor</label>
                                <div class="col-md-2">
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
                                <label class="col-md-1 control-label">Razon Social</label>
                                <div class="col-md-10">
                                    <input class="form-control" id="input_razon_social" name="input_razon_social" readonly="true" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Direccion</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="input_direccion" name="input_direccion" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Documento</label>
                                <div class="col-md-3">
                                    <select id="select_documento" name="select_documento" class="form-control">
                                        <?php
                                        $a_documentos = $c_documentos->ver_documentos();
                                        foreach ($a_documentos as $fila) {
                                            echo '<option value="' . $fila['id_documento'] . '">' . $fila['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control text-center" value="" id="input_serie" name="input_serie" required>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control text-center" value="" id="input_numero" name="input_numero" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="btn_validar_documento" class="btn btn-warning btn-sm" onclick="validar_documento()" disabled=true><i class="fa fa-search"></i> Validar Doc.</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Sub Total</label>
                                <div class="col-md-2">
                                    <input class="form-control text-center" value="0.00" id="input_subtotal" name="input_subtotal" readonly required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">IGV</label>
                                <div class="col-md-2">
                                    <input class="form-control text-center" value="0.00" id="input_igv" name="input_igv" readonly required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Total</label>
                                <div class="col-md-2">
                                    <input class="form-control text-center" value="0.00" id="input_total" name="input_total" required>
                                </div>
                            </div>

                    </div>
                    <div class="panel-footer text-right">
                        <button class="btn btn-success" type="submit" id="registrar_productos">Guardar Documento</button>
                    </div>
                    </form>
                </div>
                <!-- end panel -->
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
    });

</script>

</body>

</html>




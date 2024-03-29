<?php
session_start();

if (!isset($_SESSION['id_empresa'])) {
    header("Location: login.php");
}
require 'class/cl_sucursal.php';
$c_sucursal = new cl_sucursal();

$titulo_panel = "REGISTRO DE SUCURSAL";

if (filter_input(INPUT_GET, 'id')){
    $c_sucursal->setIdSucursal(filter_input(INPUT_GET, 'id'));
    $c_sucursal->obtener_datos();
    $titulo_panel = "MODIFICAR DATOS DE SUCURSAL";
}

$title = "Registro de Sucursal - Farmacia - Luna Systems Peru";
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
                            <span>Configuracion</span>
                        </li>
                        <li class="active">
                            <span>Sucursales</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    <?php echo $titulo_panel?>
                </h2>
            </div>
        </div>
    </div>


    <div class="content">


        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <form class="form-horizontal" name="reg_sucursal" id="reg_sucursal" action="procesos/reg_sucursal.php" method="post">
                        <div class="panel-body">
                            <div class="form-group" id="error_ruc">

                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Nombre: </label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control"
                                           name="input_nombre" id="input_nombre"
                                           max-lenght="245" value="<?php echo $c_sucursal->getNombre()?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Direccion: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="input_direccion"
                                           id="input_direccion" max-lenght="245" value="<?php echo $c_sucursal->getDireccion()?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Ubigeo: </label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" name="input_ubigeo"
                                           id="input_ubigeo" max-lenght="6" value="<?php echo $c_sucursal->getUbigeo()?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Distrito: </label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="input_distrito"
                                           id="input_distrito" max-lenght="9"  value="<?php echo $c_sucursal->getDistrito()?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Provincia: </label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="input_provincia"
                                           id="input_provincia" max-lenght="9" value="<?php echo $c_sucursal->getProvincia()?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Departamento: </label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="input_departamento"
                                           id="input_departamento" max-lenght="9" value="<?php echo $c_sucursal->getDepartamento()?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Codigo SUNAT: </label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" name="input_codsunat"
                                           id="input_codsunat" max-lenght="4" value="<?php echo $c_sucursal->getCodsunat()?>" required/>
                                </div>
                            </div>

                        </div>

                        <div class="panel-footer text-right">
                            <input type="hidden" name="input_idsucursal" value="<?php echo $c_sucursal->getIdSucursal()?>">
                            <a href="ver_sucursales.php" class="btn btn-success" ><i class="fa fa-arrow-left"></i> Regresar</a>
                            <button type="submit" class="btn btn-primary" id="registrar_sucursal"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </form>
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
    function enviar_ruc() {
        var parametros = {
            "input_documento": $("#input_ndocumento").val()
        };

        if ($("#input_ndocumento").val().length === 8 || $("#input_ndocumento").val().length === 11) {
            $.ajax({
                data: parametros,
                url: 'ajax_post/validar_cliente.php',
                type: 'get',
                beforeSend: function () {
                    $("#error_ruc").html("<div class=\"alert alert-success\"><strong> Espere! </strong> Estamos procesando su peticion.</div>");
                },
                success: function (response) {
                    $("#error_ruc").html("");
                    var json = response;
                    console.log(json);
                    var json_ruc = JSON.parse(json);
                    var success = json_ruc.success;
                    if (success === false) {
                        $("#error_ruc").html("<div class=\"alert alert-danger\"><strong> Error! </strong> " + json_ruc.result + "</div>");
                        $("#registrar_cliente").prop('disabled', true);
                    }

                    if (success === "existe") {
                        $("#error_ruc").html("<div class=\"alert alert-warning\"><strong> Alerta! </strong> Este cliente ya esta registrado.</div>");
                        $("#input_ruc").prop('readonly', true);
                        $("#registrar_cliente").prop('disabled', true);
                        $("#btn_comprueba_ruc").prop('disabled', true);
                        $("#input_razon_social").val(json_ruc.result.nombre);
                    }

                    if (success === true) {
                        $("#input_ndocumento").prop('readonly', true);
                        $("#btn_comprueba_ruc").prop('disabled', true);
                        $("#registrar_cliente").prop('disabled', false);
                        $("#input_datos").prop('readonly', false);
                        $("#input_telefono").focus();
                        $("#input_datos").val(json_ruc.result.nombre);
                        $("#input_direccion").val(json_ruc.result.direccion);
                    }
                },
                error: function () {
                    $("#error_ruc").html("<div class=\"alert alert-warning\"><strong> Error! </strong> Ocurrio un error al procesar.</div>");
                    $("#input_ruc").prop('readonly', false);
                    $("#input_datos").val("");
                    $("#input_telefono").val("");
                    $("#input_direccion").val("");
                    $("#input_datos").focus();
                }
            });
        } else {
            $("#error_ruc").html("<div class=\"alert alert-danger\"><strong> Error! </strong> Numero de Documento incompleto.</div>");
        }
    }
</script>

</body>

</html>




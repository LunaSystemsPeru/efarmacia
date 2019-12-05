<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}
$title = "Registro de Proveedor - Farmacia - Luna Systems Peru";
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
                            <span>Ventas</span>
                        </li>
                        <li class="active">
                            <span>Empresa</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Registro de Proveedor
                </h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <form class="form-horizontal" name="frm_reg_proveedor" id="frm_reg_proveedor"
                          action="procesos/reg_proveedor.php" method="post">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                                <a class="closebox"><i class="fa fa-times"></i></a>
                            </div>
                            Datos Generales
                        </div>
                        <div class="panel-body">
                            <div class="form-group" id="error_ruc">

                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">N DOCUMENTO: </label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control text-center"
                                           name="input_ruc" id="input_ruc"
                                           max-lenght="11" required/>
                                </div>
                                <button type="button" class="btn btn-info" onclick="enviar_ruc()" id="btn_comprueba_ruc"><i class="fa fa-search"></i> Validar RUC</button>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">DATOS: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="input_razon_social"
                                           id="input_razon_social" max-lenght="11" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">NOMBRE COMERCIAL: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="input_comercial"
                                           id="input_comercial" required readonly/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">DIRECCION: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="input_direccion"
                                           id="input_direccion" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Condicion: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="input_condicion"
                                           id="input_condicion" required readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Estado: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="input_estado"
                                           id="input_estado" required readonly/>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer text-right">
                            <button class="btn btn-primary" type="submit" id="registrar_proveedor">Guardar
                            </button>
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
            "ruc": $("#input_ruc").val()
        };

        if ($("#input_ruc").val().length === 11) {
            $.ajax({
                data: parametros,
                url: 'ajax_post/validar_proveedor.php',
                type: 'post',
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
                        $("#error_ruc").html("<div class=\"alert alert-danger\"><strong> Error! </strong> El numero de RUC es incorrecto.</div>");
                    }

                    if (success === "existe") {
                        $("#error_ruc").html("<div class=\"alert alert-warning\"><strong> Alerta! </strong> Esta empresa ya esta registrada.</div>");
                        $("#input_ruc").prop('readonly', true);
                        $("#btn_comprueba_ruc").prop('disabled', true);
                        $("#input_razon_social").val(json_ruc.result.RazonSocial);
                    }

                    if (success === true) {
                        var estado = json_ruc.result.Estado;
                        var condicion = json_ruc.result.Condicion;

                        if (condicion === "NO HABIDO" || estado === "BAJA DE OFICIO" || estado === "BAJA PROV. POR OFICI") {
                            $("#error_ruc").html("<div class=\"alert alert-warning\"><strong> Alerta! </strong> NO PODEMOS REGISTRAR A ESTA EMPRESA.</div>");
                            $("#input_razon_social").val(json_ruc.result.RazonSocial);
                            $("#input_estado").val(estado);
                            $("#input_condicion").val(condicion);
                            $("#input_ruc").prop('readonly', true);
                            $("#btn_comprueba_ruc").prop('disabled', true);
                        } else {
                            $("#input_ruc").prop('readonly', true);
                            $("#btn_comprueba_ruc").prop('disabled', true);
                            $("#input_comercial").prop('readonly', false);
                            $("#input_comercial").focus();
                            $("#input_comercial").val(json_ruc.result.NombreComercial);
                            $("#input_razon_social").val(json_ruc.result.RazonSocial);
                            $("#input_direccion").val(json_ruc.result.Direccion);
                            $("#input_estado").val(estado);
                            $("#input_condicion").val(condicion);
                        }
                    }
                },
                error: function () {
                    $("#error_ruc").html("<div class=\"alert alert-warning\"><strong> Error! </strong> Ocurrio un error al procesar.</div>");
                    $("#input_ruc").prop('readonly', false);
                    $("#input_razon_social").val("");
                    $("#input_comercial").val("");
                    $("#input_estado").val("");
                    $("#input_condicion").val("");
                    $("#input_ruc").focus();
                }
            });
        } else {
            $("#error_ruc").html("<div class=\"alert alert-danger\"><strong> Error! </strong> Numero de RUC incompleto.</div>");
        }
    }
</script>

</body>

</html>




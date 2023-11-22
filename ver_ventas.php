<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

if (!isset($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_venta.php';
$c_venta = new cl_venta();
$c_venta->setIdEmpresa($_SESSION['id_empresa']);
$c_venta->setIdSucursal($_SESSION['id_sucursal']);
$c_venta->setPeriodo(date("Ym"));

if (filter_input(INPUT_GET, 'periodo')) {
    $c_venta->setPeriodo(filter_input(INPUT_GET, 'periodo'));
}
$title = "Ver Ventas - Farmacia - Luna Systems Peru";
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
    <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css">
    <link href="vendor/toast/build/jquery.toast.min.css" rel="stylesheet">
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
                            <span>Ventas</span>
                        </li>
                        <li class="active">
                            <span>Ventas</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Listar Ventas
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
                                <a href="reg_venta.php" class="btn btn-success">Nueva Venta</a>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-warning" data-toggle="modal" data-target="#modalbuscar">Buscar Documento</button>
                            </div>
                            <div class="btn-group">
                                <a href="ver_utilidad_venta.php?periodo=<?php echo date("Ym") ?>" class="btn btn-info">Ver Utilidad del mes</a>
                            </div>

                            <div class="btn-group">
                                <input type="hidden" id="input-periodo" value="<?php echo $c_venta->getPeriodo() ?>">
                                <input type="hidden" id="input-empresa" value="<?php echo $c_venta->getIdEmpresa() ?>">
                                <input type="hidden" id="input-tienda" value="<?php echo $c_venta->getIdSucursal() ?>">
                                <button type="button" onclick="cargarXLS()" class="btn btn-info">Ver EXCEL</button>
                            </div>

                            <div class="modal fade" id="modalbuscar" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal">
                                            <div class="color-line"></div>
                                            <div class="modal-header text-center">
                                                <h4 class="modal-title">Agregar Mi Documento SUNAT</h4>
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
                                                    <label class="col-lg-2 control-label">Cliente: </label>
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
                                        <select class="form-control" id="select_anio" onchange="obtener_periodo()">
                                            <option>Seleccionar Año</option>
                                            <?php
                                            foreach ($c_venta->ver_anios() as $fila) {
                                                echo '<option value="' . $fila['anio'] . '">' . $fila['anio'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="select_periodo" onchange="ver_periodo()">
                                            <option>Seleccionar Periodo</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="tabla-ingresos" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="10%">Documento</th>
                                    <th width="8%">Fecha</th>
                                    <th width="10%">Doc. Cliente</th>
                                    <th>Datos Cliente</th>
                                    <th width="11%">Usuario</th>
                                    <th width="6%">Total</th>
                                    <th width="10%">Estado</th>
                                    <th width="15%">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $a_ventas = $c_venta->ver_ventas();
                                foreach ($a_ventas as $fila) {
                                    $estado = "";
                                    if ($fila['estado'] == 1) {
                                        $total = $fila['total'];
                                        $pagado = $fila['pagado'];
                                        $estado = "<label class='label label-success'>Pagado</label>";
                                    } else {
                                        $total = 0;
                                        $pagado = 0;
                                        $estado = "<label class='label label-danger'>Anulado</label>";
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <a target="_blank" href="reports/documento_venta.php?id_venta=<?php echo $fila['id_venta'] ?>&periodo=<?php echo $fila['periodo'] ?>">
                                                <?php echo $fila['abreviatura'] . " | " . $fila['serie'] . " - " . $fila['numero'] ?>
                                            </a>
                                        </td>
                                        <td class="text-center"><?php echo $fila['fecha'] ?></td>
                                        <td><?php echo $fila['documento'] ?></td>
                                        <td><?php echo $fila['nombre'] ?></td>
                                        <td class="text-center"><?php echo $fila['username'] ?></td>
                                        <td class="text-right"><?php echo number_format($total, 2) ?></td>
                                        <td class="text-center">
                                            <?php echo $estado; ?>
                                        </td>
                                        <td class="text-center">


                                            <?php
                                            if ($fila['estado'] == 1) {
                                                if ($fila['id_documento'] != 1) {
                                                    echo '<a target="_blank" href="greenter/files/20605162739-' . $fila['cod_sunat'] . '-' . $fila['serie'] . '-' . $fila['numero'] . '.xml" class="btn btn-primary btn-sm"><i class="fa fa-file-pdf-o"></i> XML</a>';
                                                }
                                                ?>
                                                <button class="btn btn-info btn-sm" title="Ver Detalle" onclick="obtener_detalle('<?php echo $fila['id_venta'] ?>', '<?php echo $fila['periodo'] ?>')"><i class="fa fa-eye-slash"></i></button>
                                                <button onclick="anular_venta(<?php echo $fila["id_venta"] . "," . $fila["periodo"]; ?>)" class="btn btn-danger btn-sm" title="Anular Documento"><i class="fa fa-close"></i></button>

                                                <?php
                                            } ?>

                                            <!--<button class="btn btn-success btn-sm" title="Ver Pagos"><i class="fa fa-money"></i></button>-->

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="btn-group">
                            <button type="button" onclick="obtenerTXTComparativa()" class="btn btn-info">generar TXT consulta MASIVA</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="modal_ver_detalle" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="color-line"></div>
                    <div class="modal-header text-center">
                        <h4 class="modal-title">Ver detalle de venta</h4>
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
<script src="vendor/toast/build/jquery.toast.min.js"></script>
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<!-- App scripts -->
<script src="scripts/homer.js"></script>

<script>

    $(function () {

        // Initialize Example 1
        $('#tabla-ingresos').dataTable(
            {
                order: [[1, "desc"], [0, "desc"]],
                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
                buttons: [
                    {extend: 'copy', className: 'btn-sm'},
                    {extend: 'csv', title: 'Ventas', className: 'btn-sm'},
                    {extend: 'pdf', title: 'Ventas', className: 'btn-sm'},
                    {extend: 'print', className: 'btn-sm'}
                ]
            });

    });

</script>

<script>
    function obtener_detalle(id_venta, periodo) {
        var parametros = {
            id_venta: id_venta,
            periodo: periodo
        };
        $.ajax({
            data: parametros, //datos que se envian a traves de ajax
            url: 'modals_php/m_venta_productos.php', //archivo que recibe la peticion
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

    function obtener_periodo() {
        var anio = $("#select_anio").val();
        var periodo = $("#select_periodo");
        var parametros = {
            anio: anio
        };
        $.ajax({
            data: parametros, //datos que se envian a traves de ajax
            url: 'ajax_post/obtener_periodos_venta.php', //archivo que recibe la peticion
            type: 'post', //método de envio
            beforeSend: function () {
                //$("#select_periodo").html("")
            },
            success: function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                var json_response = JSON.parse(response);
                periodo.find('option').remove();
                periodo.append('<option value="">Seleccionar periodo</option>')
                $(json_response).each(function (i, v) { // indice, valor
                    periodo.append('<option value="' + v.periodo + '">' + v.periodo + '</option>');
                });
                periodo.prop('disabled', false);
            }
        });
    }

    function ver_periodo() {
        window.location.href = 'ver_ventas.php?periodo=' + $("#select_periodo").val();
    }


    function anular_venta(id_venta, periodo) {

        swal({
            title: "Anular Venta",
            text: "Esta seguro de ANULAR este documento?",
            type: "warning",
            showCancelButton: true,
            //cancelButtonClass: 'btn-secondary ',
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Anular",
            cancelButtonText: "No, cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                window.location.href = 'procesos/del_venta.php?id_venta=' + id_venta + '&periodo=' + periodo;
            }
        });
    }

    function cargarXLS() {
        periodo = document.getElementById('input-periodo').value
        empresa = document.getElementById('input-empresa').value
        tienda = document.getElementById('input-tienda').value
        $.get('reports/xls_ventas_fechas.php', {'periodo': periodo, 'tienda': tienda, 'empresa': empresa}, function (data) {
            console.log(data)
            window.location.href = data;
        })
    }

    function obtenerTXTComparativa() {
        let periodo = document.getElementById('input-periodo').value
        let tienda = document.getElementById('input-tienda').value
        $.get('reports/txt_consulta_masiva_sunat.php', {'periodo': periodo, 'tienda': tienda}, function (data) {
            let array_archivos = JSON.parse(data)
            let archivos = array_archivos.archivos
            for (var i = 0; i < archivos.length; i++) {
                //console.log(archivos[i]);
                generarLink(archivos[i] + ".txt", 'reports/tmp/')
            }
        })
    }

    function generarLink(file, carpeta) {
        var downloadLink = document.createElement("a");
        downloadLink.download = file;
        downloadLink.innerHTML = "Download File";
        if (window.webkitURL != null) {
            downloadLink.href = carpeta + file + "?v=" + Date.now();
        } else {
            downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
            downloadLink.onclick = destroyClickedElement;
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
        }

        downloadLink.click();
    }


</script>


</body>

</html>




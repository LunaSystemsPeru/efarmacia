<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_compra.php';
require 'class/cl_banco.php';

$c_compra = new cl_compra();
$c_banco=new cl_banco();
$c_banco->setIdEmpresa($_SESSION['id_empresa']);
$c_compra->setIdEmpresa($_SESSION['id_empresa']);

$title = "Ver Documentos de Compras - Farmacia - Luna Systems Peru";
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
        <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css">

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
                                    <span>Compras</span>
                                </li>
                                <li class="active">
                                    <span>Gastos Documentados</span>
                                </li>
                            </ol>
                        </div>
                        <h2 class="font-light m-b-xs">
                            Listar Compras
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
                                        <a href="reg_compra.php" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Doc. Compra</a>
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
                                                    <?php
                                                   /* $a_periodo = $c_compra->verPeriodos();
                                                    foreach ($a_periodo as $fila) {
                                                        ?>
                                                        <option ><?php echo $fila['periodo']?></option>
                                                    <?php
                                                    }*/
                                                    ?>
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
                                <table id="tabla-ingresos" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="7%">Id.</th>
                                            <th width="11%">Fecha</th>
                                            <th width="30%">Proveedor</th>
                                            <th width="15%">Documento</th>
                                            <th width="11%">Usuario</th>
                                            <th width="7%">Total</th>
                                            <th width="7%">Pagado</th>
                                            <th width="20%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a_compras = $c_compra->verFilas();
                                    $total = 0;
                                    $pagado = 0;
                                    foreach ($a_compras as $fila) {
                                        $total += $fila['total'];
                                        $pagado += $fila['pagado'];
                                        ?>
                                        <tr>
                                            <td><?php echo $fila['periodo'] . $fila['id_compra']?></td>
                                            <td class="text-center"><?php echo $fila['fecha']?></td>
                                            <td><?php echo $fila['documento'] . " | ".$fila['nombre']?></td>
                                            <td><?php echo $fila['abreviatura'] . " | " .  $fila['serie']. " - " .  $fila['numero']?></td>
                                            <td class="text-center"><?php echo $fila['username']?></td>
                                            <td class="text-right"><?php echo number_format($fila['total'],2)?></td>
                                            <td class="text-right"><?php echo number_format($fila['pagado'],2 )?></td>
                                            <td class="text-center">
                                                <button onclick="obtener_datos_pago(<?php echo $fila['id_compra'] . ",". $fila['periodo'] ;?>)" data-toggle="modal" data-target="#modalpagocompra" class="btn btn-sm btn-warning" title="Ver Pagos"><i class="fa fa-money"></i></button>
                                                <button onclick="eliminar_compra(<?php echo $fila['id_compra'] . ",". $fila['periodo'] ;?>)" class="btn btn-danger btn-sm" title="Eliminar Documento"><i class="fa fa-close"></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td class="text-right"><?php echo number_format($total,2 )?></td>
                                        <td class="text-right"><?php echo number_format($pagado,2 )?></td>
                                        <td class="text-right"><?php echo number_format($total - $pagado,2 )?></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        <!-- Modal -->
        <div class="modal fade" id="modalpagocompra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center" style="padding: 15px;">
                        <h5 class="modal-title" id="exampleModalLabel">Pago de documento de compra</h5>
                    </div>
                    <div id="contenpago" class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div  class="modal fade" id="modalPagar" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center" style="padding: 15px;">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Pago</h5>
                    </div>
                    <div  class="modal-body">
                        <div>
                            <span id="idPre_total" style="font-weight: bold; font-size: 1.5em;" >Total: </span><br>
                            <span id="idPre_pagado" style="font-weight: bold; font-size: 1.5em;" >Pagado: </span><br><br>

                        </div>
                        <form id="input_form_pago">
                            <input type="hidden" id="id_compra" name="id_compra">
                            <input type="hidden" id="periodo_compra" name="periodo">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Fecha:</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control"  name="fecha" style="margin-bottom: 5px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Banco:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_banco" style="margin-bottom: 5px;">
                                        <?php
                                        $listaBancos= $c_banco->verFilas();
                                        foreach ($listaBancos as $value){
                                            echo "<option value='{$value['id_banco']}'>{$value['nombre']}</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Monto:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="monto">
                                </div>
                            </div>



                        </form>


                        <div >

                            <button style="margin-top: 15px;margin: auto;" class="btn btn-primary" onclick="enviarPagoCompra ()">registrar</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
        <script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
        <!-- App scripts -->
        <script src="scripts/homer.js"></script>

        <script>


            $(function () {

                // Initialize Example 1
                $('#tabla-ingresos').dataTable({
                    order: [[1, "asc"]],
                    dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                    "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
                    buttons: [
                        {extend: 'copy', className: 'btn-sm'},
                        {extend: 'csv', title: 'Compras', className: 'btn-sm'},
                        {extend: 'pdf', title: 'Compras', className: 'btn-sm'},
                        {extend: 'print', className: 'btn-sm'}
                    ]
                });

            });

        </script>


    </body>
    <script>
        function eliminar_compra(id_compra,periodo) {
            swal({
                title: "Anular Compra",
                text: "Esta seguro de ANULAR esta compra?",
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
                    var urls=window.location.toString();
                    var res = urls.substring(0,urls.length- 16);
                    console.log(res+"/procesos/del_compra.php?idcompra="+id_compra+"&periodo="+periodo);
                    location.href=res+"/procesos/del_compra.php?idcompra="+id_compra+"&periodo="+periodo;
                }
            });
        }
    </script>
    <script>
        function obtener_datos_pago(id,periodo) {
            $("#id_compra").val(id);
            $("#periodo_compra").val(periodo);
            /*$.get( "ajax_post/detalle_compra.php?id_compra={id}%", function( data ) {
                $( ".result" ).html( data );
                alert( "Load was performed." );
            });*/
            $.post( "ajax_post/detalle_compra.php",
                { id_compra: id, periodo: periodo },
                function( data ) {
                $("#contenpago").html(data);
            });
        }

        function preparar_datos_pagos() {
            console.log($("#idTotal").text());
            $("#idPre_total").text("Total: " + $("#idTotal").text());
            $("#idPre_pagado").text("Pagado: " + $("#idPagado").text());
        }

        function enviarPagoCompra () {
            if (true){
                $.ajax({
                    type: "POST",
                    url: "procesos/reg_pago_compra.php",
                    data: $("#input_form_pago").serialize(),
                    success: function(data)
                    {

                        console.log(data);

                        if (isJsonStructure(data)){
                            var obj = JSON.parse(data);
                            swal({
                                title: "Pago",
                                text: "Pago Registrado con exito!",
                                type: "success",
                                showCancelButton: false,
                                //cancelButtonClass: 'btn-secondary ',
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Registrado",
                                //cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: true,
                                //closeOnCancel: false
                            }, function (isConfirm) {
                                if (isConfirm) {
                                    $('#modalPagar').modal('toggle');
                                    obtener_datos_pago(obj.id,obj.periodo);
                                    estado_reload=true;
                                }
                            });
                        }else{
                            swal("Error en el servidor,  contacte con soporte");
                        }
                    }
                });
            }
        }

        $('#modalpagocompra').on('hide.bs.modal', function (e) {
            if (estado_reload){
                window.location.reload();

            }

        });

        function eliminar_pago_compra(id_pago) {
            swal({
                title: "Anular Pago",
                text: "Esta seguro de ANULAR este Pago?",
                type: "warning",
                showCancelButton: true,
                //cancelButtonClass: 'btn-secondary ',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Anular",
                cancelButtonText: "No, cancelar!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.get( "procesos/del_compra_pago.php?id_pago="+ id_pago, function( data ) {
                        console.log(data);

                        if (isJsonStructure(data)){
                            var obj = JSON.parse(data);
                            obtener_datos_pago(obj.id,obj.periodo);
                            estado_reload=true;
                        }else{
                            swal("Error en el servidor,  contacte con soporte");
                        }
                     });
                }
            });
        }
        var estado_reload=false;
        function isJsonStructure(str) {
            if (typeof str !== 'string') return false;
            try {
                const result = JSON.parse(str);
                const type = Object.prototype.toString.call(result);
                return type === '[object Object]'
                    || type === '[object Array]';
            } catch (err) {
                return false;
            }
        }
    </script>

</html>




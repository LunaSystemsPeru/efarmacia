<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_banco_movimiento.php';
require 'class/cl_banco.php';
require 'class/cl_movimiento_banco_tipo.php';

$c_movimiento = new cl_banco_movimiento();
$c_banco = new cl_banco();
$c_banco_tipo = new cl_movimiento_banco_tipo();

$c_movimiento->setIdBanco(filter_input(INPUT_GET, 'id_banco'));
$c_banco->setIdBanco($c_movimiento->getIdBanco());
$c_banco->setIdEmpresa($_SESSION['id_empresa']);

if (!$c_movimiento->getIdBanco()) {
    header("Location: ver_bancos.php");
}
$title = "Ver Movimientos del Banco - Farmacia - Luna Systems Peru";
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>

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
                            <a href="ver_bancos.php" class="btn btn-default"><i class="fa fa-arrow-left"> </i> ver Bancos</a>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-success" data-toggle="modal" data-target="#modaltransferir"><i class="fa fa-angle-double-up"> </i> Transferir a otro Banco</button>
                        </div>

                        <div class="btn-group">
                            <button class="btn btn-info" data-toggle="modal" data-target="#modalenviar"><i class="fa fa-send"> </i> Enviar a Tienda</button>
                        </div>

                        <div class="btn-group">
                            <button class="btn btn-info" data-toggle="modal" data-target="#modaladdgasto"><i class="fa fa-send"> </i> Agregar Gasto</button>
                        </div>

                        <div class="modal fade" id="modaltransferir" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-horizontal" method="post" action="procesos/reg_transferencia_banco.php">
                                        <div class="color-line"></div>
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Agregar Transferencia a Otro Banco - Anticipo</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Banco: </label>
                                                <div class="col-lg-10">
                                                    <select class="form-control" name="select_banco">
                                                        <?php
                                                        foreach ($c_banco->verOtrosBancos() as $fila) {
                                                            ?>
                                                            <option value="<?php echo $fila['id_banco'] ?>"><?php echo $fila['nombre'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Fecha: </label>
                                                <div class="col-lg-10">
                                                    <input type="date" class="form-control"
                                                           name="input_fecha" id="input_fecha" value="<?php echo date("Y-m-d") ?>"
                                                           required/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Monto: </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control text-right"
                                                           name="input_monto" id="input_monto" maxlength="10"
                                                           required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="hidden_id_banco" value="<?php echo $c_banco->getIdBanco() ?>">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalenviar" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-horizontal" method="post" action="procesos/reg_envio_banco_caja.php">
                                        <div class="color-line"></div>
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Agregar envio a Farmacia</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Fecha: </label>
                                                <div class="col-lg-10">
                                                    <input type="date" class="form-control"
                                                           name="input_fecha" id="input_fecha" value="<?php echo date("Y-m-d") ?>"
                                                           required/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Monto: </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control text-right"
                                                           name="input_monto" id="input_monto" maxlength="10"
                                                           required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="hidden_id_banco" value="<?php echo $c_banco->getIdBanco() ?>">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modaladdgasto" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">


                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Agregar Gasto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="procesos/reg_movimiento_banco.php" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="inputIdBanco" class="form-control" id="inputIdBanco" value="<?php echo $_GET['id_banco']; ?>">
                                            <div class="form-group row">
                                                <label for="inputMonto" class="col-sm-2 col-form-label">Tipo</label>
                                                <div class="col-sm-10">
                                                    <select name="inputIdTipo" class="form-control" searchable="Search here..">
                                                        <option value="" disabled selected>Seleccione banco</option>
                                                        <?php
                                                        foreach ($c_banco_tipo->verFilas() as $value) {
                                                            echo '<option value="' . $value['id_tipo'] . '">' . $value['nombre'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputMonto" class="col-sm-2 col-form-label">Monto</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="inputMonto" class="form-control" id="inputMonto" placeholder="Monto 00.0 s/.">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputTipo" class="col-sm-2 col-form-label">Tipo</label>
                                                <div class="col-sm-10">
                                                    <fieldset class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="ingreso" checked>
                                                                    <label class="form-check-label" for="gridRadios1">
                                                                        Ingreso
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="salida">
                                                                    <label class="form-check-label" for="gridRadios2">
                                                                        Salida
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-2 col-form-label">Descripccion</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="inputDescripccion" id="inputDescripccion" placeholder="Descripccion ..." rows="4" cols="20"></textarea>
                                                    <!--input type="email" class="form-control" id="inputDescripccion" placeholder="Descripccion"-->
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
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
                                <th>Fecha</th>
                                <th>Descripcion</th>
                                <th>Tipo</th>
                                <th>Ingresa</th>
                                <th>Egresa</th>
                                <th>Saldo</th>
                                <!--                                <th>Acciones</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a_movimientos = $c_movimiento->verFilas();
                            $item = 1;
                            $saldo = 0;
                            foreach ($a_movimientos as $fila) {
                                $saldo += $fila['ingresa'] - $fila['egresa'];
                                ?>
                                <tr>
                                    <td><?php echo $item ?></td>
                                    <td><?php echo $fila['fecha'] ?></td>
                                    <td><?php echo $fila['descripcion'] ?></td>
                                    <td><?php echo $fila['nombre'] ?></td>
                                    <td class="text-right"><?php echo number_format($fila['ingresa'], 2) ?></td>
                                    <td class="text-right"><?php echo number_format($fila['egresa'], 2) ?></td>
                                    <td class="text-right"><?php echo number_format($saldo, 2) ?></td>
                                    <!--<td class="text-center">
                                        <button class="btn btn-success btn-sm" title="Ver Detalle de Caja"><i class="fa fa-bar-chart"></i></button>
                                    </td>-->
                                </tr>
                                <?php
                                $item++;
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<!-- App scripts -->
<script src="scripts/homer.js"></script>

<script>

    $(function () {

        // Initialize Example 1
        $('#tabla-cajas').dataTable({
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
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




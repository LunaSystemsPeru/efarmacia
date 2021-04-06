<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_caja_diaria.php';
require 'class/cl_caja_movimiento.php';
require 'class/cl_banco.php';

$c_banco = new cl_banco();
$c_caja = new cl_caja_diaria();
$cm = new cl_caja_movimiento();

$c_caja->setIdEmpresa($_SESSION['id_empresa']);
$c_caja->setFecha(date("Y-m-d"));
$c_caja->setIdSucursal($_SESSION['id_sucursal']);
$existe_caja = $c_caja->obtener_datos();
$c_banco->setIdEmpresa($_SESSION['id_empresa']);

$cm->setFecha($c_caja->getFecha());
$cm->setIdEmpresa($c_caja->getIdEmpresa());
$cm->setIdSucursal($c_caja->getIdSucursal());

$title = "Caja Diaria - Farmacia - Luna Systems Peru";
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
                        <li>
                            <span>Inicio</span>
                        </li>
                        <li class="active">
                            <span>---</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    inicio
                </h2>
            </div>
        </div>
    </div>


    <div class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default collapsed">
                    <div class="panel-heading">
                        <?php if (!$existe_caja) { ?>
                            <button type="button" data-toggle="modal" data-target="#modal_reg_apertura"
                                    class="btn btn-warning" alt="Aperturar Caja" title="Aperturar Caja">
                                <i class="fa fa-money"></i> Abrir Caja
                            </button>
                        <?php } else { ?>
                            <a href="ver_caja_mensual.php" class="btn btn-danger"> cierre caja</a>
                        <?php } ?>
                        <a href="ver_caja_mensual.php" class="btn btn-success"> Ver Cierre Mensual</a>
                        <div class="btn-group">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#modalenviar">Enviar a Banco</button>
                        </div>


                        <div class="modal fade" id="modalenviar" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-horizontal" method="post" action="procesos/reg_envio_caja_banco.php">
                                        <div class="color-line"></div>
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Enviar al Banco</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Banco: </label>
                                                <div class="col-lg-10">
                                                    <select class="form-control" name="select_banco">
                                                        <?php
                                                        foreach ($c_banco->verFilas() as $fila) {
                                                            ?>
                                                            <option value="<?php echo $fila['id_banco'] ?>"><?php echo $fila['nombre'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Monto: </label>
                                                <div class="col-lg-4">
                                                    <input type="number" class="form-control"
                                                           name="input_monto" id="input_monto" maxlength="8"
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

                        <div class="modal fade" id="modal_reg_apertura" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-horizontal" method="post" action="procesos/reg_apertura_caja.php">
                                        <div class="color-line"></div>
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Abrir Caja</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Monto</label>
                                                <div class="col-lg-10">
                                                    <input type="number" step="0.01" placeholder="S/ " name="input_apertura"
                                                           id="input_apertura"
                                                           class="form-control" required="true">
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

                        <div class="modal fade" id="modal_reg_movimiento" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Agregar Movimiento de Caja</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="procesos/reg_caja_movimiento.php" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="inputMonto" class="col-sm-2 col-form-label">Monto</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="inputMonto" class="form-control" id="inputMonto" placeholder="Monto 00.0 s/.">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputTipo" class="col-sm-2 col-form-label">Tipo</label>
                                                <div class="col-sm-10">
                                                    <fieldset class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="ingreso">
                                                                    <label class="form-check-label" for="gridRadios1">
                                                                        Ingreso
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="salida" checked>
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
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        if ($existe_caja) {
                            ?>
                            <div class="col-lg-6">
                                <div class="panel panel-default collapsed">
                                    <div class="panel-heading">
                                        <span><i class="fa fa-dollar"></i> Ver Caja</span>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Detalle caja</th>
                                                <th>monto</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Apertura</td>
                                                <td class="text-right text-success">
                                                    + <?php echo number_format($c_caja->getMApertura(), 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Ventas Efectivo</td>
                                                <td class="text-right text-success">
                                                    + <?php echo number_format($c_caja->getVentaDia(), 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Cobros Ventas</td>
                                                <td class="text-right text-success">
                                                    + <?php echo number_format($c_caja->getVentaCobro(), 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Otros Ingresos</td>
                                                <td class="text-right text-success">
                                                    + <?php echo number_format($c_caja->getOtrosIngresos(), 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Ventas Anuladas</td>
                                                <td class="text-right text-danger">
                                                    - <?php echo number_format($c_caja->getVentaAnulacion(), 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Gastos</td>
                                                <td class="text-right text-danger">
                                                    - <?php echo number_format($c_caja->getCompraEgreso() + $c_caja->getGastosVarios(), 2) ?></td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right">
                                                    <strong><?php echo number_format($c_caja->getMApertura() + $c_caja->getMSistema(), 2) ?></strong>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="panel panel-default collapsed">
                                    <div class="panel-heading">
                                        <span><i class="fa fa-bars"></i> Ver resumen</span>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped">
                                            <tbody>
                                            <tr>
                                                <td>Total Ventas</td>
                                                <td class="text-right"><?php echo number_format(0, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Ventas en Efectivo</td>
                                                <td class="text-right"><?php echo number_format(0, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Ventas por cobrar</td>
                                                <td class="text-right"><?php echo number_format(0, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Utilidad</td>
                                                <td class="text-right"><?php echo number_format(0, 2) ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="panel panel-default collapsed">
                                    <div class="panel-heading">
                                        <span><i class="fa fa-subway"></i> Ver Movimientos</span>
                                        <button type="button" data-toggle="modal" data-target="#modal_reg_movimiento"
                                                class="btn btn-warning col-lg-offset-2" alt="Añadir Movimiento"
                                                title="Añadir Movimiento"><i
                                                    class="fa fa-money"></i> Agregar Movimiento
                                        </button>

                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Descripccion</th>
                                                <th>Monto</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $suma_movimientos = 0;
                                            $item = 1;
                                            foreach ($cm->verFilas() as $value) {
                                                $monto = $value['MONTO'];
                                                $descripccion = $value['DESCRIPCCION'];
                                                $suma_movimientos += ($monto);
                                                ?>
                                                <tr>
                                                    <td><?php echo $item ?></td>
                                                    <td><?php echo $descripccion ?></td>
                                                    <td class="text-right"><?php echo $monto ?></td>
                                                </tr>


                                                <?php
                                                $item++;
                                            }
                                            ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right"><?php echo number_format($suma_movimientos, 2) ?></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="panel panel-default collapsed">
                                    <div class="panel-heading">
                                        <span><i class="fa fa-money"></i> Ver Totales</span>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Descripcion</th>
                                                <th>monto</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>total sistema</td>
                                                <td class="text-right"><?php echo number_format($c_caja->getMApertura() + $c_caja->getMSistema(), 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td>en efectivo</td>
                                                <td class="text-right"><?php echo number_format($c_caja->getMCierre(), 2) ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <?php
                        } else {
                            require 'modals_php/m_sin_caja.php';
                        }
                        ?>
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

</body>

</html>




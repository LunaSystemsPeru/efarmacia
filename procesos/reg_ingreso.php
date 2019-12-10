<?php
session_start();

require '../class/cl_ingreso.php';
require '../class/cl_ingreso_productos.php';
require '../class/cl_varios.php';

$c_ingreso = new cl_ingreso();
$c_detalle = new cl_ingreso_productos();
$c_varios = new cl_varios();

$fecha = filter_input(INPUT_POST, 'input_fecha');
$c_ingreso->setFecha($fecha);
$c_ingreso->setIdDocumento(filter_input(INPUT_POST, 'select_documento'));
$c_ingreso->setSerie(filter_input(INPUT_POST, 'input_serie'));
$c_ingreso->setNumero(filter_input(INPUT_POST, 'input_numero'));
$c_ingreso->setIdEmpresa($_SESSION['id_empresa']);
$c_ingreso->setIdUsuario($_SESSION['id_usuario']);
$c_ingreso->setTotal(filter_input(INPUT_POST, 'input_total_hidden'));
$c_ingreso->setIdProveedor(filter_input(INPUT_POST, 'hidden_id_proveedor'));
$c_ingreso->setPeriodo($c_varios->anio_de_fecha($fecha) . $c_varios->zerofill($c_varios->mes_de_fecha($fecha), 2));
$c_ingreso->obtener_codigo();

if ($c_ingreso->insertar()) {
    //llenar generales de detalle
    $c_detalle->setPeriodo($c_ingreso->getPeriodo());
    $c_detalle->setIdIngreso($c_ingreso->getIdIngreso());
    $c_detalle->setIdEmpresa($c_ingreso->getIdEmpresa());
    //leer detalle de ingreso
    $a_detalle = $_SESSION['productos_ingreso'];
    foreach ($a_detalle as $value) {
        $c_detalle->setIdProducto($value['id_producto']);
        $c_detalle->setLote($value['lote']);
        $c_detalle->setVencimiento($value['vcto']);
        $c_detalle->setCantidad($value['cantidad']);
        $c_detalle->setCosto($value['costo']);
        $c_detalle->setVenta($value['precio']);
        $c_detalle->insertar();
    }

    header("Location: ../ver_ingresos.php");
}

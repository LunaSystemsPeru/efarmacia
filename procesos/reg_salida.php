<?php
session_start();

require '../class/cl_salida.php';
require '../class/cl_salida_producto.php';
require '../class/cl_varios.php';

$c_salida = new cl_salida();
$c_detalle = new cl_salida_producto();
$c_varios = new cl_varios();

$fecha = filter_input(INPUT_POST, 'input_fecha');
$c_salida->setFecha($fecha);
$c_salida->setIdEmpresa($_SESSION['id_empresa']);
$c_salida->setIdUsuario($_SESSION['id_usuario']);
$c_salida->setTotal(filter_input(INPUT_POST, 'input_total_hidden'));
$c_salida->setIdProveedor(filter_input(INPUT_POST, 'hidden_id_proveedor'));
$c_salida->obtener_codigo();

if ($c_salida->insertar()) {
    //llenar generales de detalle
    $c_detalle->setIdEmpresa($c_salida->getIdEmpresa());
    $c_detalle->setIdSalida($c_salida->getIdSalida());
    //leer detalle de ingreso
    $a_detalle = $_SESSION['productos_ingreso'];
    foreach ($a_detalle as $value) {
        $c_detalle->setIdProducto($value['id_producto']);
        $c_detalle->setCantidad($value['cantidad']);
        $c_detalle->setCosto($value['costo']);
        $c_detalle->insertar();
    }
}
    header("Location: ../ver_salida.php");


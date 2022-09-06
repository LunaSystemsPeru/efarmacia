<?php
session_start();

require '../class/cl_ajuste.php';
require '../class/cl_varios.php';
require '../class/cl_ajuste_producto.php';

$c_ajuste = new cl_ajuste();
$c_detalle = new cl_ajuste_producto();
$c_varios = new cl_varios();

$c_ajuste->setIdUsuario($_SESSION['id_usuario']);
$c_ajuste->setIdEmpresa($_SESSION['id_empresa']);
$c_ajuste->setFecha(date("Y-m-d"));
$c_ajuste->setAnio($c_varios->anio_de_fecha($c_ajuste->getFecha()));
$c_ajuste->setIdSucursal($_SESSION['id_sucursal']);
$c_ajuste->obtener_codigo();

if ($c_ajuste->insertar()) {
    $c_detalle->setIdAjuste($c_ajuste->getIdAjuste());
    $c_detalle->setIdEmpresa($c_ajuste->getIdEmpresa());
    $c_detalle->setIdSucursal($c_ajuste->getIdSucursal());

    $a_ajuste = $_SESSION['productos_ajuste'];
    foreach ($a_ajuste as $fila) {
        $c_detalle->setIdProducto($fila['id_producto']);
        $c_detalle->setCosto($fila['costo']);
        $c_detalle->setVenta($fila['precio']);
        $c_detalle->setCactual($fila['cactual']);
        $c_detalle->setCnueva($fila['cantidad']);
        $c_detalle->setLote($fila['lote']);
        $c_detalle->setVencimiento($fila['vcto']);
        $c_detalle->insertar();
    }

    header("Location: ../ver_ajustes.php");
}
<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../class/cl_venta.php';
require '../class/cl_ventas_anuladas.php';

$c_venta = new cl_venta();
$c_anulada = new cl_ventas_anuladas();

$c_venta->setIdVenta(filter_input(INPUT_GET, 'id_venta'));
$c_venta->setPeriodo(filter_input(INPUT_GET, 'periodo'));
$c_venta->setIdEmpresa($_SESSION["id_empresa"]);

$c_anulada->setVentaIdVenta($c_venta->getIdVenta());
$c_anulada->setFecha(date("Y-m-d"));
$c_anulada->setMotivo("-");

if ($c_venta->anular()) {
    $c_anulada->insertar();
    header("Location: ../ver_ventas.php");
}else{
    echo "error:";
}
<?php
session_start();

require '../class/cl_compra.php';
require '../class/cl_compra_pago.php';
require '../class/cl_banco_movimiento.php';

$c_compra=new cl_compra();
$c_compra_pago=new cl_compra_pago();
$c_banco_movimiento=new cl_banco_movimiento();

$id_compra=filter_input(INPUT_GET, 'idcompra');
$periodo=filter_input(INPUT_GET, 'periodo');
$id_empresa=$_SESSION["id_empresa"];

$c_compra->setIdEmpresa($id_empresa);
$c_compra->setIdCompra($id_compra);
$c_compra->setPeriodo($periodo);
$c_compra->obtenerDatos();

$c_compra_pago->setPeriodo($periodo);
$c_compra_pago->setIdCompra($id_compra);
$c_compra_pago->setIdEmpresa($id_empresa);

$listaDelete=$c_compra_pago->verCompasPagos();
foreach ($listaDelete as $value){
    $c_compra_pago->setIdPago($value["id_pago"]);
    $c_compra_pago->obtenerDatos();
    $c_compra_pago->eliminar();
    $c_banco_movimiento->setIdMovimiento($c_compra_pago->getIdMovimiento());
    $c_banco_movimiento->eliminar();
}

if ($c_compra->eliminar())
header("Location: ../ver_compras.php");






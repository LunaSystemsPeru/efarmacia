<?php
require '../class/cl_compra_pago.php';
require '../class/cl_banco_movimiento.php';

$c_compra_pago=new cl_compra_pago();
$c_banco_movimiento=new cl_banco_movimiento();


$id_pago=filter_input(INPUT_GET, 'id_pago');


$c_compra_pago->setIdPago($id_pago);
$c_compra_pago->obtenerDatos();
$c_banco_movimiento->setIdMovimiento($c_compra_pago->getIdMovimiento());

$c_compra_pago->eliminar();
$c_banco_movimiento->eliminar();


echo '{ "id": '.$c_compra_pago->getIdCompra() . ', "periodo": '.$c_compra_pago->getPeriodo() . ' }';

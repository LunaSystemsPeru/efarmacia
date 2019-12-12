<?php
session_start();

require  '../class/cl_banco_movimiento.php';
require  '../class/cl_compra_pago.php';

$c_banco_movimiento=new cl_banco_movimiento();
$c_compra_pago=new cl_compra_pago();

$idBanco=filter_input(INPUT_POST, 'id_banco');
$idcompra=filter_input(INPUT_POST, 'id_compra');
$periodo=filter_input(INPUT_POST, 'periodo');
$monto=filter_input(INPUT_POST, 'monto');
$fecha = filter_input(INPUT_POST, 'fecha');

echo  "{$idBanco} - {$idcompra} - {$periodo} - {$monto}";


$c_banco_movimiento->obtener_codigo();
$c_banco_movimiento->setDescripcion("");
$c_banco_movimiento->setEgresa($monto);
$c_banco_movimiento->setFecha($fecha);
$c_banco_movimiento->setIdBanco($idBanco);
$c_banco_movimiento->setIdTipo(7);
$c_banco_movimiento->setIngresa(0);
$c_banco_movimiento->insertar();


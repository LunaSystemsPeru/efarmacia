<?php
session_start();

require  '../class/cl_banco_movimiento.php';
require  '../class/cl_compra_pago.php';
require  '../class/cl_compra.php';
require  '../class/cl_documentos_sunat.php';
require  '../class/cl_proveedor.php';

$c_banco_movimiento=new cl_banco_movimiento();
$c_compra_pago=new cl_compra_pago();
$c_compra=new cl_compra();
$c_documentos_sunat=new cl_documentos_sunat();
$c_proveedor=new cl_proveedor();


$idBanco=filter_input(INPUT_POST, 'id_banco');
$idcompra=filter_input(INPUT_POST, 'id_compra');
$periodo=filter_input(INPUT_POST, 'periodo');
$monto=filter_input(INPUT_POST, 'monto');
$fecha = filter_input(INPUT_POST, 'fecha');

$c_compra->setIdCompra($idcompra);
$c_compra->setPeriodo($periodo);
$c_compra->setIdEmpresa($_SESSION["id_empresa"]);
$c_compra->obtenerDatos();

$c_proveedor->setIdEmpresa($c_compra->getIdEmpresa());
$c_proveedor->setIdProveedor($c_compra->getIdProveedor());
$c_proveedor->obtener_datos();

$c_documentos_sunat->setIdDocumento($c_compra->getIdDocumento());
$c_documentos_sunat->obtener_datos();

$c_banco_movimiento->obtener_codigo();
$c_banco_movimiento->setDescripcion("PAGO A PROVEEDOR | {$c_proveedor->getDocumento()} | {$c_documentos_sunat->getAbreviatura()} - {$c_compra->getSerie()} - {$c_compra->getNumero()}");
$c_banco_movimiento->setEgresa($monto);
$c_banco_movimiento->setFecha($fecha);
$c_banco_movimiento->setIdBanco($idBanco);
$c_banco_movimiento->setIdTipo(7);
$c_banco_movimiento->setIngresa(0);
$c_banco_movimiento->insertar();

$c_compra_pago->obtener_codigo();
$c_compra_pago->setIdEmpresa($c_compra->getIdEmpresa());
$c_compra_pago->setIdCompra($idcompra);
$c_compra_pago->setPeriodo($periodo);
$c_compra_pago->setFecha($fecha);
$c_compra_pago->setMonto($monto);
$c_compra_pago->setIdMovimiento($c_banco_movimiento->getIdMovimiento());
$c_compra_pago->insertar();

echo '{ "id": '.$idcompra . ', "periodo": '.$periodo . ' }';
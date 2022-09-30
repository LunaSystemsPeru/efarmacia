<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../class/cl_caja_movimiento.php';


$monto=$_POST["inputMonto"];
$descr=$_POST["inputDescripccion"];
$rad=$_POST["gridRadios"];

$cm = new cl_caja_movimiento();
if($rad=="ingreso")
{
	$cm->setIngresa($monto);
	$cm->setRetira(0);
}else{
	$cm->setRetira($monto);
	$cm->setIngresa(0);
}

$cm->setIdEmpresa($_SESSION['id_empresa']);
$cm->setIdUsuario($_SESSION['id_usuario']);
$cm->setIdSucursal($_SESSION['id_sucursal']);
$cm->setFecha(date("Y-m-d"));
$cm->setGlosa($descr);
$cm->obtener_codigo();


if($cm->insertar()){
	header("Location: ../ver_caja_diaria.php");
}










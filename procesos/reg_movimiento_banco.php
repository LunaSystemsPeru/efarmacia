<?php

session_start();
require '../class/cl_documentos_sunat.php';
require '../class/cl_banco_movimiento.php';


$id_banco=$_POST["inputIdBanco"];

$monto=$_POST["inputMonto"];
$descr=$_POST["inputDescripccion"];
$rad=$_POST["gridRadios"];

$id_tipo=$_POST["inputIdTipo"];

$cm_bt = new cl_banco_movimiento();
$cm_bt->obtener_codigo();

if($rad=="ingreso")
{
	$cm_bt->setIngresa($monto);
	$cm_bt->setEgresa(0);
}else{
	$cm_bt->setEgresa($monto);
	$cm_bt->setIngresa(0);
}

$cm_bt->setIdBanco($id_banco);
$cm_bt->setDescripcion($descr);
$cm_bt->setIdTipo($id_tipo);

if($cm_bt->insertar()){
header("Location: ../ver_movimientos_banco.php?id_banco=".$id_banco);
}



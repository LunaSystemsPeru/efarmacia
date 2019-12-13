<?php
session_start();

require '../class/cl_banco.php';
require '../class/cl_banco_movimiento.php';

$bm = new cl_banco_movimiento();
$c_banco = new cl_banco();

$id_banco_origen = filter_input(INPUT_POST, 'hidden_id_banco');
$id_banco_destino = filter_input(INPUT_POST, 'select_banco');
$id_empresa = $_SESSION['id_empresa'];
$monto = filter_input(INPUT_POST, 'input_monto');

$c_banco->setIdEmpresa($id_empresa);
$c_banco->setIdBanco($id_banco_destino);
$c_banco->obtener_datos();

$bm->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$bm->setIdEmpresa($id_empresa);
$bm->setIdBanco($id_banco_origen);
$bm->setDescripcion("ENVIO DE TRANSFERENCIA A " . $c_banco->getNombre());
$bm->setIngresa(0);
$bm->setEgresa($monto);
$bm->setIdTipo(6);
$bm->obtener_codigo();

if ($bm->insertar()) {
    $c_banco->setIdBanco($id_banco_origen);
    $c_banco->obtener_datos();

    $bm->setIdBanco($id_banco_destino);
    $bm->setDescripcion("RECEPCION DE TRANSFERENCIA DE " . $c_banco->getNombre());
    $bm->setIngresa($monto);
    $bm->setEgresa(0);
    $bm->obtener_codigo();

    if ($bm->insertar()) {
        header("Location: ../ver_movimientos_banco.php?id_banco=".$id_banco_origen);
    }
}
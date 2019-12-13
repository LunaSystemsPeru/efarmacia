<?php
session_start();

require '../class/cl_banco_movimiento.php';
require '../class/cl_caja_movimiento.php';

$bm = new cl_banco_movimiento();
$cm = new cl_caja_movimiento();

$cm->setIdEmpresa($_SESSION['id_empresa']);
$cm->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$cm->setIngresa(0);
$cm->setRetira(filter_input(INPUT_POST, 'input_monto'));
$cm->setGlosa("ENVIO DE DINERO A BANCO");
$cm->setIdUsuario($_SESSION['id_usuario']);
$cm->obtener_codigo();

$reg_cm = $cm->insertar();

if ($reg_cm) {
    $bm->setEgresa(0);
    $bm->setFecha($cm->getFecha());
    $bm->setIdEmpresa($cm->getIdEmpresa());
    $bm->setIdBanco(filter_input(INPUT_POST, 'select_banco'));
    $bm->setDescripcion("RECIBE DINERO DE FARMACIA");
    $bm->setIngresa($cm->getRetira());
    $bm->setIdTipo(5);
    $bm->obtener_codigo();

    if ($bm->insertar()) {
        header("Location: ../ver_caja_diaria.php");
    }
}
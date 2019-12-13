<?php
session_start();

require '../class/cl_banco_movimiento.php';
require '../class/cl_caja_movimiento.php';

$bm = new cl_banco_movimiento();
$cm = new cl_caja_movimiento();

$id_empresa = $_SESSION['id_empresa'];
$id_usuario = $_SESSION['id_usuario'];
$monto = filter_input(INPUT_POST, 'input_monto');
$fecha = filter_input(INPUT_POST, 'input_fecha');

$bm->setEgresa($monto);
$bm->setIngresa(0);
$bm->setFecha($fecha);
$bm->setIdEmpresa($id_empresa);
$bm->setIdBanco(filter_input(INPUT_POST, 'hidden_id_banco'));
$bm->setDescripcion("ENVIAR DINERO A FARMACIA");
$bm->setIdTipo(12);
$bm->obtener_codigo();

if ($bm->insertar()) {
    $cm->setIdEmpresa($id_empresa);
    $cm->setFecha($fecha);
    $cm->setIngresa($monto);
    $cm->setRetira(0);
    $cm->setGlosa("RECIBE DINERO DE BANCO");
    $cm->setIdUsuario($id_usuario);
    $cm->obtener_codigo();

    $reg_cm = $cm->insertar();

    if ($reg_cm) {
        header("Location: ../ver_movimientos_banco.php?id_banco" . $bm->getIdBanco());
    }
}
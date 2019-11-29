<?php
session_start();

require '../class/cl_documentos_empresa.php';

$c_tido = new cl_documentos_empresa();
$c_tido->setIdEmpresa($_SESSION['id_empresa']);
$c_tido->setIdDocumento(filter_input(INPUT_GET, 'idtido'));
$c_tido->obtener_datos();

$resultado = [];
$resultado['serie'] = $c_tido->getSerie();
$resultado['numero'] = $c_tido->getNumero();

echo json_encode($resultado);
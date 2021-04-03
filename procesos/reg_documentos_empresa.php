<?php
session_start();

require '../class/cl_documentos_empresa.php';

$c_mis_documentos = new cl_documentos_empresa();

$c_mis_documentos->setIdEmpresa($_SESSION['id_empresa']);
$c_mis_documentos->setIdSucursal($_SESSION['id_sucursal']);
$c_mis_documentos->setIdDocumento(filter_input(INPUT_POST, 'select_documento'));
$c_mis_documentos->setSerie(filter_input(INPUT_POST, 'input_serie'));
$c_mis_documentos->setNumero(filter_input(INPUT_POST, 'input_numero'));

if ($c_mis_documentos->insertar()) {
    header("Location: ../ver_mis_documentos.php");
}
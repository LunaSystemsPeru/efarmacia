<?php
session_start();

require '../class/cl_cliente.php';
require '../class/cl_documento_internet.php';

$c_cliente = new cl_cliente();
$c_internet = new cl_documento_internet();

$documento = filter_input(INPUT_GET, 'documento');
$resultado = [];

if (strlen($documento) == 8) {
    $c_internet->setTipo(2);
}
if (strlen($documento) == 11) {
    $c_internet->setTipo(1);
}
$c_internet->setDocumento($documento);
$respuesta = json_decode($c_internet->validar(), true);
//echo $respuesta;

if ($c_internet->getTipo() == 2) {
    $resultado["success"] = "nuevo";
    $resultado["documento"] = $respuesta["dni"];
    $resultado["datos"] = $respuesta["apellidoPaterno"] . " " . $respuesta["apellidoMaterno"] . " " . $respuesta["nombres"];
    $resultado["direccion"] = "";
}

if ($c_internet->getTipo() == 1) {
    $resultado["success"] = "nuevo";
    $resultado["documento"] = $documento;
    $resultado["datos"] = $respuesta["razonSocial"];
    $resultado["direccion"] = $respuesta["direccion"];
}
//  }

echo json_encode($resultado);

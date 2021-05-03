<?php
session_start();

require '../class/cl_cliente.php';
require '../class/cl_documento_internet.php';

$c_cliente = new cl_cliente();
$c_internet = new cl_documento_internet();

$documento = filter_input(INPUT_GET, 'documento');
$resultado = [];

$c_cliente->setDocumento($documento);
$c_cliente->setIdEmpresa($_SESSION['id_empresa']);
if ($c_cliente->buscar_documento()) {
    $c_cliente->obtener_datos();
    $resultado["success"] = "existe";
    $resultado["documento"] = $c_cliente->getDocumento();
    $resultado["datos"] = $c_cliente->getNombre();
    $resultado["direccion"] = $c_cliente->getDireccion();
} else {
    if (strlen($documento) == 8) {
        $c_internet->setTipo(2);
    }
    if (strlen($documento) == 11) {
        $c_internet->setTipo(1);
    }
    $c_internet->setDocumento($documento);
    $respuesta = json_decode($c_internet->validar(), true);

/*    if ($respuesta['success'] == false) {
        $resultado["success"] = "error";
        $resultado["documento"] = $documento;
        $resultado["datos"] = "error de documento";
        $resultado["direccion"] = "";
    } else {
*/
        if ($c_internet->getTipo() == 2) {
            $resultado["success"] = "nuevo";
            $resultado["documento"] = $respuesta["dni"];
            $resultado["datos"] = $respuesta["apellidoPaterno"] . " " . $respuesta["apellidoMaterno"] . " " . $respuesta["nombres"];
            $resultado["direccion"] = "";
        }

        if ($c_internet->getTipo() == 1) {
            $resultado["success"] = "nuevo";
            $resultado["documento"] = $respuesta["result"]["RUC"];
            $resultado["datos"] = $respuesta["result"]["RazonSocial"];
            $resultado["direccion"] = $respuesta["result"]["Direccion"];
        }
  //  }
}

echo json_encode($resultado);

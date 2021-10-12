<?php
session_start();
require '../class_varios/cl_validar_documento.php';
require '../class/cl_cliente.php';

$c_validar = new cl_validar_documento();
$c_cliente = new cl_cliente();
$c_cliente->setIdEmpresa($_SESSION['id_empresa']);

$documento = filter_input(INPUT_GET, 'input_documento');
$resultado = "";
if (strlen($documento) == 8) {
    $c_validar->setDni($documento);
    $json = $c_validar->obtener_dni();
    print_r($json);
    $decodificado = json_decode($json, true);
    $success = $decodificado['success'];
    if ($success == false) {
        $array_result = $decodificado['msg'];
    }
    if ($success == true) {
        $array_result = array(
            "nombre" => $decodificado['entity']['nombre'],
            "direccion" => "-"
        );
    }
    $resultado = (object)array(
        "success" => $success,
        "result" => $array_result
    );
}

if (strlen($documento) == 11) {
    $c_validar->setRuc($documento);
    $json = $c_validar->obtener_ruc();
    $decodificado = json_decode($json, true);
    $success = $decodificado['success'];
    if ($success == false) {
        $array_result = $decodificado['msg'];
    }
    if ($success == true) {
        $array_result = array(
            "nombre" => $decodificado['entity']['RazonSocial'],
            "direccion" => $decodificado['entity']['Direccion']
        );
    }
    $resultado = (object)array(
        "success" => $success,
        "result" => $array_result
    );
}

echo json_encode($resultado);

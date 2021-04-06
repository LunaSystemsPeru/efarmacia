<?php
session_start();

require '../class/cl_sucursal.php';

$c_sucursal = new cl_sucursal();

$c_sucursal->setIdEmpresa($_SESSION['id_empresa']);
$c_sucursal->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$c_sucursal->setDireccion(filter_input(INPUT_POST, 'input_direccion'));
$c_sucursal->setUbigeo(filter_input(INPUT_POST, 'input_ubigeo'));
$c_sucursal->setDistrito(filter_input(INPUT_POST, 'input_distrito'));
$c_sucursal->setProvincia(filter_input(INPUT_POST, 'input_provincia'));
$c_sucursal->setDepartamento(filter_input(INPUT_POST, 'input_departamento'));
$c_sucursal->setCodsunat(filter_input(INPUT_POST, 'input_codsunat'));

if (filter_input(INPUT_POST, 'input_idsucursal')) {
    $c_sucursal->setIdSucursal(filter_input(INPUT_POST, 'input_idsucursal'));
    $c_sucursal->modificar();
} else {
    $c_sucursal->obtener_codigo();
    $c_sucursal->insertar();
}

header("Location: ../ver_sucursales.php");


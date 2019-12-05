<?php
session_start();
require '../class/cl_proveedor.php';
$c_proveedor = new cl_proveedor();

$c_proveedor->setDocumento(filter_input(INPUT_POST, 'input_ruc'));
$c_proveedor->setNombre(filter_input(INPUT_POST, 'input_razon_social'));
$c_proveedor->setDireccion(filter_input(INPUT_POST, 'input_direccion'));
$c_proveedor->setIdEmpresa($_SESSION['id_empresa']);
$c_proveedor->obtener_codigo();

if ($c_proveedor->insertar()) {
    header("Location: ../ver_proveedores.php");
}

<?php
session_start();
require '../class/cl_producto_sucursal.php';

$c_producto = new cl_producto_sucursal();

$c_producto->setIdEmpresa($_SESSION['id_empresa']);
$c_producto->setIdSucursal($_SESSION['id_sucursal']);
$c_producto->setIdProducto(filter_input(INPUT_GET, 'id_producto'));

if ($c_producto->eliminar()) {
    header("Location: ../ver_productos_sucursal.php");
}
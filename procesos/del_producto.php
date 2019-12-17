<?php
session_start();
require '../class/cl_producto.php';

$c_producto = new cl_producto();

$c_producto->setIdEmpresa($_SESSION['id_empresa']);
$c_producto->setIdProducto(filter_input(INPUT_GET, 'id_producto'));

if ($c_producto->eliminar()) {
    header("Location: ../ver_productos.php");
}
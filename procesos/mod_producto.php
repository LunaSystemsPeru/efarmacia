<?php
session_start();
require '../class/cl_producto.php';
$c_producto = new cl_producto();

$c_producto->setIdProducto(filter_input(INPUT_POST, 'id_producto'));
$c_producto->setCosto(filter_input(INPUT_POST, 'input_costo'));
$c_producto->setPrecio(filter_input(INPUT_POST, 'input_precio'));
$c_producto->setIdEmpresa($_SESSION['id_empresa']);


if ($c_producto->actualizar_productos()) {
    header("Location: ../ver_productos.php");
}
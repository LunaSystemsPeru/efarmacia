<?php
session_start();
require '../class/cl_producto.php';
$c_producto = new cl_producto();


$c_producto->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$c_producto->setPrincipioActivo(filter_input(INPUT_POST, 'input_principio_activo'));
$c_producto->setCosto(filter_input(INPUT_POST, 'input_costo'));
$c_producto->setPrecio(filter_input(INPUT_POST, 'input_precio'));
$c_producto->setIdLaboratorio(filter_input(INPUT_POST, 'select_laboratorio'));
$c_producto->setIdPresentacion(filter_input(INPUT_POST, 'select_presentacion'));
$c_producto->setIdEmpresa($_SESSION['id_empresa']);
$c_producto->obtener_codigo();

if ($c_producto->insertar()) {
    header("Location: ../ver_productos.php");
}
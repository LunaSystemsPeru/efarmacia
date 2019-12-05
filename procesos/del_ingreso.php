<?php
session_start();

require '../class/cl_ingreso.php';
require '../class/cl_ingreso_productos.php';

$id_ingreso = filter_input(INPUT_GET, 'id_ingreso');
$periodo = filter_input(INPUT_GET, 'periodo');
$id_empresa = $_SESSION['id_empresa'];

$c_ingreso = new cl_ingreso();
$c_detalle = new cl_ingreso_productos();

$c_ingreso->setIdEmpresa($id_empresa);
$c_ingreso->setIdIngreso($id_ingreso);
$c_ingreso->setPeriodo($periodo);

$c_detalle->setIdEmpresa($id_empresa);
$c_detalle->setIdIngreso($id_ingreso);
$c_detalle->setPeriodo($periodo);

if ($c_detalle->eliminar() ) {
    if ($c_ingreso->eliminar()) {
        header("Location: ../ver_ingresos.php");
    }
}


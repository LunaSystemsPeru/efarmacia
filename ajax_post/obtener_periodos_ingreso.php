<?php
session_start();
require '../class/cl_ingreso.php';

$c_ingreso = new cl_ingreso();
$c_ingreso->setIdEmpresa($_SESSION['id_empresa']);

$rsultado = $c_ingreso->ver_periodos(filter_input(INPUT_POST, 'anio'));

echo json_encode($rsultado);
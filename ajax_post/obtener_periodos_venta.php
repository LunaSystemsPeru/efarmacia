<?php
session_start();
require '../class/cl_venta.php';

$c_venta = new cl_venta();
$c_venta->setIdEmpresa($_SESSION['id_empresa']);

$rsultado = $c_venta->ver_periodos(filter_input(INPUT_POST, 'anio'));

echo json_encode($rsultado);
<?php
session_start();

require '../class/cl_caja_diaria.php';
$c_caja = new cl_caja_diaria();
$c_caja->setIdEmpresa($_SESSION['id_empresa']);
$c_caja->setIdSucursal($_SESSION['id_sucursal']);
$c_caja->setFecha(date("Y-m-d"));
$c_caja->setMApertura(filter_input(INPUT_POST, 'input_apertura'));

if ($c_caja->insertar()) {
    header("Location: ../ver_caja_diaria.php");
}
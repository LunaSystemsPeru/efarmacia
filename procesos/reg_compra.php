<?php
session_start();

require '../class/cl_compra.php';
require '../class/cl_varios.php';

$c_compra = new cl_compra();
$c_varios = new cl_varios();

$id_empresa = $_SESSION['id_empresa'];

$c_compra->setIdEmpresa($id_empresa);
$c_compra->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$c_compra->setPeriodo($c_varios->fecha_periodo($c_compra->getFecha()));
$c_compra->setIdUsuario($_SESSION['id_usuario']);
$c_compra->setIdDocumento(filter_input(INPUT_POST, 'select_documento'));
$c_compra->setSerie(filter_input(INPUT_POST, 'input_serie'));
$c_compra->setNumero(filter_input(INPUT_POST, 'input_numero'));
$c_compra->setTotal(filter_input(INPUT_POST, 'input_total'));
$c_compra->setIdProveedor(filter_input(INPUT_POST, 'hidden_id_proveedor'));
$c_compra->obtener_codigo();

if ($c_compra->insertar()) {
    header("Location: ../ver_compras.php");
}
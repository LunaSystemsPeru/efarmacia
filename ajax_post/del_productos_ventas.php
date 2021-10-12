<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../class_session/cs_productos_venta.php';
$cs_productos = new cs_productos_venta();

$cs_productos->setIdProducto(filter_input(INPUT_GET, 'input_id_producto'));
$cs_productos->eliminar();

//enviar para incluir archivo php
include 'detalle_venta_productos.php';

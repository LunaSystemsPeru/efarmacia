<?php
session_start();
require '../class_session/cs_productos_ingreso.php';
$cs_productos = new cs_productos_ingreso();

$cs_productos->setIdProducto(filter_input(INPUT_GET, 'input_id_producto'));
$cs_productos->eliminar();

//enviar para incluir archivo php
include 'detalle_ingreso_productos.php';

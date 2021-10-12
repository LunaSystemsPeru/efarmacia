<?php
session_start();
require '../class_session/cs_productos_ajuste.php';
$cs_productos = new cs_productos_ajuste();

$cs_productos->setIdProducto(filter_input(INPUT_GET, 'input_id_producto'));
$cs_productos->eliminar();

//enviar para incluir archivo php
include 'detalle_ajuste_productos.php';

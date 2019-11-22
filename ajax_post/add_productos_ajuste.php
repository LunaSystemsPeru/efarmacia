<?php
session_start();
require '../class_session/cs_productos_ajuste.php';
$cs_productos = new cs_productos_ajuste();

$cs_productos->setIdProducto(filter_input(INPUT_GET, 'input_id_producto'));
$cs_productos->setDescripcion(filter_input(INPUT_GET, 'input_descripcion_producto'));
$cs_productos->setPrecio(filter_input(INPUT_GET, 'input_precio_producto'));
$cs_productos->setCosto(filter_input(INPUT_GET, 'input_costo_producto'));
$cs_productos->setCantidad(filter_input(INPUT_GET, 'input_cnueva_producto'));
$cs_productos->setCactual(filter_input(INPUT_GET, 'input_cactual_producto'));
$cs_productos->setLote(filter_input(INPUT_GET, 'input_lote_producto'));
$cs_productos->setVcto(filter_input(INPUT_GET, 'input_vcto_producto'));

$cs_productos->agregar();

//enviar para incluir archivo php
include 'detalle_ajuste_productos.php';

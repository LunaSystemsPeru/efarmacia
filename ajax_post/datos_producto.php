<?php
session_start();
require '../class/cl_producto.php';
$c_producto=new cl_producto();
$c_producto->setIdProducto(filter_input(INPUT_GET, 'idproduc'));
$c_producto->setIdEmpresa($_SESSION["id_empresa"]);
$a_json = array();
$a_json["estado"]=false;
if ($c_producto->obtener_datos()){
    $a_json["estado"]=true;
    $a_json["cantidad"]=$c_producto->getCantidad();
    $a_json["precio"]=$c_producto->getPrecio();
    $a_json["costo"]=$c_producto->getCosto();
    $a_json["fecha"]=$c_producto->getFechaVcto();
    $a_json["lote"]=$c_producto->getLote();
}
echo json_encode($a_json);







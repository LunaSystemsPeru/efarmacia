<?php
require '../class_graficas/cl_productos.php';
$c_producto = new cl_productos();

$tipo = filter_input(INPUT_GET, 'tipo');
if ($tipo==1) {
    echo $c_producto->verMontoLaboratorio();
}
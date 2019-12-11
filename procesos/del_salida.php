<?php
session_start();

require '../class/cl_salida.php';
require '../class/cl_salida_producto.php';

$c_salida =new cl_salida();
$c_salida_producto =new cl_salida_producto();



$id_salida = filter_input(INPUT_GET, 'id_salida');
$id_empresa = $_SESSION["id_empresa"];
$c_salida_producto->setIdSalida($id_salida);
$c_salida_producto->setIdEmpresa($id_empresa);

if ($c_salida_producto->eliminar()){
    $c_salida->setIdSalida($id_salida);
    $c_salida->setIdEmpresa($id_empresa);
    if ($c_salida->eliminar()){
        header("Location: ../ver_salidas.php");
    }
}

echo  $id_empresa . '<>' . $id_salida;

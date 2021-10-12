<?php
require '../class/cl_presentacion.php';

$c_presentacion  = new cl_presentacion();

$c_presentacion->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$c_presentacion->setAbreviatura(filter_input(INPUT_POST, 'input_abreviado'));
$c_presentacion->obtener_codigo();

if ($c_presentacion->insertar()) {
    header("Location: ../ver_presentaciones.php");
}
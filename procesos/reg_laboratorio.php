<?php
require '../class/cl_laboratorio.php';
$c_laboratorio = new cl_laboratorio();

$c_laboratorio->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$c_laboratorio->obtener_codigo();

if ($c_laboratorio->insertar()) {
    header("Location: ../ver_laboratorios.php");
}
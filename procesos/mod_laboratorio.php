<?php
require '../class/cl_laboratorio.php';
$c_laboratorio = new cl_laboratorio();

$c_laboratorio->setIdLaboratorio(filter_input(INPUT_POST, 'input_codigo'));
$c_laboratorio->setNombre(filter_input(INPUT_POST, 'input_nombre'));

if ($c_laboratorio->modificar()) {
    header("Location: ../ver_laboratorios.php");
}
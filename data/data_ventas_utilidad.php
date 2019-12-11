<?php
require '../class_graficas/cl_inicio.php';

$c_inicio = new cl_inicio();

$tipo = filter_input(INPUT_GET, 'tipo');
if ($tipo==1) {
    echo $c_inicio->utilidadMensual();
}

if ($tipo==2) {
    echo $c_inicio->utilidadDiaria();
}
<?php
require '../class/cl_movimiento_banco_tipo.php';

$c_tipo = new cl_movimiento_banco_tipo();

$c_tipo->setNombre(filter_input(INPUT_POST, 'input_nombre'));

$c_tipo->obtener_codigo();

if ($c_tipo->insertar()) {
    header("Location: ../ver_tipo_gastos.php");
}
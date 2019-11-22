<?php
require '../class_varios/cl_validar_documento.php';
$cl_validar = new cl_validar_documento();

$ruc = filter_input(INPUT_POST, 'ruc');

$cl_validar->setRuc($ruc);

echo $cl_validar->obtener_ruc();
<?php

require '../class/cl_documentos_sunat.php';

$cl_documentos = new cl_documentos_sunat();

$cl_documentos->setNombre(filter_input(INPUT_POST, 'input_documento'));
$cl_documentos->setAbreviatura(filter_input(INPUT_POST, 'input_abreviado'));
$cl_documentos->setCodSunat(filter_input(INPUT_POST, 'input_sunat'));
$cl_documentos->obtener_codigo();

if ($cl_documentos->insertar()) {
    header("Location: ../ver_documentos_sunat.php");
}
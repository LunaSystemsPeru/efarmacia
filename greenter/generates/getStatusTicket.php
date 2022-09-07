<?php
ini_set('display_errors', '1');
date_default_timezone_set('America/Lima');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
require '../../class/cl_empresa.php';
require '../src/Config.php';

$c_empresa = new cl_empresa();
$c_empresa->setIdEmpresa(3);
$c_empresa->obtener_datos();

$Config = new Config();
$Config->setRuc($c_empresa->getRuc());
$Config->setUsersol($c_empresa->getUserSol());
$Config->setClavesol($c_empresa->getClaveSol());


$see = $Config->getSee();
$ticket = filter_input(INPUT_GET,'ticket');
$res = $see->getStatus($ticket);
if (!$res->isSuccess()) {
    echo "<br> error al obtener estado de ticket ";
    print_r($res->getError());
    return;
}

$cdr = $res->getCdrResponse();
print $cdr->getDescription();
print $cdr->getNotes();
//$util->writeCdr($sum, $res->getCdrZip());
// Guardamos el CDR

//$util->showResponse($sum, $cdr);
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Lima');

use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../../models/Empresa.php';
require __DIR__ . '/../../models/VentaAnulada.php';

$util = Util::getInstance();

$id_empresa = filter_input(INPUT_POST, 'id_empresa');
$fecha = filter_input(INPUT_POST, 'fecha');

$cl_anulados = new VentaAnulada();
$cl_anulados->setFecha($fecha);
$a_anulados = $cl_anulados->verFacturasAnuladas($id_empresa);

$contar_items = 0;

$array_items = array();
foreach ($a_anulados as $value) {
    $detail = new VoidedDetail();
    $detail->setTipoDoc('01')
        ->setSerie($value['serie'])
        ->setCorrelativo($value['numero'])
        ->setDesMotivoBaja("ERROR AL BUSCAR PRODUCTOS");
    $array_items[] = $detail;
    $contar_items++;
}

$c_empresa = new Empresa();
$c_empresa->setIdEmpresa($id_empresa);
$c_empresa->obtenerDatos();

$util->setRuc($c_empresa->getRuc());
$util->setClave($c_empresa->getClaveSol());
$util->setUsuario($c_empresa->getUserSol());


if ($contar_items > 0) {

    $empresa = new Company();
    $empresa->setRuc($c_empresa->getRuc())
        ->setNombreComercial($c_empresa->getRazonSocial())
        ->setRazonSocial($c_empresa->getRazonSocial())
        ->setAddress((new Address())
            ->setUbigueo($c_empresa->getUbigeo())
            ->setDistrito($c_empresa->getDistrito())
            ->setProvincia($c_empresa->getProvincia())
            ->setDepartamento($c_empresa->getDepartamento())
            ->setUrbanizacion('-')
            ->setCodLocal('0000')
            ->setDireccion($c_empresa->getDireccion()));

    $voided = new Voided();
    $voided->setCorrelativo($c_empresa->getIdEmpresa() . "1")
        ->setFecComunicacion(\DateTime::createFromFormat('Y-m-d', $fecha))
        ->setFecGeneracion(\DateTime::createFromFormat('Y-m-d', $fecha))
        ->setCompany($empresa)
        ->setDetails($array_items);


    // Envio a SUNAT.
    $see = $util->getSee(SunatEndpoints::FE_BETA);

    $res = $see->send($voided);
    $util->writeXml($voided, $see->getFactory()->getLastXml());

    $respuesta = "";

    if ($res->isSuccess()) {
        $ticket = $res->getTicket();
        echo 'Ticket :<strong>' . $ticket . '</strong>';

        $result = $see->getStatus($ticket);
        if ($result->isSuccess()) {
            $cdr = $result->getCdrResponse();
            $util->writeCdr($voided, $result->getCdrZip());

            $respuesta = $util->showResponse($voided, $cdr);
        } else {
            $respuesta = $util->getErrorResponse($result->getError());
        }
    } else {
        $respuesta = $util->getErrorResponse($res->getError());
    }
} else {
    $respuesta = "no hay registros";
}

print $respuesta;

/*
$to = "info@lunasystemsperu.com";
$subject = "Estado del Envio de Comunicacion de Bajas " . $c_empresa->getRuc() . " del dia: " . $fecha;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$message = $respuesta;

mail($to, $subject, $message, $headers);
*/
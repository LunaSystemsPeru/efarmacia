<?php
declare(strict_types=1);
ini_set('display_errors', '1');
date_default_timezone_set('America/Lima');
error_reporting(E_ALL);

use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\VoidedDetail;

require __DIR__ . '/../vendor/autoload.php';

$fecha = filter_input(INPUT_GET, 'fecha');

$c_empresa = new cl_empresa();
$c_empresa->setIdEmpresa(filter_input(INPUT_GET, 'empresa_id'));
$c_empresa->obtener_datos();

$Config = new Config();
$Config->setRuc($c_empresa->getRuc());
$Config->setUsersol($c_empresa->getUserSol());
$Config->setClavesol($c_empresa->getClaveSol());

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
        ->setCodLocal($c_empresa->getCodEstablecimiento())
        ->setDireccion($c_empresa->getDireccion()));

$item1 = new VoidedDetail();
$item1->setTipoDoc('20')
    ->setSerie('R001')
    ->setCorrelativo('122')
    ->setDesMotivoBaja('ERROR DE SISTEMA');

$items[] = $item1;

$reversion = new Reversion();
$reversion->setCorrelativo('00001')
    ->setFecGeneracion(\DateTime::createFromFormat('Y-m-d', $fecha))
    ->setFecComunicacion(\DateTime::createFromFormat('Y-m-d', date('Y-m-d')))
    ->setCompany($empresa)
    ->setDetails([$items]);

// Envio a SUNAT.
$see = $Config->getSee();

$res = $see->send($reversion);
file_put_contents("../files/" . $reversion->getName() . '.xml',
    $see->getFactory()->getLastXml());

if (!$res->isSuccess()) {
    $observaciones = 'Codigo Error: ' . $res->getError()->getCode() . " - " . $res->getError()->getMessage() ;
    echo $observaciones;
    return;
}

/**@var $res SummaryResult */
$ticket = $res->getTicket();
echo 'Ticket :<strong>' . $ticket . '</strong>';

$res = $see->getStatus($ticket);
if (!$res->isSuccess()) {
    $observaciones = 'Codigo Error: ' . $res->getError()->getCode() . " - " . $res->getError()->getMessage() ;
    echo $observaciones;
    return;
}

$cdr = $res->getCdrResponse();
file_put_contents("../files/" . 'R-' . $reversion->getName() . '.zip', $res->getCdrZip());

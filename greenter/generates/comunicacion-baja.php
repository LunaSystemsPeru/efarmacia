<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';
require '../src/Config.php';

//cargar clases del sistema
require __DIR__ . '/../../class/cl_empresa.php';
require __DIR__ . '/../../class/cl_venta.php';
require __DIR__ . '/../../class/cl_ventas_anuladas.php';
require __DIR__ . '/../../class/cl_resumen_diario.php';
require __DIR__ . '/../../class/cl_ventas_referencias.php';


echo "<pre>";


$id_empresa = filter_input(INPUT_GET, 'id_empresa');
$fecha = filter_input(INPUT_GET, 'fecha');

$c_empresa = new cl_empresa();
$c_empresa->setIdEmpresa($id_empresa);
$c_empresa->obtener_datos();

$Config = new Config();
$Config->setRuc($c_empresa->getRuc());
$Config->setUsersol($c_empresa->getUserSol());
$Config->setClavesol($c_empresa->getClavesol());

$see = $Config->getSee();

$c_anulada = new cl_ventas_anuladas();
$c_anulada->setIdEmpresa($id_empresa);
$c_anulada->setFecha($fecha);

$lista_anulados = $c_anulada->verFacturasAnuladas();

$contar_items = 0;

$array_items = array();
foreach ($lista_anulados as $value) {
    $detail = new VoidedDetail();
    $detail->setTipoDoc('01')
        ->setSerie($value['serie'])
        ->setCorrelativo($value['numero'])
        ->setDesMotivoBaja("ERROR AL BUSCAR PRODUCTOS");
    $array_items[] = $detail;
    $contar_items++;
}

$empresa = new Company();
$empresa->setRuc($c_empresa->getRuc())
    ->setNombreComercial(addslashes($c_empresa->getNombreComercial()))
    ->setRazonSocial(addslashes($c_empresa->getRazonSocial()))
    ->setAddress((new Address())
        ->setUbigueo($c_empresa->getUbigeo())
        ->setDistrito($c_empresa->getDistrito())
        ->setProvincia($c_empresa->getProvincia())
        ->setDepartamento($c_empresa->getDepartamento())
        ->setUrbanizacion('-')
        ->setCodLocal('0000')
        ->setDireccion(addslashes($c_empresa->getDireccion())));

echo "<br>";
echo "nro de items = " . count($array_items) . "<br>";
$c_resumen = new cl_resumen_diario();

$c_resumen->obtenerId();
$c_resumen->setIdEmpresa($c_empresa->getIdEmpresa());
$c_resumen->setFecha($fecha);
$c_resumen->setCantidadItems($contar_items);

$voided = new Voided();
$voided->setCorrelativo($c_resumen->obtenerNroResumen())
    // Fecha Generacion menor que Fecha comunicacion
    ->setFecGeneracion(\DateTime::createFromFormat('Y-m-d', $fecha))
    ->setFecComunicacion(\DateTime::createFromFormat('Y-m-d', date('Y-m-d')))
    ->setCompany($empresa)
    ->setDetails($array_items);

// Envio a SUNAT.
$res = $see->send($voided);

echo $voided->getName() . "<br>";

// Guardar XML firmado digitalmente.
file_put_contents("../RC/" . $voided->getName() . '.xml',
    $see->getFactory()->getLastXml());


if (!$res->isSuccess()) {
    echo "<br> error al enviar ";
    print_r($res->getError());
    return;
}

/**@var $res SummaryResult */
$ticket = $res->getTicket();
echo '<br>Ticket :<strong>' . $ticket . '</strong><br>';

$c_resumen->setTicket($ticket);
$c_resumen->setTipo(2);

$c_resumen->insertar();

$res = $see->getStatus($ticket);
if (!$res->isSuccess()) {
    echo "<br> error al obtener estado de ticket ";
    print_r($res->getError());
    return;
}

$cdr = $res->getCdrResponse();
print_r($cdr->getDescription());
//print_r($cdr->getNotes());
//$util->writeCdr($sum, $res->getCdrZip());
// Guardamos el CDR
file_put_contents("../RC/" . 'R-' . $voided->getName() . '.zip', $res->getCdrZip());
//$util->showResponse($sum, $cdr);
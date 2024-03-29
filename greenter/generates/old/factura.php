<?php
ini_set('display_errors', '1');
date_default_timezone_set('America/Lima');
error_reporting(E_ALL);


//ini_set('default_socket_timeout', 600);

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../../class/cl_venta.php';
require __DIR__ . '/../../class/cl_cliente.php';
require __DIR__ . '/../../class/cl_empresa.php';
require __DIR__ . '/../../class/cl_venta_productos.php';
require __DIR__ . '/../../class/cl_venta_sunat.php';

require __DIR__ . '/../../class_varios/NumerosaLetras.php';
require '../generate_qr/class/GenerarQr.php';




$util = Util::getInstance();

$c_venta = new cl_venta();
$c_venta->setIdVenta(filter_input(INPUT_POST, 'id_venta'));
$c_venta->setIdEmpresa(filter_input(INPUT_POST, 'id_empresa'));
$c_venta->setPeriodo(filter_input(INPUT_POST, 'periodo'));
$c_venta->obtener_datos();

$c_cliente = new cl_cliente();
$c_cliente->setIdCliente($c_venta->getIdCliente());
$c_cliente->setIdEmpresa($c_venta->getIdEmpresa());
$c_cliente->obtener_datos();

$client = new Client();
$client->setTipoDoc('6')
    ->setNumDoc($c_cliente->getDocumento())
    ->setRznSocial($c_cliente->getNombre())
    ->setAddress((new Address())
        ->setDireccion($c_cliente->getDireccion()));

$c_empresa = new cl_empresa();
$c_empresa->setIdEmpresa($c_venta->getIdEmpresa());
$c_empresa->obtener_datos();

$util->setRuc($c_empresa->getRuc());
$util->setClave($c_empresa->getClaveSol());
$util->setUsuario($c_empresa->getUserSol());

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

//$util->setRucEmpresa($c_empresa->getRuc());

$invoice = new Invoice();

$subtotal = number_format($c_venta->getTotal() / 1.18, 2, ".", "");
$igv = number_format($c_venta->getTotal() / 1.18 * 0.18, 2, ".", "");
$total = number_format($c_venta->getTotal(), 2, ".", "");
$invoice
    ->setUblVersion('2.1')
    ->setFecVencimiento(new \DateTime())
    ->setTipoOperacion('0101')
    ->setTipoDoc('01')
    ->setSerie($c_venta->getSerie())
    ->setCorrelativo($c_venta->getNumero())
    ->setFechaEmision(\DateTime::createFromFormat('Y-m-d', $c_venta->getFecha()))
    ->setFecVencimiento(\DateTime::createFromFormat('Y-m-d', $c_venta->getFecha()))
    ->setFormaPago(new FormaPagoContado())
    ->setTipoMoneda('PEN')
    ->setClient($client)
    ->setMtoOperGravadas(number_format($c_venta->getTotal() / 1.18, 2, ".", ""))
    ->setMtoIGV(number_format($c_venta->getTotal() / 1.18 * 0.18, 2, ".", ""))
    ->setTotalImpuestos(number_format($c_venta->getTotal() / 1.18 * 0.18, 2, ".", ""))
    ->setValorVenta(number_format($c_venta->getTotal() / 1.18, 2, ".", ""))
    ->setMtoImpVenta(number_format($c_venta->getTotal(), 2, ".", ""))
    ->setSubTotal(number_format($c_venta->getTotal(), 2, ".", ""))
    ->setCompany($empresa);

$c_productos = new cl_venta_productos();
$c_productos->setIdVenta($c_venta->getIdVenta());
$c_productos->setPeriodo($c_venta->getPeriodo());
$c_productos->setIdEmpresa($c_venta->getIdEmpresa());

$items = $c_productos->ver_productos();

$array_items = array();

foreach ($items as $value) {
    $item = new SaleDetail();
    $item->setCodProducto($value['id_producto'])
        ->setUnidad('NIU')
        ->setDescripcion($value['nombre'] . "-" . $value["laboratorio"] . "-" . $value["presentacion"])
        ->setCantidad($value['cantidad'])
        ->setMtoValorUnitario(number_format($value['precio'] / 1.18, 2, '.', ''))
        ->setMtoValorVenta(number_format($value['precio'] * $value['cantidad'] / 1.18, 2, '.', ''))
        ->setMtoBaseIgv(number_format($value['precio'] * $value['cantidad'] / 1.18, 2, '.', ''))
        ->setPorcentajeIgv(18)
        ->setIgv(number_format($value['precio'] * $value['cantidad'] / 1.18 * 0.18, 2, '.', ''))
        ->setTipAfeIgv('10')
        ->setTotalImpuestos(number_format($value['precio'] * $value['cantidad'] / 1.18 * 0.18, 2, '.', ''))
        ->setMtoPrecioUnitario(number_format($value['precio'], 2, '.', ''));
    $array_items[] = $item;
}

$invoice->setDetails($array_items);

$c_numeros = new NumerosaLetras();
$numeros = htmlentities($c_numeros->to_word(number_format($c_venta->getTotal(), 2, ".", ""), "PEN"));
$invoice->setLegends([
    (new Legend())
        ->setCode('1000')
        ->setValue($numeros)
]);


/** Si solo desea enviar un XML ya generado utilice esta función* */
//$res = $see->sendXml(get_class($invoice), $invoice->getName(), file_get_contents($ruta_XML));

$nombre_archivo = $invoice->getName();
$hash = $util->getHash($invoice);
$url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$rutabase= dirname(dirname($url)) . DIRECTORY_SEPARATOR;

$nombre_xml = $rutabase . "/../files/" . $invoice->getName() . ".xml";

//generar qr
$qr = $c_empresa->getRuc() . "|" . "01" . "|" . $c_venta->getSerie() . "-" . $c_venta->getNumero() . "|" . $igv . "|" . $total . "|" . $c_venta->getFecha() . "|" . "06" . "|" . $c_cliente->getDocumento();
$c_generar = new generarQr();
$c_generar->setTexto_qr($qr);
$c_generar->setNombre_archivo($nombre_archivo);
$c_generar->generar_qr();

//obtener url de qr
$url_qr =  $rutabase . "/generate_qr/temp/" . $nombre_archivo . ".png";

// Envio a SUNAT.
$see = $util->getSee(SunatEndpoints::FE_PRODUCCION);
//$res = $see->send($invoice);
$see->getXmlSigned($invoice);
$util->writeXml($invoice, $see->getFactory()->getLastXml());

$c_hash = new cl_venta_sunat();
$c_hash->setIdVenta($c_venta->getIdVenta());
$c_hash->setPeriodo($c_venta->getPeriodo());
$c_hash->setIdEmpresa($c_venta->getIdEmpresa());
$c_hash->setHash($hash);
$c_hash->setNombreXml($invoice->getName());
$c_hash->insertar();

$descripcion = "";

$respuesta = array();
/*
if ($res->isSuccess()) {

    //obtener cdr y guardar en json
    $cdr = $res->getCdrResponse();
    $util->writeCdr($invoice, $res->getCdrZip());
    $descripcion = $cdr->getDescription();
    $c_venta->actualizar_envio();

    //$util->getResponseFromCdr($cdr);
} else {
//    var_dump($res->getError());
    $descripcion = $res->getError();
}
*/

$respuesta = array(
    "success" => true,
    "resultado" => array(
        "nombre_archivo" => $nombre_archivo,
        "direccion_xml" => $nombre_xml,
        "direccion_qr" => $url_qr,
        "hash" => $hash,
        "descripcion_cdr" => $descripcion
    )
);

echo json_encode($respuesta);


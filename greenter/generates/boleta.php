<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Lima');

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
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
require __DIR__ . '/../../greenter/generate_qr/class/GenerarQr.php';

$util = Util::getInstance();

$c_venta = new cl_venta();

$c_venta->setIdVenta(filter_input(INPUT_POST, 'id_venta'));
$c_venta->setIdEmpresa(filter_input(INPUT_POST, 'id_empresa'));
$c_venta->setPeriodo(filter_input(INPUT_POST, 'periodo'));
$c_venta->obtener_datos();

//matar proceso si no hay datos
if ($c_venta->getIdCliente() == null || $c_venta->getIdCliente() == "") {
    die("error no hay datos");
}

$c_cliente = new cl_cliente();
$c_cliente->setIdCliente($c_venta->getIdCliente());
$c_cliente->obtener_datos();
$tipo_doc ="";

if (strlen($c_cliente->getDocumento()) == 8) {
    $tipo_doc = "01";
} else {
    $tipo_doc = "00";
    $c_cliente->setDocumento('00000000');
}
$client = new Client();
$client->setTipoDoc($tipo_doc)
    ->setNumDoc($c_cliente->getDocumento())
    ->setRznSocial(utf8_decode($c_cliente->getNombre()));

$c_empresa = new cl_empresa();
$c_empresa->setIdEmpresa($c_venta->getIdEmpresa());
$c_empresa->obtener_datos();

$util->setRuc($c_empresa->getRuc());
$util->setClave($c_empresa->getClaveSol());
$util->setUsuario($c_empresa->getUserSol());

$empresa = new Company();
$empresa->setRuc($c_empresa->getRuc())
    ->setNombreComercial(utf8_decode($c_empresa->getRazonSocial()))
    ->setRazonSocial(utf8_decode($c_empresa->getRazonSocial()))
    ->setAddress((new Address())
        ->setUbigueo($c_empresa->getUbigeo())
        ->setDistrito($c_empresa->getDistrito())
        ->setProvincia($c_empresa->getProvincia())
        ->setDepartamento($c_empresa->getDepartamento())
        ->setUrbanizacion('-')
        ->setCodLocal('0000')
        ->setDireccion($c_empresa->getDireccion()));

$subtotal = number_format($c_venta->getTotal() / 1.18, 2, ".", "");
$igv = number_format($c_venta->getTotal() / 1.18 * 0.18, 2, ".", "");
$total = number_format($c_venta->getTotal(), 2, ".", "");

// Venta
$invoice = new Invoice();
$invoice
    ->setUblVersion('2.1')
    ->setTipoOperacion('0101')
    ->setTipoDoc('03')
    ->setSerie($c_venta->getSerie())
    ->setCorrelativo($c_venta->getNumero())
    ->setFechaEmision(\DateTime::createFromFormat('Y-m-d', $c_venta->getFecha()))
    ->setTipoMoneda('PEN')
    ->setClient($client)
    ->setMtoOperGravadas(number_format($c_venta->getTotal() / 1.18, 2, ".", ""))
    ->setMtoIGV(number_format($c_venta->getTotal() / 1.18 * 0.18, 2, ".", ""))
    ->setTotalImpuestos(number_format($c_venta->getTotal() / 1.18 * 0.18, 2, ".", ""))
    ->setValorVenta(number_format($c_venta->getTotal() / 1.18, 2, ".", ""))
    ->setMtoImpVenta(number_format($c_venta->getTotal(), 2, ".", ""))
    ->setCompany($empresa);

$c_productos = new cl_venta_productos();
$c_productos->setIdVenta($c_venta->getIdVenta());
$c_productos->setPeriodo($c_venta->getPeriodo());
$c_productos->setIdEmpresa($c_venta->getIdEmpresa());

$items = $c_productos->ver_productos();

$array_items = array();

foreach ($items as $value) {
    $subtotal_producto = $value['precio'] * $value['cantidad'] / 1.18;
    $igv_producto = $value['precio'] * $value['cantidad'] / 1.18 * 0.18;
    $total_producto = $value['precio'] * $value['cantidad'];
    $item = new SaleDetail();
    $item->setCodProducto($value['id_producto'])
        ->setUnidad('NIU')
        ->setDescripcion($value['nombre'] . "-" . $value["laboratorio"] . "-" . $value["presentacion"])
        ->setCantidad($value['cantidad'])
        ->setMtoValorUnitario(number_format($value['precio'] / 1.18, 2, '.', ''))
        ->setMtoValorVenta(number_format($subtotal_producto, 2, '.', ''))
        ->setMtoBaseIgv(number_format($subtotal_producto, 2, '.', ''))
        ->setPorcentajeIgv(18)
        ->setIgv(number_format($igv_producto, 2, '.', ''))
        ->setTipAfeIgv('10')
        ->setTotalImpuestos(number_format($igv_producto, 2, '.', ''))
        ->setMtoPrecioUnitario(number_format($value['precio'], 2, '.', ''));
    $array_items[] = $item;
}

$invoice->setDetails($array_items);

$c_numeros = new NumerosaLetras();
$numeros = utf8_decode($c_numeros->to_word(number_format($c_venta->getTotal(), 2, ".", ""), "PEN"));
$invoice->setLegends([
    (new Legend())
        ->setCode('1000')
        ->setValue($numeros)
]);


//fijar variables principales
$nombre_archivo = $invoice->getName();
$dominio = "http://" . $_SERVER["HTTP_HOST"] . "/clientes/farmacia/";
$nombre_xml = $dominio . "/greenter/files/" . $invoice->getName() . ".xml";
$hash = $util->getHash($invoice);

//generar qr
$qr = $c_empresa->getRuc() . "|" . "03" . "|" . $c_venta->getSerie() . "-" . $c_venta->getNumero() . "|" . $igv . "|" . $total . "|" . $c_venta->getFecha() . "|" . $tipo_doc . "|" . $c_cliente->getDocumento();
$c_generar = new generarQr();
$c_generar->setTexto_qr($qr);
$c_generar->setNombre_archivo($nombre_archivo);
$c_generar->generar_qr();

//obtener url de qr
$url_qr = $dominio . "/greenter/generate_qr/temp/" . $nombre_archivo . ".png";

// Envio a SUNAT.
$see = $util->getSee(SunatEndpoints::FE_BETA);
//$res = $see->send($invoice); //aun no se envia la boleta
$see->getXmlSigned($invoice);
$util->writeXml($invoice, $see->getFactory()->getLastXml());


$c_hash = new cl_venta_sunat();
$c_hash->setIdVenta($c_venta->getIdVenta());
$c_hash->setPeriodo($c_venta->getPeriodo());
$c_hash->setIdEmpresa($c_venta->getIdEmpresa());
$c_hash->setHash($hash);
$c_hash->setNombreXml($invoice->getName());
$c_hash->insertar();

$respuesta = array();

/*
// * no es necesario enviar boletas, eso se hara en el resumen diario
if ($res->isSuccess()) {
    //obtener cdr y guardar en json
    $cdr = $res->getCdrResponse();
    $util->writeCdr($invoice, $res->getCdrZip());
    $descripcion = $cdr->getDescription();

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

    $util->getResponseFromCdr($cdr);
} else {
    //var_dump($res->getError());
    $respuesta = array(
        "success" => false,
        "resultado" => "ERROR AL PROCESAR"
    );
}
*/

$respuesta = array(
    "success" => true,
    "resultado" => array(
        "nombre_archivo" => $nombre_archivo,
        "direccion_xml" => $nombre_xml,
        "direccion_qr" => $url_qr,
        "hash" => $hash,
        "descripcion_cdr" => ""
    )
);
echo json_encode($respuesta);

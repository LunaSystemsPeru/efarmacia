<?php

use Greenter\Model\Client\Client;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Sale\Document;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../../class/cl_venta.php';
require __DIR__ . '/../../class/cl_guia_remision.php';
require __DIR__ . '/../../class/cl_cliente.php';
require __DIR__ . '/../../class/cl_almacen.php';
require __DIR__ . '/../../class/cl_empresa.php';
require __DIR__ . '/../../class/cl_venta_productos.php';

require __DIR__ . '/../../greenter/generate_qr/class/GenerarQr.php';

$util = Util::getInstance();

$c_venta = new cl_venta();

$c_venta->setIdVenta(filter_input(INPUT_GET, 'id_venta'));
$c_venta->setIdAlmacen(filter_input(INPUT_GET, 'id_almacen'));
$c_venta->obtener_datos();

$c_guia = new cl_guia_remision();
$c_guia->setIdVenta($c_venta->getIdVenta());
$c_guia->setIdAlmacen($c_venta->getIdAlmacen());
$c_guia->cargar_datos();

$c_cliente = new cl_cliente();
$c_cliente->setIdCliente($c_venta->getIdCliente());
$c_cliente->obtener_datos();

$client = new Client();
$client->setTipoDoc('6')
    ->setNumDoc($c_cliente->getDocumento())
    ->setRznSocial($c_cliente->getDatos());

$c_almacen = new cl_almacen();
$c_almacen->setIdAlmacen($c_venta->getIdAlmacen());
$c_almacen->obtener_datos();

$c_empresa = new cl_empresa();
$c_empresa->setIdEmpresa($c_almacen->getIdEmpresa());
$c_empresa->obtener_datos();

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


$c_productos = new cl_venta_productos();
$c_productos->setIdVenta($c_venta->getIdVenta());
$c_productos->setIdAlmacen($c_venta->getIdAlmacen());

$items = $c_productos->ver_detalle();

$array_items = array();
$sumar_cantidades = 0;

foreach ($items as $value) {
    $detail = new DespatchDetail();
    $detail->setCantidad($value['cantidad'])
        ->setUnidad('NIU')
        ->setDescripcion($value['descripcion'] . ' ' . $value['marca'] . ' ' . $value['modelo'])
        ->setCodigo($value['id_producto']);
        //->setCodProdSunat($value['id_producto']);

    $sumar_cantidades += $value['cantidad'];

    $array_items[] = $detail;
}

$transp = new Transportist();
$transp->setTipoDoc('6')
    ->setNumDoc($c_guia->getRucTransporte())
    ->setRznSocial($c_guia->getRazonTransporte())
    ->setPlaca($c_guia->getPlaca())
    ->setChoferTipoDoc('1')
    ->setChoferDoc($c_guia->getDniChofer());

$envio = new Shipment();
$envio->setModTraslado('01')
    ->setCodTraslado('01')
    ->setDesTraslado('VENTA')
    ->setFecTraslado(new \DateTime())
    ->setIndTransbordo(false)
    ->setPesoTotal(50)
    ->setUndPesoTotal('KGM')
    ->setNumBultos($sumar_cantidades)
    ->setLlegada(new Direction($c_guia->getUbigeo(), $c_guia->getLlegada()))
    ->setPartida(new Direction($c_almacen->getUbigeo(), $c_almacen->getDireccion()))
    ->setTransportista($transp);

$despatch = new Despatch();
$despatch->setTipoDoc('09')
    ->setSerie($c_guia->getSerie())
    ->setCorrelativo($c_guia->getNumero())
    ->setFechaEmision(new \DateTime())
    ->setCompany($empresa)
    ->setDestinatario($client)
    //->setTercero($client)
    ->setObservacion('FT: ' . $c_venta->getSerie() . "-" . $c_venta->getNumero())
    ->setEnvio($envio);

$despatch->setDetails([$detail]);

// Envio a SUNAT.
$util->setRucEmpresa($c_empresa->getRuc());
$see = $util->getSee(SunatEndpoints::GUIA_PRODUCCION);

$res = $see->send($despatch);
$util->writeXml($despatch, $see->getFactory()->getLastXml());

$nombre_archivo = $despatch->getName();
/*
if ($res->isSuccess()) {
    $cdr = $res->getCdrResponse();
    $util->writeCdr($despatch, $res->getCdrZip());

    $util->showResponse($despatch, $cdr);
} else {
    echo $util->getErrorResponse($res->getError());
}
*/

$respuesta = array();
if ($res->isSuccess()) {

    $dominio = "http://" . $_SERVER["HTTP_HOST"] . "/clientes/sonomusic/";
    $nombre_xml = $dominio . "/greenter/files/" . $despatch->getName() . ".xml";
    $hash = $util->getHash($despatch);

    $c_guia->setHash($hash);
    $c_guia->actualizar_hash();

    //obtener cdr y guardar en json
    $cdr = $res->getCdrResponse();
    $util->writeCdr($despatch, $res->getCdrZip());
    $descripcion = $cdr->getDescription();

    $respuesta = array(
        "success" => true,
        "resultado" => array(
            "nombre_archivo" => $nombre_archivo,
            "direccion_xml" => $nombre_xml,
            "direccion_qr" => "",
            "hash" => $hash,
            "descripcion_cdr" => $descripcion
        )
    );

    //$util->getResponseFromCdr($cdr);
} else {
    var_dump($res->getError());
    $respuesta = array(
        "success" => false,
        "resultado" => "error al procesar"
    );
}

echo json_encode($respuesta);




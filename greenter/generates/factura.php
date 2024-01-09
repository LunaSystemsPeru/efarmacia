<?php
ini_set('display_errors', '1');
date_default_timezone_set('America/Lima');
error_reporting(E_ALL);


use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;

require __DIR__ . '/../vendor/autoload.php';
require '../src/Config.php';

require __DIR__ . '/../../class/cl_venta.php';
require __DIR__ . '/../../class/cl_cliente.php';
require __DIR__ . '/../../class/cl_empresa.php';
require __DIR__ . '/../../class/cl_venta_productos.php';
require __DIR__ . '/../../class/cl_venta_sunat.php';
require __DIR__ . '/../../class/cl_sucursal.php';

require __DIR__ . '/../../class_varios/NumerosaLetras.php';
require '../generate_qr/class/GenerarQr.php';

$NumeroLetras = new NumerosaLetras();

$c_venta = new cl_venta();
$c_venta->setIdVenta(filter_input(INPUT_POST, 'id_venta'));
$c_venta->setIdEmpresa(filter_input(INPUT_POST, 'id_empresa'));
$c_venta->setPeriodo(filter_input(INPUT_POST, 'periodo'));
$c_venta->obtener_datos();

$c_sucursal = new cl_sucursal();
$c_sucursal->setIdSucursal($c_venta->getIdSucursal());
$c_sucursal->setIdEmpresa($c_venta->getIdEmpresa());
$c_sucursal->obtener_datos();

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

$Config = new Config();
$Config->setRuc($c_empresa->getRuc());
$Config->setUsersol($c_empresa->getUserSol());
$Config->setClavesol($c_empresa->getClaveSol());

$see = $Config->getSee();


$empresa = new Company();
$empresa->setRuc($c_empresa->getRuc())
    ->setNombreComercial($c_empresa->getRazonSocial())
    ->setRazonSocial($c_empresa->getRazonSocial())
    ->setAddress((new Address())
        ->setUbigueo($c_sucursal->getUbigeo())
        ->setDistrito($c_sucursal->getDistrito())
        ->setProvincia($c_sucursal->getProvincia())
        ->setDepartamento($c_sucursal->getDepartamento())
        ->setUrbanizacion('-')
        ->setCodLocal($c_sucursal->getCodsunat())
        ->setDireccion($c_sucursal->getDireccion()));

//lista de productos

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

$c_numeros = new NumerosaLetras();
$numeros = htmlentities($c_numeros->to_word(number_format($c_venta->getTotal(), 2, ".", ""), "PEN"));

$legend = (new Legend())
    ->setCode('1000') // Monto en letras - Catalog. 52
    ->setValue($numeros);

$invoice->setDetails($array_items)
    ->setLegends([$legend]);

$nombre_archivo = $invoice->getName();
$tipoDoc = 6;
//generar qr
$qr = $c_empresa->getRuc() . "|" . "01" . "|" . $c_venta->getSerie() . "-" . $c_venta->getNumero() . "|" . $igv . "|" . $total . "|" . $c_venta->getFecha() . "|" . "06" . "|" . $c_cliente->getDocumento();
$generarQR = new generarQr();
$generarQR->setTexto_qr($qr);
$generarQR->setNombre_archivo($nombre_archivo);
$generarQR->generar_qr();

$result = $see->send($invoice);

// Guardar XML firmado digitalmente.
file_put_contents("../files/" . $invoice->getName() . '.xml',
    $see->getFactory()->getLastXml());

$aceptadosunat = true;
$indiceaceptado = 1;
$observaciones = "";
$code = "";

// Verificamos que la conexión con SUNAT fue exitosa.
if (!$result->isSuccess()) {
    $indiceaceptado = 3;
    // Mostrar error al conectarse a SUNAT.
    $observaciones = 'Codigo Error: ' . $result->getError()->getCode() . " - " . $result->getError()->getMessage() ;
    $aceptadosunat = false;
    //echo 'Codigo Error: '.$result->getError()->getCode();
    //echo 'Mensaje Error: '.$result->getError()->getMessage();
    //exit();
}

if ($aceptadosunat) {
// Guardamos el CDR
    file_put_contents("../files/" . 'R-' . $invoice->getName() . '.zip', $result->getCdrZip());

    $cdr = $result->getCdrResponse();

    $code = (int)$cdr->getCode();

    if ($code === 0) {
        // echo 'ESTADO: ACEPTADA'.PHP_EOL;
        if (count($cdr->getNotes()) > 0) {
            // echo 'OBSERVACIONES:'.PHP_EOL;
            // Corregir estas observaciones en siguientes emisiones.
            // var_dump($cdr->getNotes());
            $observaciones = $cdr->getNotes();
            $indiceaceptado = 2;
        }
    } else if ($code >= 2000 && $code <= 3999) {
        // echo 'ESTADO: RECHAZADA'.PHP_EOL;
        $aceptadosunat = false;
        $indiceaceptado = 4;
    } else {
        /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
        /*code: 0100 a 1999 */
        $aceptadosunat = false;
        $indiceaceptado = 4;
        // echo 'Excepción';
    }

//echo $cdr->getDescription().PHP_EOL;
    $c_hash = new cl_venta_sunat();
    $c_hash->setIdVenta($c_venta->getIdVenta());
    $c_hash->setPeriodo($c_venta->getPeriodo());
    $c_hash->setIdEmpresa($c_venta->getIdEmpresa());
    $c_hash->setHash($Config->getHash($invoice));
    $c_hash->setNombreXml($invoice->getName());
    $c_hash->insertar();

}

$respuesta = array(
    "success" => $aceptadosunat,
    "resultado" => array(
        "nombre_archivo" => $nombre_archivo,
        "hash" => $Config->getHash($invoice),
        "observaciones" => $observaciones
    )
);

echo json_encode($respuesta);
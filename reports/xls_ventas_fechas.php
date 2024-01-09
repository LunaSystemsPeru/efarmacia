<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../includes/SimpleXLSXGen.php';
require '../class/cl_venta.php';
require '../class/cl_sucursal.php';

use Shuchkin\SimpleXLSXGen;

$Venta = new cl_venta();
$Sucursal = new cl_sucursal();

$periodo = filter_input(INPUT_GET, 'periodo');
$tienda = filter_input(INPUT_GET, 'tienda');
$empresa = filter_input(INPUT_GET, 'empresa');

$nombre_archivo = 'reporte_venta_' . $periodo . '.xlsx';

if (file_exists($nombre_archivo)) {
    unlink($nombre_archivo);
}

$Sucursal->setIdEmpresa($empresa);
$Sucursal->setIdSucursal($tienda);

$Sucursal->obtener_datos();

$Venta->setPeriodo($periodo);
$Venta->setIdSucursal($tienda);
$Venta->setIdEmpresa($empresa);

$array_ventas = $Venta->ver_ventas_total();

$books = array();

$fila1 = [
    "",
    "",
    "",
    "",
    "",
    "",
    "REPORTE DE VENTAS POR PERIODO",
    "",
    "",
    "",
    ""
];
$books[] = $fila1;
$books[] = ['', ''];

$titulos = ['#', 'FECHA', 'TIPO DOCUMENTO', 'SERIE COMPROBANTE', 'NUMERO COMPROBANTE', 'DOCUMENTO CLIENTE', 'DATOS CLIENTE', 'SUB TOTAL', 'IGV', 'TOTAL', 'TIENDA', 'USUARIO', 'ESTADO COMPROBANTE', 'ESTADO SUNAT', 'IDSISTEMA'];
$books[] = $titulos;

$nrofila = 0;

foreach ($array_ventas as $item) {
    $nrofila++;

    $total = $item['total'];
    $subtotal = $total / 1.18;
    $igv = $subtotal * 0.18;

    $fila = array();
    $fila[] = $nrofila;
    $fila[] = "<center>" . $item['fecha'] . "</center>";
    $fila[] = "<center>" . $item['abreviatura'] . "</center>";
    $fila[] = "<center>" . $item['serie'] . "</center>";
    $fila[] = "<center>" . $item['numero'] . "</center>";
    $fila[] = "<center>" . $item['documento'] . "</center>";
    $fila[] = htmlentities($item['nombre']);
    $fila[] = number_format($subtotal, 2);
    $fila[] = number_format($igv, 2);
    $fila[] = number_format($total, 2);
    $fila[] = "<center>" . $item['nombresede'] . "</center>";
    $fila[] = "<center>" . $item['username'] . "</center>";
    $fila[] = $item['estado'];
    $fila[] = $item['estado'];
    $fila[] = $item['id_venta'];
    $books[] = $fila;
}

try {
    $xlsx = SimpleXLSXGen::fromArray($books);
    $xlsx->saveAs($nombre_archivo);
} catch (Exception $exception) {
    print_r($exception);
}

$host = $_SERVER["HTTP_HOST"];
$url = $_SERVER["REQUEST_URI"];

echo "https://" . $host . dirname($_SERVER["REQUEST_URI"]) . '/' . $nombre_archivo. "?version=" . explode(" ",microtime())[1];
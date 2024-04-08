<?php
require '../class_graficas/cl_reporte_venta.php';
require '../includes/SimpleXLSXGen.php';
use Shuchkin\SimpleXLSXGen;

$Reporte = new cl_reporte_venta();

$Reporte->setFechainicio(filter_input(INPUT_POST, 'fechainicio'));
$Reporte->setFechafinal(filter_input(INPUT_POST, 'fechafinal'));
$Reporte->setIdempresa(filter_input(INPUT_POST, 'empresaid'));

//estructura titulos tabla
$books = array();
$titulos = ['Item',
    'Fecha Venta',
    'Tienda',
    'Doc Venta',
    'Doc Cliente',
    'Nombre Cliente',
    'Producto',
    'Lote',
    'Fecha Venc.',
    'Cantidad',
    'Pr. Costo',
    'Pr. Venta',
    'Parcial Compra',
    'Parcial Venta',
    'Utilidad'];
$books[] = $titulos;

$array_lista = $Reporte->verReporteVentaProductos();
$nrofila = 0;
//var_dump($array_lista);

foreach ($array_lista as $fila) {

    $nrofila++;

    $costototal = $fila['cantidad'] * $fila['costo'];
    $preciototal = $fila['cantidad'] * $fila['precio'];
    $utilidad = $preciototal - $costototal;

    $fila = [
        $nrofila,
        $fila['fecha'],
        $fila['nsucursal'],
        $fila['abreviatura'] . " | " . $fila['serie'] . " - " . $fila['numero'],
        "\0". $fila['documento'],
        htmlentities($fila['ncliente']),
        htmlentities($fila['nproducto']),
        "\0". $fila['lote'],
        "\0". $fila['lote'],
        $fila['cantidad'],
        number_format($fila['costo'], 2),
        number_format($fila['precio'], 2),
        number_format($costototal, 2),
        number_format($preciototal, 2),
        number_format($utilidad, 2)
    ];
    $books[] = $fila;
 //   echo var_dump($fila) . "<br>";
}


$xlsx = SimpleXLSXGen::fromArray($books);
$xlsx->saveAs('reporte_ventas_detallada_' . $Reporte->getFechainicio() . "_" . $Reporte->getFechafinal() . '.xlsx');

echo json_encode(['name' => 'reporte_ventas_detallada_' . $Reporte->getFechainicio() . "_" . $Reporte->getFechafinal() . '.xlsx']);

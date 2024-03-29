<?php
require '../class_graficas/cl_reporte_venta.php';
require '../includes/SimpleXLSXGen.php';
use Shuchkin\SimpleXLSXGen;

$Reporte = new cl_reporte_venta();

$Reporte->setFechainicio(filter_input(INPUT_POST, 'fechainicio'));
$Reporte->setFechafinal(filter_input(INPUT_POST, 'fechafinal'));
$Reporte->setIdempresa(filter_input(INPUT_POST, 'empresaid'));

$filai = [
    "",
    "",
    "REPORTE DE PRODUCTOS VENDIDOS"
];
$books[] = $filai;

//estructura titulos tabla
$books = array();
$fila = ['Item',
    'Tienda',
    'Producto',
    'Lote',
    'Vcto',
    'Costo',
    'Precio',
    'Cantidad',
    'Costo Parcial',
    'Precio Parcial',
    'Utilidad'];
$books[] = $fila;

$array_lista = $Reporte->verVentasProductos();
$nrofila = 0;
//var_dump($array_lista);

foreach ($array_lista as $fila) {

    $nrofila++;

    $costototal = $fila['cantidad'] * $fila['costo'];
    $preciototal = $fila['cantidad'] * $fila['precio'];
    $utilidad = $preciototal - $costototal;
    $fila = [
        $nrofila,
        $fila['ntienda'],
        $fila['nproducto'],
        $fila['lote'],
        $fila['vcto'],
        $fila['costo'],
        $fila['precio'],
        $fila['cantidad'],
        number_format($costototal, 2),
        number_format($preciototal, 2),
        number_format($utilidad, 2),
    ];
    $books[] = $fila;
}


$xlsx = SimpleXLSXGen::fromArray($books);
$xlsx->saveAs('reporte_ventas_productos_' . $Reporte->getFechainicio() . "_" . $Reporte->getFechafinal() . '.xlsx');

echo json_encode(['name' => 'reporte_ventas_productos_' . $Reporte->getFechainicio(). "_" . $Reporte->getFechafinal() . '.xlsx']);

<?php
require '../class_graficas/cl_reporte_inventario.php';
require '../includes/SimpleXLSXGen.php';
use Shuchkin\SimpleXLSXGen;

$Reporte = new cl_reporte_inventario();

$Reporte->setIdsucursal(filter_input(INPUT_POST, 'tiendaid'));
$Reporte->setIdempresa(filter_input(INPUT_POST, 'empresaid'));

$books = array();

$filai = [
    ['<center>MIS PRODUCTOS EN STOCK</center>', null]
];
$books[] = $filai;

//estructura titulos tabla
$fila = ['Item',
    'Producto',
    'Presentacion',
    'Lote',
    'Vcto',
    'Costo',
    'Precio',
    'Cantidad',
    'Costo Parcial',
    'Precio Parcial',
    'Utilidad'];
$books[] = $fila;

$array_lista = $Reporte->verMisProductos();
$nrofila = 0;
//var_dump($array_lista);

foreach ($array_lista as $fila) {
    

    $nrofila++;

    $costototal = $fila['cantidad'] * $fila['pcompra'];
    $preciototal = $fila['cantidad'] * $fila['pventa'];
    $utilidad = $preciototal - $costototal;
    $fila = [
        $nrofila,
        $fila['nproducto'],
        $fila['npresentacion'],
        $fila['lote'],
        $fila['vcto'],
        number_format($fila['pcompra'],2),
        number_format($fila['pventa'],2),
        $fila['cantidad'],
        number_format($costototal, 2),
        number_format($preciototal, 2),
        number_format($utilidad, 2),
    ];
    $books[] = $fila;
}


$xlsx = SimpleXLSXGen::fromArray($books);
$xlsx->saveAs('reporte_mis_productos_' . $Reporte->getIdempresa() . "_" . $Reporte->getIdsucursal() . '.xlsx');

//echo "hola";

echo json_encode(['name' => 'reporte_mis_productos_' . $Reporte->getIdempresa(). "_" . $Reporte->getIdsucursal() . '.xlsx']);

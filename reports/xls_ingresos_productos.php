<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require '../class_graficas/cl_reporte_inventario.php';
require '../includes/SimpleXLSXGen.php';
use Shuchkin\SimpleXLSXGen;

$Reporte = new cl_reporte_inventario();

$Reporte->setEmpresaid(filter_input(INPUT_POST, 'empresaid'));

$filai = [
    "",
    "",
    "REPORTE DE INGRESO DE PRODUCTOS - DETALLADO"
];
$books[] = $filai;

//estructura titulos tabla
$books = array();
$fila = ['Item',
    'Fecha',
    'Documento',
    'Proveedor',
    'Tienda',
    'Usuario',
    'Producto',
    'Presentacion',
    'Laboratorio',
    'Lote',
    'Fec Vcto',
    'Cantidad',
    'Costo Compra',
    'Precio Venta',
    'Parcial Compra',
    'Parcial Venta',
    'Utilidad'];
$books[] = $fila;

$array_lista = $Reporte->verIngresosProductosIndividuales();
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
        $fila['documentos_sunat'] . " | " . $fila['serie'] . "-" . $fila['numero'],
        $fila['documento']. " - " . $fila['proveedor'],
        "-",
        $fila['username'],
        $fila['nombre'],
        $fila['presentacion'],
        $fila['laboratorio'],
        $fila['lote'],
        $fila['vcto'],
        $fila['cantidad'],
        $fila['costo'],
        $fila['precio'],
        number_format($costototal, 2),
        number_format($preciototal, 2),
        number_format($utilidad, 2),
    ];
    $books[] = $fila;
}
/*
echo "<pre>";
print_r($books);
echo "</pre>";
*/
$xlsx = SimpleXLSXGen::fromArray($books);
$xlsx->saveAs('reporte_ingresos_productos.xlsx');

echo json_encode(['name' => 'reporte_ingresos_productos.xlsx']);

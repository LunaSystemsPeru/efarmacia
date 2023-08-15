<?php
require '../class_graficas/cl_reporte_inventario.php';
require '../class/cl_sucursal.php';
require '../includes/SimpleXLSXGen.php';

use Shuchkin\SimpleXLSXGen;

$Reporte = new cl_reporte_inventario();
$Sucursal = new cl_sucursal();

$Reporte->setSucursalid(filter_input(INPUT_POST, 'tiendaid'));
$Reporte->setEmpresaid(filter_input(INPUT_POST, 'empresaid'));

$Sucursal->setIdEmpresa($Reporte->getEmpresaid());
$Sucursal->setIdSucursal($Reporte->getSucursalid());
$Sucursal->obtener_datos();

$books = array();

$filai = ['', '', '<b>VER STOCK ACTUAL VALORIZADO DE MIS PRODUCTOS EN STOCK EN TIENDA: ' . $Sucursal->getNombre() . '</b>', null, '', '', '', '', '', '', ''];
//$filai = ['<b>VER STOCK ACTUAL VALORIZADO DE MIS PRODUCTOS EN STOCK EN TIENDA: ' . $Sucursal->getNombre() . '</b>', null, null, null, '', '', '', '', '', '', ''];
$books[] = $filai;

//estructura titulos tabla
$fila = ['Item',
    'Cod. Producto',
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

$array_lista = $Reporte->verMisProductosValorizados();
$nrofila = 0;
//var_dump($array_lista);

foreach ($array_lista as $fila) {


    $nrofila++;

    $costototal = $fila['cantidad'] * $fila['pcompra'];
    $preciototal = $fila['cantidad'] * $fila['pventa'];
    $utilidad = $preciototal - $costototal;
    $fila = [
        $nrofila,
        $fila['id_producto'],
        $fila['nproducto'],
        $fila['npresentacion'],
        $fila['lote'],
        $fila['vcto'],
        number_format($fila['pcompra'], 2),
        number_format($fila['pventa'], 2),
        $fila['cantidad'],
        number_format($costototal, 2),
        number_format($preciototal, 2),
        number_format($utilidad, 2),
    ];
    $books[] = $fila;
}


$xlsx = SimpleXLSXGen::fromArray($books);
$xlsx->saveAs('reporte_mis_productos_' . $Reporte->getEmpresaid() . "_" . $Reporte->getSucursalid() . '.xlsx');

//echo "hola";

echo json_encode(['name' => 'reporte_mis_productos_' . $Reporte->getEmpresaid() . "_" . $Reporte->getSucursalid() . '.xlsx']);

<?php

require '../class/cl_venta.php';
require '../class/cl_sucursal.php';
require '../class/cl_empresa.php';
require '../class_varios/Varios.php';

array_map('unlink', glob("tmp/*.txt"));

$Venta = new cl_venta();
$Tienda = new cl_sucursal();
$Empresa = new cl_empresa();
$Util = new Varios();

$Venta->setIdSucursal(filter_input(INPUT_GET, 'tienda'));
$Venta->setPeriodo(filter_input(INPUT_GET, 'periodo'));

$Tienda->setIdSucursal($Venta->getIdSucursal());
$Tienda->obtener_datos();

$Empresa->setIdEmpresa($Tienda->getIdEmpresa());
$Empresa->obtener_datos();

$totalitems = 0;
$nroarchivo = 1;
$archivo = [];
$file_txt = [];

$nroitems = $Venta->verComprobantesMensual()->num_rows;
$total_archivos = ceil($nroitems / 100);

for ($i = 0; $i < $total_archivos; $i++) {
    $file_txt[] = "CONSULTA_" . $Empresa->getRuc() . "_" . $Venta->getPeriodo() . "_" . $i;
    $archivo[] = fopen('tmp/' . $file_txt[$i] . ".txt", "w");
}

foreach ($Venta->verComprobantesMensual() as $item) {
    $totalitems++;
    $posicionarchivo = ceil($totalitems / 100) - 1;
    $contenido = $item['ruc'] . "|" .
        $item['cod_sunat'] . "|" .
        $item['serie'] . "|" .
        $item['numero'] . "|" .
        $Util->fecha_mysql_web($item['fecha']) . "|" .
        number_format($item['total'], 2);
    fwrite($archivo[$posicionarchivo], $contenido . PHP_EOL);
    //echo "<pre>";
    //echo $totalitems . " " .  $archivo[$posicionarchivo] . PHP_EOL;
    //echo "</pre>";
}

for ($i = 0; $i < $total_archivos; $i++) {
    fclose($archivo[$i]);
}

echo json_encode(["archivos" => $file_txt]);

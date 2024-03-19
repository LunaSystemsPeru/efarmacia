<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../class/cl_venta.php';
require '../../class/cl_sucursal.php';
require '../../class/cl_empresa.php';
require '../../class_varios/Varios.php';

$Venta = new cl_venta();
$Tienda = new cl_sucursal();
$Empresa = new cl_empresa();
$Util = new Varios();

$totalitems = 0;

$fechainicio = date('Y-m-d');
$fechainicio = date("Y-m-d", strtotime($fechainicio . "- 4 days"));

$fechafin = date('Y-m-d');
$lista_cpes = $Venta->verComprobantesCPEFechas($fechainicio, $fechafin);

echo "<pre>";
foreach ($lista_cpes as $item) {
    //$query = "select e.ruc, ds.cod_sunat, v.serie, v.numero, v.fecha, v.total, v.periodo, v.id_empresa, v.id_venta
    $array_CPE = [
        "numRuc" => $item['ruc'],
        "codComp" => $item['cod_sunat'],
        "numeroSerie" => $item['serie'],
        "numero" => $item['numero'],
        "fechaEmision" => $Util->fecha_mysql_web($item['fecha']),
        "monto" => number_format($item['total'], 2)
    ];

    $jsoncpe = json_encode($array_CPE);

    $response = file_get_contents('https://lunasystemsperu.com/clientes/lunafact/intranet/composer/functions/consulta_comprobantes_cpe.php?json=' . $jsoncpe);
    $json_response = json_decode($response, false);

    $object = (object)$json_response;
    if (!isset($object->data->estadoCp)) {
        continue;
    }

    $estadoCP = $object->data->estadoCp;

    $estadocomprobante = 0;

    if ($estadoCP == "0") {
        $estadocomprobante = 0;
        if ($item['estado'] != 1) {
            $estadocomprobante = 1;
        } else {
            echo "Comprobante no existe en sunat {$item['ruc']} - {$item['cod_sunat']} - {$item['serie']} - {$item['fecha']}";
        }
    }
    if ($estadoCP == "1" || $estadoCP == "2") {
        $estadocomprobante = 1;
        if ($estadoCP == 1 && $item['estado'] == 2) {
            $estadocomprobante = 2;
            echo "Comprobante no esta anulado en sunat {$item['ruc']} - {$item['cod_sunat']} - {$item['serie']} - {$item['fecha']}";
        }
    }

    $Venta->setEnviadoSunat($estadocomprobante);
    $Venta->setIdEmpresa($item['id_empresa']);
    $Venta->setPeriodo($item['periodo']);
    $Venta->setIdVenta($item['id_venta']);
    $Venta->actualizar_envio();
}
echo "</pre>";
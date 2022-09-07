<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Document;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;

require __DIR__ . '/../vendor/autoload.php';
require '../src/Config.php';

//cargar clases del sistema
require __DIR__ . '/../../class/cl_empresa.php';
require __DIR__ . '/../../class/cl_venta.php';
require __DIR__ . '/../../class/cl_ventas_anuladas.php';
require __DIR__ . '/../../class/cl_resumen_diario.php';
require __DIR__ . '/../../class/cl_ventas_referencias.php';

$id_empresa = filter_input(INPUT_GET, 'id_empresa');
$fecha = filter_input(INPUT_GET, 'fecha');

$c_empresa = new cl_empresa();
$c_empresa->setIdEmpresa($id_empresa);
$c_empresa->obtener_datos();

$Config = new Config();
$Config->setRuc($c_empresa->getRuc());
$Config->setUsersol($c_empresa->getUserSol());
$Config->setClavesol($c_empresa->getClavesol());

$see = $Config->getSee();

$c_venta = new cl_venta();
$c_venta->setIdEmpresa($id_empresa);
$c_venta->setFecha($fecha);

$c_referencia = new cl_ventas_referencias();

$resultado_empresa = $c_venta->verDocumentosResumen();

$c_anulada = new cl_ventas_anuladas();
$c_anulada->setIdEmpresa($id_empresa);
$c_anulada->setFecha($fecha);

$resultado_anuladas = $c_anulada->verResumenAnuladas();

//enviar documento del dia solo activos
$contar_items = 0;
$array_items = array();
foreach ($resultado_empresa as $fila) {
    $contar_items++;
    //tipo cliente
    $tipo_doc = "1";
    $doc_cliente = "00000000";
    if (strlen($fila['documento']) == 8) {
        $tipo_doc = "1";
        $doc_cliente = $fila['documento'];
    } else if (strlen($fila['documento']) == 11) {
        $tipo_doc = "6";
        $doc_cliente = $fila['documento'];
    } else {
        $tipo_doc = "0";
    }

    //estado
    $estado = $fila['estado'];
    $estado = "1";

    //totales
    $total = floatval($fila['total']);
    $subtotal = $total / 1.18;
    $igv = $total / 1.18 * 0.18;


    $item = new SummaryDetail();
    $item->setTipoDoc($fila['cod_sunat'])
        ->setSerieNro($fila['serie'] . "-" . $fila['numero'])
        ->setEstado($estado)
        ->setClienteTipo($tipo_doc)
        ->setClienteNro($doc_cliente)
        ->setTotal($total)
        ->setMtoOperGravadas($subtotal)
        ->setMtoOperInafectas(0)
        ->setMtoOperExoneradas(0)
        ->setMtoOtrosCargos(0)
        ->setMtoIGV($igv);

    if ($fila['id_documento'] == 5) {
        //si es nota de credito
        $c_referencia->setIdNota($fila['id_venta']);
        $c_referencia->obtenerDatos();
        //obtener el i dde la venta amarrada

        $c_venta_afecta = new cl_venta();
        $c_venta_afecta->setIdVenta($c_referencia->getIdVenta());
        $c_venta_afecta->obtener_datos();


        //obtener laa serie y el numero y mostrar
        $item->setDocReferencia($c_venta_afecta->getSerie() . "-" . $c_venta_afecta->getNumero());
    }

    $c_venta->setIdEmpresa($id_empresa);
    $c_venta->setPeriodo($fila["periodo"]);
    $c_venta->setIdVenta($fila["id_venta"]);
    $c_venta->actualizar_envio();

    $array_items[] = $item;

}

//enviar documentos anulados en el dia
foreach ($resultado_anuladas as $fila) {
    $contar_items++;
    //tipo cliente
    $tipo_doc = "1";
    $doc_cliente = "00000000";
    if (strlen($fila['documento']) == 8) {
        $tipo_doc = "1";
        $doc_cliente = $fila['documento'];
    } else if (strlen($fila['documento']) == 11) {
        $tipo_doc = "6";
        $doc_cliente = $fila['documento'];
    } else {
        $tipo_doc = "0";
    }

    //estado
    $estado = $fila['estado'];
    $estado = "3";
    if ($fila['estado'] == 1) {
        $estado = "3";
    }
    if ($fila['estado'] == 2) {
        $estado = "3";
    }

    //totales
    $total = floatval($fila['total']);
    $subtotal = $total / 1.18;
    $igv = $total / 1.18 * 0.18;


    $item = new SummaryDetail();
    $item->setTipoDoc($fila['cod_sunat'])
        ->setSerieNro($fila['serie'] . "-" . $fila['numero'])
        ->setEstado($estado)
        ->setClienteTipo($tipo_doc)
        ->setClienteNro($doc_cliente)
        ->setTotal($total)
        ->setMtoOperGravadas($subtotal)
        ->setMtoOperInafectas(0)
        ->setMtoOperExoneradas(0)
        ->setMtoOtrosCargos(0)
        ->setMtoIGV($igv);

    if ($fila['id_documento'] == 5) {
        //si es nota de credito
        $c_referencia->setIdNota($fila['id_venta']);
        $c_referencia->obtenerDatos();
        //obtener el i dde la venta amarrada

        $c_venta_afecta = new cl_venta();
        $c_venta_afecta->setIdVenta($c_referencia->getIdVenta());
        $c_venta_afecta->obtener_datos();


        //obtener laa serie y el numero y mostrar
        $item->setDocReferencia($c_venta_afecta->getSerie() . "-" . $c_venta_afecta->getNumero());
    }

    $c_venta->setIdEmpresa($id_empresa);
    $c_venta->setPeriodo($fila["periodo"]);
    $c_venta->setIdVenta($fila["id_venta"]);
    $c_venta->actualizar_envio();

    $array_items[] = $item;
}

if ($contar_items > 0) {

    // Emisor
    $empresa = new Company();
    $empresa->setRuc($c_empresa->getRuc())
        ->setNombreComercial(addslashes($c_empresa->getNombreComercial()))
        ->setRazonSocial(addslashes($c_empresa->getRazonSocial()))
        ->setAddress((new Address())
            ->setUbigueo($c_empresa->getUbigeo())
            ->setDistrito($c_empresa->getDistrito())
            ->setProvincia($c_empresa->getProvincia())
            ->setDepartamento($c_empresa->getDepartamento())
            ->setUrbanizacion('-')
            ->setCodLocal('0000')
            ->setDireccion(addslashes($c_empresa->getDireccion())));

//$util->setRucEmpresa($c_empresa->getRuc());
    echo "nro de items = " . count($array_items) . "<br>";

    $sum = new Summary();
    $sum->setFecGeneracion(\DateTime::createFromFormat('Y-m-d', $fecha))
        ->setFecResumen(\DateTime::createFromFormat('Y-m-d', $fecha))
        ->setCorrelativo('001')
        ->setCompany($empresa)
        ->setDetails($array_items);

    // Envio a SUNAT.
    $res = $see->send($sum);

    echo $sum->getName() . "<br>";

    // Guardar XML firmado digitalmente.
    file_put_contents("../RC/" . $sum->getName() . '.xml',
        $see->getFactory()->getLastXml());
    $c_resumen = new cl_resumen_diario();


    if (!$res->isSuccess()) {
        echo "<br> error al enviar ";
        print_r($res->getError());
        return;
    }

    /**@var $res SummaryResult */
    $ticket = $res->getTicket();
    echo '<br>Ticket :<strong>' . $ticket . '</strong><br>';

    $c_resumen->obtenerId();
    $c_resumen->setIdEmpresa($c_empresa->getIdEmpresa());
    $c_resumen->setFecha($fecha);
    $c_resumen->setCantidadItems($contar_items);
    $c_resumen->setTipo(1);

    //$c_resumen->insertar();

    $res = $see->getStatus($ticket);
    if (!$res->isSuccess()) {
        echo "<br> error al obtener estado de ticket ";
        print_r($res->getError());
        return;
    }

    $cdr = $res->getCdrResponse();
    print_r($cdr->getDescription());
    //print_r($cdr->getNotes());
    //$util->writeCdr($sum, $res->getCdrZip());
    // Guardamos el CDR
    file_put_contents("../RC/" . 'R-' . $sum->getName() . '.zip', $res->getCdrZip());
    //$util->showResponse($sum, $cdr);
}
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

//cargar clases del sistema
require __DIR__ . '/../../class/cl_empresa.php';
require __DIR__ . '/../../class/cl_venta.php';
require __DIR__ . '/../../class/cl_ventas_anuladas.php';
require __DIR__ . '/../../class/cl_resumen_diario.php';
require __DIR__ . '/../../class/cl_ventas_referencias.php';

$util = Util::getInstance();

$id_empresa = filter_input(INPUT_POST, 'id_empresa');
$fecha = filter_input(INPUT_POST, 'fecha');
if ($id_empresa) {

//inicar clases del sistema
    $c_empresa = new cl_empresa();
    $c_empresa->setIdEmpresa($id_empresa);
    $c_empresa->obtener_datos();

    $util->setRuc($c_empresa->getRuc());
    $util->setClave($c_empresa->getClaveSol());
    $util->setUsuario($c_empresa->getUserSol());

    $c_venta = new cl_venta();
    $c_venta->setIdEmpresa($id_empresa);
    $c_venta->setFecha($fecha);

    $c_referencia = new cl_ventas_referencias();

    $resultado_empresa = $c_venta->verDocumentosResumen();

    $c_anulada = new cl_ventas_anuladas();
    $c_anulada->setIdEmpresa($id_empresa);
    $c_anulada->setFecha($fecha);

    $resultado_anuladas = $c_anulada->verResumenAnuladas();

    //print_r ($resultado_empresa);

    //enviar documento del dia solo activos
    $contar_items = 0;
    $array_items = array();
    foreach ($resultado_empresa as $fila) {
        $contar_items++;
        //tipo cliente
        $doc_cliente = "00000000";
        if (strlen($fila['documento']) == 8) {
            $tipo_doc = 1;
            $doc_cliente = $fila['documento'];
        } else if (strlen($fila['documento']) == 11) {
            $tipo_doc = 6;
            $doc_cliente = $fila['documento'];
        } else {
            $tipo_doc = 0;
        }

        //estado
        $estado = $fila['estado'];
        if ($fila['estado'] == 1) {
            $estado = "1";
        }
        if ($fila['estado'] == 2) {
            $estado = "1";
        }

        //totales
        $total = $fila['total'];
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
        $doc_cliente = "00000000";
        if (strlen($fila['documento']) == 8) {
            $tipo_doc = 1;
            $doc_cliente = $fila['documento'];
        } else if (strlen($fila['documento']) == 11) {
            $tipo_doc = 6;
            $doc_cliente = $fila['documento'];
        } else {
            $tipo_doc = 0;
        }

        //estado
        $estado = $fila['estado'];
        if ($fila['estado'] == 1) {
            $estado = "3";
        }
        if ($fila['estado'] == 2) {
            $estado = "3";
        }

        //totales
        $total = $fila['total'];
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


    //print_r($array_items);

    $empresa = new Company();
    $empresa->setRuc($c_empresa->getRuc())
        ->setNombreComercial($c_empresa->getRazonSocial())
        ->setRazonSocial($c_empresa->getRazonSocial())
        ->setAddress((new Address())
            ->setUbigueo($c_empresa->getUbigeo())
            ->setDistrito($c_empresa->getDistrito())
            ->setProvincia($c_empresa->getProvincia())
            ->setDepartamento($c_empresa->getDepartamento())
            ->setUrbanizacion('-')
            ->setCodLocal('0000')
            ->setDireccion($c_empresa->getDireccion()));

    //$util->setRucEmpresa($c_empresa->getRuc());

    $sum = new Summary();
    $sum->setFecGeneracion(\DateTime::createFromFormat('Y-m-d', $fecha))
        ->setFecResumen(\DateTime::createFromFormat('Y-m-d', $fecha))
        ->setCorrelativo('001')
        ->setCompany($empresa)
        ->setDetails($array_items);


//variables generales
    $nombre_archivo = $sum->getName();
    $dominio = "https://" . $_SERVER["HTTP_HOST"] . "/clientes/farmacia/";
    $nombre_xml = $dominio . "/greenter/files/" . $sum->getName() . ".xml";
    $nombre_zip_respuesta = $dominio . "/greenter/files/R-" . $sum->getName() . ".zip";

    if ($contar_items > 0) {
// Envio a SUNAT.
        $see = $util->getSee(SunatEndpoints::FE_PRODUCCION);

        $res = $see->send($sum);
        $util->writeXml($sum, $see->getFactory()->getLastXml());

//lenar resumen diario;
        $c_resumen = new cl_resumen_diario();
        $c_resumen->obtenerId();
        $c_resumen->setIdEmpresa($c_empresa->getIdEmpresa());
        $c_resumen->setFecha($fecha);
        $c_resumen->setCantidadItems($contar_items);
        $c_resumen->setTipo(1);

        if ($res->isSuccess()) {

            /**@var $res \Greenter\Model\Response\SummaryResult */
            $ticket = $res->getTicket();
            echo "nro de ticket = " . $ticket;
            $c_resumen->setTicket($ticket);
            $descripcion = "";
            $result = $see->getStatus($ticket);
            if ($result->isSuccess()) {
                $cdr = $result->getCdrResponse();
                $util->writeCdr($sum, $result->getCdrZip());

                $descripcion = $cdr->getDescription();

                //$util->showResponse($sum, $cdr);
                echo "res: " .   $respuesta = $util->showResponse($sum, $cdr);



            } else {
                echo $util->getErrorResponse($result->getError());
                //  $respuesta = $util->getErrorResponse($result->getError());
                /*$respuesta = array(
                    "success" => false,
                    "resultado" => "ERROR EN EL TICKET"
                );*/
            }

            $c_resumen->insertar();
            /*
                        $respuesta = array(
                            "success" => true,
                            "resultado" => array(
                                "ticket" => $ticket,
                                "nombre_archivo" => $nombre_archivo,
                                "direccion_xml" => $nombre_xml,
                                "direccion_zip_respuesta" => $nombre_zip_respuesta,
                                "descripcion_cdr" => $descripcion
                            )
                        );
            */
        } else {
            echo $util->getErrorResponse($res->getError());
            //   $respuesta = $util->getErrorResponse($res->getError());
            /*$respuesta = array(
                 "success" => false,
                 "resultado" => "ERROR AL ENVIAR"
             );*/
        }

        //echo json_encode($respuesta);
    } else {
        //$respuesta= "error al enviar no hay items";
        $respuesta = array(
            "success" => false,
            "resultado" => "ERROR AL ENVIAR - NO HAY ITEMS"
        );
        echo  json_encode($respuesta);
    }


    /*
    $to = "info@lunasystemsperu.com";
    $subject = "Estado del Envio de Resumen de Boletas " . $c_empresa->getRuc() . " del dia: " . $fecha;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $message = $respuesta;

    mail($to, $subject, $message, $headers);
    */
}
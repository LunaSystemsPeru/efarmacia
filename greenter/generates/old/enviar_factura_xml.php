<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//ini_set('default_socket_timeout', 600);

use Greenter\Model\Sale\Invoice;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../../class/cl_venta.php';
require __DIR__ . '/../../class/cl_empresa.php';


$util = Util::getInstance();

$id_empresa = filter_input(INPUT_POST, 'id_empresa');
$fecha = filter_input(INPUT_POST, 'fecha');

if ($id_empresa) {

    $c_empresa = new cl_empresa();
    $c_empresa->setIdEmpresa($id_empresa);
    $c_empresa->obtener_datos();

    //definir valor por defecto para ruc de empresa
    $util->setRuc($c_empresa->getRuc());
    $util->setClave($c_empresa->getClaveSol());
    $util->setUsuario($c_empresa->getUserSol());

    $c_venta = new cl_venta();
    $c_venta->setIdEmpresa($id_empresa);
    $c_venta->setFecha($fecha);

//parametros de archivos xml
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $rutabase = dirname(dirname($url)) . DIRECTORY_SEPARATOR;

    $see = $util->getSee(SunatEndpoints::FE_PRODUCCION);

    $contar_malas = 0;
    $total_filas = 0;

    $mensaje = "";

//lista de documentos por empresa y fecha
    $resultado = $c_venta->verFacturasResumen();
    foreach ($resultado as $fila) {
        $total_filas++;

        //generar nombres de archivos
        $nombre_archivo = $c_empresa->getRuc() . "-01-" . $fila['serie'] . "-" . $fila['numero'];
        $archivo_xml = $rutabase . "../files/" . $nombre_archivo . ".xml";
        $mensaje = $mensaje . "archivo a enviar = " . $archivo_xml . PHP_EOL;

        if (file_exists($archivo_xml)) {
            /** Si solo desea enviar un XML ya generado utilice esta función* */
            $res = $see->sendXml(Invoice::class, $nombre_archivo, file_get_contents($archivo_xml));

            if ($res->isSuccess()) {
                //obtener cdr y guardar en json
                $cdr = $res->getCdrResponse();
                $util->writeCdr($nombre_archivo, $res->getCdrZip());
                $mensaje = $mensaje . "archivo recibido por sunat " . $cdr->getDescription() . PHP_EOL;

                $c_venta->setIdVenta($fila['id_venta']);
                $c_venta->setIdEmpresa($id_empresa);
                $c_venta->setPeriodo($fila["periodo"]);
                $c_venta->actualizar_envio();
            } else {
                $mensaje = $mensaje . "error al recibir el archivo " . PHP_EOL;
                $contar_malas++;
            }
        } else {
            $mensaje = $mensaje . "archivo no existe = " . $archivo_xml . PHP_EOL;
            $contar_malas++;
        }
    }


    $mensaje = $mensaje . $contar_malas . " de " . $total_filas;

    print_r($mensaje);
    /*
        $to = "info@lunasystemsperu.com";
        $subject = "Estado del Envio de Facturas Electronica " . $c_empresa->getRuc() . " del dia: " . $fecha;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $message = $mensaje;

        mail($to, $subject, $message, $headers);
    */

}
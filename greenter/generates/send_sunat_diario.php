<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 02/09/19
 * Time: 07:45 PM
 */
/*if (!isset($_SESSION)) {
    session_start();
}*/

error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Lima');

require '../../class/cl_empresa.php';

$c_empresa = new cl_empresa();
//variables publicas
$url = "http://www.lunasystemsperu.com/clientes/farmacia/";
$fecha = date("Y-m-d");
//$fecha = '2021-09-07';

//recorrer lista de empresas
$array_empresas = $c_empresa->ver_empresas();
foreach ($array_empresas as $fila) {
    echo "----ID EMPRESA: " . $fila['id_empresa'] . " nombre " . $fila['razon_social'] . "<br>";
    $id_empresa = $fila['id_empresa'];

    //enviar resumen de boletas
    $ruta = $url . "greenter/generates/enviar_factura_xml.php";
    $post = [
        'id_empresa' => $id_empresa,
        'fecha' => $fecha
    ];
    print_r($post);

    $ch_factura = curl_init();
    curl_setopt($ch_factura, CURLOPT_URL, $ruta);
    curl_setopt($ch_factura, CURLOPT_POST, 1);
    curl_setopt($ch_factura, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch_factura, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch_factura, CURLOPT_RETURNTRANSFER, true);
    $respuesta_factura = curl_exec($ch_factura);
    curl_close($ch_factura);

    echo "<br>" . " respuesta factura " . "<br>";
    print_r($respuesta_factura);
    echo "<br>";

    $ruta = $url . "greenter/generates/resumen.php";
    //enviar resumen de facturas
    $ch_resumen = curl_init();
    curl_setopt($ch_resumen, CURLOPT_URL, $ruta);
    curl_setopt($ch_resumen, CURLOPT_POST, 1);
    curl_setopt($ch_resumen, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch_resumen, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch_resumen, CURLOPT_RETURNTRANSFER, true);
    $respuesta_resumen = curl_exec($ch_resumen);
    curl_close($ch_resumen);

    echo "<br>" . " respuesta resumen " . "<br>";
    print_r($respuesta_resumen);
    echo "<br>";

    //enviar notificacion de bajas
    $ruta = $url . "greenter/generates/comunicacion-baja.php";
    //enviar resumen de facturas
    $ch_baja= curl_init();
    curl_setopt($ch_baja, CURLOPT_URL, $ruta);
    curl_setopt($ch_baja, CURLOPT_POST, 1);
    curl_setopt($ch_baja, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch_baja, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch_baja, CURLOPT_RETURNTRANSFER, true);
    $respuesta_baja= curl_exec($ch_baja);
    curl_close($ch_baja);

    echo "<br>" . " respuesta comunicacion baja " . "<br>";
    print_r($respuesta_baja);
    echo "<br><br>";

}

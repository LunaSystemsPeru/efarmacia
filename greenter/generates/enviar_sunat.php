<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Lima');

$url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

$rutabase = dirname($url) . DIRECTORY_SEPARATOR;
echo $rutabase;

require '../../class/cl_empresa.php';

$c_empresa = new cl_empresa();

$fecha = date("Y-m-d");
//$fecha = filter_input(INPUT_GET, 'fecha');
//$fecha = '2021-11-07';

$ruta = 'https://lunasystemsperu.com/clientes/alufarma/greenter/functions/validarCPE.php';
//enviar resumen de facturas
$ch_resumen = curl_init();
curl_setopt($ch_resumen, CURLOPT_URL, $ruta);
curl_setopt($ch_resumen, CURLOPT_POST, 0);
curl_setopt($ch_resumen, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch_resumen, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch_resumen, CURLOPT_RETURNTRANSFER, true);
$respuesta_resumen = curl_exec($ch_resumen);
curl_close($ch_resumen);

//recorrer lista de empresas
$array_empresas = $c_empresa->ver_empresas();
foreach ($array_empresas as $fila) {
    if ($fila['estado'] == 1) {
        echo "----ID EMPRESA: " . $fila['id_empresa'] . " nombre " . $fila['razon_social'] . PHP_EOL;
        $id_empresa = $fila['id_empresa'];

        $ruta = $rutabase . "resumen-activos.php?id_empresa=" . $id_empresa . '&fecha=' . $fecha;
        //enviar resumen de facturas
        $ch_resumen = curl_init();
        curl_setopt($ch_resumen, CURLOPT_URL, $ruta);
        curl_setopt($ch_resumen, CURLOPT_POST, 0);
        curl_setopt($ch_resumen, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch_resumen, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch_resumen, CURLOPT_RETURNTRANSFER, true);
        $respuesta_resumen = curl_exec($ch_resumen);
        curl_close($ch_resumen);

        echo PHP_EOL . " respuesta resumen " . PHP_EOL;
        print_r($respuesta_resumen);
        echo PHP_EOL;

        $ruta = $rutabase . "resumen-anulados.php?id_empresa=" . $id_empresa . '&fecha=' . $fecha;
        //enviar resumen de facturas
        $ch_resumen = curl_init();
        curl_setopt($ch_resumen, CURLOPT_URL, $ruta);
        curl_setopt($ch_resumen, CURLOPT_POST, 0);
        curl_setopt($ch_resumen, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch_resumen, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch_resumen, CURLOPT_RETURNTRANSFER, true);
        $respuesta_resumen = curl_exec($ch_resumen);
        curl_close($ch_resumen);

        echo PHP_EOL . " respuesta resumen anulados " . PHP_EOL;
        print_r($respuesta_resumen);
        echo PHP_EOL;


        $ruta = $rutabase . "comunicacion-baja.php?id_empresa=" . $id_empresa . '&fecha=' . $fecha;
        //enviar resumen de facturas
        $ch_resumen = curl_init();
        curl_setopt($ch_resumen, CURLOPT_URL, $ruta);
        curl_setopt($ch_resumen, CURLOPT_POST, 0);
        curl_setopt($ch_resumen, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch_resumen, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch_resumen, CURLOPT_RETURNTRANSFER, true);
        $respuesta_resumen = curl_exec($ch_resumen);
        curl_close($ch_resumen);

        echo PHP_EOL . " respuesta comunicacion baja " . PHP_EOL;
        print_r($respuesta_resumen);
        echo PHP_EOL;

    }

}

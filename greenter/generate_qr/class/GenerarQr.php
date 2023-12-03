<?php

include __DIR__ . "/../qrlib.php";

class generarQr
{

    private $texto_qr;
    private $nombre_archivo;

    function __construct()
    {

    }

    function setTexto_qr($texto_qr)
    {
        $this->texto_qr = $texto_qr;
    }

    function setNombre_archivo($nombre_archivo)
    {
        $this->nombre_archivo = $nombre_archivo;
    }

    function generar_qr()
    {
        $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
        $PNG_WEB_DIR = 'temp/';
        //html PNG location prefix
        $filename = $PNG_TEMP_DIR . $this->nombre_archivo . '.png';

        QRcode::png($this->texto_qr, $filename, "Q", 4, 2);
    }

}

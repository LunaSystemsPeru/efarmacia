<?php

class cl_varios {
    
	//date_default_timezone_set('America/Lima');
	
    public function __construct() 
    { 
    }

    function fecha_mysql_web($source) {
        $date = new DateTime($source);
        return $date->format('d/m/Y');
    }

    function fecha_periodo($source) {
        $date = new DateTime($source);
        return $date->format('Ym');
    }

    function fecha_cotizacion($source) {
        $date = new DateTime($source);
        return $date->format('Y-md');
    }

    function anio_de_fecha($source) {
        $date = new DateTime($source);
        return $date->format('Y');
    }

    function mes_de_fecha($source) {
        $date = new DateTime($source);
        return $date->format('m');
    }

    function mesactual ()  {
        $mes = date("m");
        return $mes;
    }
    
    function nombremes($mes) {
        setlocale(LC_TIME, 'spanish');
        $nombre = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
        return ucwords($nombre);
    }
    
    function fecha_tabla($date) {
        $to_format = 'd/m/Y';
        $from_format = 'Y-m-d';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }
	
	function fecha_tabla_completa($date) {
        $to_format = 'd/m/Y H:i:s';
        $from_format = 'Y-m-d H:i:s';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_mysql($date) {
        $to_format = 'Y-m-d';
        $from_format = 'd/m/Y';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }
    
    function fecha_actual_completa() {
        date_default_timezone_set('America/Lima');
        return date("Y-m-d H:i:s");
    }

    function fecha_actual_corta() {
		date_default_timezone_set('America/Lima');
        return date("Y-m-d");
    }

    function zerofill($valor, $longitud) {
        $res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
        return $res;
    }

    function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++) {
            $key .= $pattern[mt_rand(0, $max)];
        }
        return $key;
    }

}

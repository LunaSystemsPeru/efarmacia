<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of varios
 *
 * @author gerenciatecnica
 */
class Varios
{

    public function __construct()
    {
        date_default_timezone_set('America/Los_Angeles');
    }

    function mesactual()
    {
        $mes = date("m");
        return $mes;
    }

    function nombremes($mes)
    {
        setlocale(LC_TIME, 'spanish');
        $nombre = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
        return ucwords($nombre);
    }

    function fecha_tabla($date)
    {
        $to_format = 'd/m/Y';
        $from_format = 'Y-m-d';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_tabla_completa($date)
    {
        $to_format = 'd/m/Y H:i:s';
        $from_format = 'Y-m-d H:i:s';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_mysql($date)
    {
        $to_format = 'Y-m-d';
        $from_format = 'd/m/Y';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_actual_completa()
    {
        $fecha_actual = date("Y-m-d H:i:s");
        return $fecha_actual;
    }

    function fecha_actual_corta()
    {
        date_default_timezone_set('America/Los_Angeles');
        $fecha_actual = date("Y-m-d");
        return $fecha_actual;
    }

    function zerofill($valor, $longitud)
    {
        $res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
        return $res;
    }

    /**
     * @param $longitud
     * @return string
     */
    function generarCodigo($longitud)
    {
        $key = '';
        $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++) {
            $key .= $pattern{mt_rand(0, $max)};
        }
        return $key;
    }

    function fecha_mysql_web($source)
    {
        $date = new DateTime($source);
        return $date->format('d/m/Y');
    }

    function fecha_web_mysql($source)
    {
        $to_format = 'Y-m-d';
        $from_format = 'd/m/Y';
        $date_aux = date_create_from_format($from_format, $source);
        return date_format($date_aux, $to_format);
    }


}

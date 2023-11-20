<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cl_validar_documento
 *
 * @author luis
 */
class cl_validar_documento
{

    private $url_ruc = "https://goempresarial.com/apis/peru-consult-api/public/api/v1/ruc/%s?token=abcxyz";
    private $url_dni = "https://goempresarial.com/apis/peru-consult-api/public/api/v1/dni/%s?token=abcxyz";
    private $dni;
    private $ruc;

    function __construct()
    {

    }

    function setDni($dni)
    {
        $this->dni = $dni;
    }

    function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    public function obtener_ruc()
    {
        if (strlen($this->ruc) == 11) {
            $urlfinal = sprintf($this->url_ruc, $this->ruc);
            $json_ruc = file_get_contents($urlfinal);
            // Check for errors
            if ($json_ruc === FALSE) {
                die('Error');
            } else {
                $array_ruc = json_decode($json_ruc, true);
                $json_ruc = (object)array(
                    "success" => true,
                    "result" => $array_ruc
                );
            }
        } else {
            $json_ruc = (object)array(
                "success" => false,
                "result" => "LA CANTIDAD DE DIGITOS NO ES 11"
            );
        }

        return json_encode($json_ruc);
    }

    public function obtener_dni()
    {
        if (strlen($this->dni) == 8) {
            $urlfinal = sprintf($this->url_dni, $this->dni);
            $json = file_get_contents($urlfinal, FALSE);
            // Check for errors
            if ($json === FALSE) {
                die('Error');
            } else {
                $array_dni = json_decode($json, true);
                $json = (object)array(
                    "success" => true,
                    "result" => $array_dni
                );
            }
        } else {
            $json = (object)array(
                "success" => false,
                "result" => "LA CANTIDAD DE DIGITOS NO ES 8"
            );
        }

        return json_encode($json);

    }

}

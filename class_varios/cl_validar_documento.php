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
class cl_validar_documento {

    private $url_ruc = "https://lunasystemsperu.com/apis/apiruc.php?ruc=";
    private $url_dni = "https://lunasystemsperu.com/apis/apidni.php?dni=";
    private $dni;
    private $ruc;

    function __construct() {
        
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function setRuc($ruc) {
        $this->ruc = $ruc;
    }

    public function obtener_ruc() {
        if (strlen($this->ruc) == 11) {
            $json_ruc = file_get_contents($this->url_ruc . $this->ruc, FALSE);
            // Check for errors
            if ($json_ruc === FALSE) {
                die('Error');
            } else {
                $array_ruc = json_decode($json_ruc, true);
                $json_ruc = (object) array(
                    "success" => true,
                    "result" => $array_ruc
                );
            }
        } else {
            $json_ruc = (object) array(
                        "success" => false,
                        "result" => "LA CANTIDAD DE DIGITOS NO ES 11"
            );
        }

        return json_encode($json_ruc);
    }

    public function obtener_dni() {
        if (strlen($this->dni) == 8) {
            $json = file_get_contents($this->url_dni . $this->dni, FALSE);
            // Check for errors
            if ($json === FALSE) {
                die('Error');
            } else {
                $array_dni = json_decode($json, true);
                $json = (object) array(
                    "success" => true,
                    "result" => $array_dni
                );
            }
        } else {
            $json = (object) array(
                        "success" => false,
                        "result" => "LA CANTIDAD DE DIGITOS NO ES 8"
            );
        }

        return json_encode($json);

    }

}

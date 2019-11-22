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

    private $url_ruc = "http://lunasystemsperu.com/consultas_json/composer/consulta_sunat_JMP.php?ruc=";
    private $url_dni = "http://lunasystemsperu.com/consultas_json/composer/consultas_dni_JMP.php?dni=";
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
            }
        } else {
            $json_ruc = (object) array(
                        "success" => false,
                        "entity" => "LA CANTIDAD DE DIGITOS NO ES 11"
            );
        }

        return $json_ruc;
    }

    public function obtener_dni() {
        if (strlen($this->dni) == 8) {
            $json = file_get_contents($this->url_dni . $this->dni, FALSE);
            // Check for errors
            if ($json === FALSE) {
                die('Error');
            }
        } else {
            $json = (object) array(
                        "success" => false,
                        "entity" => "LA CANTIDAD DE DIGITOS NO ES 8"
            );
        }

        return $json;
    }

}

<?php


class cl_documento_internet
{
    private $tipo;
    private $documento;

    /**
     * DocumentoInternet constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param mixed $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    public function validar()
    {
        $direccion = "";

        //si es ruc
        if ($this->tipo == 1) {
            $direccion = "http://www.lunasystemsperu.com/apis/apiruc.php?ruc=" . $this->documento;
        }

        //si es dni
        if ($this->tipo == 2) {
            $direccion = "http://www.lunasystemsperu.com/apis/apidni.php?dni=" . $this->documento;
            //$direccion = "http://www.lunasystemsperu.com/consultas_json/composer/consultas_dni_JMP.php?dni=" . $this->documento;
        }

        $json = file_get_contents($direccion, FALSE);
        // Check for errors
        if ($json === FALSE) {
            die('Error');
        }

        return $json;
    }
}
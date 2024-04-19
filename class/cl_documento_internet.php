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
            $direccion = "https://goempresarial.com/apis/peru-consult-api/public/api/v1/ruc/".$this->documento."?token=abcxyz";
        }

        //si es dni
        if ($this->tipo == 2) {
            //$direccion = "https://goempresarial.com/apis/peru-consult-api/public/api/v1/dni/".$this->documento."?token=abcxyz";
            $direccion = "https://goempresarial.com/apis/luna-consult/public/index.php?dni=" . $this->documento;
            //$direccion = "https://www.lunasystemsperu.com/consultas_json/composer/consultas_dni_JMP.php?dni=" . $this->documento;
        }

       // echo $direccion;

        $json = file_get_contents($direccion);
        // Check for errors
        if ($json === FALSE) {
            die('Error');
        }

        return $json;
    }
}
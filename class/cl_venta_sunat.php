<?php

include 'cl_conectar.php';

class cl_venta_sunat
{

    private $id_venta;
    private $periodo;
    private $id_empresa;
    private $hash;
    private $nombre_xml;

    /**
     * cl_venta_sunat constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdVenta()
    {
        return $this->id_venta;
    }

    /**
     * @param mixed $id_venta
     */
    public function setIdVenta($id_venta)
    {
        $this->id_venta = $id_venta;
    }

    /**
     * @return mixed
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @param mixed $periodo
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    /**
     * @return mixed
     */
    public function getIdEmpresa()
    {
        return $this->id_empresa;
    }

    /**
     * @param mixed $id_empresa
     */
    public function setIdEmpresa($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getNombreXml()
    {
        return $this->nombre_xml;
    }

    /**
     * @param mixed $nombre_xml
     */
    public function setNombreXml($nombre_xml)
    {
        $this->nombre_xml = $nombre_xml;
    }


    public function insertar()
    {
        global $conn;
        $query = "INSERT INTO ventas_sunat 
                         VALUES ($this->id_venta,
                                 $this->periodo ,
                                $this->id_empresa,
                                '$this->hash',
                                '$this->nombre_xml')";

        //echo $query;
        $resultado = $conn->query($query);

        if (!$resultado) {
            die('Could not enter data in venta: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }

}
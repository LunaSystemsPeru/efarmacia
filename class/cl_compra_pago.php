<?php

require 'cl_conectar.php';

class cl_compra_pago
{
    private $id_pago;
    private $id_compra;
    private $periodo;
    private $id_empresa;
    private $fecha;
    private $monto;

    /**
     * cl_compra_pago constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdPago()
    {
        return $this->id_pago;
    }

    /**
     * @param mixed $id_pago
     */
    public function setIdPago($id_pago)
    {
        $this->id_pago = $id_pago;
    }

    /**
     * @return mixed
     */
    public function getIdCompra()
    {
        return $this->id_compra;
    }

    /**
     * @param mixed $id_compra
     */
    public function setIdCompra($id_compra)
    {
        $this->id_compra = $id_compra;
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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * @param mixed $monto
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }

    public function verCompasPagos()
    {
        global $conn;
        $query = "select * from compra_pago where id_compra = $this->id_compra and periodo=$this->periodo and id_empresa=$this->id_empresa";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }


}

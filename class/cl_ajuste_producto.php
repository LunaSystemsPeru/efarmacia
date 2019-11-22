<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:41 PM
 */

class cl_ajuste_producto
{
    private $id_ajuste;
    private $anio;
    private $id_empresa;
    private $id_producto;
    private $cactual;
    private $cnueva;
    private $costo;
    private $venta;
    private $lote;
    private $vencimiento;

    /**
     * cl_ajuste_producto constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return mixed
     */
    public function getIdAjuste()
    {
        return $this->id_ajuste;
    }

    /**
     * @param mixed $id_ajuste
     */
    public function setIdAjuste($id_ajuste)
    {
        $this->id_ajuste = $id_ajuste;
    }

    /**
     * @return mixed
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * @param mixed $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
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
    public function getIdProducto()
    {
        return $this->id_producto;
    }

    /**
     * @param mixed $id_producto
     */
    public function setIdProducto($id_producto)
    {
        $this->id_producto = $id_producto;
    }

    /**
     * @return mixed
     */
    public function getCactual()
    {
        return $this->cactual;
    }

    /**
     * @param mixed $cactual
     */
    public function setCactual($cactual)
    {
        $this->cactual = $cactual;
    }

    /**
     * @return mixed
     */
    public function getCnueva()
    {
        return $this->cnueva;
    }

    /**
     * @param mixed $cnueva
     */
    public function setCnueva($cnueva)
    {
        $this->cnueva = $cnueva;
    }

    /**
     * @return mixed
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * @param mixed $costo
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;
    }

    /**
     * @return mixed
     */
    public function getVenta()
    {
        return $this->venta;
    }

    /**
     * @param mixed $venta
     */
    public function setVenta($venta)
    {
        $this->venta = $venta;
    }

    /**
     * @return mixed
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * @param mixed $lote
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
    }

    /**
     * @return mixed
     */
    public function getVencimiento()
    {
        return $this->vencimiento;
    }

    /**
     * @param mixed $vencimiento
     */
    public function setVencimiento($vencimiento)
    {
        $this->vencimiento = $vencimiento;
    }


}
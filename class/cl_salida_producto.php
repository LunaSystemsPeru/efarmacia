<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:36 PM
 */

class cl_salida_producto
{

    private $id_salida;
    private $perido;
    private $id_empresa;
    private $id_producto;
    private $cantidad;
    private $costo;
    private $venta;
    private $lote;
    private $vencimiento;

    /**
     * cl_salida_producto constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdSalida()
    {
        return $this->id_salida;
    }

    /**
     * @param mixed $id_salida
     */
    public function setIdSalida($id_salida)
    {
        $this->id_salida = $id_salida;
    }

    /**
     * @return mixed
     */
    public function getPerido()
    {
        return $this->perido;
    }

    /**
     * @param mixed $perido
     */
    public function setPerido($perido)
    {
        $this->perido = $perido;
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
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
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
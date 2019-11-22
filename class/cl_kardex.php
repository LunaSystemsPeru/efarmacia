<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:27 PM
 */

include 'cl_conectar.php';

class cl_kardex
{
    private $fecha;
    private $id_empresa;
    private $id_producto;

    /**
     * cl_kardex constructor.
     */
    public function __construct()
    {
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

    function ver_kardex_diario()
    {
        global $conn;
        $query = "select p.nombre, kp.lote, kp.vcto, kp.c_ingresa, kp.c_sale, kp.cu_sale, kp.cu_ingresa, km.nombre as movimiento, kp.id_registro, kp.serie_doc, kp.numero_doc "
            . "from kardex_producto kp "
            . "inner join producto p on p.id_producto = kp.id_producto and p.id_empresa = kp.id_empresa "
            . "inner join kardex_movimiento km on km.id_movimiento = kp.id_movimiento "
            . "where kp.id_empresa = '" . $this->id_empresa . "' and kp.fecha = '" . $this->fecha . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
<?php

include 'cl_conectar.php';

class cl_ventas_referencias
{
    private $id_nota;
    private $id_venta;
    private $id_motivo;
    private $conectar;

    /**
     * VentaReferencia constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getIdNota()
    {
        return $this->id_nota;
    }

    /**
     * @param mixed $id_nota
     */
    public function setIdNota($id_nota)
    {
        $this->id_nota = $id_nota;
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
    public function getIdMotivo()
    {
        return $this->id_motivo;
    }

    /**
     * @param mixed $id_motivo
     */
    public function setIdMotivo($id_motivo)
    {
        $this->id_motivo = $id_motivo;
    }

    public function obtenerDatos()
    {
        global $conn;
        $sql = "select * 
        from ventas_referencias 
        where id_venta = '$this->id_nota'";
        $fila = $conn->query($sql)->fetch_assoc();
        $this->id_venta = $fila['id_referencia'];
        $this->id_motivo = $fila['id_motivo'];
    }

    public function insertar()
    {
        global $conn;
        $sql = "insert into ventas_referencias 
        values ('$this->id_nota', '$this->id_venta', '$this->id_motivo')";
        return $conn->query($sql);
    }
}
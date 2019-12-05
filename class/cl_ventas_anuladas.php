<?php

include 'cl_conectar.php';

class cl_ventas_anuladas
{
    private $venta_id_venta;
    private $periodo;
    private $id_empresa;
    private $fecha;
    private $motivo;

    /**
     * VentaAnulada constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getVentaIdVenta()
    {
        return $this->venta_id_venta;
    }

    /**
     * @param mixed $venta_id_venta
     */
    public function setVentaIdVenta($venta_id_venta)
    {
        $this->venta_id_venta = $venta_id_venta;
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
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param mixed $motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }


    public function insertar()
    {
        global $conn;
        $sql = "insert into ventas_anuladas 
        values ('$this->venta_id_venta', '$this->periodo', '$this->id_empresa','$this->fecha','$this->motivo')";
        return $conn->query($sql);

    }

    public function verFacturasAnuladas($id_empresa)
    {
        global $conn;

        $sql = "SELECT v.id_venta, v.fecha, va.fecha AS fecha_anulado, ds.cod_sunat, ds.abreviatura, v.serie, v.numero, c.documento, c.nombre, v.total, v.estado, v.id_documento, v.enviado_sunat, v.estado
        FROM ventas_anuladas AS va 
            INNER JOIN venta AS v ON v.id_venta = va.venta_id_venta 
            INNER JOIN documentos_sunat ds ON v.id_documento = ds.id_documento
            INNER JOIN cliente c ON v.id_cliente = c.id_cliente 
        where v.id_empresa = '$id_empresa' and v.fecha = '$this->fecha' and v.id_documento = 3 ";
        $resultado = $conn->query($sql);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
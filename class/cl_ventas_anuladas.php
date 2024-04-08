<?php

include 'cl_conectar.php';

class cl_ventas_anuladas
{
    private $venta_id_venta;
    private $periodo;
    private $id_empresa;
    private $fecha;
    private $motivo;
    private $enviado_sunat;

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

    public function verResumenAnuladas()
    {
        global $conn;

        $sql = "SELECT v.id_venta, v.periodo, v.fecha, va.fecha AS fecha_anulado, ds.cod_sunat, ds.abreviatura, v.serie, v.numero, c.documento, c.nombre, v.total, v.estado, v.id_documento, v.enviado_sunat, v.estado
        FROM ventas_anuladas AS va 
            INNER JOIN venta AS v ON v.id_venta = va.venta_id_venta and va.id_empresa = v.id_empresa and va.periodo = v.periodo
            INNER JOIN documentos_sunat ds ON v.id_documento = ds.id_documento
            INNER JOIN cliente c ON v.id_cliente = c.id_cliente and v.id_empresa = c.id_empresa
        where v.id_empresa = '$this->id_empresa' and va.fecha = '$this->fecha' and v.serie like 'B%' and v.estado = 2 
         order by fecha_anulado asc";

        echo $sql;
        $resultado = $conn->query($sql);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    public function verFacturasAnuladas()
    {
        global $conn;
        $sql = "SELECT v.id_venta, v.fecha, va.fecha AS fecha_anulado, ds.cod_sunat, ds.abreviatura, v.serie, v.numero, c.documento, c.nombre, v.total, v.estado, v.id_documento, v.enviado_sunat, v.estado
        FROM ventas_anuladas AS va 
            INNER JOIN venta AS v ON v.id_venta = va.venta_id_venta and va.periodo = v.periodo and v.id_empresa = va.id_empresa
            INNER JOIN documentos_sunat ds ON v.id_documento = ds.id_documento
            INNER JOIN cliente c ON v.id_cliente = c.id_cliente and v.id_empresa = c.id_empresa
        where v.id_empresa = '$this->id_empresa' and va.fecha = '$this->fecha' and v.serie like 'F%' and v.estado = 2 ";
        $resultado = $conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function verFechasAnuladasPendientes()
    {
        global $conn;
        $sql = "select distinct(v.fecha) as fecha 
                from venta as v 
                where v.estado = '2' and v.enviado_sunat = '2' and v.id_empresa = '$this->id_empresa'";
        $resultado = $conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function verComprobantesAnuladosFecha()
    {
        global $conn;
        $sql = "select count(*) as cantidad_comprobantes, va.fecha as fecha_anulacion, v.fecha as fecha_venta, va.id_empresa, v.id_documento
                from ventas_anuladas va 
                inner join venta as v on v.id_empresa = va.id_empresa and v.periodo = va.periodo and v.id_venta = va.venta_id_venta
                where va.fecha = '$this->fecha'  and v.id_documento != '1'
                group by va.fecha, v.fecha, va.id_empresa, v.id_documento;";
        $resultado = $conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
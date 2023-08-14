<?php
require '../class/cl_conectar.php';

class cl_reporte_venta
{
    private $fechainicio;
    private $fechafinal;
    private $idempresa;
    private $idsucursal;

    /**
     * cl_reporte_venta constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param mixed $fechainicio
     */
    public function setFechainicio($fechainicio): void
    {
        $this->fechainicio = $fechainicio;
    }

    /**
     * @param mixed $fechafinal
     */
    public function setFechafinal($fechafinal): void
    {
        $this->fechafinal = $fechafinal;
    }

    /**
     * @param mixed $idempresa
     */
    public function setIdempresa($idempresa): void
    {
        $this->idempresa = $idempresa;
    }

    /**
     * @param mixed $idsucursal
     */
    public function setIdsucursal($idsucursal): void
    {
        $this->idsucursal = $idsucursal;
    }

    /**
     * @return mixed
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * @return mixed
     */
    public function getFechafinal()
    {
        return $this->fechafinal;
    }

    /**
     * @return mixed
     */
    public function getIdempresa()
    {
        return $this->idempresa;
    }

    /**
     * @return mixed
     */
    public function getIdsucursal()
    {
        return $this->idsucursal;
    }

    public function verReporteVentaProductos()
    {
        global $conn;
        $sql = "select v.fecha, ds.abreviatura, v.serie, v.numero, s.nombre as nsucursal, c.nombre as ncliente, c.documento, p.nombre as nproducto, vp.lote, vp.cantidad, p.costo, vp.precio, v.estado 
                from venta_producto as vp
                inner join producto as p on p.id_producto = vp.id_producto and p.id_empresa = vp.id_empresa
                inner join venta as v on v.id_venta = vp.id_venta and v.periodo = vp.periodo and v.id_empresa = vp.id_empresa
                inner join cliente as c on c.id_cliente = v.id_cliente and c.id_empresa = v.id_empresa
                inner join documentos_sunat as ds on ds.id_documento = v.id_documento
                inner join sucursales as s on s.id_sucursal = v.id_sucursal and s.id_empresa = v.id_empresa
                where v.fecha BETWEEN '$this->fechainicio' and '$this->fechafinal' and v.id_empresa = '$this->idempresa' and v.estado = 1";
        //echo $sql;
        $resultado = $conn->query($sql);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    public function verVentasProductos () {
        global $conn;
        $sql = "select s.nombre as ntienda, p.nombre as nproducto, vp.lote, vp.vcto, sum(vp.cantidad) as cantidad, p.costo, vp.precio
                from venta_producto as vp
                inner join venta as v on v.id_venta = vp.id_venta and v.periodo = vp.periodo and v.id_empresa = vp.id_empresa
                inner join producto as p on p.id_producto = vp.id_producto and p.id_empresa = vp.id_empresa
                inner join sucursales as s on s.id_sucursal = v.id_sucursal and s.id_empresa = v.id_empresa
                where v.fecha BETWEEN '$this->fechainicio' and '$this->fechafinal' and v.id_empresa = 3 and v.estado = 1
                GROUP by v.id_sucursal, vp.id_producto, vp.precio
                order by p.nombre, s.nombre";
        $resultado = $conn->query($sql);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
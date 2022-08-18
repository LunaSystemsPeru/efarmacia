<?php
require '../class/cl_conectar.php';

class cl_reporte_inventario
{
private $empresaid;

    /**
     * cl_reporte_inventario constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getEmpresaid()
    {
        return $this->empresaid;
    }

    /**
     * @param mixed $empresaid
     */
    public function setEmpresaid($empresaid): void
    {
        $this->empresaid = $empresaid;
    }

    function verIngresosProductosIndividuales()
    {
        global $conn;
        $query = "select i.fecha, i.id_documento, p.documento, p.nombre as proveedor, ds.nombre as documentos_sunat, i.serie, i.numero, u.username, ip.id_producto, pr.nombre, pr.id_laboratorio, lb.nombre as laboratorio, pr.id_presentacion, ps.nombre as presentacion, ip.lote, ip.vcto, ip.cantidad, ip.costo, ip.precio
                from ingreso_producto as ip 
                inner join ingreso as i on i.periodo = ip.periodo and ip.id_ingreso = i.id_ingreso and ip.id_empresa = i.id_empresa
                inner join producto as pr on pr.id_producto = ip.id_producto and pr.id_empresa = ip.id_empresa
                inner join documentos_sunat as ds on ds.id_documento = i.id_documento
                inner join proveedor as p on p.id_proveedor = i.id_proveedor
                inner join presentacion as ps on ps.id_presentacion = pr.id_presentacion
                inner join laboratorio as lb on lb.id_laboratorio = pr.id_laboratorio
                inner join usuario as u on u.id_usuario = i.id_usuario and u.id_empresa = i.id_empresa
                where i.id_empresa = '$this->id_empresa'
                order by i.fecha asc ";

        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
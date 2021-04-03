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
    private $id_surcursal;

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

    /**
     * @return mixed
     */
    public function getIdSurcursal()
    {
        return $this->id_surcursal;
    }

    /**
     * @param mixed $id_surcursal
     */
    public function setIdSurcursal($id_surcursal)
    {
        $this->id_surcursal = $id_surcursal;
    }

    function ver_kardex_diario()
    {
        global $conn;
        $query = "select kp.id_kardex, kp.id_producto, p.nombre, pr.nombre as presentacion, lb.nombre as laboratorio, kp.lote, kp.vcto, kp.id_registro, km.nombre as movimiento, ds.abreviatura as doc_sunat, kp.serie_doc, kp.numero_doc, kp.c_ingresa, kp.c_sale, kp.cu_ingresa, kp.cu_sale, s.nombre as nsucursal 
        from kardex_producto as kp
        inner join producto as p on p.id_producto = kp.id_producto and p.id_empresa = kp.id_empresa
        inner join sucursales s on kp.id_sucursal = s.id_sucursal
        inner join laboratorio as lb on lb.id_laboratorio = p.id_laboratorio
        inner join presentacion as pr on pr.id_presentacion = p.id_presentacion
        inner join kardex_movimiento as km on km.id_movimiento = kp.id_movimiento
        inner join documentos_sunat as ds on ds.id_documento = kp.id_documento
        where kp.id_empresa = '$this->id_empresa' and kp.fecha = '$this->fecha'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_kardex_producto()
    {
        global $conn;
        $query = "select kp.id_kardex, kp.fecha, kp.id_producto, kp.lote, kp.vcto, kp.id_registro, km.nombre as movimiento, ds.abreviatura as doc_sunat, kp.serie_doc, kp.numero_doc, kp.c_ingresa, kp.c_sale, kp.cu_ingresa, kp.cu_sale 
        from kardex_producto as kp
        inner join kardex_movimiento as km on km.id_movimiento = kp.id_movimiento
        inner join documentos_sunat as ds on ds.id_documento = kp.id_documento
        where kp.id_empresa = '$this->id_empresa' and kp.id_producto = '$this->id_producto' and kp.id_sucursal = '$this->id_surcursal' 
        order by kp.fecha asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:09 PM
 */

include 'cl_conectar.php';

class cl_venta_productos
{

    private $id_empresa;
    private $id_venta;
    private $periodo;
    private $id_producto;
    private $costo;
    private $venta;
    private $lote;
    private $vencimiento;
    private $cantidad;

    /**
     * cl_venta_productos constructor.
     */
    public function __construct()
    {
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

    public function insertar()
    {
        global $conn;
        $query = "insert into venta_producto values ('" . $this->id_venta . "', '" . $this->periodo . "', '" . $this->id_empresa . "', '" . $this->id_producto . "', '" . $this->lote . "', '" . $this->vencimiento . "', "
            . "'" . $this->cantidad . "', '" . $this->costo . "', '" . $this->venta . "')";
        //echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in venta_producto: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }

    public function eliminar()
    {
        global $conn;
        $query = "delete from venta_producto  
        where id_venta = '$this->id_venta' and id_empresa = '$this->id_empresa' and periodo = '$this->periodo'";
        //echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in venta_producto: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }

    function ver_productos()
    {
        global $conn;
        $query = "SELECT p.id_producto, p.nombre, l.nombre AS laboratorio, p2.nombre AS presentacion, vp.vcto, vp.lote, vp.cantidad, vp.costo, vp.precio 
                FROM venta_producto vp 
                    INNER JOIN producto p ON vp.id_producto = p.id_producto AND vp.id_empresa = p.id_empresa 
                    INNER JOIN laboratorio l ON p.id_laboratorio = l.id_laboratorio 
                    INNER JOIN presentacion p2 ON p.id_presentacion = p2.id_presentacion
                where vp.id_venta = '" . $this->id_venta . "' and vp.periodo = '" . $this->periodo . "' and vp.id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function ver_utilidad()
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, l.nombre as laboratorio, p2.nombre as presentacion, sum(vp.cantidad) as cvendido, vp.precio, p.precio as preventa, p.costo
        from venta_producto as vp
        inner join producto p on vp.id_producto = p.id_producto and vp.id_empresa = p.id_empresa
        inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
        inner join presentacion p2 on p.id_presentacion = p2.id_presentacion
        inner join venta v on vp.id_venta = v.id_venta and vp.periodo = v.periodo and vp.id_empresa = v.id_empresa
        where vp.id_empresa = '$this->id_empresa' and year(v.fecha) = year(curdate())
        group by vp.precio, vp.id_producto
        order by p.nombre asc, l.nombre asc, p.nombre asc, vp.precio asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);

    }

    function ver_utilidad_sucursal()
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, l.nombre as laboratorio, p2.nombre as presentacion, sum(vp.cantidad) as cvendido, vp.precio, p.precio as preventa, p.costo
        from venta_producto as vp
        inner join producto p on vp.id_producto = p.id_producto and vp.id_empresa = p.id_empresa
        inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
        inner join presentacion p2 on p.id_presentacion = p2.id_presentacion
        inner join venta v on vp.id_venta = v.id_venta and vp.periodo = v.periodo and vp.id_empresa = v.id_empresa
        where vp.id_empresa = '$this->id_empresa' and year(v.fecha) = year(curdate())
        group by vp.precio, vp.id_producto
        order by p.nombre asc, l.nombre asc, p.nombre asc, vp.precio asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);

    }

    function ver_utilidad_periodo()
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, l.nombre as laboratorio, p2.nombre as presentacion, sum(vp.cantidad) as cvendido, vp.precio, p.precio as preventa, p.costo
        from venta_producto as vp
             inner join producto p on vp.id_producto = p.id_producto and vp.id_empresa = p.id_empresa
             inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
             inner join presentacion p2 on p.id_presentacion = p2.id_presentacion
             inner join venta v on vp.id_venta = v.id_venta and vp.periodo = v.periodo and vp.id_empresa = v.id_empresa
        where v.id_sucursal = '$this->id_empresa' and v.periodo = '$this->periodo'
        group by vp.precio, vp.id_producto
        order by p.nombre asc, l.nombre asc, p.nombre asc, vp.precio asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);

    }

    function ver_utilidad_periodo_sucursal($idsucursal)
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, l.nombre as laboratorio, p2.nombre as presentacion, sum(vp.cantidad) as cvendido, vp.precio, p.precio as preventa, p.costo
                from venta_producto as vp
                         inner join producto p on vp.id_producto = p.id_producto and vp.id_empresa = p.id_empresa
                         inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
                         inner join presentacion p2 on p.id_presentacion = p2.id_presentacion
                         inner join venta v on vp.id_venta = v.id_venta and vp.periodo = v.periodo and vp.id_empresa = v.id_empresa
                         inner join sucursales s on v.id_sucursal = s.id_sucursal
                where v.id_sucursal = '$idsucursal' and v.periodo = '$this->periodo'
                group by vp.precio, vp.id_producto
                order by p.nombre asc, l.nombre asc, p.nombre asc, vp.precio asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);

    }

}
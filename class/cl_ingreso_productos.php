<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:06 PM
 */

include 'cl_conectar.php';

class cl_ingreso_productos
{

    private $id_empresa;
    private $id_ingreso;
    private $periodo;
    private $id_producto;
    private $cantidad;
    private $costo;
    private $venta;
    private $lote;
    private $vencimiento;

    /**
     * cl_ingreso_productos constructor.
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
    public function getIdIngreso()
    {
        return $this->id_ingreso;
    }

    /**
     * @param mixed $id_ingreso
     */
    public function setIdIngreso($id_ingreso)
    {
        $this->id_ingreso = $id_ingreso;
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

    public function insertar()
    {
        global $conn;
        $query = "insert into ingreso_producto values ('" . $this->periodo . "', '" . $this->id_ingreso . "', '" . $this->id_empresa . "', '" . $this->id_producto . "', '" . $this->lote . "', '" . $this->vencimiento . "', "
            . "'" . $this->cantidad . "', '" . $this->costo . "', '" . $this->venta . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in ingreso_producto: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    public function eliminar()
    {
        global $conn;
        $query = "delete from ingreso_producto 
        where periodo = '$this->periodo' and id_ingreso = '$this->id_ingreso' and id_empresa = '$this->id_empresa'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in ingreso_producto: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_productos()
    {
        global $conn;
        $query = "select p.nombre, p.principio_activo, l.nombre as laboratorio, p2.nombre as presentacion, i.vcto, i.lote, i.cantidad, i.costo, i.precio "
            . "from ingreso_producto i "
            . "inner join producto p on i.id_producto = p.id_producto and i.id_empresa = p.id_empresa  "
            . "inner join laboratorio l on p.id_laboratorio = l.id_laboratorio "
            . "inner join presentacion p2 on p.id_presentacion = p2.id_presentacion "
            . "where i.id_ingreso = '" . $this->id_ingreso . "' and i.periodo = '" . $this->periodo . "' and i.id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_historia_compra_miproducto($idsucursal)
    {
        global $conn;
        $query = "select i.fecha, ds.abreviatura ,i.serie, i.numero, p.nombre, ip.cantidad, ip.costo, ip.lote, ip.precio, ip.vcto   
                    from ingreso_producto as ip 
                    inner join ingreso i on ip.periodo = i.periodo and ip.id_ingreso = i.id_ingreso and ip.id_empresa = i.id_empresa 
                    inner join proveedor p on i.id_proveedor = p.id_proveedor and i.id_empresa = p.id_empresa
                    inner join documentos_sunat ds on i.id_documento = ds.id_documento
                    where ip.id_producto = '$this->id_producto' and i.id_empresa = '$this->id_empresa' and i.id_sucursal = '$idsucursal'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function verTodosIngresos()
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
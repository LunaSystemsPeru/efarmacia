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

    function ver_productos()
    {
        global $conn;
        $query = "SELECT p.id_producto, p.nombre, p.principio_activo, l.nombre AS laboratorio, p2.nombre AS presentacion, vp.vcto, vp.lote, vp.cantidad, vp.costo, vp.precio 
                FROM venta_producto vp 
                    INNER JOIN producto p ON vp.id_producto = p.id_producto AND vp.id_empresa = p.id_empresa  
                    INNER JOIN laboratorio l ON p.id_laboratorio = l.id_laboratorio 
                    INNER JOIN presentacion p2 ON p.id_presentacion = p2.id_presentacion
                where vp.id_venta = '" . $this->id_venta . "' and vp.periodo = '" . $this->periodo . "' and vp.id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:41 PM
 */

require 'cl_conectar.php';

class cl_ajuste_producto
{
    private $id_ajuste;
    private $id_empresa;
    private $id_producto;
    private $cactual;
    private $cnueva;
    private $costo;
    private $venta;
    private $lote;
    private $vencimiento;
    private $id_sucursal;

    /**
     * @return mixed
     */
    public function getIdSucursal() {
        return $this->id_sucursal;
    }

    /**
     * @param mixed $id_sucursal
     */
    public function setIdSucursal($id_sucursal) {
        $this->id_sucursal = $id_sucursal;
    }


    /**
     * cl_ajuste_producto constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return mixed
     */
    public function getIdAjuste()
    {
        return $this->id_ajuste;
    }

    /**
     * @param mixed $id_ajuste
     */
    public function setIdAjuste($id_ajuste)
    {
        $this->id_ajuste = $id_ajuste;
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
    public function getCactual()
    {
        return $this->cactual;
    }

    /**
     * @param mixed $cactual
     */
    public function setCactual($cactual)
    {
        $this->cactual = $cactual;
    }

    /**
     * @return mixed
     */
    public function getCnueva()
    {
        return $this->cnueva;
    }

    /**
     * @param mixed $cnueva
     */
    public function setCnueva($cnueva)
    {
        $this->cnueva = $cnueva;
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
        $query = "insert into invenvario_productos values ('$this->id_ajuste', '$this->id_producto', '$this->id_empresa', '$this->cactual', '$this->cnueva', '$this->costo', '$this->venta', '$this->lote', '$this->vencimiento')";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in invenvario_productos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function verFilas()
    {
        global $conn;
        $query = "select ip.id_producto,ip.vcto, ip.lote, ip.venta, ip.costo, ip.cactual, ip.cnueva, p.nombre, p2.nombre as presentacion, l.nombre as laboratorio  
        from invenvario_productos as ip 
        inner join producto p on ip.id_producto = p.id_producto and ip.id_empresa = p.id_empresa 
        inner join presentacion p2 on p.id_presentacion = p2.id_presentacion 
        inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
        where ip.id_inventario = '$this->id_ajuste' ";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
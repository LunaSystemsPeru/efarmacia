<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 17/03/2019
 * Time: 01:07 PM
 */

class cs_productos_venta
{
    private $id_producto;
    private $descripcion;
    private $cantidad;
    private $costo;
    private $precio;
    private $lote;
    private $vcto;

    /**
     * cs_productos_venta constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param mixed $id_producto
     */
    public function setIdProducto($id_producto)
    {
        $this->id_producto = $id_producto;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @param mixed $costo
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @param mixed $lote
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
    }

    /**
     * @param mixed $vcto
     */
    public function setVcto($vcto)
    {
        $this->vcto = $vcto;
    }

    function agregar()
    {
        $_SESSION['productos_venta'][$this->id_producto] = array(
            'id_producto' => $this->id_producto,
            'descripcion' => $this->descripcion,
            'cantidad' => $this->cantidad,
            'precio' => $this->precio,
            'costo' => $this->costo,
            'lote' => $this->lote,
            'vcto' => $this->vcto,
        );
    }

    function eliminar()
    {
        unset($_SESSION['productos_venta'][$this->id_producto]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 17/03/2019
 * Time: 12:09 AM
 */

class cs_productos_ingreso
{
    private $id_producto;
    private $descripcion;
    private $cantidad;
    private $costo;
    private $precio;
    private $lote;
    private $vcto;

    /**
     * cs_productos_ingreso constructor.
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
        $_SESSION['productos_ingreso'][$this->id_producto] = array(
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
        unset($_SESSION['productos_ingreso'][$this->id_producto]);
    }

    function obtener_total() {
        $array_detalle = $_SESSION['productos_ingreso'];
        $total = 0;
        foreach ($array_detalle as $value) {
            $t_cantidad = $value['cantidad'];
            $t_costo = $value['costo'];
            $t_parcial = $t_cantidad * $t_costo;
            $total = $total + $t_parcial;
        }
        return $total;
    }
}
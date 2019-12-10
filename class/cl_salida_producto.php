<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:36 PM
 */

class cl_salida_producto
{

    private $id_salida;
    private $id_empresa;
    private $id_producto;
    private $cantidad;
    private $costo;

    /**
     * @return mixed
     */
    public function getIdSalida()
    {
        return $this->id_salida;
    }

    /**
     * @param mixed $id_salida
     */
    public function setIdSalida($id_salida)
    {
        $this->id_salida = $id_salida;
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

    public function insertar()
    {
        global $conn;
        $query = "INSERT INTO salidas_productos         
                    VALUES ('$this->id_salida',
                            '$this->id_empresa',
                            '$this->id_producto',
                            '$this->cantidad',
                            '$this->costo')";
        $resultado = $conn->query($query);

        echo $query;
        if (!$resultado) {
            die('Could not enter data in salida: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }


}
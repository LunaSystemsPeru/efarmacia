<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 18/03/2019
 * Time: 05:12 PM
 */

class cl_venta_cobros
{
    private $id_venta;
    private $periodo;
    private $id_empresa;
    private $id_cobro;
    private $fecha;
    private $monto;

    /**
     * cl_venta_cobros constructor.
     */
    public function __construct()
    {
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
    public function getIdCobro()
    {
        return $this->id_cobro;
    }

    /**
     * @param mixed $id_cobro
     */
    public function setIdCobro($id_cobro)
    {
        $this->id_cobro = $id_cobro;
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
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * @param mixed $monto
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_cobro) + 1, 1) as codigo "
            . "from ventas_cobro "
            . "where periodo = '" . $this->periodo . "' and id_empresa = '" . $this->id_empresa . "' and id_venta = '" . $this->id_venta . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_cobro = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into ventas_cobro values ('" . $this->id_venta . "', '" . $this->periodo . "', '" . $this->id_empresa . "', '" . $this->id_cobro . "', '" . $this->fecha . "', '" . $this->monto . "')";
        //echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in ventas_cobro: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }
}
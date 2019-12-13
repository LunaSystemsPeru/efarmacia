<?php

require 'cl_conectar.php';

class cl_compra_pago
{
    private $id_pago;
    private $id_compra;
    private $periodo;
    private $id_empresa;
    private $fecha;
    private $monto;
    private $id_movimiento;

    /**
     * cl_compra_pago constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdMovimiento()
    {
        return $this->id_movimiento;
    }

    /**
     * @param mixed $id_movimiento
     */
    public function setIdMovimiento($id_movimiento)
    {
        $this->id_movimiento = $id_movimiento;
    }


    /**
     * @return mixed
     */
    public function getIdPago()
    {
        return $this->id_pago;
    }

    /**
     * @param mixed $id_pago
     */
    public function setIdPago($id_pago)
    {
        $this->id_pago = $id_pago;
    }

    /**
     * @return mixed
     */
    public function getIdCompra()
    {
        return $this->id_compra;
    }

    /**
     * @param mixed $id_compra
     */
    public function setIdCompra($id_compra)
    {
        $this->id_compra = $id_compra;
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

    public function obtener_codigo() {
        global $conn;
        $query = "select ifnull(max(id_pago) + 1, 1) as codigo 
        from compra_pago ";

        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_pago = $fila ['codigo'];
            }
        }
    }

    public function insertar() {
        global $conn;
        $query = "INSERT INTO compra_pago
                    VALUES ('$this->id_pago',
                            '$this->id_compra',
                            '$this->periodo',
                            '$this->id_empresa',
                            '$this->fecha',
                            '$this->monto',
                            '$this->id_movimiento')";

        $resultado = $conn->query($query);

        if (!$resultado) {
            die('Could not enter data in compra_pago: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }


        return $grabado;
    }
    public function eliminar()
    {
        global $conn;
        $query = "delete from compra_pago where  id_pago='{$this->id_pago}'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in compra_pago: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }

    public function obtenerDatos(){
        $existe = false;
        global $conn;
        $query = "SELECT * FROM compra_pago WHERE id_pago=".$this->id_pago;

        $resultado = $conn->query($query);

        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_pago;
                            $this->id_compra=$fila["id_compra"];
                            $this->periodo=$fila["periodo"];
                            $this->id_empresa=$fila["id_empresa"];
                            $this->fecha=$fila["fecha"];
                            $this->monto=$fila["monto"];
                            $this->id_movimiento=$fila["id_movimiento"];
            }
        }
        return $existe;
    }

    public function verCompasPagos()
    {
        global $conn;
        $query = "SELECT comp.*,ba.nombre AS banco  
                    FROM compra_pago AS comp 
                        INNER JOIN bancos_movimientos AS bm ON comp.id_movimiento= bm.id_movimiento
                        INNER JOIN bancos AS ba ON bm.id_banco = ba.id_banco  
                    where comp.id_compra = $this->id_compra and comp.periodo=$this->periodo and comp.id_empresa=$this->id_empresa";

        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }


}

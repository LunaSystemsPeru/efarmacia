<?php

include 'cl_conectar.php';
class cl_salida
{
    private $id_salida;
    private $id_empresa;
    private $fecha;
    private $id_proveedor;
    private $id_usuario;
    private $total;

    /**
     * cl_salida constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

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
    public function getIdProveedor()
    {
        return $this->id_proveedor;
    }

    /**
     * @param mixed $id_proveedor
     */
    public function setIdProveedor($id_proveedor)
    {
        $this->id_proveedor = $id_proveedor;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_salida) + 1, 1) as codigo 
                    from salidas where  id_empresa = '" . $this->id_empresa . "'";

        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0)
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_salida = $fila ['codigo'];

        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into salidas values ('$this->id_salida',
             '$this->id_empresa',
             '$this->fecha',
             '$this->id_proveedor',
             '$this->id_usuario',
             '$this->total')";
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

    function ver_salidas()
    {
        global $conn;
        $query = "SELECT sa.*, pro.nombre AS proveedor, pro.documento, us.nombre  AS usuario
                    FROM salidas AS sa
                        INNER JOIN proveedor AS pro ON pro.id_proveedor = sa.id_proveedor AND pro.id_empresa=sa.id_empresa
                        INNER JOIN usuario AS us ON us.id_usuario= sa.id_usuario AND us.id_empresa= sa.id_empresa
                    WHERE sa.id_empresa = '$this->id_empresa'
                    ORDER BY sa.fecha ASC";

        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    public function eliminar()
    {
        global $conn;
        $query = "delete from salidas  where  id_salida= '$this->id_salida' and id_empresa = '$this->id_empresa'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in ingreso: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }


}
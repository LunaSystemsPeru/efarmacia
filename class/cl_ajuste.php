<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:38 PM
 */

require 'cl_conectar.php';

class cl_ajuste
{
    private $id_ajuste;
    private $anio;
    private $id_empresa;
    private $fecha;
    private $id_usuario;
    private $monto;
    private $id_sucursal;

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
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * @param mixed $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
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

    /**
     * @return mixed
     */
    public function getIdSucursal()
    {
        return $this->id_sucursal;
    }

    /**
     * @param mixed $id_sucursal
     */
    public function setIdSucursal($id_sucursal)
    {
        $this->id_sucursal = $id_sucursal;
    }

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_inventario) + 1, 1) as codigo 
            from inventario ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_ajuste = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into inventario values ('$this->id_ajuste', '$this->anio', '$this->fecha', '$this->id_usuario', '$this->id_empresa', 0, '$this->id_sucursal')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in inventario: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    public function obtener_datos()
    {
        $existe = false;
        global $conn;
        $query = "select * from inventario where id_inventario = '$this->id_ajuste'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->anio = $fila['anio'];
                $this->fecha = $fila['fecha'];
                $this->id_usuario = $fila['id_usuario'];
                $this->id_empresa = $fila['id_empresa'];
                $this->monto = $fila['monto'];
                $this->id_sucursal = $fila['id_sucursal'];
            }
        }
        return $existe;
    }

    function verFilas()
    {
        global $conn;
        $query = "select i.id_inventario, i.fecha,i.anio, u.username, i.monto  
        from inventario as i 
        inner join usuario u on i.id_usuario = u.id_usuario and i.id_empresa = u.id_empresa 
        where i.id_empresa = '$this->id_empresa' and i.id_sucursal = '$this->id_sucursal' ";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

}
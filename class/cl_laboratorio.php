<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:51 PM
 */
include 'cl_conectar.php';
class cl_laboratorio
{

    private $id_laboratorio;
    private $nombre;

    /**
     * cl_laboratorio constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdLaboratorio()
    {
        return $this->id_laboratorio;
    }

    /**
     * @param mixed $id_laboratorio
     */
    public function setIdLaboratorio($id_laboratorio)
    {
        $this->id_laboratorio = $id_laboratorio;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = strtoupper($nombre);
    }

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_laboratorio) + 1, 1) as codigo "
            . "from laboratorio ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_laboratorio = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into laboratorio values ('".$this->id_laboratorio."', '".$this->nombre."')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in laboratorio: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    public function modificar()
    {
        global $conn;
        $query = "update laboratorio 
        set nombre = '$this->nombre' 
        where id_laboratorio = '$this->id_laboratorio'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not modify data in laboratorio: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    public function obtener_datos() {
        $existe = false;
        global $conn;
        $query = "select * from laboratorio where id_laboratorio = '" . $this->id_laboratorio . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila['nombre'];
            }
        }
        return $existe;
    }

    function ver_laboratorios() {
        global $conn;
        $query = "select * from laboratorio "
            . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
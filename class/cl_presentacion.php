<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:52 PM
 */

include 'cl_conectar.php';

class cl_presentacion
{
    private $id_presentacion;
    private $nombre;
    private $abreviatura;

    /**
     * cl_presentacion constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdPresentacion()
    {
        return $this->id_presentacion;
    }

    /**
     * @param mixed $id_presentacion
     */
    public function setIdPresentacion($id_presentacion)
    {
        $this->id_presentacion = $id_presentacion;
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
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * @param mixed $abreviatura
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;
    }

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_presentacion) + 1, 1) as codigo "
            . "from presentacion ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_presentacion = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into presentacion values ('".$this->id_presentacion."', '".$this->nombre."', '".$this->abreviatura."')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in presentacion: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        $conn->close();
        return $grabado;
    }

    public function obtener_datos() {
        $existe = false;
        global $conn;
        $query = "select * from presentacion where id_presentacion = '" . $this->id_presentacion . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila['nombre'];
                $this->abreviatura = $fila['abreviatura'];
            }
        }
        return $existe;
    }

    function ver_presentaciones() {
        global $conn;
        $query = "select * from presentacion "
            . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }


}
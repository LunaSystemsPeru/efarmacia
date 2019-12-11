<?php

require 'cl_conectar.php';

class cl_movimiento_banco_tipo
{

    private $id_tipo;
    private $nombre;

    /**
     * cl_movimiento_banco_tipo constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdTipo()
    {
        return $this->id_tipo;
    }

    /**
     * @param mixed $id_tipo
     */
    public function setIdTipo($id_tipo)
    {
        $this->id_tipo = $id_tipo;
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

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_tipo) + 1, 1) as codigo 
        from bancos_movimientos_tipo ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_tipo = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into bancos_movimientos_tipo values ('$this->id_tipo', '$this->nombre')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in bancos_movimientos_tipo: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }


    function verFilas()
    {
        global $conn;
        $query = "select * 
            from bancos_movimientos_tipo";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
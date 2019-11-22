<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:49 PM
 */

include 'cl_conectar.php';

class cl_documentos_sunat
{

    private $id_documento;
    private $nombre;
    private $abreviatura;
    private $cod_sunat;

    /**
     * cl_documentos_sunat constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdDocumento()
    {
        return $this->id_documento;
    }

    /**
     * @param mixed $id_documento
     */
    public function setIdDocumento($id_documento)
    {
        $this->id_documento = $id_documento;
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

    /**
     * @return mixed
     */
    public function getCodSunat()
    {
        return $this->cod_sunat;
    }

    /**
     * @param mixed $cod_sunat
     */
    public function setCodSunat($cod_sunat)
    {
        $this->cod_sunat = $cod_sunat;
    }

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_documento) + 1, 1) as codigo "
            . "from documentos_sunat ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_documento = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into documentos_sunat values ('".$this->id_documento."', '".$this->nombre."', '".$this->abreviatura."', '".$this->cod_sunat."')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in documentos_sunat: ' . mysqli_error($conn));
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
        $query = "select * from documentos_sunat where id_documento = '" . $this->id_documento . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila['nombre'];
                $this->abreviatura = $fila['abreviatura'];
                $this->cod_sunat = $fila['cod_sunat'];
            }
        }
        return $existe;
    }

    function ver_documentos() {
        global $conn;
        $query = "select * from documentos_sunat "
            . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
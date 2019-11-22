<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:50 PM
 */

include 'cl_conectar.php';

class cl_empresa
{
    private $id_empresa;
    private $ruc;
    private $razon_social;
    private $nombre_comercial;
    private $direccion;
    private $telefono;
    private $email;
    private $estado;

    /**
     * cl_empresa constructor.
     */
    public function __construct()
    {
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
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * @param mixed $ruc
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    /**
     * @return mixed
     */
    public function getRazonSocial()
    {
        return $this->razon_social;
    }

    /**
     * @param mixed $razon_social
     */
    public function setRazonSocial($razon_social)
    {
        $this->razon_social = $razon_social;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getNombreComercial()
    {
        return $this->nombre_comercial;
    }

    /**
     * @param mixed $nombre_comercial
     */
    public function setNombreComercial($nombre_comercial)
    {
        $this->nombre_comercial = $nombre_comercial;
    }

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_empresa) + 1, 1) as codigo "
            . "from empresa ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_empresa = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into empresa values ('" . $this->id_empresa . "', '" . $this->ruc . "', '" . $this->razon_social . "', '" . $this->nombre_comercial . "', "
            . "'" . $this->direccion . "', '" . $this->telefono . "', '" . $this->email . "', '1')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in empresa: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        $conn->close();
        return $grabado;
    }

    public function obtener_datos()
    {
        $existe = false;
        global $conn;
        $query = "select * from empresa where id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->ruc = $fila['ruc'];
                $this->razon_social= $fila['razon_social'];
                $this->direccion = $fila['direccion'];
                $this->nombre_comercial = $fila['nombre_comercial'];
                $this->telefono = $fila['telefono'];
                $this->email = $fila['email'];
                $this->estado = $fila['estado'];
            }
        }
        return $existe;
    }

    public function validar_ruc()
    {
        $existe = false;
        global $conn;
        $query = "select id_empresa from empresa "
            . "where ruc = '" . $this->ruc . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_empresa = $fila['id_empresa'];
            }
        }
        return $existe;
    }

    function ver_empresas()
    {
        global $conn;
        $query = "select * from empresa "
            . "order by razon_social asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }



}
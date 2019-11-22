<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:56 PM
 */

include 'cl_conectar.php';

class cl_usuario
{
    private $id_empresa;
    private $id_usuario;
    private $username;
    private $password;
    private $nombre;
    private $fecha_registro;
    private $ultimo_ingreso;
    private $telefono;
    private $email;
    private $estado;

    /**
     * cl_usuario constructor.
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    /**
     * @param mixed $fecha_registro
     */
    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    /**
     * @return mixed
     */
    public function getUltimoIngreso()
    {
        return $this->ultimo_ingreso;
    }

    /**
     * @param mixed $ultimo_ingreso
     */
    public function setUltimoIngreso($ultimo_ingreso)
    {
        $this->ultimo_ingreso = $ultimo_ingreso;
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


    function getEstado()
    {
        return $this->estado;
    }

    function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_usuario) + 1, 1) as codigo "
            . "from usuario "
            . "where id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_usuario = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into usuario values ('" . $this->id_usuario . "', '" . $this->id_empresa . "', '" . $this->nombre . "', '" . $this->username . "', "
            . "'" . $this->password . "', 'now()', 'now()', '" . $this->telefono . "', '" . $this->email . "', '1')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in usuario: ' . mysqli_error($conn));
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
        $query = "select * from usuario where id_usuario = '" . $this->id_usuario . "' and id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila['nombre'];
                $this->username = $fila['username'];
                $this->password = $fila['password'];
                $this->fecha_registro = $fila['fecha_registro'];
                $this->ultimo_ingreso = $fila['ultimo_ingreso'];
                $this->telefono = $fila['telefono'];
                $this->email = $fila['email'];
                $this->estado = $fila['estado'];
            }
        }
        return $existe;
    }

    public function validar_username()
    {
        $existe = false;
        global $conn;
        $query = "select id_usuario from usuario "
            . "where username = '" . $this->username . "' and id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_usuario = $fila['id_usuario'];
            }
        }
        return $existe;
    }

    function ver_usuarios()
    {
        global $conn;
        $query = "select * from usuario "
            . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
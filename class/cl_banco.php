<?php

require 'cl_conectar.php';

class cl_banco
{
    private $id_banco;
    private $nombre;
    private $saldo;
    private $id_empresa;
    private $cuenta;

    /**
     * cl_banco constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdBanco()
    {
        return $this->id_banco;
    }

    /**
     * @param mixed $id_banco
     */
    public function setIdBanco($id_banco)
    {
        $this->id_banco = $id_banco;
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
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * @param mixed $saldo
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;
    }

    /**
     * @return mixed
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * @param mixed $cuenta
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;
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

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_banco) + 1, 1) as codigo 
            from bancos ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_banco = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into bancos values ('$this->id_banco', '$this->nombre', '$this->cuenta', '$this->saldo')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in bancos: ' . mysqli_error($conn));
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
        $query = "select * from bancos where id_banco = '$this->id_banco'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila['nombre'];
                $this->cuenta = $fila['cuenta'];
                $this->saldo = $fila['saldo'];
            }
        }
        return $existe;
    }

    function verFilas()
    {
        global $conn;
        $query = "select * from bancos
            where id_empresa = '$this->id_empresa'  
            order by nombre asc ";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }


}
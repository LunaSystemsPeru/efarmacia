<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:46 PM
 */

include 'cl_conectar.php';

class cl_cliente
{
    private $id_cliente;
    private $id_empresa;
    private $documento;
    private $nombre;
    private $direccion;
    private $telefono;
    private $total_venta;
    private $total_pagado;
    private $ultima_venta;

    /**
     * cl_cliente constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    /**
     * @param mixed $id_cliente
     */
    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    /**
     * @return mixed
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param mixed $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
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
    public function getTotalVenta()
    {
        return $this->total_venta;
    }

    /**
     * @param mixed $total_venta
     */
    public function setTotalVenta($total_venta)
    {
        $this->total_venta = $total_venta;
    }

    /**
     * @return mixed
     */
    public function getTotalPagado()
    {
        return $this->total_pagado;
    }

    /**
     * @param mixed $total_pagado
     */
    public function setTotalPagado($total_pagado)
    {
        $this->total_pagado = $total_pagado;
    }

    /**
     * @return mixed
     */
    public function getUltimaVenta()
    {
        return $this->ultima_venta;
    }

    /**
     * @param mixed $ultima_venta
     */
    public function setUltimaVenta($ultima_venta)
    {
        $this->ultima_venta = $ultima_venta;
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
        $query = "select ifnull(max(id_cliente) + 1, 1) as codigo "
            . "from cliente "
            . "where id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_cliente = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into cliente values ('" . $this->id_cliente . "', '" . $this->id_empresa . "', '" . $this->documento . "', '" . $this->nombre . "', '" . $this->direccion . "', '" . $this->telefono . "', "
            . "'" . $this->total_venta . "', '" . $this->total_pagado . "', '" . $this->ultima_venta . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in cliente: ' . mysqli_error($conn));
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
        $query = "select * from cliente "
            . "where id_cliente = '" . $this->id_cliente . "' and id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->documento = $fila['documento'];
                $this->nombre = $fila['nombre'];
                $this->direccion = $fila['direccion'];
                $this->telefono = $fila['telefono'];
                $this->ultima_venta = $fila['ultima_venta'];
                $this->total_venta = $fila['total_venta'];
                $this->total_pagado = $fila['total_pagado'];
            }
        }
        return $existe;
    }

    public function buscar_documento()
    {
        $existe = false;
        global $conn;
        $query = "select id_cliente from cliente "
            . "where documento = '" . $this->documento . "' and id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_cliente = $fila['id_cliente'];
            }
        }
        return $existe;
    }

    function ver_clientes()
    {
        global $conn;
        $query = "select * from cliente "
            . "where id_empresa = '" . $this->id_empresa . "' "
            . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
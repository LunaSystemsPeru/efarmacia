<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:55 PM
 */

include 'cl_conectar.php';

class cl_proveedor
{
    private $id_empresa;
    private $id_proveedor;
    private $documento;
    private $nombre;
    private $direccion;
    private $total_compra;
    private $total_pagado;

    /**
     * cl_proveedor constructor.
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
    public function getTotalCompra()
    {
        return $this->total_compra;
    }

    /**
     * @param mixed $total_compra
     */
    public function setTotalCompra($total_compra)
    {
        $this->total_compra = $total_compra;
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


    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_proveedor) + 1, 1) as codigo from proveedor " .
            "where id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_proveedor = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into proveedor " .
            "values ('" . $this->id_proveedor . "', '" . $this->id_empresa . "', '" . $this->documento . "', '" . $this->nombre . "', '" . $this->direccion . "', '0', '0')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in documentos_sunat: ' . mysqli_error($conn));
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
        $query = "select * from proveedor " .
            "where id_empresa = '" . $this->id_empresa . "' and id_proveedor = '" . $this->id_proveedor . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->documento = $fila['documento'];
                $this->nombre = $fila['nombre'];
                $this->direccion = $fila['direccion'];
                $this->total_compra = $fila['total_compra'];
                $this->total_pagado = $fila['total_pagado'];
            }
        }
        return $existe;
    }

    function ver_proveedores()
    {
        global $conn;
        $query = "select * from proveedor "
            . "where id_empresa = '" . $this->id_empresa . "' "
            . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
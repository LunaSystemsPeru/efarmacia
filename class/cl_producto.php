<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:53 PM
 */

include 'cl_conectar.php';

class cl_producto
{

    private $id_empresa;
    private $id_producto;
    private $nombre;
    private $principio_activo;
    private $id_presentacion;
    private $id_laboratorio;
    private $costo;
    private $precio;
    private $cantidad;
    private $fecha_vcto;
    private $lote;
    private $id_proveedor;
    private $estado;

    /**
     * cl_producto constructor.
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
    public function getIdProducto()
    {
        return $this->id_producto;
    }

    /**
     * @param mixed $id_producto
     */
    public function setIdProducto($id_producto)
    {
        $this->id_producto = $id_producto;
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
    public function getPrincipioActivo()
    {
        return $this->principio_activo;
    }

    /**
     * @param mixed $principio_activo
     */
    public function setPrincipioActivo($principio_activo)
    {
        $this->principio_activo = $principio_activo;
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
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * @param mixed $costo
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getFechaVcto()
    {
        return $this->fecha_vcto;
    }

    /**
     * @param mixed $fecha_vcto
     */
    public function setFechaVcto($fecha_vcto)
    {
        $this->fecha_vcto = $fecha_vcto;
    }

    /**
     * @return mixed
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * @param mixed $lote
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
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

    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_producto) + 1, 1) as codigo from producto where id_empresa = '" . $this->id_empresa . "' ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_producto = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into producto values ('" . $this->id_producto . "', '" . $this->id_empresa . "', '" . $this->nombre . "', '" . $this->principio_activo . "', '" . $this->id_laboratorio . "', "
            . "'" . $this->id_presentacion . "', '" . $this->costo . "', '" . $this->precio . "', '0', '2000-01-01', '-', 0)";
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

    public function obtener_datos()
    {
        $existe = false;
        global $conn;
        $query = "select * from producto where id_empresa = '" . $this->id_empresa . "' and id_producto = '" . $this->id_producto . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila['nombre'];
                $this->principio_activo = $fila['principio_activo'];
                $this->id_laboratorio = $fila['id_laboratorio'];
                $this->id_presentacion = $fila['id_presentacion'];
                $this->costo = $fila['costo'];
                $this->precio = $fila['precio'];
                $this->cantidad = $fila['cantidad'];
                $this->lote = $fila['lote'];
                $this->fecha_vcto = $fila['vcto'];
                $this->id_proveedor = $fila['id_proveedor'];
            }
        }
        return $existe;
    }

    function ver_productos()
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, p.principio_activo, pr.nombre as npresentacion, l.nombre as nlaboratorio, p.cantidad, p.precio, p.lote, p.vcto "
            . "from producto as p "
            . "inner join laboratorio as l on p.id_laboratorio = l.id_laboratorio "
            . "inner join presentacion pr on p.id_presentacion = pr.id_presentacion "
            . "where p.id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
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
        $this->nombre = strtoupper($nombre);
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
        $query = "insert into producto values ('" . $this->id_producto . "', '" . $this->id_empresa . "',
         '" . $this->costo . "', '" . $this->precio . "', '0', '2000-01-01', '-', 0)";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in producto: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    public function eliminar()
    {
        global $conn;
        $query = "delete from producto 
        where id_producto = '" . $this->id_producto . "' and id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in producto: ' . mysqli_error($conn));
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

        $query = "SELECT * FROM producto
                INNER JOIN productos_minsa  
                    ON producto.id_producto = productos_minsa.id_producto_sistema  
                    where id_empresa = '" . $this->id_empresa . "' and id_producto = '" . $this->id_producto . "'";

        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila['nombre'];
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
        $query = "SELECT p.id_producto,
          pm.nombre,
          pr.nombre AS npresentacion,
          l.nombre AS nlaboratorio,
          p.cantidad,
          p.precio,
          p.lote,
          p.vcto,
          DATEDIFF(p.vcto, CURRENT_DATE()) AS faltantes 
        FROM
          producto AS p 
          INNER JOIN productos_minsa AS pm
            ON p.id_producto = pm.id_producto_sistema 
          INNER JOIN laboratorio AS l 
            ON pm.id_laboratorio = l.id_laboratorio 
          INNER JOIN presentacion pr 
            ON pm.id_presentacion = pr.id_presentacion 
        WHERE p.id_empresa = '$this->id_empresa'";
        $resultado = $conn->query($query);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function verVencidos () {
        global $conn;
        $query = "SELECT 
                    p.id_producto,
                    pm.nombre,
                    l.nombre AS laboratorio,
                    p.cantidad,
                    p.precio,
                    p2.nombre AS presentacion,
                    p.vcto,
                    (p.vcto - CURDATE()) AS faltantes 
                  FROM
                    producto AS p 
                    INNER JOIN productos_minsa AS pm 
                    ON p.id_producto = pm.id_producto_sistema 
                    
                    INNER JOIN laboratorio l 
                      ON pm.id_laboratorio = l.id_laboratorio 
                    INNER JOIN presentacion p2 
                      ON pm.id_presentacion = p2.id_presentacion 
                  WHERE p.id_empresa = '$this->id_empresa' 
                    AND CURDATE() >= DATE_SUB(p.vcto, INTERVAL 121 DAY) 
                    AND cantidad > 0 
                  ORDER BY p.vcto ASC ";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function verSinStock () {
        global $conn;
        $query = "SELECT p.id_producto, pm.nombre, l.nombre AS laboratorio, p.cantidad, p.precio, p2.nombre AS presentacion
        FROM producto AS p
        INNER JOIN productos_minsa AS pm 
	ON p.id_producto = pm.id_producto_sistema   
        INNER JOIN laboratorio l ON pm.id_laboratorio = l.id_laboratorio
        INNER JOIN presentacion p2 ON pm.id_presentacion = p2.id_presentacion
        where p.id_empresa = '$this->id_empresa' and p.cantidad <= 0
        order by p.vcto asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }



    function actualizar_productos()
    {
        global $conn;
        $query = "update producto 
                    set id_producto = '$this->id_producto',
                        costo = '$this->costo',
                        precio = '$this->precio'
                    where id_producto = '$this->id_producto'
                      and id_empresa = '$this->id_empresa'";
        $resultado = $conn->query($query);
        return true;

    }
}
<?php
require_once 'cl_conectar.php';

class cl_producto_sucursal
{
    private $id_sucursal;
    private $id_producto;
    private $id_empresa;
    private $cantidad;

    /**
     * cl_producto_sucursal constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdSucursal()
    {
        return $this->id_sucursal;
    }

    /**
     * @param mixed $id_sucursal
     */
    public function setIdSucursal($id_sucursal)
    {
        $this->id_sucursal = $id_sucursal;
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

    public function insertar()
    {
        global $conn;
        $query = "insert into productos_sucursales values ('$this->id_sucursal', '$this->id_producto', '$this->id_empresa', '$this->cantidad')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in inventario: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_productos()
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, p.principio_activo, pr.nombre as npresentacion, l.nombre as nlaboratorio, p.cantidad, p.precio, p.lote, p.vcto, DATEDIFF(p.vcto, current_date()) as faltantes 
        from productos_sucursales as ps 
            inner join producto as p on p.id_producto = ps.id_producto 
        inner join laboratorio as l on p.id_laboratorio = l.id_laboratorio 
        inner join presentacion pr on p.id_presentacion = pr.id_presentacion 
        where p.id_empresa = '$this->id_empresa'";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function verVencidos () {
        global $conn;
        $query = "select p.id_producto, p.nombre, l.nombre as laboratorio, p.precio, p2.nombre as presentacion, p.vcto, (p.vcto - curdate()) as faltantes
        from producto as p
        inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
        inner join presentacion p2 on p.id_presentacion = p2.id_presentacion
        where p.id_empresa = '$this->id_empresa' and curdate() >= date_sub(p.vcto, interval 121 day ) and cantidad > 0
        order by p.vcto asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function verVencidosPeriodo ($periodo) {
        global $conn;
        $query = "select p.id_producto, p.nombre, l.nombre as laboratorio, p.precio, p2.nombre as presentacion, p.vcto, (p.vcto - curdate()) as faltantes, p3.nombre as nproveedor, ps.cantidad, p.lote, p.costo
        from productos_sucursales as ps 
        inner join producto p on ps.id_producto = p.id_producto and ps.id_empresa = p.id_empresa 
        inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
        inner join presentacion p2 on p.id_presentacion = p2.id_presentacion
        inner join proveedor p3 on p.id_proveedor = p3.id_proveedor and p.id_empresa = p3.id_empresa
        where p.id_empresa = '$this->id_empresa' and ps.id_sucursal = '$this->id_sucursal' and concat(year(p.vcto),'-',month(p.vcto)) = '$periodo' and ps.cantidad > 0
        order by p.vcto asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
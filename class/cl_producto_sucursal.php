<?php
require_once 'cl_conectar.php';

class cl_producto_sucursal
{
    private $id_sucursal;
    private $id_producto;
    private $id_empresa;
    private $cantidad;
    private $pventa;
    private $pcosto;
    private $lote;
    private $vcto;

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

    /**
     * @return mixed
     */
    public function getPventa()
    {
        return $this->pventa;
    }

    /**
     * @param mixed $pventa
     */
    public function setPventa($pventa): void
    {
        $this->pventa = $pventa;
    }

    /**
     * @return mixed
     */
    public function getPcosto()
    {
        return $this->pcosto;
    }

    /**
     * @param mixed $pcosto
     */
    public function setPcosto($pcosto): void
    {
        $this->pcosto = $pcosto;
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
    public function setLote($lote): void
    {
        $this->lote = $lote;
    }

    /**
     * @return mixed
     */
    public function getVcto()
    {
        return $this->vcto;
    }

    /**
     * @param mixed $vcto
     */
    public function setVcto($vcto): void
    {
        $this->vcto = $vcto;
    }

    public function actualizar()
    {
        global $conn;
        $query = "update productos_sucursales set pventa = '$this->pventa', pcompra = '$this->pcosto'
                where id_producto = '$this->id_producto' and id_sucursal = '$this->id_sucursal' and id_empresa = '$this->id_empresa'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in inventario: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
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

    public function eliminar()
    {
        global $conn;
        $query = "delete from productos_sucursales 
                    where id_sucursal = '$this->id_sucursal' and id_producto = '$this->id_producto' and id_empresa = '$this->id_empresa'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in inventario: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_productos()
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, p.principio_activo, pr.nombre as npresentacion, l.nombre as nlaboratorio, ps.cantidad, ps.pventa as precio, ps.lote, ps.vcto, DATEDIFF(ps.vcto, current_date()) as faltantes 
        from productos_sucursales as ps 
            inner join producto as p on p.id_producto = ps.id_producto and p.id_empresa = ps.id_empresa
        inner join laboratorio as l on p.id_laboratorio = l.id_laboratorio 
        inner join presentacion pr on p.id_presentacion = pr.id_presentacion 
        where ps.id_sucursal = '$this->id_sucursal' and ps.id_empresa = '$this->id_empresa' ";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function buscar_productos($term)
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, p.principio_activo, pr.nombre as npresentacion, l.nombre as nlaboratorio, ps.cantidad, ps.pventa as precio, ps.lote, ps.vcto, DATEDIFF(ps.vcto, current_date()) as faltantes 
        from productos_sucursales as ps 
            inner join producto as p on p.id_producto = ps.id_producto and p.id_empresa = ps.id_empresa
        inner join laboratorio as l on p.id_laboratorio = l.id_laboratorio 
        inner join presentacion pr on p.id_presentacion = pr.id_presentacion 
        where ps.id_sucursal = '$this->id_sucursal' and ps.id_empresa = '$this->id_empresa' and p.nombre like '%$term%' ";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function verSinStock()
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, l.nombre as laboratorio, ps.pventa as precio, p2.nombre as presentacion, ps.cantidad
        from productos_sucursales as ps 
            inner join producto as p on p.id_producto = ps.id_producto and p.id_empresa = ps.id_empresa 
        inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
        inner join presentacion p2 on p.id_presentacion = p2.id_presentacion
        where ps.id_empresa = '$this->id_empresa' and ps.id_sucursal = '$this->id_sucursal' and ps.cantidad <= 0
        order by p.vcto asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function verVencidos()
    {
        global $conn;
        $query = "select p.nombre, ps.lote, ps.vcto, ps.cantidad, ps.pventa, ps.pcompra, l.nombre as nlaboratorio, p2.nombre as npresentacion, p.principio_activo, p.id_producto, TIMESTAMPDIFF(day , ps.vcto, current_date()) as faltantes
                    from productos_sucursales as ps 
                    inner join producto p on ps.id_empresa = p.id_empresa and ps.id_producto = p.id_producto 
                    inner join laboratorio l on p.id_laboratorio = l.id_laboratorio 
                    inner join presentacion p2 on p.id_presentacion = p2.id_presentacion
                    where ps.id_empresa = '$this->id_empresa' and ps.id_sucursal = '$this->id_sucursal' and ps.vcto < current_date() 
                    order by ps.vcto asc, p.nombre asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function verVencidosPeriodo($periodo)
    {
        global $conn;
        $query = "select p.id_producto, p.nombre, l.nombre as laboratorio, ps.pventa as precio, p2.nombre as presentacion, ps.vcto, (ps.vcto - curdate()) as faltantes, p3.nombre as nproveedor, ps.cantidad, ps.lote, ps.pcompra as costo
        from productos_sucursales as ps 
        inner join producto p on ps.id_producto = p.id_producto and ps.id_empresa = p.id_empresa 
        inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
        inner join presentacion p2 on p.id_presentacion = p2.id_presentacion 
        inner join proveedor p3 on p.id_proveedor = p3.id_proveedor and p.id_empresa = p3.id_empresa 
        where ps.id_empresa = '$this->id_empresa' and ps.id_sucursal = '$this->id_sucursal' and concat(year(ps.vcto),'-',month(ps.vcto)) = '$periodo' and ps.cantidad > 0
        order by ps.vcto asc";
        //echo $query;
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtener_datos()
    {
        $existe = false;
        global $conn;
        $query = "select * from productos_sucursales where id_empresa = '" . $this->id_empresa . "' and id_producto = '" . $this->id_producto . "' and id_sucursal = '$this->id_sucursal'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->cantidad = $fila['cantidad'];
                $this->pventa = $fila['pventa'];
                $this->pcosto = $fila['pcompra'];
                $this->lote = $fila['lote'];
                $this->vcto = $fila['vcto'];
            }
        } else {
            $this->cantidad = 0;
            $existe = false;
        }
        return $existe;
    }
}
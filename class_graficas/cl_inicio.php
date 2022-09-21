<?php
if (!isset($_SESSION)) {
    session_start();
}

require '../class/cl_conectar.php';

class cl_inicio
{
    private $id_empresa;
    private $id_sucursal;

    /**
     * cl_inicio constructor.
     */
    public function __construct()
    {
        $this->id_empresa = $_SESSION['id_empresa'];
        $this->id_sucursal = $_SESSION['id_sucursal'];
    }


    public function utilidadMensual()
    {
        global $conn;
        $sql = "select  m.id, m.nombre, ifnull(sum(vp.cantidad * vp.precio), 0) as venta, ifnull(sum((vp.precio - vp.costo) * vp.cantidad), 0) as utilidad
        from mes as m
        left join venta as v on month(v.fecha) = m.id and v.id_empresa = '$this->id_empresa' and v.id_sucursal = '$this->id_sucursal' and v.estado=1 and year(v.fecha) = year(curdate())
        left join venta_producto vp on v.id_venta = vp.id_venta and v.periodo = vp.periodo and v.id_empresa = vp.id_empresa
        group by m.id";
        $resultado = $conn->query($sql);
        $i = 0;
        $registros = array();
        while ($row = $resultado->fetch_assoc()) {
            $registros[$i] = $row;
            $i++;
        };
        //return json_encode(array('data' => $registros));
        return json_encode($registros);

    }

    public function utilidadDiaria()
    {
        global $conn;
        $sql = "select day(v.fecha) as dia, ifnull(sum(vp.cantidad * vp.precio), 0) as venta, ifnull(sum((vp.precio - vp.costo) * vp.cantidad), 0) as utilidad
        from venta as v
        inner join venta_producto vp on v.id_venta = vp.id_venta and v.periodo = vp.periodo and v.id_empresa = vp.id_empresa
        where month(v.fecha) = month(curdate()) and v.id_empresa = '$this->id_empresa' and v.id_sucursal = '$this->id_sucursal' and v.estado=1 and year(v.fecha) = year(curdate())
        group by v.fecha
        order by v.fecha asc";
        $resultado = $conn->query($sql);
        $i = 0;
        $registros = array();
        while ($row = $resultado->fetch_assoc()) {
            $registros[$i] = $row;
            $i++;
        };
        //return json_encode(array('data' => $registros));
        return json_encode($registros);

    }

    public function VentasLaboratorioAnio()
    {
        global $conn;
        $sql = "select l.nombre as nomlaboratorio,  sum(vp.cantidad * vp.precio) as venta,  sum(p.precio * p.cantidad) as existe
            from venta_producto as vp
            inner join producto p on vp.id_producto = p.id_producto and vp.id_empresa = p.id_empresa
                inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
            inner join venta v on vp.id_venta = v.id_venta and vp.periodo = v.periodo and vp.id_empresa = v.id_empresa
            where year(v.fecha) = year(curdate()) and v.estado = 1 and v.id_empresa = '$this->id_empresa' and v.id_sucursal = '$this->id_sucursal'
            group by p.id_laboratorio 
            order by sum(vp.cantidad * vp.precio) desc";
        $resultado = $conn->query($sql);
        $i = 0;
        $registros = array();
        while ($row = $resultado->fetch_assoc()) {
            $registros[$i] = $row;
            $i++;
        };
        //return json_encode(array('data' => $registros));
        return json_encode($registros);

    }

    public function VentasLaboratorioMes()
    {
        global $conn;
        $sql = "select l.nombre as nomlaboratorio,  sum(vp.cantidad * vp.precio) as venta,  sum(p.precio * p.cantidad) as existe
            from venta_producto as vp
            inner join producto p on vp.id_producto = p.id_producto and vp.id_empresa = p.id_empresa
                inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
            inner join venta v on vp.id_venta = v.id_venta and vp.periodo = v.periodo and vp.id_empresa = v.id_empresa
            where year(v.fecha) = year(curdate()) and month(v.fecha) = month(curdate()) and v.estado = 1 and v.id_empresa = '$this->id_empresa' and v.id_sucursal = '$this->id_sucursal'
            group by p.id_laboratorio
            order by sum(vp.cantidad * vp.precio) desc";
        $resultado = $conn->query($sql);
        $i = 0;
        $registros = array();
        while ($row = $resultado->fetch_assoc()) {
            $registros[$i] = $row;
            $i++;
        };
        //return json_encode(array('data' => $registros));
        return json_encode($registros);

    }

        public function verTotalVencimientos()
    {
        global $conn;
        $sql = "select year(p.vcto) as anio_vcto, month(p.vcto) as mes_vcto, count(*) as stock_vence
            from productos_sucursales as ps 
            inner join producto p on ps.id_producto = p.id_producto and ps.id_empresa = p.id_empresa
            where p.id_empresa = '$this->id_empresa' and ps.id_sucursal = '$this->id_sucursal' and ps.cantidad > 0 and curdate() > date_sub(p.vcto, INTERVAL 121 day )
            group by year(p.vcto), month(p.vcto)
            order by year(p.vcto) asc, month(p.vcto) asc";
        $resultado = $conn->query($sql);
        $i = 0;
        $registros = array();
        while ($row = $resultado->fetch_assoc()) {
            $registros[$i] = $row;
            $i++;
        };
        //return json_encode(array('data' => $registros));
        return json_encode($registros);

    }
}
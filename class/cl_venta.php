<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:07 PM
 */

include 'cl_conectar.php';

class cl_venta
{

    private $id_empresa;
    private $periodo;
    private $id_venta;
    private $fecha;
    private $id_documento;
    private $serie;
    private $numero;
    private $id_cliente;
    private $total;
    private $pagado;
    private $estado;
    private $id_usuario;
    private $enviado_sunat;
    private $id_sucursal;

    /**
     * cl_venta constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getEnviadoSunat()
    {
        return $this->enviado_sunat;
    }

    /**
     * @param mixed $enviado_sunat
     */
    public function setEnviadoSunat($enviado_sunat)
    {
        $this->enviado_sunat = $enviado_sunat;
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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @param mixed $periodo
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    /**
     * @return mixed
     */
    public function getIdVenta()
    {
        return $this->id_venta;
    }

    /**
     * @param mixed $id_venta
     */
    public function setIdVenta($id_venta)
    {
        $this->id_venta = $id_venta;
    }

    /**
     * @return mixed
     */
    public function getIdDocumento()
    {
        return $this->id_documento;
    }

    /**
     * @param mixed $id_documento
     */
    public function setIdDocumento($id_documento)
    {
        $this->id_documento = $id_documento;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
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
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * @param mixed $pagado
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;
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

    public function anular()
    {
        global $conn;
        $query = "update venta 
        set estado = '2'   
        where id_venta = '$this->id_venta' and id_empresa = '$this->id_empresa' and periodo = '$this->periodo'";
        //echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in venta: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }


    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_venta) + 1, 1) as codigo 
                from venta where periodo = '" . $this->periodo . "' and id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_venta = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into venta values ('" . $this->id_venta . "', '" . $this->periodo . "', '" . $this->id_empresa . "', '" . $this->fecha . "', '" . $this->id_documento . "', '" . $this->serie . "', "
            . "'" . $this->numero . "', '" . $this->id_cliente . "', '" . $this->total . "', '0', '0', NOW(), '" . $this->id_usuario . "', '0','$this->id_sucursal')";
        //echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in venta: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }

    public function obtener_datos()
    {
        $existe = false;
        global $conn;
        $query = "SELECT * 
                  FROM venta 
                  WHERE id_venta = '$this->id_venta'
                        AND periodo='$this->periodo' 
                        AND id_empresa= '$this->id_empresa'";
        $resultado = $conn->query($query);

        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->fecha = $fila["fecha"];
                $this->id_documento = $fila["id_documento"];
                $this->serie = $fila["serie"];
                $this->numero = $fila["numero"];
                $this->id_cliente = $fila["id_cliente"];
                $this->total = $fila["total"];
                $this->pagado = $fila["pagado"];
                $this->estado = $fila["estado"];
                $this->id_usuario = $fila["id_usuario"];
                $this->id_sucursal = $fila["id_sucursal"];
            }
        }
        return $existe;
    }

    function ver_ventas()
    {
        global $conn;
        $query = "select v.periodo, v.id_venta, v.fecha, ds.abreviatura, v.serie, v.numero, c.documento, c.nombre, v.total, v.pagado, v.estado, u.username, v.id_documento, ds.cod_sunat   
            from venta v 
            inner join documentos_sunat ds on v.id_documento = ds.id_documento 
            inner join cliente c on v.id_cliente = c.id_cliente and v.id_empresa = c.id_empresa 
            inner join usuario u on v.id_empresa = u.id_empresa and u.id_usuario = v.id_usuario 
            where v.id_empresa = '$this->id_empresa' and v.periodo = '$this->periodo' and v.id_sucursal = '$this->id_sucursal' 
            order by v.fecha asc, v.numero asc";
        // echo $query;
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function ver_ventas_total()
    {
        global $conn;
        $query = "select v.periodo, v.id_venta, v.fecha, ds.abreviatura, v.serie, v.numero, c.documento, c.nombre, v.total, v.enviado_sunat, v.estado, u.username, s.nombre as nombresede    
            from venta v
            inner join sucursales s on v.id_empresa = s.id_empresa and v.id_sucursal = s.id_sucursal
            inner join documentos_sunat ds on v.id_documento = ds.id_documento 
            inner join cliente c on v.id_cliente = c.id_cliente and v.id_empresa = c.id_empresa 
            inner join usuario u on v.id_empresa = u.id_empresa and u.id_usuario = v.id_usuario
            where v.id_empresa = '$this->id_empresa' and v.periodo = '$this->periodo' ";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function ver_anios()
    {
        global $conn;
        $query = "select distinct(year(fecha)) as anio 
        from venta 
        where id_empresa = '$this->id_empresa' 
        order by year(fecha) asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function ver_periodos($anio)
    {
        global $conn;
        $query = "select distinct(periodo) as periodo 
        from venta 
        where id_empresa = '$this->id_empresa' and year(fecha) = '$anio'   
        order by periodo asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }


    public function verDocumentosResumen()
    {
        global $conn;
        $query = "SELECT v.id_venta, v.periodo, v.fecha, ds.cod_sunat, ds.abreviatura, v.serie, v.numero, c.documento, c.nombre, v.total, v.estado, v.id_documento, v.enviado_sunat, v.estado
        FROM venta AS v 
            INNER JOIN documentos_sunat ds ON v.id_documento = ds.id_documento
            INNER JOIN cliente c ON v.id_cliente = c.id_cliente AND  c.id_empresa=v.id_empresa
        where v.id_empresa = '$this->id_empresa' and v.fecha = '$this->fecha' and v.id_documento in (2,5)";
        //echo $query ."<br>";
        return $conn->query($query);
    }

    public function verFacturasResumen()
    {
        global $conn;
        $query = "SELECT v.id_venta,v.periodo, v.fecha, ds.cod_sunat, ds.abreviatura, v.serie, v.numero, c.documento, c.nombre, v.total, v.estado, v.id_documento, v.enviado_sunat, v.estado
        from venta as v 
            inner join documentos_sunat ds ON v.id_documento = ds.id_documento
            inner join cliente c on v.id_cliente = c.id_cliente AND  c.id_empresa=v.id_empresa
        where v.id_empresa = '$this->id_empresa' and v.fecha = '$this->fecha' and v.id_documento = 3 ";
        return $conn->query($query);
    }

    public function actualizar_envio()
    {
        global $conn;
        $query = "update venta 
        set enviado_sunat = 1 
        where id_venta = '$this->id_venta'";
        return $conn->query($query);
    }

    public function verFechasPendientes()
    {
        global $conn;
        $query = "select v.id_documento, v.fecha, count(*) as cantidad
                from venta as v 
                where v.id_documento = 2 and month(v.fecha) = 9 and year(v.fecha) = 2022
                GROUP by v.fecha";
        return $conn->query($query);
    }

    public function verComprobantesMensual()
    {
        global $conn;
        $query = "select e.ruc, ds.cod_sunat, v.serie, v.numero, v.fecha, v.total
                from venta as v
                    inner join documentos_sunat ds on v.id_documento = ds.id_documento
                    inner join empresa e on v.id_empresa = e.id_empresa
                where v.id_sucursal = '$this->id_sucursal' and v.periodo = '$this->periodo' and v.id_documento in (3,5,2)";
        return $conn->query($query);
    }
}
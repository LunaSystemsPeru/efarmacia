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

    /**
     * cl_venta constructor.
     */
    public function __construct()
    {
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


    public function obtener_codigo()
    {
        global $conn;
        $query = "select ifnull(max(id_venta) + 1, 1) as codigo "
            . "from venta where periodo = '" . $this->periodo . "' and id_empresa = '" . $this->id_empresa . "'";
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
            . "'" . $this->numero . "', '" . $this->id_cliente . "', '" . $this->total . "', '0', '0', NOW(), '" . $this->id_usuario . "')";
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
                  WHERE id_venta = $this->id_venta 
                        AND periodo='" . $this->periodo. "' 
                        AND id_empresa= $this->id_empresa";
        $resultado = $conn->query($query);

        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->fecha=$fila["fecha"];
                $this->id_documento=$fila["id_documento"];
                $this->serie=$fila["serie"];
                $this->numero=$fila["numero"];
                $this->id_cliente=$fila["id_cliente"];
                $this->total=$fila["total"];
                $this->pagado=$fila["pagado"];
                $this->estado=$fila["estado"];
                $this->id_usuario=$fila["id_usuario"];
            }
        }
        return $existe;
    }

    function ver_ventas()
    {
        global $conn;
        $query = "select v.periodo, v.id_venta, v.fecha, ds.abreviatura, v.serie, v.numero, c.documento, c.nombre, v.total, v.pagado, v.estado "
            . "from venta v "
            . "inner join documentos_sunat ds on v.id_documento = ds.id_documento "
            . "inner join cliente c on v.id_cliente = c.id_cliente and v.id_empresa = c.id_empresa "
            . "where v.id_empresa = '".$this->id_empresa."'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }


    public function verDocumentosResumen()
    {
        $sql = "SELECT v.id_venta, v.fecha, ds.cod_sunat, ds.abreviatura, v.serie, v.numero, c.documento, c.nombre, v.total, v.estado, v.id_documento, v.enviado_sunat, v.estado
        FROM venta AS v 
            INNER JOIN documentos_sunat ds ON v.id_tido = ds.id_tido
            INNER JOIN cliente c ON v.id_cliente = c.id_cliente 
        where v.id_empresa = '$this->id_empresa' and v.fecha = '$this->fecha' and v.id_tido in (1,3)";
        return $this->conectar->get_Cursor($sql);
    }

    public function verFacturasResumen()
    {
        $sql = "select v.id_venta, v.fecha, ds.cod_sunat, ds.abreviatura, v.serie, v.numero, c.documento, c.datos, v.total, v.estado, v.id_tido, v.enviado_sunat, v.estado
        from ventas as v 
            inner join documentos_sunat ds on v.id_tido = ds.id_tido
            inner join clientes c on v.id_cliente = c.id_cliente 
        where v.id_empresa = '$this->id_empresa' and v.fecha = '$this->fecha' and v.id_tido = 2 ";
        return $this->conectar->get_Cursor($sql);
    }
}
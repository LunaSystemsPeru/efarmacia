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
            . "'" . $this->numero . "', '" . $this->id_cliente . "', '" . $this->total . "', '0', '0', 'NOW()', '" . $this->id_usuario . "')";
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
        $query = "select * from venta where id_documento = '" . $this->id_documento . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila['nombre'];
                $this->abreviatura = $fila['abreviatura'];
                $this->cod_sunat = $fila['cod_sunat'];
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
}
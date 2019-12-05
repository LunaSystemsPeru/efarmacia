<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 07:04 PM
 */

include 'cl_conectar.php';

class cl_ingreso
{

    private $id_ingreso;
    private $periodo;
    private $id_empresa;
    private $fecha;
    private $id_documento;
    private $serie;
    private $numero;
    private $id_proveedor;
    private $total;
    private $id_usuario;

    /**
     * cl_ingreso constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdIngreso()
    {
        return $this->id_ingreso;
    }

    /**
     * @param mixed $id_ingreso
     */
    public function setIdIngreso($id_ingreso)
    {
        $this->id_ingreso = $id_ingreso;
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
        $query = "select ifnull(max(id_ingreso) + 1, 1) as codigo "
            . "from ingreso where periodo = '" . $this->periodo . "' and id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_ingreso = $fila ['codigo'];
            }
        }
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into ingreso values ('" . $this->periodo . "', '" . $this->id_ingreso . "', '" . $this->id_empresa . "', '" . $this->fecha . "', '" . $this->id_documento . "', '" . $this->serie . "', "
            . "'" . $this->numero . "', '" . $this->id_proveedor . "', '" . $this->id_usuario . "', '" . $this->total . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in ingreso: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }

    public function eliminar()
    {
        global $conn;
        $query = "delete from ingreso 
        where id_ingreso = '$this->id_ingreso' and periodo = '$this->periodo' and id_empresa = '$this->id_empresa'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in ingreso: ' . mysqli_error($conn));
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
        $query = "select * from ingreso "
            . "where periodo = '" . $this->periodo . "' and id_ingreso = '" . $this->id_ingreso . "' and id_empresa = '" . $this->id_empresa . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->fecha = $fila['fecha'];
                $this->id_documento = $fila['id_documento'];
                $this->serie = $fila['serie'];
                $this->numero = $fila['numero'];
                $this->id_proveedor = $fila['id_proveedor'];
                $this->id_usuario = $fila['id_usuario'];
                $this->total = $fila['total'];
            }
        }
        return $existe;
    }

    function ver_ingresos()
    {
        global $conn;
        $query = "select i.periodo, i.id_ingreso, i.fecha, ds.abreviatura as doc_sunat, i.serie, i.numero, p.documento as ruc, p.nombre as razon_social, u.username, i.total "
            . "from ingreso i "
            . "inner join documentos_sunat ds on i.id_documento = ds.id_documento "
            . "inner join proveedor p on i.id_proveedor = p.id_proveedor and i.id_empresa = p.id_empresa "
            . "inner join usuario u on i.id_usuario = u.id_usuario and i.id_empresa = u.id_empresa "
            . "where i.id_empresa = '".$this->id_empresa."' "
            . "order by i.fecha asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:58 PM
 */

require 'cl_conectar.php';

class cl_compra
{
    private $id_empresa;
    private $periodo;
    private $id_compra;
    private $fecha;
    private $id_documento;
    private $serie;
    private $numero;
    private $id_proveedor;
    private $total;
    private $pagado;
    private $id_usuario;
    private $id_sucursal;

    /**
     * @return mixed
     */
    public function getIdSucursal() {
        return $this->id_sucursal;
    }

    /**
     * @param mixed $id_sucursal
     */
    public function setIdSucursal($id_sucursal) {
        $this->id_sucursal = $id_sucursal;
    }


    /**
     * cl_compra constructor.
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
    public function getIdCompra()
    {
        return $this->id_compra;
    }

    /**
     * @param mixed $id_compra
     */
    public function setIdCompra($id_compra)
    {
        $this->id_compra = $id_compra;
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
        $this->serie = strtoupper($serie);
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
        $query = "select ifnull(max(id_compra) + 1, 1) as codigo 
            from compra 
            where periodo = '$this->periodo' and id_empresa = '$this->id_empresa' ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_compra = $fila ['codigo'];
            }
        }
    }

    public function obtenerDatos(){
        $existe = false;
        global $conn;
        $query = "select * from compra where id_compra = $this->id_compra and periodo=$this->periodo and id_empresa=$this->id_empresa and id_sucursal=$this->id_sucursal";
        $resultado = $conn->query($query);

        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->fecha = $fila['fecha'];
                $this->id_documento = $fila['id_documento'];
                $this->serie = $fila['serie'];
                $this->numero = $fila['numero'];
                $this->id_proveedor = $fila['id_proveedor'];
                $this->total = $fila['total'];
                $this->pagado = $fila['pagado'];
                $this->id_usuario=$fila['id_usuario'];
            }
        }
        return $existe;
    }

    public function insertar()
    {
        global $conn;
        $query = "insert into compra value ('$this->id_compra', '$this->periodo', '$this->id_empresa', '$this->fecha', '$this->id_documento', '$this->serie', '$this->numero', '$this->id_proveedor', '$this->total', '0', '$this->id_usuario','$this->id_sucursal')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not insert data in compra: ' . mysqli_error($conn));
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
        $query = "delete from compra where id_compra = $this->id_compra and periodo=$this->periodo and id_empresa=$this->id_empresa";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in compra: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        //$conn->close();
        return $grabado;
    }

    public function verFilas()
    {
        global $conn;
        $query = "select c.id_compra, c.periodo, p.documento, p.nombre, c.fecha, ds.abreviatura, c.numero, c.serie, c.total, c.pagado, u.username 
        from compra as c 
        inner join documentos_sunat ds on c.id_documento = ds.id_documento 
        inner join proveedor p on c.id_proveedor = p.id_proveedor and c.id_empresa = p.id_empresa
        inner join usuario u on c.id_usuario = u.id_usuario and c.id_empresa = u.id_empresa
        where c.id_empresa = '$this->id_empresa' and c.pagado < c.total";

        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function verPeriodos()
    {
        global $conn;
        $query = "select concat(year(fecha), LPAD(month(fecha), 2,0)) as periodo 
        from compra
        where id_empresa = '$this->id_empresa' 
        group by year(fecha), month(fecha)";
        echo $query;
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }


}
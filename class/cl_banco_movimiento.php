<?php

require 'cl_conectar.php';

class cl_banco_movimiento {

    private $id_banco;
    private $id_movimiento;
    private $fecha;
    private $descripcion;
    private $ingresa;
    private $egresa;
    private $id_tipo;
    
    private $id_empresa;

    /**
     * cl_banco_movimiento constructor.
     */
    public function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getIdBanco() {
        return $this->id_banco;
    }

    /**
     * @param mixed $id_banco
     */
    public function setIdBanco($id_banco) {
        $this->id_banco = $id_banco;
    }

    /**
     * @return mixed
     */
    public function getIdMovimiento() {
        return $this->id_movimiento;
    }

    /**
     * @param mixed $id_movimiento
     */
    public function setIdMovimiento($id_movimiento) {
        $this->id_movimiento = $id_movimiento;
    }

    /**
     * @return mixed
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getIngresa() {
        return $this->ingresa;
    }

    /**
     * @param mixed $ingresa
     */
    public function setIngresa($ingresa) {
        $this->ingresa = $ingresa;
    }

    /**
     * @return mixed
     */
    public function getEgresa() {
        return $this->egresa;
    }

    /**
     * @param mixed $egresa
     */
    public function setEgresa($egresa) {
        $this->egresa = $egresa;
    }

    /**
     * @return mixed
     */
    public function getIdTipo() {
        return $this->id_tipo;
    }

    /**
     * @param mixed $id_tipo
     */
    public function setIdTipo($id_tipo) {
        $this->id_tipo = $id_tipo;
    }
    
    public function setIdEmpresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

    public function obtener_codigo() {
        global $conn;
        $query = "select ifnull(max(id_movimiento) + 1, 1) as codigo 
        from bancos_movimientos ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_movimiento = $fila ['codigo'];
            }
        }
    }

    public function insertar() {
        global $conn;
        $query = "insert into bancos_movimientos "
                . "values ('$this->id_movimiento',"
                . " '$this->id_banco', "
                . "now(), "
                . "'$this->descripcion',"
                . " '$this->ingresa', "
                . "'$this->egresa',"
                . " '$this->id_tipo')";

        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in bancos_movimientos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        insert_caja_m();
        
        return $grabado;
    }

    public function insert_caja_m() {
        global $conn;
        $query = "INSERT INTO caja_movimiento 
            VALUES(
                '$this->id_empresa', 
                now(), 
                '$this->id_movimiento', 
                '$this->ingresa', 
                '$this->retira', 
                '$this->glosa', 
                '$this->id_usuario'
                );";
        
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in caja movimiento: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }

        return $grabado;
    }

    function verFilas() {
        global $conn;
        $query = "select bm.fecha, bm.descripcion, bm.ingresa, bm.egresa, bm.id_movimiento, bmt.nombre 
            from bancos_movimientos as bm 
            inner join bancos_movimientos_tipo bmt on bm.id_tipo = bmt.id_tipo 
            where bm.id_banco ='$this->id_banco' 
            order by bm.fecha asc, bm.id_movimiento asc";
        $resultado = $conn->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

}

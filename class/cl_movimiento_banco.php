<?php

include 'cl_conectar.php';

class cl_caja_movimiento {

    private $id_movimiento;
    private $id_banco;
    private $fecha;
    private $descripccion;
    private $ingresa;
    private $egresa;
    private $id_tipo;

    function getId_movimiento() {
        return $this->id_movimiento;
    }

    function getId_banco() {
        return $this->id_banco;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getDescripccion() {
        return $this->descripccion;
    }

    function getIngresa() {
        return $this->ingresa;
    }

    function getEgresa() {
        return $this->egresa;
    }

    function getId_tipo() {
        return $this->id_tipo;
    }

    function setId_movimiento($id_movimiento) {
        $this->id_movimiento = $id_movimiento;
    }

    function setId_banco($id_banco) {
        $this->id_banco = $id_banco;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setDescripccion($descripccion) {
        $this->descripccion = $descripccion;
    }

    function setIngresa($ingresa) {
        $this->ingresa = $ingresa;
    }

    function setEgresa($egresa) {
        $this->egresa = $egresa;
    }

    function setId_tipo($id_tipo) {
        $this->id_tipo = $id_tipo;
    }

    
    public function obtener_codigo() {
        global $conn;
        $query = "select ifnull(max(id_movimiento) + 1, 1) as codigo "
                . "from caja_movimiento "
                . "where id_empresa = '" . $this->id_empresa . "'  and id_usuario= " . $this->id_usuario;
        //echo $query;
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_movimiento = $fila ['codigo'];
            }
        }
    }

    public function insertar() {
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

    public function tabular() {
        global $conn;
        
        $query = "SELECT 
                    (ingresa-retira) AS 'MONTO', 
                    glosa AS 'DESCRIPCCION',
                    fecha AS 'FECHA'
                        FROM
                          caja_movimiento;";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in caja movimiento: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }

        return $resultado;
    }

}

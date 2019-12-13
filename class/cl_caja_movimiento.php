<?php

include 'cl_conectar.php';

class cl_caja_movimiento {

    private $id_empresa;
    private $fecha;
    private $id_movimiento;
    private $ingresa;
    private $retira;
    private $glosa;
    private $id_usuario;

    /**
     * cl_caja_movimiento constructor.
     */
    public function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getIdEmpresa() {
        return $this->id_empresa;
    }

    /**
     * @param mixed $id_empresa
     */
    public function setIdEmpresa($id_empresa) {
        $this->id_empresa = $id_empresa;
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
    public function getRetira() {
        return $this->retira;
    }

    /**
     * @param mixed $retira
     */
    public function setRetira($retira) {
        $this->retira = $retira;
    }

    /**
     * @return mixed
     */
    public function getGlosa() {
        return $this->glosa;
    }

    /**
     * @param mixed $glosa
     */
    public function setGlosa($glosa) {
        $this->glosa = $glosa;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario() {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
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

    public function verFilas() {
        global $conn;
        
        $query = "SELECT (cm.ingresa-cm.retira) AS 'MONTO', cm.glosa AS 'DESCRIPCCION', cm.id_movimiento, u.username 
            FROM caja_movimiento as cm
            inner join usuario u on cm.id_usuario = u.id_usuario and cm.id_empresa = u.id_empresa
            where cm.fecha = '$this->fecha' and cm.id_empresa = '$this->id_empresa'";
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

<?php
require 'cl_conectar.php';

class cl_sucursal {
    private $id_sucursal;
    private $id_empresa;
    private $nombre;
    private $direccion;
    private $ubigeo;
    private $distrito;
    private $provincia;
    private $departamento;
    private $codsunat;

    /**
     * cl_sucursal constructor.
     */
    public function __construct() {
    }

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
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDireccion() {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getUbigeo() {
        return $this->ubigeo;
    }

    /**
     * @param mixed $ubigeo
     */
    public function setUbigeo($ubigeo) {
        $this->ubigeo = $ubigeo;
    }

    /**
     * @return mixed
     */
    public function getDistrito() {
        return $this->distrito;
    }

    /**
     * @param mixed $distrito
     */
    public function setDistrito($distrito) {
        $this->distrito = $distrito;
    }

    /**
     * @return mixed
     */
    public function getProvincia() {
        return $this->provincia;
    }

    /**
     * @param mixed $provincia
     */
    public function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    /**
     * @return mixed
     */
    public function getDepartamento() {
        return $this->departamento;
    }

    /**
     * @param mixed $departamento
     */
    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    /**
     * @return mixed
     */
    public function getCodsunat() {
        return $this->codsunat;
    }

    /**
     * @param mixed $codsunat
     */
    public function setCodsunat($codsunat) {
        $this->codsunat = $codsunat;
    }

    public function obtener_codigo(){
        global $conn;
        $query="select ifnull(max(id_sucursal)+1,1) as codigo 
                    from sucursales";
        $resultado= $conn->query($query);
        if ($resultado->num_rows>0){
            while ($fila=$resultado->fetch_assoc()){
                $this->id_sucursal=$fila['codigo'];
            }
        }
    }

    public function insertar(){
        global $conn;
        $query = "insert into sucursales values ('".$this->id_sucursal."', '".$this->id_empresa."', '".$this->nombre."', '".
        $this->direccion."', '".$this->ubigeo."', '".$this->distrito."', '".$this->provincia."', '".$this->departamento."', '".$this->codsunat."')";
        $resultado= $conn-$query($query);
        if(!$resultado){
            die('Could not enter data in sucursales: ' .mysqli_error($conn));
        }else{
            $grabado=true;
        }
        return $grabado;
    }

    public function modificar(){
        global $conn;
        $query= "update sucursales set nombre = '$this->nombre', direccion = '$this->direccion', ubigeo= '$this->ubigeo', distrito= '$this->distrito', provincia='$this->provincia', departamento= '$this->departamento', codsunat = '$this->codsunat', id_empresa = '$this->id_empresa'
        where id_sucursal= '$this->id_sucursal' ";
        $resultado= $conn->query($query);
        if(!$resultado){
            die('Could not enter data in sucursales: ' .mysqli_error($conn));
        }else{
            $grabado=true;
        }
        return $grabado;
    }

    public function obtener_datos(){
        $existe=false;
        global $conn;
        $query= "select * from sucursales where id_sucursal = '$this->id_sucursal'";
        $resultado=$conn->query($query);
        if($resultado->num_rows>0){
            $existe=true;
            while ($fila= $resultado->fetch_assoc()){
                $this->id_empresa= $fila['id_empresa'];
                $this->nombre= $fila['nombre'];
                $this->direccion=$fila['direccion'];
                $this->ubigeo=$fila['ubigeo'];
                $this->distrito=$fila['distrito'];
                $this->provincia=$fila['provincia'];
                $this->departamento=$fila['departamento'];
                $this->codsunat=$fila['codsunat'];
            }
        }
        return $existe;
    }

    public function verFilas(){
        global $conn;
        $query="select * from sucursales 
                where id_empresa = '$this->id_empresa' 
                order by nombre asc ";
        $resultado = $conn->query($query);
        $fila= $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
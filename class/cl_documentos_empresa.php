<?php
/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 14/03/2019
 * Time: 06:48 PM
 */
include 'cl_conectar.php';

class cl_documentos_empresa
{
    private $id_documento;
    private $id_empresa;
    private $serie;
    private $numero;

    /**
     * cl_documentos_empresa constructor.
     */
    public function __construct()
    {
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

    public function insertar()
    {
        global $conn;
        $query = "insert into documentos_empresa values ('".$this->id_documento."', '".$this->id_empresa."', '".$this->serie."', '".$this->numero."')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in documentos_empresa: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        $conn->close();
        return $grabado;
    }

    public function obtener_datos() {
        $existe = false;
        global $conn;
        $query = "select * from documentos_empresa where id_documento = '" . $this->id_documento . "' and id_empresa = '" . $this->id_empresa . "'";

        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_documento = $fila['id_documento'];
                $this->serie = $fila['serie'];
                $this->numero = $fila['numero'];
            }
        }
        return $existe;
    }

    function ver_documentos() {
        global $conn;
        $query = "select de.id_documento, ds.nombre, de.serie, de.numero 
            from documentos_empresa de 
            inner join documentos_sunat ds on de.id_documento = ds.id_documento 
            where de.id_empresa = '" . $this->id_empresa . "' 
            order by ds.nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
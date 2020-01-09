<?php
include 'cl_conectar.php';

class cl_producto_minsa
{
    private $nombre;
    private $id_presentacion;
    private $id_laboratorio;

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getIdPresentacion()
    {
        return $this->id_presentacion;
    }

    /**
     * @param mixed $id_presentacion
     */
    public function setIdPresentacion($id_presentacion)
    {
        $this->id_presentacion = $id_presentacion;
    }

    /**
     * @return mixed
     */
    public function getIdLaboratorio()
    {
        return $this->id_laboratorio;
    }

    /**
     * @param mixed $id_laboratorio
     */
    public function setIdLaboratorio($id_laboratorio)
    {
        $this->id_laboratorio = $id_laboratorio;
    }


}
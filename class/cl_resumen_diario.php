<?php


class cl_resumen_diario
{
    private $id_resumen_diario;
    private $id_empresa;
    private $fecha;
    private $ticket;
    private $cantidad_items;
    private $tipo;

    /**
     * cl_resumen_diario constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdResumenDiario()
    {
        return $this->id_resumen_diario;
    }

    /**
     * @param mixed $id_resumen_diario
     */
    public function setIdResumenDiario($id_resumen_diario)
    {
        $this->id_resumen_diario = $id_resumen_diario;
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
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return mixed
     */
    public function getCantidadItems()
    {
        return $this->cantidad_items;
    }

    /**
     * @param mixed $cantidad_items
     */
    public function setCantidadItems($cantidad_items)
    {
        $this->cantidad_items = $cantidad_items;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function obtenerId()
    {
        global $conn;
        $query = "select ifnull(max(id_resumen_diario) + 1, 1) as codigo 
                from resumen_diario ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_resumen_diario= $fila ['codigo'];
            }
        }

    }

    public function insertar()
    {
        global $conn;
        $sql = "insert into resumen_diario 
        values ('$this->id_resumen_diario', '$this->id_empresa', '$this->fecha', '$this->ticket', '$this->cantidad_items', '$this->tipo')";
        echo $sql;
        return $conn->query($sql);
    }
}
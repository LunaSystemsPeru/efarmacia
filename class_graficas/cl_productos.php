<?php
if (!isset($_SESSION)) {
    session_start();
}

require '../class/cl_conectar.php';

class cl_productos
{
    private $id_empresa;

    /**
     * cl_inicio constructor.
     */
    public function __construct()
    {
        $this->id_empresa = $_SESSION['id_empresa'];
    }

    function verMontoLaboratorio () {
        global $conn;
        $query = "select sum(p.cantidad * p.precio) as total_actual, l.nombre
        from producto as p
        inner join laboratorio l on p.id_laboratorio = l.id_laboratorio
        where p.id_empresa = '$this->id_empresa'
        group by p.id_laboratorio
        order by sum(p.cantidad * p.precio)";
        $resultado = $conn->query($query);
        $i = 0;
        $registros = array();
        while ($row = $resultado->fetch_assoc()) {
            $registros[$i] = $row;
            $i++;
        };
        //return json_encode(array('data' => $registros));
        return json_encode($registros);
    }

}
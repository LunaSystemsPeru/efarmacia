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
        $query = "SELECT SUM(p.cantidad * p.precio) AS total_actual, l.nombre
        FROM producto AS p
        INNER JOIN productos_minsa AS pm 
    ON p.id_producto = pm.id_producto_sistema 
        INNER JOIN laboratorio l ON pm .id_laboratorio = l.id_laboratorio
        WHERE p.id_empresa = '$this->id_empresa'
        GROUP BY pm .id_laboratorio
        ORDER BY SUM(p.cantidad * p.precio)";
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
<?php
if (!isset($_SESSION)) {
    session_start();
}

require '../class/cl_conectar.php';

class cl_productos
{
    private $id_empresa;
    private $id_sucursal;

    /**
     * cl_inicio constructor.
     */
    public function __construct()
    {
        $this->id_empresa = $_SESSION['id_empresa'];
        $this->id_sucursal = $_SESSION['id_sucursal'];
    }

    function verMontoLaboratorio()
    {
        global $conn;
        $query = "SELECT SUM(ps.cantidad * ps.pventa) AS total_actual, l.nombre
            FROM productos_sucursales AS ps
            inner join producto as p on p.id_empresa = ps.id_empresa and p.id_producto = ps.id_producto
            INNER JOIN laboratorio l ON p .id_laboratorio = l.id_laboratorio
            WHERE ps.id_empresa = '$this->id_empresa' and ps.id_sucursal = '$this->id_sucursal'
            GROUP BY p.id_laboratorio
            ORDER BY SUM(ps.cantidad * ps.pventa)";
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
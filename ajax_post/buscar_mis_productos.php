<?php
session_start();
require '../class/cl_conectar.php';
global $conn;
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "SELECT 
          ps.cantidad, p.id_producto, p.nombre, ps.pventa as precio, ps.pcompra as costo, ps.vcto, ps.lote,
          l.nombre AS laboratorio,
          pr.nombre AS presentacion 
        FROM
             productos_sucursales as ps 
             inner join producto as p on p.id_producto = ps.id_producto and p.id_empresa = ps.id_empresa
          INNER JOIN laboratorio AS l 
            ON p.id_laboratorio = l.id_laboratorio 
          INNER JOIN presentacion AS pr 
            ON p.id_presentacion = pr.id_presentacion 
            WHERE ps.id_sucursal= '{$_SESSION['id_sucursal']}' and ps.id_empresa = '{$_SESSION['id_empresa']}' and  p.nombre LIKE '%$searchTerm%'";
// echo $query;
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {

        $a_json_row['value'] = $row['nombre'] . " - " . $row['presentacion'] . " - " . $row['laboratorio'] . " - S/ " . $row['precio'] . " - C.Actual: " . $row['cantidad'];
        $a_json_row['id'] = $row['id_producto'];
        $a_json_row['nombre'] = $row['nombre'];
        $a_json_row['presentacion'] = $row['presentacion'];
        $a_json_row['laboratorio'] = $row['laboratorio'];
        $a_json_row["cantidad"] = $row['cantidad'];
        $a_json_row["precio"] = $row['precio'];
        $a_json_row["costo"] = $row['costo'];
        $a_json_row["vcto"] = $row['vcto'];
        $a_json_row["lote"] = $row['lote'];
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();

<?php
session_start();
require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "SELECT 
          p.*,
          pm.*,
          l.nombre AS laboratorio,
          pr.nombre AS presentacion 
        FROM
          productos_minsa AS pm 
          INNER JOIN producto AS p 
            ON pm.id_producto_minsa = p.id_producto 
          INNER JOIN laboratorio AS l 
            ON pm.id_laboratorio = l.id_laboratorio 
          INNER JOIN presentacion AS pr 
            ON pm.id_presentacion = pr.id_presentacion 
            WHERE p.id_empresa= '{$_SESSION['id_empresa']}' and  pm.nombre LIKE '%$searchTerm%'";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {

        $a_json_row['value'] = $row['nombre'] . " - " . $row['presentacion'] . " - " . $row['laboratorio'];
        $a_json_row['id'] = $row['id_producto_sistema'];
        $a_json_row['nombre'] = $row['nombre'];
        $a_json_row["cantidad"]=$row['cantidad'];
        $a_json_row["precio"]=$row['precio'];
        $a_json_row["costo"]=$row['costo'];
        $a_json_row["vcto"]=$row['vcto'];
        $a_json_row["lote"]=$row['lote'];
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();
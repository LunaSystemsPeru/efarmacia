<?php
session_start();
require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "select documento, nombre, direccion, id_cliente 
from cliente 
where id_empresa = '" . $_SESSION['id_empresa'] . "' and (documento like '%" . $searchTerm . "%' or nombre like '%" . $searchTerm . "%') 
order by nombre asc";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $razon_social = $row["nombre"];
        $ruc = $row["documento"];
        $direccion = $row['direccion'];
        $a_json_row['value'] = $ruc . " | " . $razon_social;
        $a_json_row['id'] = $row['id_cliente'];
        $a_json_row['ruc'] = $ruc;
        $a_json_row['razon_social'] = $razon_social;
        $a_json_row['direccion'] = $direccion;
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();

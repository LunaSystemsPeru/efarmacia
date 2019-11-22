<?php
session_start();
require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "select p.id_producto, p.nombre, p.principio_activo, pr.nombre as npresentacion, l.nombre as nlaboratorio, p.cantidad, p.costo, p.precio, p.lote, p.vcto "
    . "from producto as p "
    . "inner join laboratorio as l on p.id_laboratorio = l.id_laboratorio "
    . "inner join presentacion pr on p.id_presentacion = pr.id_presentacion "
    . "where p.id_empresa = '" . $_SESSION['id_empresa'] . "' and (p.nombre like '%" . $searchTerm . "%' or p.principio_activo like '%" . $searchTerm . "%') "
    . "order by p.nombre asc";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $a_json_row['value'] = $row['nombre'] . " - " . $row['npresentacion'] . " - " . $row['nlaboratorio'] . " | P. Act.: " . $row['principio_activo'] . " | Precio: " . $row['precio'] . " | Lote: " . $row['vcto'] . " - " . $row['lote'];
        $a_json_row['id'] = $row['id_producto'];
        $a_json_row['nombre'] = $row['nombre'] . " - " . $row['npresentacion'] . " - " . $row['nlaboratorio'];
        $a_json_row['cantidad'] = $row['cantidad'];
        $a_json_row['costo'] = $row['costo'];
        $a_json_row['precio'] = $row['precio'];
        $a_json_row['vcto'] = $row['vcto'];
        $a_json_row['lote'] = $row['lote'];
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();

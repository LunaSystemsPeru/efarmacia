<?php
session_start();

require '../class/cl_cliente.php';
$c_cliente = new cl_cliente();
$c_cliente->setIdEmpresa($_SESSION['id_empresa']);

$c_cliente->setDocumento(filter_input(INPUT_POST, 'input_ndocumento'));
$c_cliente->setNombre(filter_input(INPUT_POST, 'input_datos'));
$c_cliente->setDireccion(filter_input(INPUT_POST, 'input_direccion'));
$c_cliente->setTelefono(filter_input(INPUT_POST, 'input_telefono'));

if (filter_input(INPUT_POST, 'hidden_id_cliente')) {
    $c_cliente->setIdCliente(filter_input(INPUT_POST, 'hidden_id_cliente'));
    $c_cliente->modificar();
} else {
    $c_cliente->obtener_codigo();
    $c_cliente->insertar();
}

    header("Location: ../ver_clientes.php");

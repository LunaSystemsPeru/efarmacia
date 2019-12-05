<?php
session_start();
require '../class/cl_usuario.php';
$c_usuario = new cl_usuario();

$c_usuario->setIdEmpresa($_SESSION['id_empresa']);
$c_usuario->setEmail(filter_input(INPUT_POST, 'input_email'));
$c_usuario->setTelefono(filter_input(INPUT_POST, 'input_telefono'));
$c_usuario->setNombre(filter_input(INPUT_POST, 'input_datos'));
$c_usuario->setPassword(filter_input(INPUT_POST, 'input_contrasena'));
$c_usuario->setUsername(filter_input(INPUT_POST, 'input_nick'));

$c_usuario->setIdUsuario(filter_input(INPUT_POST, 'hidden_id_usuario'));

if ($c_usuario->getIdUsuario() == "" || $c_usuario->getIdUsuario() == 0) {
    $c_usuario->obtener_codigo();
    $c_usuario->insertar();
} else {
    $c_usuario->modificar();
}

header("Location: ../ver_usuarios.php");

<?php

ini_set('session.cache_expire', 200000);
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 2000000);
ini_set('session.gc_maxlifetime', 200000); //el mas importante

session_start();
require '../class/cl_usuario.php';
require '../class/cl_empresa.php';

$c_empresa = new cl_empresa();
$c_usuario = new cl_usuario();

$c_empresa->setRuc(filter_input(INPUT_POST, 'input_ruc'));
$c_usuario->setUsername(filter_input(INPUT_POST, 'input_username'));
$password = filter_input(INPUT_POST, 'input_password');

$existe_ruc = $c_empresa->validar_ruc();

if ($existe_ruc) {
    $c_empresa->obtener_datos();
    $c_usuario->setIdEmpresa($c_empresa->getIdEmpresa());
    $existe_usuario = $c_usuario->validar_username();
    if ($existe_usuario) {
        $c_usuario->obtener_datos();
        if ($password == $c_usuario->getPassword()) {
            $_SESSION['id_empresa'] = $c_empresa->getIdEmpresa();
            $_SESSION['id_usuario'] = $c_usuario->getIdUsuario();
            $_SESSION['nombre_comercial'] = $c_empresa->getNombreComercial();
            $_SESSION['nombre_usuario'] = $c_usuario->getNombre();


            header("Location: ../index.php");
        }
    } else {
        header("../login.php?error=2");
    }
} else {
    header("../login.php?error=1");
}


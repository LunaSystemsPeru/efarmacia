<?php

ini_set('session.cache_expire', 200000);
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 2000000);
ini_set('session.gc_maxlifetime', 200000); //el mas importante

session_start();

require '../class/cl_usuario.php';
require '../class/cl_empresa.php';
require '../class/cl_sucursal.php';

$c_empresa = new cl_empresa();
$c_usuario = new cl_usuario();
$c_sucursal = new cl_sucursal();

$c_usuario->setUsername(filter_input(INPUT_POST, 'input_username'));
$password = filter_input(INPUT_POST, 'input_password');

$existe_usuario = $c_usuario->validar_username();
if ($existe_usuario) {
    $c_usuario->obtener_datos();

    $c_sucursal->setIdSucursal($c_usuario->getIdSucursal());
    $c_sucursal->setIdEmpresa($c_usuario->getIdEmpresa());
    $c_sucursal->obtener_datos();

    $c_empresa->setIdEmpresa($c_usuario->getIdEmpresa());
    $c_empresa->obtener_datos();


    //echo $c_usuario->getPassword();
    if ($password == $c_usuario->getPassword()) {
        $c_usuario->actualizarFecha();
        $_SESSION['id_empresa'] = $c_empresa->getIdEmpresa();
        $_SESSION['id_usuario'] = $c_usuario->getIdUsuario();
        $_SESSION['nombre_comercial'] = $c_empresa->getNombreComercial();
        $_SESSION['nombre_usuario'] = $c_usuario->getNombre();
        $_SESSION['id_sucursal'] = $c_usuario->getIdSucursal();
        $_SESSION['nombre_sucursal'] = $c_sucursal->getNombre();
        header("Location: ../index_graficas.php");
    } else {
        header("Location: ../login.php?error=contraseña incorrecta");
    }
} else {
    header("Location: ../login.php?error=no existe");
}


<?php
session_start();

require '../class/cl_banco.php';
require '../class/cl_banco_movimiento.php';

$c_banco = new cl_banco();
$c_movimiento = new cl_banco_movimiento();

$c_banco->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$c_banco->setCuenta(filter_input(INPUT_POST, 'input_cuenta'));
$c_banco->setSaldo(filter_input(INPUT_POST, 'input_saldo'));
$c_banco->setIdEmpresa($_SESSION['id_empresa']);

$c_banco->obtener_codigo();


$c_movimiento->obtener_codigo();
$c_movimiento->setIdBanco($c_banco->getIdBanco());
$c_movimiento->setFecha(date("Y-m-d"));
$c_movimiento->setIngresa($c_banco->getSaldo());
$c_movimiento->setEgresa(0);
$c_movimiento->setIdTipo(1);
$c_movimiento->setDescripcion("APERTURA DEL BANCO");

if ($c_banco->insertar()) {
    if ($c_banco->getSaldo() > 0) {
        $c_movimiento->insertar();
    }
    header("Location: ../ver_bancos.php");
}

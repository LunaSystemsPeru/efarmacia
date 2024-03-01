<?php
date_default_timezone_set('America/Lima');

$servidor = "localhost";
$bd = "goempres_alufarma";
$usu = "goempres_root";
$pass = "k;6?6,m{7ePs";
$puerto = "3306";

try {
    $conn = new mysqli($servidor, $usu, $pass, $bd, $puerto);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $ex) {
    print_r($ex->getMessage());
}
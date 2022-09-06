<?php
date_default_timezone_set('America/Los_Angeles');

$servidor = "localhost";
$bd = "goempres_alufarma";
$usu = "goempres_root";
$pass = "k;6?6,m{7ePs";
$puerto = "3306";
$conn = new mysqli($servidor, $usu, $pass, $bd, $puerto);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
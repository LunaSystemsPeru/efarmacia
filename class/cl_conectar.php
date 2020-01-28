<?php
date_default_timezone_set('America/Los_Angeles');

$servidor = "lunasystemsperu.com";
$bd = "lsp_farmacia";
$usu = "usr_farmacia";
$pass = "U0xO13NxlQAfc15I";
$puerto = "3306";
$conn = new mysqli($servidor, $usu, $pass, $bd, $puerto);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
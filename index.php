<?php
$link = $_SERVER['HTTP_HOST'] ;
if ($link == "alufarma.ml") {
    header("Location: login.php");
} else {
    echo "pagina bloqueda, consulte con su administrador para ingresar a la pagina correcta";
}

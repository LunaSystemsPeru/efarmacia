<?php
require '../class/cl_venta.php';

$Venta = new cl_venta();

//20605162739|03|B001|7185|04/11/2023|25.00|ACEPTADO|ACTIVO|HABIDO|
//20605162739|03|B001|7186|06/11/2023|70.00|NO EXISTE|-|-|El comprobante no existe

$filetxt = $_FILES['file_txt'];

$target_dir = "tmp/";
$target_file = $target_dir . basename($_FILES["file_txt"]["name"]);

if (move_uploaded_file($_FILES["file_txt"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["file_txt"]["name"])). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}

$fp = fopen($target_file, "r");
while (!feof($fp)) {
    $linea = fgets($fp);
    $array_linea = explode("|", $linea);
    $estado = $array_linea[6];
    $estado_db = 1;
    echo $estado . " - ";
    if ($estado == 'NO EXISTE') {
        $estado_db = 0;
    }
    $Venta->setSerie($array_linea[2]);
    $Venta->setNumero($array_linea[3]);
    $Venta->setEnviadoSunat($estado_db);
    $Venta->actualizarEstadoSUNAT() ;
    echo "<br>";
}
fclose($fp);
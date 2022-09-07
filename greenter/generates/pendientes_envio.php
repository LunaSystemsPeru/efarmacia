<?php
require '../../class/cl_venta.php';

$c_venta = new cl_venta();

$array_fechas = $c_venta->verFechasPendientes();

?>
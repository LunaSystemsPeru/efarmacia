<?php
session_start();
require "../class/cl_compra_pago.php";
require "../class/cl_compra.php";
require "../class/cl_proveedor.php";
$c_compra_pago=new cl_compra_pago();
$c_compra=new cl_compra();
$c_proveedor=new cl_proveedor();


$idCompra=filter_input(INPUT_POST, 'id_compra');
$periodo=filter_input(INPUT_POST, 'periodo');
$idEmpresa=$_SESSION["id_empresa"];

$c_compra_pago->setIdEmpresa($idEmpresa);
$c_compra_pago->setPeriodo($periodo);
$c_compra_pago->setIdCompra($idCompra);

$c_compra->setIdEmpresa($idEmpresa);
$c_compra->setPeriodo($periodo);
$c_compra->setIdCompra($idCompra);


if ($c_compra->obtenerDatos()){

    $c_proveedor->setIdEmpresa($idEmpresa);
    $c_proveedor->setIdProveedor($c_compra->getIdProveedor());
    $c_proveedor->obtener_datos();
    $pagado=$c_compra->getPagado();

    $listaCompraPago=$c_compra_pago->verCompasPagos();

    echo "Fecha : ".$c_compra->getFecha()." <br/>";
    echo "Documento : ".$c_compra->getSerie() ."|". $c_compra->getNumero()." <br/>";
    echo "Proveedor : ".$c_proveedor->getNombre()." <br/>";
    echo "Total : {$c_compra->getTotal()}<br/>";
    echo "<div class='table-responsive'>";
    echo     "<table class='table table-hover table-condensed'>";
    echo         "<thead>";
    echo             "<tr>";
    echo                 "<th>#</th>";
    echo                 "<th>Fecha</th>";
    echo                 "<th>Monto</th>";
    echo                 "<th></th>";
    echo             "</tr>";
    echo         "</thead>";
    echo         "<tbody>";
    foreach ($listaCompraPago as $fila){

    echo             "<tr>";
    echo                 "<th scope='row'>".$fila['id_pago']."</th>";
    echo                 "<td>".$fila['fecha']."</td>";
    echo                 "<td>{$fila['monto']}</td>";
    echo                "<td><button class='btn btn-info btn-sm' title='Eliminar'><i class='fa fa-eye-slash'></i></button></td>";
    echo             "</tr>";

    }

    echo         "</tbody>";
    if ($pagado!=$c_compra->getTotal()){
        echo     "</table> <br/><br/>";
        echo     "<button data-toggle='modal' data-target='#modalPagar' type='button' class='btn btn-primary'>Agregar Pago</button>";
    }

    echo "</div>";
}

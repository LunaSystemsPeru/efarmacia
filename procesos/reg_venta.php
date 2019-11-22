<?php
session_start();

require '../class/cl_venta.php';
require '../class/cl_venta_productos.php';
require '../class/cl_venta_cobros.php';
require '../class/cl_documentos_empresa.php';
require '../class/cl_varios.php';

$c_venta = new cl_venta();
$c_detalle = new cl_venta_productos();
$c_cobros = new cl_venta_cobros();
$c_varios = new cl_varios();
$c_mis_documentos = new cl_documentos_empresa();

$c_venta->setIdEmpresa($_SESSION['id_empresa']);
$fecha = filter_input(INPUT_POST, 'input_fecha');
$c_venta->setPeriodo($c_varios->anio_de_fecha($fecha) . $c_varios->zerofill($c_varios->mes_de_fecha($fecha), 2));
$c_venta->setFecha($fecha);
$c_venta->setIdDocumento(filter_input(INPUT_POST, 'select_documento'));

$c_mis_documentos->setIdDocumento($c_venta->getIdDocumento());
$c_mis_documentos->setIdEmpresa($c_venta->getIdEmpresa());
$c_mis_documentos->obtener_datos();

$c_venta->setSerie($c_mis_documentos->getSerie());
$c_venta->setNumero($c_mis_documentos->getNumero());
$c_venta->setIdCliente(filter_input(INPUT_POST, 'hidden_id_cliente'));
$c_venta->setTotal(filter_input(INPUT_POST, 'hidden_total'));
$c_venta->setIdUsuario($_SESSION['id_usuario']);
$c_venta->obtener_codigo();

if ($c_venta->insertar()) {
    $c_detalle->setIdEmpresa($c_venta->getIdEmpresa());
    $c_detalle->setIdVenta($c_venta->getIdVenta());
    $c_detalle->setPeriodo($c_venta->getPeriodo());
    $a_detalle = $_SESSION['productos_venta'];
    foreach ($a_detalle as $value) {
        $c_detalle->setIdProducto($value['id_producto']);
        $c_detalle->setLote($value['lote']);
        $c_detalle->setVencimiento($value['vcto']);
        $c_detalle->setCantidad($value['cantidad']);
        $c_detalle->setCosto($value['costo']);
        $c_detalle->setVenta($value['precio']);
        $c_detalle->insertar();
    }

    $c_cobros->setIdEmpresa($c_venta->getIdEmpresa());
    $c_cobros->setPeriodo($c_venta->getPeriodo());
    $c_cobros->setIdVenta($c_venta->getIdVenta());
    $c_cobros->setFecha($c_venta->getFecha());
    $c_cobros->setMonto($c_venta->getTotal());
    $c_cobros->obtener_codigo();
    $c_cobros->insertar();


    header("Location: ../ver_ventas.php");

}
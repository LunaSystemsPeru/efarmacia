<?php
session_start();

require '../class/cl_venta.php';
require '../class/cl_venta_productos.php';
require '../class/cl_venta_cobros.php';
require '../class/cl_documentos_empresa.php';
require '../class_varios/SendCurlVenta.php';
require '../class/cl_varios.php';
require '../class/cl_cliente.php';

$c_venta = new cl_venta();
$c_detalle = new cl_venta_productos();
$c_cobros = new cl_venta_cobros();
$c_varios = new cl_varios();
$c_mis_documentos = new cl_documentos_empresa();
$c_cliente = new cl_cliente();
$sendCurlVenta = new SendCurlVenta();
$id_empresa = $_SESSION['id_empresa'];
$id_sucursal = $_SESSION['id_sucursal'];

$c_cliente->setIdEmpresa($id_empresa);
$c_cliente->setDocumento(filter_input(INPUT_POST, 'input_documento_cliente'));
$c_cliente->setNombre(addslashes(filter_input(INPUT_POST, 'input_cliente')));
$c_cliente->setDireccion(addslashes(filter_input(INPUT_POST, 'input_direccion')));

$tipo_doc = filter_input(INPUT_POST, 'select_documento');

if ($tipo_doc == 1) {
    $c_cliente->setIdCliente(0);
    $c_cliente->obtener_datos();
}
if ($tipo_doc == 2 || $tipo_doc == 3) {
    if ($c_cliente->getDocumento() == "") {
        $c_cliente->obtener_codigo();
        $c_cliente->setDocumento("SD" . $c_varios->generarCodigo(5));
        $c_cliente->setTotalPagado(0);
        $c_cliente->setTelefono(0);
        $c_cliente->setTotalVenta(0);
        $c_cliente->setUltimaVenta(date("Y-m-d"));
        $c_cliente->insertar();
    } else {
        if (!$c_cliente->buscar_documento()) {
            $c_cliente->obtener_codigo();
            $c_cliente->setTotalPagado(0);
            $c_cliente->setTelefono(0);
            $c_cliente->setTotalVenta(0);
            $c_cliente->setUltimaVenta(date("Y-m-d"));
            $c_cliente->insertar();
        }
    }
}


$c_venta->setIdEmpresa($id_empresa);
$c_venta->setIdSucursal($id_sucursal);

$fecha = filter_input(INPUT_POST, 'input_fecha');

$c_venta->setPeriodo($c_varios->anio_de_fecha($fecha) . $c_varios->zerofill($c_varios->mes_de_fecha($fecha), 2));
$c_venta->setFecha($fecha);
$c_venta->setIdDocumento(filter_input(INPUT_POST, 'select_documento'));

$c_mis_documentos->setIdDocumento($c_venta->getIdDocumento());
$c_mis_documentos->setIdEmpresa($c_venta->getIdEmpresa());
$c_mis_documentos->setIdSucursal($c_venta->getIdSucursal());
$c_mis_documentos->obtener_datos();

$c_venta->setSerie($c_mis_documentos->getSerie());
$c_venta->setNumero($c_mis_documentos->getNumero());
$c_venta->setIdCliente($c_cliente->getIdCliente());
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

    $sendCurlVenta->setIdTido($c_mis_documentos->getIdDocumento());
    $sendCurlVenta->setIdVenta($c_venta->getIdVenta());
    $sendCurlVenta->setPeriodo($c_varios->fecha_periodo($c_venta->getFecha()));
    $sendCurlVenta->enviar_json();
    echo "{\"venta\":" . $c_venta->getIdVenta() . ",\"periodo\":" . $c_venta->getPeriodo() . "}";
    // header("Location: ../ver_ventas.php");

}
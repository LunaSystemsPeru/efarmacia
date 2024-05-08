<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

date_default_timezone_set('America/Lima');
session_start();
//ob_start();
//require('../includes/fpdf.php');

require '../class/cl_empresa.php';
require '../class/cl_sucursal.php';
require '../class/cl_venta.php';
require '../class/cl_venta_productos.php';
require '../class/cl_cliente.php';
require '../class/cl_documentos_sunat.php';
require '../class_varios/NumerosaLetras.php';
require '../class/cl_venta_sunat.php';
require '../class_varios/Varios.php';

require('../class_varios/fpdf/fpdf.php');
define('FPDF_FONTPATH', '../class_varios/fpdf/font/');

$id_venta = filter_input(INPUT_GET, 'id_venta', FILTER_SANITIZE_NUMBER_INT);
$periodo = filter_input(INPUT_GET, 'periodo', FILTER_SANITIZE_NUMBER_INT);

$c_varios = new Varios();
$c_numeros_letras = new NumerosaLetras();

$c_venta = new cl_venta();
$c_venta->setIdVenta($id_venta);
$c_venta->setIdEmpresa($_SESSION['id_empresa']);
$c_venta->setPeriodo($periodo);
$c_venta->obtener_datos();

$c_sucursal = new cl_sucursal();
$c_sucursal->setIdSucursal($c_venta->getIdSucursal());
$c_sucursal->obtener_datos();

$c_empresa = new cl_empresa();
$c_empresa->setIdEmpresa($c_venta->getIdEmpresa());
$c_empresa->obtener_datos();

$c_cliente = new cl_cliente();
$c_cliente->setIdCliente($c_venta->getIdCliente());
$c_cliente->setIdEmpresa($_SESSION['id_empresa']);
$c_cliente->obtener_datos();

$c_tido = new cl_documentos_sunat();
$c_tido->setIdDocumento($c_venta->getIdDocumento());
$c_tido->obtener_datos();

$serie = $c_varios->zerofill($c_venta->getSerie(), 4);
$numero = $c_varios->zerofill($c_venta->getNumero(), 8);

$c_detalle = new cl_venta_productos();
$c_detalle->setIdVenta($c_venta->getIdVenta());
$c_detalle->setPeriodo($periodo);
$c_detalle->setIdEmpresa($_SESSION['id_empresa']);

$c_recibido = new cl_venta_sunat();
$c_recibido->setIdVenta($c_venta->getIdVenta());
$c_recibido->setIdEmpresa($_SESSION['id_empresa']);
$c_recibido->setPeriodo($periodo);
$c_recibido->obtener_datos();

$id_moneda = 1;
$nmoneda = "";
$ncorto = "";
if ($id_moneda == 1) {
    $nmoneda = "SOLES";
    $ncorto = "PEN";
}
if ($id_moneda == 2) {
    $nmoneda = "DOLAR AMERICANO";
    $ncorto = "USD";
}

if (strlen($c_cliente->getDocumento()) == 7) {
    $c_cliente->setDocumento("00000000");
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(10, 8, 10);
$pdf->SetAutoPageBreak(true, 8);
$pdf->AddPage();

$imagen = $c_empresa->getLogo();
$r = 100;
$g = 100;
$b = 100;

$pdf->Image('../images/' . $imagen, 10, 10, 29, 25);
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);


$pdf->SetFont('Arial', 'B', 12);
$pdf->Rect(140, 10, 60, 24);
$pdf->SetTextColor(00, 00, 0);
$pdf->SetY(10);
$pdf->SetX(140);
$pdf->Cell(60, 6, "RUC: " . $c_empresa->getRuc(), 0, 1, 'C');
$pdf->SetX(140);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
$pdf->SetFillColor($r, $g, $b);
$pdf->MultiCell(60, 6, $c_tido->getNombre() . " ELECTRONICA", 0, "C", 1);
//$pdf->Cell(70, 8, $c_tido->getNombre() . " ELECTRONICA", 0, 1, 'C', 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(140);
$pdf->SetTextColor(00, 00, 0);
$pdf->Cell(60, 6, $serie . "-" . $numero, 0, 1, 'C');

$pdf->SetY(10);
$pdf->SetX(53);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(110, 4, $c_empresa->getRazonSocial(), 0, 1, 'L');
$pdf->SetX(53);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(75, 4, $c_sucursal->getDireccion(), 0, "L");
$pdf->SetX(53);
$pdf->Cell(75, 4, "Telefono: ", 0, 1, 'L');

$pdf->SetY(36);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
$pdf->SetFillColor($r, $g, $b);
$pdf->Cell(190, 6, "FACTURADO A ", 0, 1, 'C', 1);
$pdf->Ln(1);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);

$pdf->Cell(25, 4, "CLIENTE: ", 0, 0, 'L');
$pdf->Cell(93, 4, $c_cliente->getDocumento(), 0, 0, 'L');
$pdf->Cell(32, 4, "FECHA EMISION:", 0, 0, 'R');
$pdf->Cell(40, 4, $c_varios->fecha_tabla($c_venta->getFecha()), 0, 1, 'C');

$pdf->Cell(118, 4, htmlentities($c_cliente->getNombre()), 0, 0, 'L');
$pdf->Cell(32, 4, "MONEDA:", 0, 0, 'R');
$pdf->Cell(40, 4, $nmoneda, 0, 1, 'C');

$pdf->Cell(25, 4, "DIRECCION:", 0, 0, 'L');
//$pdf->Cell(130, 5, htmlentities($c_entidad->getDireccion()), 0, 0, 'L');
$pdf->SetX(128);
$pdf->Cell(32, 4, "IGV:", 0, 0, 'R');
$pdf->Cell(40, 4, "18.00 %", 0, 0, 'C');
$pdf->SetX(35);
$pdf->MultiCell(90, 4, htmlentities(trim($c_cliente->getDireccion())));


$pdf->Ln(1);

$y = $pdf->GetY();
//$pdf->Line(10, $y, 200, $y);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
$pdf->SetFillColor($r, $g, $b);
$pdf->Cell(15, 5, "CANT.", 0, 0, 'C', 1);
$pdf->Cell(135, 5, "DESCRIPCION", 0, 0, 'C', 1);
$pdf->Cell(20, 5, "P.UNIT ", 0, 0, 'C', 1);
$pdf->Cell(20, 5, "P. TOTAL", 0, 1, 'C', 1);

$y = $pdf->GetY();
//$pdf->Line(10, $y, 200, $y);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);

$a_productos = $c_detalle->ver_productos();
$suma = 0;
$items = array();
$fila_productos = array();
foreach ($a_productos as $value) {
    $cantidad = $value['cantidad'];
    $precio = $value['precio'];
    $subtotal = $cantidad * $precio;
    $pdf->Cell(15, 4, $value['cantidad'], 0, 0, 'C');
    //$pdf->Cell(110, 10, $value['descripcion'], 0, 0, 'L');
    $pdf->SetX(160);
    $pdf->Cell(20, 4, number_format($precio, 2), 0, 0, 'R');
    $pdf->Cell(20, 4, number_format($subtotal, 2), 0, 0, 'R');
    $pdf->SetX(25);
    $pdf->MultiCell(135, 4, htmlentities($value['nombre'] . "-" . $value["laboratorio"] . "-" . $value["presentacion"]), 0, 'J');
    //$pdf->Ln(2);
}

$pdf->SetY(-195);

$pdf->Ln(3);
$y = $pdf->GetY();
$pdf->Line(10, $y, 200, $y);

$pdf->SetY(-184);
if ($c_venta->getIdDocumento() == 3 || $c_venta->getIdDocumento() == 2) {

    $pdf->Image('../greenter/generate_qr/temp/' . $c_recibido->getNombreXml() . '.png', 130, 108, 22, 22);
}


$pdf->Ln(2);
$pdf->Cell(170, 5, "SUB TOTAL: ", 0, 0, 'R');
$pdf->Cell(20, 5, number_format($c_venta->getTotal() / 1.18, 2), 0, 1, 'R');

$total_final = number_format($c_venta->getTotal(), 2, ".", "");
/*
$pdf->Cell(170, 4, "Operaciones Gravadas: ", 0, 0, 'R');
$pdf->Cell(20, 4, number_format($c_venta->getTotal() / 1.18, 2), 0, 1, 'R');
$pdf->Cell(170, 4, "Operaciones Inafectas: ", 0, 0, 'R');
$pdf->Cell(20, 4, number_format(0, 2), 0, 1, 'R');
$pdf->Cell(170, 4, "Operaciones Gratuitas: ", 0, 0, 'R');
$pdf->Cell(20, 4, number_format(0, 2), 0, 1, 'R');
$pdf->Cell(170, 4, "Operaciones Exoneradas: ", 0, 0, 'R');
$pdf->Cell(20, 4, number_format(0, 2), 0, 1, 'R');
$pdf->Ln(3);
*/
$pdf->Cell(70, 4, "Importe en Letras", 0, 0, 'L');
$pdf->Cell(100, 4, "IGV: ", 0, 0, 'R');
$pdf->Cell(20, 4, number_format($c_venta->getTotal() / 1.18 * 0.18, 2), 0, 1, 'R');
$pdf->Cell(120, 4, htmlentities($c_numeros_letras->to_word($total_final, $ncorto)), 0, 0, 'L');
$pdf->Cell(50, 4, "TOTAL: ", 0, 0, 'R');
$pdf->Cell(20, 4, number_format($c_venta->getTotal(), 2), 0, 1, 'R');

$pdf->Ln(3);
$y = $pdf->GetY();
$pdf->Line(10, $y, 200, $y);
$pdf->Ln(2);
$pdf->MultiCell(190, 4, htmlentities("Representacion Impresa de la " . $c_tido->getNombre() . " ELECTRONICA, visite efarmacia.lunasystemsperu.com"), 0, 'C');
$pdf->MultiCell(190, 4, htmlentities("Resumen: " . $c_recibido->getHash()), 0, 'C');

$nombre_archivo = $c_recibido->getNombreXml() . ".pdf";

//$pdf->Output();
//para descargar automatica
//$pdf->Output("../public/archivos/" . $nombre_archivo, "F");
//para abrir y generarle nombre automaticamente
$pdf->Output($nombre_archivo, "I");
//ob_end_flush();

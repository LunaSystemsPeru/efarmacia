<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Lima');
session_start();
//ob_start();
//require('../includes/fpdf.php');

require '../class/cl_empresa.php';
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

//$pdf = new FPDF('L', 'mm', array(210,148.5));
$pdf = new FPDF('P', 'mm', 'a4');
//$pdf->SetMargins(52.5, 8, 52.5);
$pdf->SetMargins(8, 8, 8);
$pdf->SetAutoPageBreak(true, 8);
$pdf->AddPage();

$imagen = $c_empresa->getLogo();
$r = 140;
$g = 73;
$b = 116;
$altura_linea = 3;

/*
$pdf->Image('../images/' . $imagen, 10, 10, 36, 20);
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);
*/

$izquierda = 0;
$izquierda = 52.5;

$pdf->Image('../images/' . $imagen, 8 + $izquierda, 8, 20, 15);
$pdf->Ln(22);


$pdf->SetY(8);
$pdf->SetX(30 + $izquierda);
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(00, 00, 0);
$pdf->Cell(70, $altura_linea, "*** " . utf8_decode($c_empresa->getNombreComercial()) . " ***", 0, 1, 'C');
$pdf->SetX(30  + $izquierda);
$pdf->MultiCell(70, $altura_linea, utf8_decode($c_empresa->getRuc() . " | " . $c_empresa->getRazonSocial()), 0, 'C');
$pdf->SetX(30 + $izquierda );
$pdf->Cell(70, $altura_linea, "Cel/Tel: " . $c_empresa->getTelefono(), 0, 1, 'C');
$pdf->SetX(30  + $izquierda);
$pdf->MultiCell(70, $altura_linea, utf8_decode($c_empresa->getDireccion()), 0, 'C');
//$pdf->SetX(30);

$pdf->SetX($izquierda);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(105, $altura_linea, $c_tido->getNombre() . " ELECTRONICA | " . $c_venta->getSerie() . " - " . $c_varios->zerofill($c_venta->getNumero(),5), 0, 1, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', '', 9);
$pdf->SetX(8 + $izquierda);
$pdf->Cell(90, $altura_linea, "Fecha: " . $c_varios->fecha_mysql_web($c_venta->getFecha()) . " " . date("H:i:s"), 0, 1, 'L');
$pdf->SetX(8 + $izquierda);
$pdf->MultiCell(90, $altura_linea, "Cliente: " . $c_cliente->getDocumento() . " | " . utf8_decode($c_cliente->getNombre()));

$pdf->Ln();
$y = $pdf->GetY();
//$pdf->Line(10, $y, 200, $y);
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
$pdf->SetFillColor($r, $g, $b);
$pdf->SetX(8 + $izquierda);
$pdf->Cell(75, 5, "Cant - Descripcion", 0, 0, 'C', 1);
$pdf->Cell(15, 5, "Parcial", 0, 1, 'C', 1);

$pdf->Ln(2);
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
    //$pdf->Cell(15, 4, $value['cantidad'], 0, 0, 'C');
    //$pdf->Cell(110, 10, $value['descripcion'], 0, 0, 'L');
    $pdf->SetX(84 + $izquierda);
    $pdf->Cell(15, 3, number_format($subtotal, 2), 0, 0, 'R');
    $pdf->SetX(8 + $izquierda);
    $pdf->MultiCell(75, 3, $cantidad . " " .$value["presentacion"] . " | " . strtoupper(utf8_decode($value['nombre'] . " | " . $value["laboratorio"] )), 0, 'J');
    //$pdf->Ln(2);
}

$pdf->SetY(-64);
$pdf->SetY(-64- 148.5);

$pdf->Ln(3);
$y = $pdf->GetY();
$pdf->Line(8 + $izquierda, $y, 98 + $izquierda, $y);

$pdf->SetY(-43);
$pdf->SetY(-43-148.5);

if ($c_venta->getIdDocumento() != 1) {
    $pdf->Image('../greenter/generate_qr/temp/' . $c_recibido->getNombreXml() . '.png', 8 + $izquierda, 88, 22, 22);
}



$pdf->Ln(2);
$pdf->SetX(8 + $izquierda);
$pdf->Cell(75, 3, "SUB TOTAL: ", 0, 0, 'R');
$pdf->Cell(15, 3, number_format($c_venta->getTotal() / 1.18, 2), 0, 1, 'R');

$total_final = number_format($c_venta->getTotal(), 2, ".", "");

$pdf->SetX(8 + $izquierda);
$pdf->Cell(50, 3, "Importe en Letras", 0, 0, 'L');
$pdf->Cell(25, 3, "IGV: ", 0, 0, 'R');
$pdf->Cell(15, 3, number_format($c_venta->getTotal() / 1.18 * 0.18, 2), 0, 1, 'R');
$pdf->SetX(8 + $izquierda);
$pdf->Cell(50, 3, utf8_decode($c_numeros_letras->to_word($total_final, $ncorto)), 0, 0, 'L');
$pdf->Cell(25, 3, "TOTAL: ", 0, 0, 'R');
$pdf->Cell(15, 3, number_format($c_venta->getTotal(), 2), 0, 1, 'R');

$pdf->Ln(3);
$y = $pdf->GetY();
$pdf->Line(8 + $izquierda, $y, 98 + $izquierda, $y);
$pdf->Ln(2);
$pdf->SetX(8 + $izquierda);
$pdf->MultiCell(90, 3, utf8_decode("Representacion Impresa de la " . $c_tido->getNombre() . " ELECTRONICA, visite efarmacia.lunasystemsperu.com"), 0, 'C');
$pdf->SetX(8 + $izquierda);
$pdf->MultiCell(90, 3, utf8_decode("Resumen: " . $c_recibido->getHash()), 0, 'C');

$nombre_archivo = $c_recibido->getNombreXml() . ".pdf";

//$pdf->Output();
//para descargar automatica
//$pdf->Output("../public/archivos/" . $nombre_archivo, "F");
//para abrir y generarle nombre automaticamente
$pdf->Output($nombre_archivo, "I");
//ob_end_flush();

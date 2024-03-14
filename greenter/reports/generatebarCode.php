<?php
require 'CodigoBarra.php';
require '../../class/cl_producto.php';

require('../../class_varios/Varios.php');
require('../../class_varios/fpdf/fpdf.php');
define('FPDF_FONTPATH', '../../class_varios/fpdf/font/');

$Producto = new cl_producto();
$CodigoBarra = new codigoBarra();
$Varios = new Varios();

$Producto->setIdEmpresa(1);
$lista_productos = $Producto->ver_productos_barras();


$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(8, 10, 8);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->SetFont('Arial', '', 6);
$pdf->SetTextColor(0, 0, 0);


$contaritems = 0;
$reseteoitems = 1;
$rompelinea = 0;
$cuentalineas = 0;
$idproducto = 0;
$nombreproducto = "";
$xactual = $pdf->GetX();
$yactual = $pdf->GetY() + 8;

$nroitemsxproducto = 12;
$nrocolumnas = 7;
$nrofilas = 17;

foreach ($lista_productos as $item) {
    $nombreproducto = $item['nombre'];
    $nombreproducto = mb_convert_encoding($item['nombre'], 'ISO-8859-1', 'UTF-8');
    $idproducto = $item['id_producto'];
    $CodigoBarra->setName($idproducto);
    $datasku = '1' . $Varios->zerofill($item['id_empresa'], 2) . $Varios->zerofill($item['id_producto'], 5);
    $CodigoBarra->setData($datasku);
    $CodigoBarra->generate();

    for ($x = 0; $x < $nroitemsxproducto; $x++) {
        if ($reseteoitems == $nrocolumnas) {
            $reseteoitems = 1;
            $rompelinea = 1;
            $cuentalineas++;
            $yactual = 15 * $cuentalineas + 16;
            $pdf->SetY($yactual);
            $pdf->SetX($xactual);

        } else {
            $pdf->SetY($yactual);

            $xnuevo = 32.3 * ($reseteoitems - 1);
            if ($xnuevo == 0) {
                $pdf->SetX(8);
            } else {
                $pdf->SetX($xnuevo + 8);
            }

            $rompelinea = 0;
        }

        //echo $idproducto;
        //$pdf->Cell(48.6, 35, $nombreproducto, 1, $rompelinea, 'C');
        $pdf->Image('temp/' . $idproducto . '.png', $pdf->GetX() + 1, $pdf->GetY() - 6, 30, 5);
        $largotexto = 100;
        $pdf->MultiCell(32.3, 2.2, (strlen($nombreproducto) > $largotexto ? substr($nombreproducto, 0, $largotexto-1) : $nombreproducto), 0, 'C');
        //$pdf->Image('barcode.png', $pdf->GetX(), $pdf->GetY(), 40, 10);


        $reseteoitems++;

        if ($cuentalineas == $nrofilas & $reseteoitems == $nrocolumnas) {
            $pdf->AddPage();
            $cuentalineas = -1;
        }
    }

    $contaritems++;

    if ($contaritems == 15) {
        break;
    }

}

$pdf->Output("hola.pdf", "I");

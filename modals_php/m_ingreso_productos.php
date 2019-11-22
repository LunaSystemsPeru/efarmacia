<?php
session_start();
require '../class/cl_ingreso_productos.php';
require '../class/cl_ingreso.php';
require '../class/cl_documentos_sunat.php';
require '../class/cl_proveedor.php';
require '../class/cl_varios.php';

$c_detalle = new cl_ingreso_productos();
$c_ingreso = new cl_ingreso();
$c_varios = new cl_varios();

$c_detalle->setIdEmpresa($_SESSION['id_empresa']);
$c_detalle->setIdIngreso(filter_input(INPUT_POST, 'id_ingreso'));
$c_detalle->setPeriodo(filter_input(INPUT_POST, 'periodo'));

$c_ingreso->setIdIngreso($c_detalle->getIdIngreso());
$c_ingreso->setPeriodo($c_detalle->getPeriodo());
$c_ingreso->setIdEmpresa($c_detalle->getIdEmpresa());
$c_ingreso->obtener_datos();

$c_proveedor = new cl_proveedor();
$c_proveedor->setIdEmpresa($c_ingreso->getIdEmpresa());
$c_proveedor->setIdProveedor($c_ingreso->getIdProveedor());
$c_proveedor->obtener_datos();

$c_tido = new cl_documentos_sunat();
$c_tido->setIdDocumento($c_ingreso->getIdDocumento());
$c_tido->obtener_datos();

$a_detalle = $c_detalle->ver_productos();

echo "Fecha de Compra: " . $c_ingreso->getFecha() . "<br>";
echo "Documento: " . $c_tido->getNombre() . " | " . strtoupper($c_ingreso->getSerie()) . " - " . $c_ingreso->getNumero(). "<br>";
echo "Proveedor: ". $c_proveedor->getDocumento() . " | " . $c_proveedor->getNombre() .  "<br>";
echo "Usuario: ". "<br>";
echo "Codigo: ". $c_ingreso->getPeriodo() . $c_varios->zerofill($c_ingreso->getIdIngreso(), 3) . "<br>";
?>

<hr>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Cant.</th>
            <th>Producto</th>
            <th>Costo</th>
            <th>P.Vta.</th>
            <th>Parcial</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_parcial = 0;
        $total_utilidad = 0;
        foreach ($a_detalle as $value) {
            $cantidad = $value['cantidad'];
            $precio = $value['precio'];
            $costo = $value['costo'];
            $parcial = $costo * $cantidad;
            $utilidad = ($precio - $costo) * $cantidad;
            $total_parcial += $parcial;
            $total_utilidad += $utilidad;
            ?>
            <tr>
                <td class="text-center"><?php echo $cantidad ?></td>
                <td><?php echo $value['nombre'] . " | " . $value['presentacion'] . " | " .$value['laboratorio'] . " | Lote: " . $value['lote'] . " | Vcto: " . $value['vcto']?></td>
                <td class="text-right"><?php echo number_format($costo, 2) ?></td>
                <td class="text-right"><?php echo number_format($precio, 2) ?></td>
                <td class="text-right"><?php echo number_format($parcial, 2) ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center"></td>
            <td class="text-right text-capitalize">TOTAL</td>
            <td class="text-right"></td>
            <td class="text-right">-</td>
            <td class="text-right"><?php echo number_format($total_parcial, 2) ?></td>
        </tr>
    </tfoot>
</table>


<?php
session_start();
require '../class/cl_venta_productos.php';

$c_detalle = new cl_venta_productos();
$c_detalle->setIdEmpresa($_SESSION['id_empresa']);
$c_detalle->setIdVenta(filter_input(INPUT_POST, 'id_venta'));
$c_detalle->setPeriodo(filter_input(INPUT_POST, 'periodo'));
$a_detalle = $c_detalle->ver_productos();
?>
<hr>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Cant.</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Parcial</th>
            <th>Utilidad</th>
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
            $parcial = $precio * $cantidad;
            $utilidad = ($precio - $costo) * $cantidad;
            $total_parcial += $parcial;
            $total_utilidad += $utilidad;
            ?>
            <tr>
                <td class="text-center"><?php echo $cantidad ?></td>
                <td><?php echo $value['nombre'] . " | " . $value['presentacion'] . " | " .$value['laboratorio'] . " | Lote: " . $value['lote'] . " | Vcto: " . $value['vcto']?></td>
                <td class="text-right"><?php echo number_format($precio, 2) ?></td>
                <td class="text-right"><?php echo number_format($parcial, 2) ?></td>
                <td class="text-right"><?php echo number_format($utilidad, 2) ?></td>
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
            <td class="text-right"><?php echo number_format($total_parcial, 2) ?></td>
            <td class="text-right"><?php echo number_format($total_utilidad, 2) ?></td>
        </tr>
    </tfoot>
</table>

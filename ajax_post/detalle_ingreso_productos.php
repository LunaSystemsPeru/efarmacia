<?php
$array = $_SESSION['productos_ingreso'];
$subtotal = 0;
$item = 1;

foreach ($array as $value) {
    $cantidad = $value['cantidad'];
    $costo = $value['costo'];
    $parcial = $cantidad * $costo;
    $subtotal += $parcial;
    ?>
    <tr>
        <td><?php echo $item?></td>
        <td><?php echo $value['id_producto'] . " | " . $value['descripcion'] ?></td>
        <td class="text-center"><?php echo $value['vcto'] . " | " . $value['lote'] ?></td>
        <td class="text-center"><?php echo $value['cantidad']?></td>
        <td class="text-right"><?php echo number_format($value['costo'], 2)?></td>
        <td class="text-right"><?php echo number_format($value['precio'], 2)?></td>
        <td class="text-right"><?php echo number_format($value['costo'] * $value['cantidad'], 2)?></td>
        <td class="text-center">
            <button class="btn btn-danger btn-sm" title="Eliminar Documento" onclick="eliminar_item(<?php echo $value['id_producto'] ?>)"><i class="fa fa-close"></i></button>
        </td>
    </tr>
    <?php
    $item++;
}
?>
<script>
    $("#input_subtotal").val("<?php echo number_format($subtotal / 1.18, 2, '.', ',') ?>");
    $("#input_igv").val("<?php echo number_format(($subtotal /1.18 * 0.18), 2, '.', ',') ?>");
    $("#input_total").val("<?php echo number_format(($subtotal), 2, '.', ',') ?>");
    $("#input_total_hidden").val("<?php echo $subtotal; ?>");

</script>
<?php
$array = $_SESSION['productos_venta'];
$subtotal = 0;
$item = 1;

foreach ($array as $value) {
    $cantidad = $value['cantidad'];
    $precio = $value['precio'];
    $parcial = $cantidad * $precio;
    $subtotal += $parcial;
    ?>
    <tr>
        <td><?php echo $item?></td>
        <td><?php echo $value['id_producto'] . " | " . $value['descripcion'] . " | " . $value['vcto'] . " | " . $value['lote'] ?></td>
        <td class="text-center"><?php echo $value['cantidad']?></td>
        <td class="text-right"><?php echo number_format($value['precio'], 2)?></td>
        <td class="text-right"><?php echo number_format($value['precio'] * $value['cantidad'], 2)?></td>
        <td class="text-center">
            <button class="btn btn-danger btn-sm" title="Eliminar Documento" onclick="eliminar_item(<?php echo $value['id_producto'] ?>)"><i class="fa fa-close"></i></button>
        </td>
    </tr>
    <?php
    $item++;
}
?>
<script>
    console.log("S/ <?php echo number_format($subtotal, 2, '.', ',') ?>");
    $("#hidden_total").val(<?php echo $subtotal?>);
    $("#lbl_suma_pedido").html("S/ <?php echo number_format($subtotal, 2, '.', ',') ?>");
</script>
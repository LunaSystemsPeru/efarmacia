<?php
$array = $_SESSION['productos_ajuste'];
$subtotal = 0;
$item = 1;

foreach ($array as $value) {
    $cnueva = $value['cantidad'];
    $cactual = $value['cactual'];
    $diferencia = $cactual - $cnueva;
    ?>
    <tr>
        <td><?php echo $item?></td>
        <td><?php echo $value['id_producto'] . " | " . $value['descripcion'] ?></td>
        <td class="text-center"><?php echo $value['vcto'] . " | " . $value['lote'] ?></td>
        <td class="text-center"><?php echo $value['cactual']?></td>
        <td class="text-center"><?php echo $value['cantidad']?></td>
        <td class="text-center"><?php echo $diferencia?></td>
        <td class="text-right"><?php echo number_format($value['costo'], 2)?></td>
        <td class="text-right"><?php echo number_format($value['precio'], 2)?></td>
        <td class="text-center">
            <button class="btn btn-danger btn-sm" title="Eliminar Documento" onclick="eliminar_item(<?php echo $value['id_producto'] ?>)"><i class="fa fa-close"></i></button>
        </td>
    </tr>
    <?php
    $item++;
}
?>
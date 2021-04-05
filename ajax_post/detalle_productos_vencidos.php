<?php
session_start();
$id_empresa = $_SESSION['id_empresa'];
$id_sucursal = $_SESSION['id_sucursal'];
require '../class/cl_producto_sucursal.php';
$c_producto = new cl_producto_sucursal();

$c_producto->setIdEmpresa($id_empresa);
$c_producto->setIdSucursal($id_sucursal);
$periodo = filter_input(INPUT_POST, 'periodo');
$a_vencidos = $c_producto->verVencidosPeriodo($periodo);
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Item</th>
        <th>Producto</th>
        <th>Laboratorio</th>
        <th>Proveedor</th>
        <th>Costo Compra</th>
        <th>Cantidad</th>
        <th>Precio Venta</th>
        <th>En Stock S/</th>
    </tr>
    </thead>
    <tbody>
<?php
$item = 1;
foreach ($a_vencidos as $value) {
    ?>
    <tr>
        <td><?php echo $item ?></td>
        <td><?php echo $value['id_producto'] . " | " . $value['nombre'] . " | " . $value['vcto'] . " | " . $value['lote'] ?></td>
        <td><?php echo $value['laboratorio'] ?></td>
        <td><?php echo $value['nproveedor'] ?></td>
        <td class="text-center"><?php echo $value['costo'] ?></td>
        <td class="text-center"><?php echo $value['cantidad'] ?></td>
        <td class="text-right"><?php echo number_format($value['precio'], 2) ?></td>
        <td class="text-right"><?php echo number_format($value['precio'] * $value['cantidad'], 2) ?></td>
    </tr>
    <?php
    $item++;
}
?>
    </tbody>
</table>

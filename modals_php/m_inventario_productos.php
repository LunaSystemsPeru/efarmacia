<?php
session_start();
require '../class/cl_ajuste_producto.php';
require '../class/cl_ajuste.php';
require '../class/cl_usuario.php';
require '../class/cl_varios.php';

$c_detalle = new cl_ajuste_producto();
$c_ajuste = new cl_ajuste();
$c_usuario = new cl_usuario();
$c_varios = new cl_varios();

$c_detalle->setIdAjuste(filter_input(INPUT_POST, 'id_ajuste'));

$c_ajuste->setIdAjuste($c_detalle->getIdAjuste());
$c_ajuste->obtener_datos();

$c_usuario->setIdUsuario($c_ajuste->getIdUsuario());
$c_usuario->setIdEmpresa($c_ajuste->getIdEmpresa());
$c_usuario->obtener_datos();

$a_detalle = $c_detalle->verFilas();

echo "Fecha de Inventario: " . $c_ajuste->getFecha() . "<br>";
echo "Documento: NOTA DE INVENTARIO | " . strtoupper($c_ajuste->getAnio()) . " - " . $c_ajuste->getIdAjuste(). "<br>";
echo "Usuario: ". $c_usuario->getUsername() ."<br>";
?>

<hr>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Item.</th>
            <th>Producto</th>
            <th>Lote / Vcto</th>
            <th>Costo</th>
            <th>C. Sist.</th>
            <th>C. Encont.</th>
            <th>Difere. S/</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        foreach ($a_detalle as $value) {
            $sistema = $value['cactual'];
            $actual = $value['cnueva'];
            $costo = $value['costo'];
            $diferencia = $actual - $sistema;
            $diferencia = $diferencia * $costo;
            $total += $diferencia;
            ?>
            <tr>
                <td class="text-center"><?php echo $value['id_producto'] ?></td>
                <td><?php echo $value['nombre'] . " | " . $value['presentacion'] . " | " .$value['laboratorio'] ?></td>
                <td><?php echo $value['lote'] . " | " . $value['vcto']?></td>
                <td class="text-right"><?php echo number_format($costo, 2) ?></td>
                <td class="text-right"><?php echo number_format($sistema, 0) ?></td>
                <td class="text-right"><?php echo number_format($actual, 0) ?></td>
                <td class="text-right"><?php echo number_format($diferencia, 2) ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="5"></td>
            <td class="text-right text-capitalize">TOTAL</td>
            <td class="text-right"><?php echo number_format($total, 2) ?></td>
        </tr>
    </tfoot>
</table>


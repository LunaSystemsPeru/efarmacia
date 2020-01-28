<?php
session_start();
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=precios_mimsa.xls');

require '../class/cl_empresa.php';
require '../class/cl_producto.php';

$c_empresa = new cl_empresa();
$c_producto = new cl_producto();

$c_empresa->setIdEmpresa($_SESSION['id_empresa']);
$c_empresa->obtener_datos();

$c_producto->setIdEmpresa($c_empresa->getIdEmpresa());
$a_productos = $c_producto->ver_productos_mimsa();
?>

<table border="0" cellpadding="2" cellspacing="0" width="100%">
    <tr>
        <td>CodEstab</td>
        <td>CodProd</td>
        <td>Precio 1</td>
        <td>Precio 2</td>
    </tr>
    <?php
    foreach ($a_productos as $fila) {
        ?>
        <tr>
            <td><?php echo $c_empresa->getCodEstablecimiento()?></td>
            <td><?php echo $fila['id_mimsa']?></td>
            <td><?php echo number_format($fila['precio_caja'], 2)?></td>
            <td><?php echo number_format($fila['precio'], 2)?></td>
        </tr>
    <?php
    }
    ?>

</table>


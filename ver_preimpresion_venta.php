<?php
session_start();

$id_venta = filter_input(INPUT_GET, 'id_venta');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sistema de Facturacion Electronica - Luna Systems Peru</title>

    <!-- Common plugins -->
    <link href="../public/images/favicon.png" rel="icon"/>
    <link href="../public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/plugins/simple-line-icons/simple-line-icons.css" rel="stylesheet">
    <link href="../public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../public/plugins/pace/pace.css" rel="stylesheet">
    <link href="../public/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/plugins/nano-scroll/nanoscroller.css">
    <link rel="stylesheet" href="../public/plugins/metisMenu/metisMenu.min.css">
    <!-- dataTables -->
    <link href="../public/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="../public/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../public/plugins/toast/jquery.toast.min.css" rel="stylesheet">

    <!--template css-->
    <link href="../public/css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<?php include '../fixed/menu_superior.php' ?>

<?php include '../fixed/menu_derecha.php' ?>

<?php include '../fixed/menu_izquierda.php' ?>


<!--main content start-->
<section class="main-content container">


    <!--page header start-->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h4>Ver Documento Emitido</h4>
            </div>
            <div class="col-sm-6 text-right">
                <ol class="breadcrumb">
                    <li><a href="javascript: void(0);"><i class="fa fa-home"></i></a></li>
                    <li>Visualizar Documento</li>
                </ol>
            </div>

        </div>
        <br>

        <div class="row">
            <div class="col-lg-3 buttons">
                <a href="ver_ventas.php" class="btn btn-success"><i class="fa fa-arrow-circle-o-left"></i> Ver Ventas</a>
                <br>
                <a href="reg_venta.php" class="btn btn-info"><i class="fa fa-plus"></i> Agregar Venta</a>
            </div>
            <div class="col-lg-9">
                <iframe class="col-lg-12" height="500px" src="../reports/documento_venta.php?id_venta=<?php echo $id_venta?>"></iframe>
            </div>
        </div>
    </div>
    <!--page header end-->


    <!--start page content-->

    <!--end page content-->


    <?php include '../fixed/footer.php'; ?>

</section>
<!--end main content-->

<!--Common plugins-->
<script src="../public/plugins/jquery/dist/jquery.min.js"></script>
<script src="../public/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="../public/plugins/pace/pace.min.js"></script>
<script src="../public/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
<script src="../public/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="../public/plugins/nano-scroll/jquery.nanoscroller.min.js"></script>
<script src="../public/plugins/metisMenu/metisMenu.min.js"></script>
<script src="../public/js/float-custom.js"></script>

<!-- Datatables-->
<script src="../public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../public/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="../public/plugins/toast/jquery.toast.min.js"></script>

</body>

<!-- Mirrored from bootstraplovers.com/templates/float-admin-v1.1/light-version/page-empty.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Feb 2017 07:43:09 GMT -->
</html>
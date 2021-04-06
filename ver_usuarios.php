<?php
session_start();

if (is_null($_SESSION['id_empresa'])) {
    header("Location: login.php");
}

require 'class/cl_usuario.php';
$c_usuario = new cl_usuario();
$c_usuario->setIdEmpresa($_SESSION['id_empresa']);

$title = "Ver Usuarios - Farmacia - Luna Systems Peru";
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title><?php echo $title; ?></title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css"/>
    <link rel="stylesheet" href="vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css"/>

    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css"/>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet"
          href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css"
          type="text/css"/>
</head>
<body class="fixed-navbar fixed-sidebar">

<!-- Simple splash screen-->
<div class="splash">
    <div class="color-line"></div>
    <div class="splash-title"><h1><?php echo $title; ?></h1>
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>
</div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a
        href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Header -->
<?php include("includes/header.php"); ?>

<!-- Navigation -->
<?php include("includes/navigation.php"); ?>

<!-- Main Wrapper -->
<div id="wrapper">
    <div class="normalheader transition animated fadeIn">
        <div class="hpanel">
            <div class="panel-body">
                <a class="small-header-action" href="#">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>

                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="index.php">Dashboard</a></li>
                        <li>
                            <span>Generales</span>
                        </li>
                        <li class="active">
                            <span>Usuarios</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Listar Usuarios
                </h2>
            </div>
        </div>
    </div>


    <div class="content animate-panel">


        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 m-b-md">
                                <div class="btn-group">
                                    <a href="reg_usuario.php" class="btn btn-success"><i class="fa fa-plus"></i> Agregar Usuario</a>
                                </div>
                            </div>
                        </div>
                        <table id="table-laboratorios" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id.</th>
                                <th>Username</th>
                                <th>Nombre</th>
                                <th>Sucursal</th>
                                <th>Telefono</th>
                                <th>Fec. Registro</th>
                                <th>Ultimo Ingreso</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a_usuarios = $c_usuario->ver_usuarios();
                            foreach ($a_usuarios as $fila) {
                                ?>
                                <tr>
                                    <td><?php echo $fila['id_usuario']?></td>
                                    <td><?php echo $fila['username']?></td>
                                    <td><?php echo $fila['nombre']?></td>
                                    <td><?php echo $fila['nombresede']?></td>
                                    <td><?php echo $fila['telefono']?></td>
                                    <td><?php echo $fila['fecha_registro']?></td>
                                    <td><?php echo $fila['ultimo_ingreso']?></td>
                                    <td class="text-center">
                                        <a href="reg_usuario.php?id_usuario=<?php echo $fila['id_usuario']?>" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-info btn-sm" title="Recuperar Contraseña"><i class="fa fa-send"></i></button>
                                        <button class="btn btn-danger btn-sm" title="Dar de baja"><i class="fa fa-arrow-down"></i></button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Right sidebar -->
    <?php include("includes/right_sidebar.php"); ?>

    <!-- Footer-->
    <?php include("includes/footer.php"); ?>

</div>

<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>
<!-- DataTables -->
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DataTables buttons scripts -->
<script src="vendor/pdfmake/build/pdfmake.min.js"></script>
<script src="vendor/pdfmake/build/vfs_fonts.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<!-- App scripts -->
<script src="scripts/homer.js"></script>

</body>

</html>




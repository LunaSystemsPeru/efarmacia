<?php
session_start();

if (!isset($_SESSION['id_empresa'])) {
    header("Location: login.php");
}
require 'class/cl_sucursal.php';
$title = "Ver Sucursales - Farmacia - Luna Systems Peru";

$c_sucursal = new cl_sucursal();

$c_sucursal->setIdEmpresa($_SESSION['id_empresa']);
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
        <link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />

        <!-- Vendor styles -->
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css"/>
        <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css"/>
        <link rel="stylesheet" href="vendor/animate.css/animate.css"/>
        <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css"/>
        <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css">
        <!-- App styles -->
        <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
        <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css"/>
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet"
              href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css"
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
                href="https://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
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
                                    <span>Sucursales</span>
                                </li>
                                <li class="active">
                                    <span>Sucursales</span>
                                </li>
                            </ol>
                        </div>
                        <h2 class="font-light m-b-xs">
                            Ver mis Sucursales
                        </h2>
                    </div>
                </div>
            </div>


            <div class="content animate-panel">


                <div class="row">
                    <div class="col-lg-12">
                        <div class="hpanel">
                            <div class="panel-heading ">
                                Listar Sucursales
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-9 m-b-md">
                                        <div class="btn-group">
                                            <a href="reg_sucursal.php" class="btn btn-info"><i class="fa fa-plus"></i> Nueva Sucursal</a>
                                        </div>
                                    </div>
                                </div>


                                <table id="tabla-salidas" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id.</th>
                                            <th>Nombre</th>
                                            <th>Direccion</th>
                                            <th>Cod SUNAT</th>
                                            <th>Ubigeo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $listaSucursales= $c_sucursal->verFilas();
                                    foreach ($listaSucursales as $listar){
                                       echo '<tr>';
                                       echo     '<td>'. $listar["id_sucursal"] .'</td>';
                                       echo     '<td>'. $listar["nombre"] .'</td>';
                                       echo     '<td>'. $listar["direccion"] .'</td>';
                                       echo     '<td class="text-center">'. $listar["codsunat"] .'</td>';
                                       echo     '<td class="text-center">'. $listar["ubigeo"] .'</td>';
                                       echo     '<td class="text-center">';
                                       echo         '<a href="reg_sucursal.php?id='.$listar["id_sucursal"].'" class="btn btn-warning btn-sm" title="Editar Sucursal"><i class="fa fa-edit"></i></button>';
                                       echo     '</td>';
                                       echo '</tr>';

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
        <script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
        <!-- App scripts -->
        <script src="scripts/homer.js"></script>

        <script>

            $(function () {

                // Initialize Example 1
                $('#tabla-salidas').dataTable({
                    dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    buttons: [
                        {extend: 'copy', className: 'btn-sm'},
                        {extend: 'csv', title: 'Ingresos_201903', className: 'btn-sm'},
                        {extend: 'pdf', title: 'Ingresos_201903', className: 'btn-sm'},
                        {extend: 'print', className: 'btn-sm'}
                    ]
                });

            });

        </script>

        <script !src="">
            function eliminar (id_salida) {

                swal({
                    title: "Anular Ingreso",
                    text: "Esta seguro de Eliminar este documento?",
                    type: "warning",
                    showCancelButton: true,
                    //cancelButtonClass: 'btn-secondary ',
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Anular",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        window.location.href = 'procesos/del_salida.php?id_salida=' + id_salida;
                    }
                });
            }
        </script>

    </body>

</html>




<?php
/* ===================================================
   SESION
===================================================*/
$lifetime = (60 * 60 * 24 * 1); //Duracion de la session_cookie
// session_set_cookie_params($lifetime, $path = $_SERVER["DOCUMENT_ROOT"] . '', $domain = $_SERVER['HTTP_HOST'], $secure = false, $httponly = false);
session_start();

// if (isset($_SERVER['HTTPS'])) {
//     $dominioApp = 'https://' . $_SERVER['SERVER_NAME'];
// } else {
//     $dominioApp = 'http://' . $_SERVER['SERVER_NAME'];
// }


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>PDC INTERNATIONAL INC</title>

    <!-- =================================================== 
        PLUGINS CSS
    =================================================== -->
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="views/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="views/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="views/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Datatables -->
    <link rel="stylesheet" href="views/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="views/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <!-- =================================================== 
        PLUGINS JS
    =================================================== -->
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="views/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="views/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="views/dist/js/adminlte.js"></script>
    <!-- Datatables -->
    <script src="views/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Sweearlet2 -->
    <script src="views/plugins/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="views/dist/js/demo.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="views/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="views/plugins/raphael/raphael.min.js"></script>
    <script src="views/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="views/plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="views/plugins/chart.js/Chart.min.js"></script>

    <!-- PAGE SCRIPTS -->
    <!-- <script src="views/dist/js/pages/dashboard2.js"></script> -->
    <!-- =================================================== CUSTOM JS =================================================== -->
    <script src="views/js/plantilla.js"></script>
    <script src="views/js/operations.js"></script>


</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed sidebar-collapse">

    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == "ok") : ?>
        <div class="wrapper">

            <!-- =================================================== NAVBAR (Header)=================================================== -->
            <?php include('includes/header.php'); ?>

            <!-- =================================================== MAIN SIDE BAR CONTAINER (menu) =================================================== -->
            <?php include('includes/menu.php'); ?>

            <!-- =================================================== CONTENT(contenido) =================================================== -->
            <?php
            if (isset($_GET['page'])) {
                $rutaUrl = explode("/", $_GET['page']);

                //$ruta = $_GET['ruta'];
                $ruta = $rutaUrl[0];

                if (
                    $ruta == "logout"
                ) {
                    include "modulos/{$ruta}.php";
                } else if ( # Operations
                    $ruta == "operations-index" ||
                    $ruta == "operations-companies" ||
                    $ruta == "operations-products"
                ) {
                    include "modulos/operations/" . $ruta . ".php";
                } else { # Página no válida
                    include "includes/error404.php";
                }
            } else {
                include "modulos/operations/operations-index.php";
            }
            ?>

            <!-- =================================================== MAIN FOOTER =================================================== -->
            <?php include('includes/footer.php'); ?>

        </div>
        <!-- ./wrapper -->
    <?php else : ?>
        <div class="hold-transition login-page">
            <?php 
                if (isset($_GET['page'])) {
                    $rutaUrl = explode("/", $_GET['page']);

                    //$ruta = $_GET['ruta'];
                    $ruta = $rutaUrl[0];

                    if (
                        $ruta == "operations-login" ||
                        $ruta == "clients-login"
                    ){
                        include "modulos/login/" . $ruta . ".php";
                    } else{
                        include('modulos/login/login.php');
                    }
                } else {
                    include('modulos/login/login.php');
                }
                
            ?>
        </div>
    <?php endif ?>

    <!-- =================================================== MODAL PARA CERRAR SESIÓN =================================================== -->
    <div class="modal fade" id="cerrarSesionModal" tabindex="-1" role="dialog" aria-labelledby="cerrarSesionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cerrarSesionModalLabel">Log Out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="text-center">
                            Are you sure you want to log out?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <a href="./logout" class="btn btn-danger">Log Out</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
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
    <!-- daterange picker -->
    <link rel="stylesheet" href="views/plugins/daterangepicker/daterangepicker.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="views/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="views/css/plantilla.css">

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
    <!-- date-range-picker -->
    <script src="views/plugins/daterangepicker/moment.min.js"></script>
    <script src="views/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Momentjs -->
    <script src="views/plugins/moment/moment-with-locales.min.js"></script>
    <!-- Sweearlet2 -->
    <script src="views/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- PDF JS -->
    <script src="views/plugins/pdf-js/pdf.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="views/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

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
    <script src="views/js/plantilla.js?v=<?= time() ?>"></script>
    <script src="views/js/operations.js?v=<?= time() ?>"></script>
    <script src="views/js/companies.js?v=<?= time() ?>"></script>
    <script src="views/js/users.js?v=<?= time() ?>"></script>


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
                    $ruta == "operations-products" ||
                    $ruta == "orders"
                ) {
                    include "modulos/operations/" . $ruta . ".php";
                } else if ( # Companies
                    $ruta == "c-neworder" ||
                    $ruta == "c-orders" ||
                    $ruta == "c-shippedorders"
                ) {
                    include "modulos/companies/" . $ruta . ".php";
                } else if ( # Users
                    $ruta == "users"
                ) {
                    include "modulos/users/" . $ruta . ".php";
                } else { # Página no válida
                    include "includes/error404.php";
                }
            } else {
                include "modulos/operations/operations-index.php";
            }
            ?>

            <!-- =================================================== MAIN FOOTER =================================================== -->
            <?php include('includes/modals.php'); ?>
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
                ) {
                    include "modulos/login/" . $ruta . ".php";
                } else {
                    include('modulos/login/login.php');
                }
            } else {
                include('modulos/login/login.php');
            }

            ?>
        </div>
    <?php endif ?>

</body>

</html>
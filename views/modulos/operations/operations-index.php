<?php if (!array_search('OPERATIONS', $_SESSION['options'])) : ?>
    <script>
        window.location = 'c-neworder';
    </script>
<?php endif ?>

<?php
# INFORMACIÓN DE LA BASE DE DATOS
$NewOrdersToday = DashboardController::ctrOrdersToday();
$OrdersInProcess = DashboardController::ctrOrdersInProcess();
$OrdersDeliveredThisWeek = DashboardController::ctrOrdersDeliveredThisWeek();
$DataOrdersDeliveredMonth = DashboardController::ctrChartOrdersDeliveredThisMonth();
$OrdersShipped = DashboardController::ctrOrderShipped();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- ===================================================
                            OTROS INDICADORES
                        =================================================== -->
                        <div class="row">
                            <!-- ===================================================
                                NEW ORDERS
                            =================================================== -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-clipboard-list"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text text-uppercase">There are</span>
                                        <span class="info-box-number">
                                            <h1><?= $NewOrdersToday ?></h1>
                                        </span>
                                        <span class="info-box-text text-uppercase">New orders today</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <!-- ===================================================
                                ORDERS IN PROCESS
                            =================================================== -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tasks"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text text-uppercase">There are</span>
                                        <span class="info-box-number">
                                            <h1><?= $OrdersInProcess ?></h1>
                                        </span>
                                        <span class="info-box-text text-uppercase">Orders in process</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <!-- ===================================================
                                ORDERS DELIVERED THIS WEEK
                            =================================================== -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-clipboard-check"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text text-uppercase">There are</span>
                                        <span class="info-box-number">
                                            <h1><?= $OrdersDeliveredThisWeek ?></h1>
                                        </span>
                                        <span class="info-box-text text-uppercase">Orders delivered this week</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <!-- ===================================================
                                TOTAL PALLETS DELIVERED MONTH
                            =================================================== -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-pallet"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text text-uppercase">Total pallets delivered this month</span>
                                        <span class="info-box-number">
                                            <h1>750</h1>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <!-- ===================================================
                                ORDERS DELIVERED MONTH
                            =================================================== -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-paste"></i></span>
                                    <?php
                                    $calculoPorcentaje = $DataOrdersDeliveredMonth['ordenesEntregadasMes'] / $DataOrdersDeliveredMonth['totalOrdenesMes'] * 100;
                                    ?>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-uppercase">Orders delivered this month</span>
                                        <div class="progress-group">
                                            <span class="progress-text"><b><?= $DataOrdersDeliveredMonth['ordenesEntregadasMes'] ?></b></span>
                                            <span class="float-right"><b><?= $DataOrdersDeliveredMonth['totalOrdenesMes'] ?></b></span>
                                            <div class="progress" style="height: 20px">
                                                <div class="progress-bar bg-secondary" style="width: <?= $calculoPorcentaje ?>%;"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->
                                        <!-- <span class="info-box-number">
                                            <h1><?= $temp['ordenesEntregadasMes'] ?></h1>
                                        </span> -->
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <!-- ===================================================
                                ORDERS SHIPPED
                            =================================================== -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-truck-loading"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-number">
                                            <h1><?= $OrdersShipped ?></h1>
                                        </span>
                                        <span class="info-box-text text-uppercase">Orders shipped</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                        </div>

                        <!-- ===================================================
                            TOTAL ORDERS DELIVERED BY MONTH
                        =================================================== -->
                        <div class="row d-flex justify-content-center">
                            <div class="col-12 col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                            <h4 class="text-center font-weight-bold">
                                                TOTAL ORDERS DELIVERED BY MONTH
                                            </h4>
                                        </div>
                                    <div class="card-body">
                                        <div class="chart">
                                            <!-- Sales Chart Canvas -->
                                            <canvas id="ChartOrdersxMonth" style="height: 15rem;"></canvas>
                                        </div>
                                        <!-- /.chart-responsive -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- ===================================================
    MODAL PARA CAMBIO DE CONTRASEÑA
=================================================== -->
<?php
/* ===================================================
       CONSULTO SI EL USUARIO TIENE QUE REALIZAR CAMBIO DE CONTRASEÑA
    ===================================================*/
$usuario = UsersController::ctrShowUsers('idUser', $_SESSION['user_id']);

if ($usuario['change_password'] != 0) :

?>

    <!-- Modal -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCambiarPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <i class="fas fa-user-secret"></i>
                            Change Password
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                            </div>
                            <input type="password" name="pass1" id="pass1" class="form-control" placeholder="Type new password" minlength="4" required>
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                            </div>
                            <input type="password" name="pass2" id="pass2" class="form-control" placeholder="Please confirm your password" minlength="4" required>
                        </div>

                        <input type="hidden" name="cedulaUsuario" value="<?= $usuario['dni'] ?>">

                    </div>
                    <div class="modal-footer">
                        <a href="logout" class="btn btn-danger"><i class="fas fa-times"></i> Cancel </a>
                        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button> -->
                        <button type="submit" class="btn btn-success " disabled id="btnCambioPassword"><i class="fas fa-lock"></i> Change</button>
                    </div>
                </div><!-- modal-content -->

                <?php
                #INSTANCIO EL CONTROLADOR PARA EJECUTAR EL CAMBIO DE CONTRASEÑA
                $cambiarPassword = new UsersController();
                $cambiarPassword->ctrCambioPassword();
                ?>

            </form><!-- form -->

        </div>
    </div>

    <!-- ===================================================
    
=================================================== -->

    <script>
        //Código JS 
        $('#modalCambiarPassword').modal('show');

        /* ===================== 
            VALIDO SI LAS CONSTRASEÑAS SON IGUALES 
        ========================= */
        $('#pass1, #pass2').bind('input propertychange', function() {

            if ($("#pass1").val() === $("#pass2").val()) {
                console.log("Password correcto");

                //habilitamos el boton para cambiar   
                $("#btnCambioPassword").removeAttr("disabled");

            } else {
                $("#btnCambioPassword").attr("disabled", "");
            }
        });
    </script>


<?php endif ?>
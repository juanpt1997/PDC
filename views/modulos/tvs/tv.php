<?php
$fecha1 = date("Y-m-d", strtotime('monday this week'));
$fecha2 = date("Y-m-d", strtotime('sunday this week'));

$NewOrdersToday = DashboardController::ctrOrdersToday();
$OrdersDeliveredThisWeek = DashboardController::ctrOrdersDeliveredThisWeek();
$PalletsDeliveredThisWeek = DashboardController::ctrPalletsDelivered($fecha1, date("Y-m-d"));
$PalletsNeededThisMonth = DashboardController::ctrPalletsNeeded($fecha1, $fecha2);

# Orders
$fechas = array(
    'fecha1' => $fecha1,
    'fecha2' => $fecha2
);
$Orders = OrdersController::ctrShowOrders(null, "TV", $fechas);
?>

<div class="container-fluid">
    <!-- ===================== 
            DELIVERIES FOR THIS WEEK
        ========================= -->
    <div class="row mt-3">
        <div class="col-12 text-center">
            <h1 class="font-weight-bold">DELIVERIES FOR THIS WEEK</h1>
        </div>
    </div>
    <!-- /.row -->

    <!-- ===================================================
        INDICADORES
    =================================================== -->
    <div class="row mt-3">
        <!-- ===================================================
            NEW ORDERS TODAY
        =================================================== -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-clipboard-list"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text text-uppercase">&nbsp;</span>
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
            ORDERS DELIVERED THIS WEEK
        =================================================== -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-clipboard-check"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text text-uppercase">&nbsp;</span>
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
            PALLETS DELIVERED THIS WEEK
        =================================================== -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tasks"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text text-uppercase">&nbsp;</span>
                    <span class="info-box-number">
                        <h1><?= $PalletsDeliveredThisWeek ?></h1>
                    </span>
                    <!-- <span class="info-box-text text-uppercase"></span> -->
                    <span class="info-box-text text-uppercase">Pallets Delivered this week</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>



        <!-- ===================================================
            TOTAL PALLETS FOR THIS WEEK
        =================================================== -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-pallet"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text text-uppercase">&nbsp;</span>
                    <span class="info-box-number">
                        <h1><?= $PalletsNeededThisMonth ?></h1>
                    </span>
                    <span class="info-box-text text-uppercase">Pallets for this week</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <!-- ===================================================
        TABLA
    =================================================== -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table tablaTV table-striped table-bordered w-100">
                    <thead class="text-center">
                        <tr>
                            <th>Company</th>
                            <th>Customer PO</th>
                            <th>BOL REFERENCE</th>
                            <th>DELIVER BY</th>
                            <th>Product</th>
                            <th>Quanty</th>
                            <th>Pallets</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php foreach ($Orders as $key => $value) : ?>
                            <?php
                            switch ($value['Status']) {
                                case 'In Process':
                                    $Status = "<span class='badge badge-primary'>In Process</span>";
                                    break;

                                case 'Shipped':
                                    $Status = "<span class='badge badge-warning'>Shipped</span>";
                                    break;

                                default:
                                    $Status = $value['Status'];
                                    break;
                            }
                            ?>
                            <tr>
                                <td><?= $value['Company'] ?></td>
                                <td><?= $value['Customer_PO'] ?></td>
                                <td><?= $value['PO_Reference'] ?></td>
                                <td><?= $value['Delivery_DateF'] ?></td>
                                <td><?= $value['Product'] ?></td>
                                <td><?= $value['Total_Bags'] ?></td>
                                <td><?= $value['Total_Skids'] ?></td>
                                <td><?= $Status ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
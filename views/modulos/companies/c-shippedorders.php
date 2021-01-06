<?php if (!array_search('COMPANIES', $_SESSION['options'])) : ?>
    <script>
        window.location = './';
    </script>
<?php endif ?>

<?php
$Orders = OrdersController::ctrShowOrders($_SESSION['idCompany'], 'Shipped', null);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Shipped Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">Shipped Orders</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card card-primary card-outline">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm tablaOrders">
                            <thead>
                                <tr>
                                    <th>PO Order</th>
                                    <th>Client</th>
                                    <th>Customer PO</th>
                                    <th>PO Reference</th>
                                    <th>Date</th>
                                    <th>Delivery</th>
                                    <th>Real Delivery</th>
                                    <th>Product</th>
                                    <th>Quanty</th>
                                    <th>COA</th>
                                    <th>POD</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($Orders as $key => $value) : ?>
                                    <?php
                                    #$BtnOrder = "<button type='button' idorder='{$value['id_orders']}' class='btn btn-default orderInfo' data-toggle='modal' data-target='#modal-vieworder'>{$value['id_orders']}</button>";

                                    $BtnCOA = "<button type='button' class='btn btn-default btn-docs' idorder='{$value['id_orders']}' tipodoc='COA' data-toggle='modal' data-target='#modal-docs'>
                                                <i class='far fa-file-pdf'></i>
                                            </button>";

                                    $BtnPOD = "<button type='button' class='btn btn-default btn-docs' idorder='{$value['id_orders']}' tipodoc='POD' data-toggle='modal' data-target='#modal-docs'>
                                                <i class='far fa-file-pdf'></i>
                                            </button>";
                                          
                                    //$onclickEventDescargar = `onclick="javascript:window.open('pdf/po.php?order=${value['id_orders']}','','width=1280,height=720,left=50,top=50,toolbar=yes');`;
                                    $botonDescargarOrder = "<button class='btn btn-secondary ml-2 btn-descargarorder' type='button' idorder='{$value['id_orders']}'><i class='fas fa-save'></i></button>";
                                    $botonAcciones = "<div class='row d-flex flex-nowrap justify-content-center'>" . $botonDescargarOrder . "</div>";

                                    ?>
                                    <tr>
                                        <td><?= $value['id_orders'] ?></td>
                                        <td><?= $value['Company'] ?></td>
                                        <td><?= $value['Customer_PO'] ?></td>
                                        <td><?= $value['PO_Reference'] ?></td>
                                        <td><?= $value['Pickup_DateF'] ?></td>
                                        <td><?= $value['Delivery_DateF'] ?></td>
                                        <td><?= $value['Delivery_Real_DateF'] ?></td>
                                        <td><?= $value['Product'] ?></td>
                                        <td><?= $value['Total_Bags'] ?></td>
                                        <td><?= $BtnCOA ?></td>
                                        <td><?= $BtnPOD ?></td>
                                        <td><?= $botonAcciones ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="c-neworder" type="button" class="btn btn-sm btn-info float-left">Place New Order</a>
                    <!-- <a href="completed_orders.html" class="btn btn-sm btn-success float-right">Delivered Orders</a> -->

                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


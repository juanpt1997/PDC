<?php if (!array_search('OPERATIONS', $_SESSION['options'])) : ?>
    <script>
        window.location = './';
    </script>
<?php endif ?>

<?php
$Orders = OrdersController::ctrShowOrders(null, null);
$Companies = CompaniesController::ctrShowCompanies();
$Products = ProductsController::ctrShowProducts();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Clients Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">Clients Orders</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- ===================== 
              AGREGAR FILAS Y COLUMNAS PARA EL DESARROLLO 
            ========================= -->
            <!-- Default box -->
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
                                    <th>Status</th>
                                    <th>COA</th>
                                    <th>POD</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($Orders as $key => $value) : ?>
                                    <?php
                                    $BtnOrder = "<button type='button' idorder='{$value['id_orders']}' class='btn btn-default orderInfo' data-toggle='modal' data-target='#modal-vieworder'>{$value['id_orders']}</button>";

                                    $BtnCOA = "<button type='button' class='btn btn-default btn-docs' idorder='{$value['id_orders']}' tipodoc='COA' data-toggle='modal' data-target='#modal-docs'>
                                                <i class='far fa-file-pdf'></i>
                                            </button>";

                                    $BtnPOD = "<button type='button' class='btn btn-default btn-docs' idorder='{$value['id_orders']}' tipodoc='POD' data-toggle='modal' data-target='#modal-docs'>
                                                <i class='far fa-file-pdf'></i>
                                            </button>";

                                    switch ($value['Status']) {
                                        case 'On Process':
                                            $Status = "<span idorder='{$value['id_orders']}' class='badge badge-primary btnCambiarEstado' style='cursor: pointer;'>On Process</span>";
                                            break;

                                        case 'Shipped':
                                            $Status = "<span idorder='{$value['id_orders']}' class='badge badge-secondary btnCambiarEstado' style='cursor: pointer;'>Shipped</span>";
                                            break;

                                        case 'Sent':
                                            $Status = "<span idorder='{$value['id_orders']}' class='badge badge-warning text-white btnCambiarEstado' style='cursor: pointer;'>Sent</span>";
                                            break;

                                        case 'Canceled':
                                            $Status = "<span idorder='{$value['id_orders']}' class='badge badge-danger btnCambiarEstado' style='cursor: pointer;'>Canceled</span>";
                                            break;

                                        default:
                                            $Status = $value['Status'];
                                            break;
                                    }
                                    //$onclickEventDescargar = `onclick="javascript:window.open('pdf/po.php?order=${value['id_orders']}','','width=1280,height=720,left=50,top=50,toolbar=yes');`;
                                    $botonDescargarOrder = "<button class='btn btn-secondary ml-2 btn-descargarorder' type='button' idorder='{$value['id_orders']}'><i class='fas fa-save'></i></button>";
                                    $botonAcciones = "<div class='row d-flex flex-nowrap justify-content-center'>" . $botonDescargarOrder . "</div>";

                                    ?>
                                    <tr>
                                        <td><?= $BtnOrder ?></td>
                                        <td><?= $value['Company'] ?></td>
                                        <td><?= $value['Customer_PO'] ?></td>
                                        <td><?= $value['PO_Reference'] ?></td>
                                        <td><?= $value['Pickup_DateF'] ?></td>
                                        <td><?= $value['Delivery_DateF'] ?></td>
                                        <td><?= $value['Delivery_Real_DateF'] ?></td>
                                        <td><?= $value['Product'] ?></td>
                                        <td><?= $value['Total_Bags'] ?></td>
                                        <td><?= $Status ?></td>
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
                    <button id="btnPlaceNewOrder" type="button" class="btn btn-sm btn-info float-left" data-toggle="modal" data-target="#modal-neworder">Place New Order</button>
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

<!-- ===================================================
    MODALS
=================================================== -->
<!-- ===================================================
    MODAL NEW ORDER    
=================================================== -->
<div class="modal fade" id="modal-neworder">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">NEW ORDER</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- FORMULARIO -->
                <form id="formNewOrder" method="post">
                    <!-- PO Content  -->

                    <div class="row">

                        <!-- ===================================================
                        Client
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="form-control select2 clientInput" name="client" style="width: 100%" required>
                                    <option value="" selected disabled>Choose an option</option>
                                    <?php foreach ($Companies as $key => $value) : ?>
                                        <option value="<?= $value['id_companies'] ?>"><?= $value['Name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>

                        <!-- ===================================================
                        Product
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Product</label>
                                <select class="form-control select2 productsInput" name="id_products" style="width: 100%" required>
                                    <option value="" selected disabled>Choose an option</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Weight of Each Bag
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Weight of Each Bag</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control" name="Weight_Each_Bag" data-placeholder="lbs" style="width: 100%" maxlength="5" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Total Bags
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Total Bags</label>
                                <input type="text" class="form-control" name="Total_Bags" data-placeholder="" style="width: 100%" maxlength="5" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Total Skids
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Total Skids</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control" name="Total_Skids" data-placeholder="" style="width: 100%" maxlength="5" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Customer PO#
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Customer PO#</label>
                                <input type="text" class="form-control" name="Customer_PO" data-placeholder="" style="width: 100%" maxlength="10" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>

                    <hr>

                    <div class="row">

                        <!-- ===================================================
                        Arrange Pickup
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Please Arrange The Pickup of</label>
                                <input type="text" class="form-control" name="Arrange_Pickup" data-placeholder="" style="width: 100%" maxlength="10" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        From Release
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>From Release #</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control" name="From_Release" data-placeholder="" style="width: 100%" maxlength="10" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Pick Up Date
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Pick Up Date</label>
                                <input type="date" class="form-control" name="Pickup_Date" data-placeholder="" style="width: 100%" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                            P.O. Reference
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>P.O. Reference #</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control" name="PO_Reference" data-placeholder="" style="width: 100%" maxlength="10" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>

                    <hr>

                    <h4 class="text-muted">Delivery</h4>

                    <div class="row mt-3">
                        <!-- ===================================================
                        Delivery Terms
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Delivery Terms</label>
                                <select class="form-control" name="Delivery_Terms" required>
                                    <option value="" selected disabled>Select an option</option>
                                    <option>Customer Pick Up</option>
                                    <option>Delivery</option>
                                    <option>Third Party Inland</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        From Name
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>From Name</label>
                                <input type="text" class="form-control" name="Delivery_From_Name" data-placeholder="" style="width: 100%" maxlength="100" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Address
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Address</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control" name="Delivery_Address" data-placeholder="" style="width: 100%" maxlength="50" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Phone
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="Delivery_Phone" class="form-control" data-placeholder="" style="width: 100%" maxlength="50" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Contact
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Contact</label>
                                <div class="select2-purple">
                                    <input type="text" name="Delivery_Contact" class="form-control" data-placeholder="" style="width: 100%" maxlength="50" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Date
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Delivery Date</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="date" name="Delivery_Date" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Real_Date
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Real Delivery Date</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="date" name="Delivery_Real_Date" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <hr>

                    <h4 class="text-muted">Delivery Destination</h4>

                    <div class="row">

                        <!-- ===================================================
                            Delivery_Destination_Name
                        =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="Delivery_Destination_Name" class="form-control" data-placeholder="" style="width: 100%" maxlength="100" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_Address
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Address</label>
                                <div class="select2-purple">
                                    <input type="text" name="Delivery_Destination_Address" class="form-control" data-placeholder="" style="width: 100%" maxlength="100" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_Phone
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="Delivery_Destination_Phone" class="form-control" data-placeholder="" maxlength="100" style="width: 100%" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_Contact
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Contact</label>
                                <div class="select2-purple">
                                    <input type="text" name="Delivery_Destination_Contact" class="form-control" data-placeholder="" maxlength="100" style="width: 100%" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_Confirmed_Trucking_Charge
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Confirmed Trucking Charge</label>
                                <input type="text" name="Delivery_Destination_Confirmed_Trucking_Charge" class="form-control" data-placeholder="" maxlength="100" style="width: 100%" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                            Delivery_Destination_Comments
                        =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Comments</label>
                                <div class="select2-purple">
                                    <textarea class="form-control" name="Delivery_Destination_Comments" rows="3" placeholder="Enter ..." maxlength="255"></textarea>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>

                </form>
                <!-- /.form -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit" form="formNewOrder"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php
            $newOrder = OrdersController::ctrNewOrder();
            ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- ===================================================
    MODAL VIEW/EDIT ORDERS
=================================================== -->
<div class="modal fade" id="modal-vieworder">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Purchase Order <span class="orderTitle"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- FORMULARIO -->
                <form id="formEditOrder" method="post">
                    <!-- PO Content  -->

                    <div class="row">
                        <!-- ID ORDER -->
                        <input type="hidden" class="editOrder" name="idorder" id="idorder" value="">

                        <!-- ===================================================
                        Client
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="form-control select2 editOrder clientInput" id="company" name="company" style="width: 100%" required>
                                    <option value="" selected disabled>Choose an option</option>
                                    <?php foreach ($Companies as $key => $value) : ?>
                                        <option value="<?= $value['id_companies'] ?>"><?= $value['Name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>

                        <!-- ===================================================
                        Product
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Product</label>
                                <select class="form-control select2 editOrder productsInput" id="id_products" name="id_products" style="width: 100%" required>
                                    <option value="" selected disabled>Choose an option</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Weight of Each Bag
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Weight of Each Bag</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control editOrder" id="Weight_Each_Bag" name="Weight_Each_Bag" data-placeholder="lbs" style="width: 100%" maxlength="5" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Total Bags
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Total Bags</label>
                                <input type="text" class="form-control editOrder" id="Total_Bags" name="Total_Bags" data-placeholder="" style="width: 100%" maxlength="5" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Total Skids
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Total Skids</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control editOrder" id="Total_Skids" name="Total_Skids" data-placeholder="" style="width: 100%" maxlength="5" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Customer PO#
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Customer PO#</label>
                                <input type="text" class="form-control editOrder" id="Customer_PO" name="Customer_PO" data-placeholder="" style="width: 100%" maxlength="10" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>

                    <hr>

                    <div class="row">

                        <!-- ===================================================
                        Arrange Pickup
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Please Arrange The Pickup of</label>
                                <input type="text" class="form-control editOrder" id="Arrange_Pickup" name="Arrange_Pickup" data-placeholder="" style="width: 100%" maxlength="10" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        From Release
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>From Release #</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control editOrder" id="From_Release" name="From_Release" data-placeholder="" style="width: 100%" maxlength="10" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Pick Up Date
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Pick Up Date</label>
                                <input type="date" class="form-control editOrder" id="Pickup_Date" name="Pickup_Date" data-placeholder="" style="width: 100%" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                            P.O. Reference
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>P.O. Reference #</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control editOrder" id="PO_Reference" name="PO_Reference" data-placeholder="" style="width: 100%" maxlength="10" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>

                    <hr>

                    <h4 class="text-muted">Delivery</h4>

                    <div class="row mt-3">
                        <!-- ===================================================
                        Delivery Terms
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Delivery Terms</label>
                                <select class="form-control editOrder" id="Delivery_Terms" name="Delivery_Terms" required>
                                    <option value="" selected disabled>Select an option</option>
                                    <option>Customer Pick Up</option>
                                    <option>Delivery</option>
                                    <option>Third Party Inland</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        From Name
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>From Name</label>
                                <input type="text" class="form-control editOrder" id="Delivery_From_Name" name="Delivery_From_Name" data-placeholder="" style="width: 100%" maxlength="100" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Address
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Address</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control editOrder" id="Delivery_Address" name="Delivery_Address" data-placeholder="" style="width: 100%" maxlength="50" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Phone
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" id="Delivery_Phone" name="Delivery_Phone" class="form-control editOrder" data-placeholder="" style="width: 100%" maxlength="50" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Contact
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Contact</label>
                                <div class="select2-purple">
                                    <input type="text" id="Delivery_Contact" name="Delivery_Contact" class="form-control editOrder" data-placeholder="" style="width: 100%" maxlength="50" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Date
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Delivery Date</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="date" id="Delivery_Date" name="Delivery_Date" class="form-control editOrder datetimepicker-input" data-target="#reservationdate" required>
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Real_Date
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Real Delivery Date</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="date" id="Delivery_Real_Date" name="Delivery_Real_Date" class="form-control editOrder datetimepicker-input" data-target="#reservationdate" required>
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <hr>

                    <h4 class="text-muted">Delivery Destination</h4>

                    <div class="row">

                        <!-- ===================================================
                            Delivery_Destination_Name
                        =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="Delivery_Destination_Name" name="Delivery_Destination_Name" class="form-control editOrder" data-placeholder="" style="width: 100%" maxlength="100" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_Address
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Address</label>
                                <div class="select2-purple">
                                    <input type="text" id="Delivery_Destination_Address" name="Delivery_Destination_Address" class="form-control editOrder" data-placeholder="" style="width: 100%" maxlength="100" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_Phone
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" id="Delivery_Destination_Phone" name="Delivery_Destination_Phone" class="form-control editOrder" data-placeholder="" maxlength="100" style="width: 100%" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_Contact
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Contact</label>
                                <div class="select2-purple">
                                    <input type="text" id="Delivery_Destination_Contact" name="Delivery_Destination_Contact" class="form-control editOrder" data-placeholder="" maxlength="100" style="width: 100%" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_Confirmed_Trucking_Charge
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Confirmed Trucking Charge</label>
                                <input type="text" id="Delivery_Destination_Confirmed_Trucking_Charge" name="Delivery_Destination_Confirmed_Trucking_Charge" class="form-control editOrder" data-placeholder="" maxlength="100" style="width: 100%" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                            Delivery_Destination_Comments
                        =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Comments</label>
                                <div class="select2-purple">
                                    <textarea class="form-control editOrder" id="Delivery_Destination_Comments" name="Delivery_Destination_Comments" rows="3" placeholder="Enter ..." maxlength="255"></textarea>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>

                </form>
                <!-- /.form -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit" form="formEditOrder"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php
            $updateOrder = OrdersController::ctrEditOrder();
            ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- end modals -->
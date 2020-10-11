<?php
$Orders = OrdersController::ctrShowOrders();
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
                    <h1 class="m-0 text-dark">Clientes Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Home</a></li>
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
            <div class="card">
                <div class="card-body">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Client</th>
                                            <th>Date</th>
                                            <th>Delivery</th>
                                            <th>Real Delivery</th>
                                            <th>Product</th>
                                            <th>Quanty</th>
                                            <th>Status</th>
                                            <th>COA</th>
                                            <th>POD</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Orders as $key => $value) : ?>
                                            <?php
                                            $BtnOrder = "<button type='button' class='btn btn-default' data-toggle='modal' data-target='#modal-vieworder'>{$value['id_orders']}</button>";

                                            $BtnCOA = "<button type='button' class='btn btn-default' data-toggle='modal' data-target='#modal-coa'>
                                                        <i class='far fa-file-pdf'></i>
                                                    </button>";

                                            $BtnPOD = "<button type='button' class='btn btn-default' data-toggle='modal' data-target='#modal-pod'>
                                                        <i class='far fa-file-pdf'></i>
                                                    </button>";

                                            switch ($value['Status']) {
                                                case 'On Process':
                                                    $Status = "<span class='badge badge-danger'>On Process</span>";
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
                                                <td><?= $BtnOrder ?></td>
                                                <td><?= $value['Company'] ?></td>
                                                <td><?= $value['Pickup_Date'] ?></td>
                                                <td><?= $value['Delivery_Date'] ?></td>
                                                <td><?= $value['Delivery_Real_Date'] ?></td>
                                                <td><?= $value['Product'] ?></td>
                                                <td><?= $value['Total_Bags'] ?></td>
                                                <td><?= $Status ?></td>
                                                <td><?= $BtnCOA ?></td>
                                                <td><?= $BtnPOD ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button type="button" class="btn btn-sm btn-info float-left" data-toggle="modal" data-target="#modal-neworder">Place New Order</button>
                            <!-- <a href="completed_orders.html" class="btn btn-sm btn-success float-right">Delivered Orders</a> -->

                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card-body -->
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
                <h4 class="modal-title">Purchase Order 87651</h4>
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
                                <select class="form-control select2" name="client" style="width: 100%" required>
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
                                <select class="form-control select2" name="id_products" style="width: 100%" required>
                                    <option value="" selected disabled>Choose an option</option>
                                    <?php foreach ($Products as $key => $value) : ?>
                                        <option value="<?= $value['id_products'] ?>"><?= $value['Name'] ?></option>
                                    <?php endforeach ?>
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
                <h4 class="modal-title">Purchase Order 87651</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- PO Content  -->

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Product</label>
                            <select class="form-control select2" style="width: 100%" disabled>
                                <option selected="selected">
                                    Luna
                                </option>
                                <option>Black Beans</option>
                                <option>Cane World</option>
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Weight of Each Bag</label>
                            <div class="select2-purple">
                                <input type="text" value="235" class="form-control" data-placeholder="lbs" style="width: 100%" disabled />
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Total Bags</label>
                            <input type="text" value="50" class="form-control" data-placeholder="" style="width: 100%" disabled />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Total Skids</label>
                            <div class="select2-purple">
                                <input type="text" value="23" class="form-control" data-placeholder="" style="width: 100%" disabled />
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Customer PO#</label>
                            <input type="text" class="form-control" value="9012" data-placeholder="" style="width: 100%" disabled />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <hr />

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Please Arrange The Pickup of</label>
                            <input type="text" value="12" class="form-control" data-placeholder="" style="width: 100%" disabled />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>From Release #</label>
                            <div class="select2-purple">
                                <input type="text" value="345" class="form-control" data-placeholder="" style="width: 100%" disabled />
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Pick Up Date</label>
                            <input type="text" value="05/09/2020" class="form-control" data-placeholder="" style="width: 100%" disabled />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>P.O. Reference #</label>
                            <div class="select2-purple">
                                <input type="text" value="5432" class="form-control" data-placeholder="" style="width: 100%" disabled />
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <hr />

                <h5>Delivery</h5>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>From Name</label>
                            <input type="text" value="Luis Arana" class="form-control" data-placeholder="" style="width: 100%" disabled />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Address</label>
                            <div class="select2-purple">
                                <input type="text" value="Av 1245 New York" class="form-control" data-placeholder="" style="width: 100%" disabled />
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" value="555 567123" class="form-control" data-placeholder="" style="width: 100%" disabled />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Contact</label>
                            <div class="select2-purple">
                                <input type="text" value="Jhon Doe" class="form-control" data-placeholder="" style="width: 100%" disabled />
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Delivery Date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" value="15/09/2020" class="form-control datetimepicker-input" data-target="#reservationdate"/ disabled>
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
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Real Delivery Date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" value="17/09/2020" class="form-control
										datetimepicker-input" data-target="#reservationdate" />
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
                <hr />
                <h5>Delivery Destination</h5>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="Elizabeth Eastwood" class="form-control" data-placeholder="" style="width: 100%" disabled />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Address</label>
                            <div class="select2-purple">
                                <input type="text" value="Av Hill 123, Orlando" class="form-control" data-placeholder="" style="width: 100%" disabled />
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" value="555 768231" class="form-control" data-placeholder="" style="width: 100%" disabled />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Contact</label>
                            <div class="select2-purple">
                                <input type="text" value="Henrry Ford" class="form-control" data-placeholder="" style="width: 100%" disabled />
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Confirmed Trucking Charge</label>
                            <input type="text" value="Allan Poe" class="form-control" data-placeholder="" style="width: 100%" disabled />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Comments</label>
                            <div class="select2-purple">
                                <textarea class="form-control" rows="3" placeholder="Enter ..." disabled>Call Before Delivery</textarea>
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>

                <!-- -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- ===================================================
    MODAL DOCS
=================================================== -->
<div class="modal fade" id="modal-coa">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Certicate Of Analysis</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p align="center"><img src="COA.png" /></p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-pod">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Probe of Delivery</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p align="center"><img src="POD.png" /></p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- end modals -->
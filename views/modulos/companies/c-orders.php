<?php if (!array_search('COMPANIES', $_SESSION['options'])) : ?>
    <script>
        window.location = './';
    </script>
<?php endif ?>

<?php
//$Orders = OrdersController::ctrShowOrders($_SESSION['idCompany'], null, null);
$AllowedProducts = CompaniesController::ctrAllowedProducts($_SESSION['idCompany']);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- ===================================================
                INPUT FECHAS
            =================================================== -->
            <div class="row justify-content-center">
                <div class="col-10 col-sm-8 col-md-6 col-lg-4 col-xl-3 text-center">
                    <!-- Date range -->
                    <div class="form-group">
                        <label>Date:</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right text-center" id="rango-fechas">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
            </div>
            <!-- ===================== 
              TABLA ORDERS
            ========================= -->
            <!-- TABLE: LATEST ORDERS -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <a href="c-neworder" type="button" class="btn btn-sm btn-info float-left">Place New Order</a>
                            <!-- <a href="completed_orders.html" class="btn btn-sm btn-success float-right">Delivered Orders</a> -->
                            <button class="btn btn-sm btn-primary float-right" type="button" data-toggle="modal" data-target="#modal-c-productsAllowed">Products</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive tablaOrders">
                                <table class="table table-sm">
                                    <thead class="text-capitalize">
                                        <tr>
                                            <th>Order</th>
                                            <th>Company</th>
                                            <th>Customer PO</th>
                                            <th>BOL REFERENCE</th>
                                            <th>DATE ENTERED</th>
                                            <th>DELIVER BY</th>
                                            <th>DELIVERED DATE</th>
                                            <th>Product</th>
                                            <th>Quanty</th>
                                            <th>Status</th>
                                            <th>COA</th>
                                            <th>POD</th>
                                            <th>PDF</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">

                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

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
                                <input class="form-control" type="text" name="" id="company" readonly>
                                <input type="hidden" name="company" value="<?= $_SESSION['idCompany'] ?>">
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
                                    <input type="text" class="form-control weight editOrder" id="Weight_Each_Bag" name="Weight_Each_Bag" data-placeholder="lbs" style="width: 100%" maxlength="5" required>
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
                                    <input type="number" class="form-control editOrder" id="Total_Skids" name="Total_Skids" data-placeholder="" style="width: 100%" required>
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
                                <input type="text" class="form-control editOrder" id="Customer_PO" name="Customer_PO" data-placeholder="" style="width: 100%" maxlength="20" required>
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
                                    <input type="text" class="form-control editOrder" id="PO_Reference" name="PO_Reference" data-placeholder="" style="width: 100%" maxlength="20" required>
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
                        Address 1
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Address 1</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control editOrder" id="Delivery_Address" name="Delivery_Address" data-placeholder="" style="width: 100%" maxlength="100" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Address 2
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Address 2</label>
                                <div class="select2-purple">
                                    <input type="text" class="form-control editOrder" id="Delivery_Address2" name="Delivery_Address2" data-placeholder="" style="width: 100%" maxlength="100">
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
                                    <input type="text" id="Delivery_Contact" name="Delivery_Contact" class="form-control editOrder" data-placeholder="" style="width: 100%" maxlength="100" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_City
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>City</label>
                                <div class="select2-purple">
                                    <input type="text" id="Delivery_City" name="Delivery_City" class="form-control editOrder" data-placeholder="" style="width: 100%" maxlength="100" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_ZipCode
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Zip Code</label>
                                <div class="select2-purple">
                                    <input type="text" id="Delivery_ZipCode" name="Delivery_ZipCode" class="form-control editOrder" data-placeholder="" style="width: 100%" maxlength="20">
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
                                <label>Delivered Date</label>
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
                        Delivery_Destination_Address 1
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Address 1</label>
                                <div class="select2-purple">
                                    <input type="text" id="Delivery_Destination_Address" name="Delivery_Destination_Address" class="form-control editOrder" data-placeholder="" style="width: 100%" maxlength="100" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_Address 2
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Address 2</label>
                                <div class="select2-purple">
                                    <input type="text" id="Delivery_Destination_Address2" name="Delivery_Destination_Address2" class="form-control editOrder" data-placeholder="" style="width: 100%" maxlength="100">
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
                        Delivery_Destination_City
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>City</label>
                                <div class="select2-purple">
                                    <input type="text" id="Delivery_Destination_City" name="Delivery_Destination_City" class="form-control editOrder" data-placeholder="" maxlength="100" style="width: 100%" required>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        Delivery_Destination_ZipCode
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Zip Code</label>
                                <div class="select2-purple">
                                    <input type="text" id="Delivery_Destination_ZipCode" name="Delivery_Destination_ZipCode" class="form-control editOrder" data-placeholder="" maxlength="20" style="width: 100%">
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

<!-- ===================================================
    MODAL SEE TABLE WITH PRODUCTS ALLOWED
=================================================== -->
<div id="modal-c-productsAllowed" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Products</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-light table-sm table-bordered table-striped tablaProductsAllowed w-100">
                        <thead class="text-center">
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>Item</td>
                                <td>Weight</td>
                                <td>Unit</td>
                                <td>Price</td>
                                <td>Image</td>
                                <td>Description</td>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($AllowedProducts as $key => $value) : ?>
                                <tr>
                                    <td><?= $value['id_products'] ?></td>
                                    <td><?= $value['Name'] ?></td>
                                    <td><?= $value['Reference'] ?></td>
                                    <td><?= $value['Weight'] ?></td>
                                    <td><?= $value['Unit'] ?></td>
                                    <td><?= $value['Price'] ?></td>
                                    <td><img class="img-thumbnail img-fluid btn-imgproduct" idproduct="<?= $value['id_products'] ?>" src="<?= "." . $value['Image'] ?>" width="100" alt="" style="cursor: pointer;" data-target="#modal-imgproduct" data-toggle="modal"></td>
                                    <td class="text-sm" style="max-width: 150px"><?= $value['Description'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$ProductsAllowed = CompaniesController::ctrAllowedProducts($_SESSION['idCompany']);

if ($ProductsAllowed == null) {
    echo '
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <p>There are not allowed products for your company, please contact customer service.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';
    $hideForm = "d-none";
} else {
    $hideForm = "";
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">New Order</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">New Order</li>
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
            <div class="row <?= $hideForm ?>">
                <div class="col-12">
                    <!-- FORMULARIO -->
                    <form id="formNewOrder" method="post">
                        <!-- PO Content  -->

                        <div class="row">
                            <input type="hidden" name="client" value="<?= $_SESSION['idCompany'] ?>">

                            <!-- ===================================================
                                Client
                            =================================================== -->
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label>Client</label>
                                    <input class="form-control" type="text" name="" readonly value="<?= $ProductsAllowed[0]['Company'] ?>">
                                </div>
                                <!-- /.form-group -->
                            </div>

                            <!-- ===================================================
                                Product
                            =================================================== -->
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select class="form-control select2 productsInput" name="id_products" style="width: 100%" required>
                                        <option value="" selected disabled>Choose an option</option>
                                        <?php foreach ($ProductsAllowed as $key => $value) : ?>
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
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label>Weight of Each Bag</label>
                                    <div class="select2-purple">
                                        <input type="text" class="form-control weight" name="Weight_Each_Bag" data-placeholder="lbs" style="width: 100%" maxlength="5" required readonly>
                                    </div>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->

                            <!-- ===================================================
                        Total Bags
                    =================================================== -->
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label>Customer PO#</label>
                                    <input type="text" class="form-control" name="Customer_PO" data-placeholder="" style="width: 100%" maxlength="40" required>
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label>P.O. Reference #</label>
                                    <div class="select2-purple">
                                        <input type="text" class="form-control" name="PO_Reference" data-placeholder="" style="width: 100%" maxlength="20" required>
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <div class="select2-purple">
                                        <input type="text" name="Delivery_Contact" class="form-control" data-placeholder="" style="width: 100%" maxlength="50">
                                    </div>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->

                            <!-- ===================================================
                        Delivery_Date
                    =================================================== -->
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label>Real Delivered Date</label>
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <div class="select2-purple">
                                        <input type="text" name="Delivery_Destination_Contact" class="form-control" data-placeholder="" maxlength="100" style="width: 100%">
                                    </div>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->

                            <!-- ===================================================
                        Delivery_Destination_Confirmed_Trucking_Charge
                    =================================================== -->
                            <div class="col-12 col-sm-6 col-lg-4">
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
                            <div class="col-12 col-sm-6 col-lg-4">
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

                <div class="col-12 text-right mb-2">
                    <button class="btn btn-success" type="submit" form="formNewOrder"><i class="fas fa-save"></i> Save</button>
                    <?php
                    $newOrder = OrdersController::ctrNewOrder();
                    ?>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
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
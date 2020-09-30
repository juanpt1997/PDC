<?php
$Companies = CompaniesController::ctrShowCompanies();
//$Companies = array();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Companies</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Companies</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"></h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table tablaCompanies table-sm">
                            <thead>
                                <tr>
                                    <th>Country</th>
                                    <th>Company</th>
                                    <th>ID</th>
                                    <th>Address Line1</th>
                                    <th>Address Line2</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>ZIP Code</th>
                                    <th>Contact</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Actions</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($Companies as $key => $value) : ?>
                                    <tr>
                                        <td><?= $value['Country'] ?></td>
                                        <td><?= $value['Name'] ?></td>
                                        <td><?= $value['ID'] ?></td>
                                        <td><?= $value['Address_Line1'] ?></td>
                                        <td><?= $value['Address_Line2'] ?></td>
                                        <td><?= $value['City'] ?></td>
                                        <td><?= $value['State_Province_Region'] ?></td>
                                        <td><?= $value['Zip_Code'] ?></td>
                                        <td><?= $value['Contact_Name'] ?></td>
                                        <td><?= $value['Phone_Number'] ?></td>
                                        <td><?= $value['Email'] ?></td>
                                        <td><button class="btn btn-info btn-sm companyInfo" data-target="#modal-editcompany" data-toggle="modal" idcompany="<?= $value['id_companies'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>



                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">

                    <button type="button" class="btn btn-primary btn-sm btn-primary float-left" data-toggle="modal" data-target="#modal-newcompany">New Company</button>

                </div>

            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- ===================================================
    BEGIN MODALS
=================================================== -->
<!-- ===================================================
    NEW COMPANY
=================================================== -->
<div class="modal fade" id="modal-newcompany">
    <div class="modal-dialog modal-lg">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- ===================================================
                            COUNTRY
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Country</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                                    </div>
                                    <input name="country" type="text" class="form-control" id="" placeholder="Country" maxlength="50" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            COMPANY
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Company</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-industry"></i></span>
                                    </div>
                                    <input name="company" type="text" class="form-control" id="" placeholder="Company" maxlength="250" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            ID
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">ID</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text font-weight-bold">ID</span>
                                    </div>
                                    <input name="ID" type="text" class="form-control" id="" placeholder="..." maxlength="20">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            ADDRESS LINE 1
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Address Line 1</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input name="addrLine1" type="text" class="form-control" id="" placeholder="Address Line 1" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            ADDRESS LINE 2
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Address Line 2</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input name="addrLine2" type="text" class="form-control" id="" placeholder="Address Line 2" maxlength="100">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            CITY
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">City</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                    </div>
                                    <input name="city" type="text" class="form-control" id="" placeholder="City" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            STATE PROVINCE REGION
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">State/Province</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                    </div>
                                    <input name="state" type="text" class="form-control" id="" placeholder="State/Province" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            ZIP CODE
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Zip Code</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                    </div>
                                    <input name="zipcode" type="text" class="form-control" id="" placeholder="Zip Code" maxlength="20">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            CONTACT NAME
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Contact Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                    </div>
                                    <input name="contact" type="text" class="form-control" id="" placeholder="Contact Name" maxlength="100">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            PHONE NUMBER
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Phone Number</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
                                    </div>
                                    <input name="phone" type="text" class="form-control" id="" placeholder="Phone Number" maxlength="50">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            EMAIL
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input name="email" type="email" class="form-control" id="" placeholder="Email" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            COMMENTS
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Comments</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-comments"></i></span>
                                    </div>
                                    <textarea name="comments" class="form-control" style="max-height: 200px; min-height: 100px;" maxlength="255"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

                <?php 
                    $newCompany = CompaniesController::ctrNewCompany();
                ?>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- ===================================================
    VIEW COMPANY
=================================================== -->
<div class="modal fade" id="modal-editcompany">
    <div class="modal-dialog modal-lg">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title companyTitle"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- ===================================================
                            COUNTRY
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Country</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                                    </div>
                                    <input name="country" type="text" class="form-control editCompany" id="country" placeholder="Country" maxlength="50" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            COMPANY
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Company</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-industry"></i></span>
                                    </div>
                                    <input name="editcompany" type="text" class="form-control editCompany" id="company" placeholder="Company" maxlength="250" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            ID
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">ID</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text font-weight-bold">ID</span>
                                    </div>
                                    <input name="ID" type="text" class="form-control editCompany" id="ID" placeholder="..." maxlength="20">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            ADDRESS LINE 1
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Address Line 1</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input name="addrLine1" type="text" class="form-control editCompany" id="addrLine1" placeholder="Address Line 1" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            ADDRESS LINE 2
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Address Line 2</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input name="addrLine2" type="text" class="form-control editCompany" id="addrLine2" placeholder="Address Line 2" maxlength="100">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            CITY
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">City</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                    </div>
                                    <input name="city" type="text" class="form-control editCompany" id="city" placeholder="City" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            STATE PROVINCE REGION
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">State/Province</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                    </div>
                                    <input name="state" type="text" class="form-control editCompany" id="state" placeholder="State/Province" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            ZIP CODE
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Zip Code</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                    </div>
                                    <input name="zipcode" type="text" class="form-control editCompany" id="zipcode" placeholder="Zip Code" maxlength="20">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            CONTACT NAME
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Contact Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                    </div>
                                    <input name="contact" type="text" class="form-control editCompany" id="contact" placeholder="Contact Name" maxlength="100">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            PHONE NUMBER
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Phone Number</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
                                    </div>
                                    <input name="phone" type="text" class="form-control editCompany" id="phone" placeholder="Phone Number" maxlength="50">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            EMAIL
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input name="email" type="email" class="form-control editCompany" id="email" placeholder="Email" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            COMMENTS
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Comments</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-comments"></i></span>
                                    </div>
                                    <textarea name="comments" class="form-control editCompany" id="comments" style="max-height: 200px; min-height: 100px;" maxlength="255"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

                <?php 
                    $newCompany = CompaniesController::ctrNewCompany();
                ?>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
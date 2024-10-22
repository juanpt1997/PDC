<?php if (!array_search('OPERATIONS', $_SESSION['options'])) : ?>
    <script>
        window.location = './';
    </script>
<?php endif ?>

<?php
$Companies = CompaniesController::ctrShowCompanies();

$Products = ProductsController::ctrShowProducts();

$listOfStates = ['AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY'];
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
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
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
                                    <!-- <th>ID</th> -->
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
                                    <?php
                                    $btnEditCompany = "<button class='btn btn-secondary btn-sm companyInfo m-1' data-target='#modal-editcompany' data-toggle='modal' idcompany='{$value['id_companies']}'><i class='fas fa-pencil-alt'></i></button>";
                                    $botonProductsAllowed = "<button class='btn btn-primary btn-sm btn-productsAllowed m-1' data-target='#modal-productsAllowed' data-toggle='modal' idcompany='{$value['id_companies']}' namecompany='{$value['Name']}'><i class='fas fa-cubes'></i></button>";
                                    $btnDeleteCompany = "<button class='btn btn-danger btn-sm btnBorrarCompany m-1' id_companies='{$value['id_companies']}' nameCompany='{$value['Name']}'><i class='fas fa-trash-alt'></i></button>";
                                    $btnActions = "<div class='row d-flex flex-nowrap justify-content-center'>" . $btnEditCompany . $botonProductsAllowed . $btnDeleteCompany . "</div>";
                                    ?>
                                    <tr>
                                        <td><?= $value['Country'] ?></td>
                                        <td><?= $value['Name'] ?></td>
                                        <!-- <td><?= $value['ID'] ?></td> -->
                                        <td><?= $value['Address_Line1'] ?></td>
                                        <td><?= $value['Address_Line2'] ?></td>
                                        <td><?= $value['City'] ?></td>
                                        <td><?= $value['State_Province_Region'] ?></td>
                                        <td><?= $value['Zip_Code'] ?></td>
                                        <td><?= $value['Contact_Name'] ?></td>
                                        <td><?= $value['Phone_Number'] ?></td>
                                        <td><?= $value['Email'] ?></td>
                                        <td><?= $btnActions ?></td>
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
        <form method="post" enctype="multipart/form-data">
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
                                    <input value="United States" name="country" type="text" class="form-control" id="" placeholder="Country" maxlength="50" readonly required>
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
                        <div class="col-12 col-md-6 d-none">
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
                                    <select name="state" class="form-control" id="" required>
                                        <option value="">Select an option</option>
                                        <?php foreach ($listOfStates as $key => $value) : ?>
                                            <option><?= $value ?></option>
                                        <?php endforeach ?>
                                    </select>
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
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title companyTitle"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- ID LEAD -->
                        <input type="hidden" class="editCompany" name="idcompany" id="idcompany" value="1">
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
                                    <input name="country" type="text" class="form-control editCompany" id="country" placeholder="Country" maxlength="50" required readonly>
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
                        <div class="col-12 col-md-6 d-none">
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
                                    <!-- <input name="state" type="text" class="form-control editCompany" id="state" placeholder="State/Province" maxlength="100" required> -->
                                    <select name="state" class="form-control editCompany" id="state" required>
                                        <option value="">Select an option</option>
                                        <?php foreach ($listOfStates as $key => $value) : ?>
                                            <option><?= $value ?></option>
                                        <?php endforeach ?>
                                    </select>
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
                $modifyCompany = CompaniesController::ctrUpdateCompany();
                ?>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- ===================================================
    MODAL ASIGNAR PRODUCTS A UN COMPANY - PRODUCTS ALLOWED
=================================================== -->
<div id="modal-productsAllowed" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_ProductsAllowed">Title</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="spinner-grow spinnerDuallistbox" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="frmAllowedProducts" method="post" enctype="multipart/form-data">
                    <input id="allowedProductsIdCompany" type="hidden" name="idCompany" value="">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group divAllowedProducts">

                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit" form="frmAllowedProducts"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php
            $updateAllowedProducts = CompaniesController::ctrSaveAllowedProducts();
            ?>
        </div>
    </div>
</div>
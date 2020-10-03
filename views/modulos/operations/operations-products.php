<?php
$Products = ProductsController::ctrShowProducts();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
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
                        <table class="table tablaProducts table-sm">
                            <thead class="text-center">
                                <tr>
                                    <td>Name</td>
                                    <td>Reference</td>
                                    <td>Weight</td>
                                    <td>Unit</td>
                                    <td>Price</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php foreach ($Products as $key => $value) : ?>
                                    <tr>
                                        <td><?= $value['Name'] ?></td>
                                        <td><?= $value['Reference'] ?></td>
                                        <td><?= $value['Weight'] ?></td>
                                        <td><?= $value['Unit'] ?></td>
                                        <td><?= $value['Price'] ?></td>
                                        <td><button class="btn btn-info btn-sm productInfo" data-target="#modal-editproduct" data-toggle="modal" idproduct="<?= $value['id_products'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>



                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">

                    <button type="button" class="btn btn-primary btn-sm btn-primary float-left" data-toggle="modal" data-target="#modal-newproduct">New Product</button>

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
    NEW PRODUCTS
=================================================== -->
<div class="modal fade" id="modal-newproduct">
    <div class="modal-dialog modal-lg">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- ===================================================
                            NAME
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>
                                    <input name="Name" type="text" class="form-control" id="" placeholder="Name" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Reference
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Reference</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    </div>
                                    <input name="Reference" type="text" class="form-control" id="" placeholder="Reference" maxlength="30" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Weight
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Weight</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                    </div>
                                    <input name="Weight" type="text" class="form-control" id="" placeholder="Weight" maxlength="20" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Unit
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Unit</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-sort-numeric-up-alt"></i></span>
                                    </div>
                                    <input name="Unit" type="text" class="form-control" id="" placeholder="Unit" maxlength="20" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Price
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Price</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                    </div>
                                    <input name="Price" type="text" class="form-control" id="" placeholder="Price" maxlength="30" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Image
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Image</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    </div>
                                    <input name="Image" type="file" class="form-control" id="" placeholder="Image" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Description
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Description</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-align-center"></i></span>
                                    </div>
                                    <textarea name="Description" type="text" class="form-control" style="max-height: 200px; min-height: 100px;" id="" placeholder="Description" maxlength="250" required></textarea>
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
                $newproduct = ProductsController::ctrNewProduct();
                ?>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- ===================================================
    VIEW PRODUCT
=================================================== -->
<div class="modal fade" id="modal-editproduct">
    <div class="modal-dialog modal-lg">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title productTitle"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- ID LEAD -->
                        <input type="hidden" class="editProduct" name="idproduct" id="idproduct" value="1">
                        <!-- ===================================================
                            NAME
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>
                                    <input name="editName" type="text" class="form-control editProduct" id="Name" placeholder="Name" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Reference
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Reference</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    </div>
                                    <input name="Reference" type="text" class="form-control editProduct" id="Reference" placeholder="Reference" maxlength="30" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Weight
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Weight</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                    </div>
                                    <input name="Weight" type="text" class="form-control editProduct" id="Weight" placeholder="Weight" maxlength="20" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Unit
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Unit</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-sort-numeric-up-alt"></i></span>
                                    </div>
                                    <input name="Unit" type="text" class="form-control editProduct" id="Unit" placeholder="Unit" maxlength="20" required>
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Price
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Price</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                    </div>
                                    <input name="Price" type="text" class="form-control editProduct" id="Price" placeholder="Price" maxlength="30" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6"></div>

                        <!-- ===================================================
                            Image
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <label for="">Image</label>
                            <div class="row">
                                <div class="col-12">
                                    <img id="Image" src="..." class="img-fluid img-thumbnail" alt="..." width="100">
                                </div>
                                <div class="col-12">
                                    <input name="Image" type="file" class="form-control" id="" placeholder="Image">
                                </div>
                            </div>
                        </div>

                        <!-- ===================================================
                            Description
                        =================================================== -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Description</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-align-center"></i></span>
                                    </div>
                                    <textarea name="Description" type="text" class="form-control editProduct" style="max-height: 200px; min-height: 100px;" id="Description" placeholder="Description" maxlength="250" required></textarea>
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
                    $updateproduct = ProductsController::ctrUpdateProduct();
                ?>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
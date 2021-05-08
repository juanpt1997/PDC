<?php if (!array_search('OPERATIONS', $_SESSION['options'])) : ?>
    <script>
        window.location = './';
    </script>
<?php endif ?>

<?php
if (isset($_SESSION['bol_reference'])) {
    # Datos de la orden
    $orderData = BOLController::ctrOrderInfo($_SESSION['bol_reference']);
    $bagsxpallet = doubleval($orderData['Total_Bags']) / $orderData['Total_Skids'];
    $WeightEaBag = doubleval($orderData['Weight_Each_Bag']);
    $bolreference = $orderData['PO_Reference'];

    # Clientes
    $Companies = CompaniesController::ctrShowCompanies();

    # Tabla bol
    $TablaBOL = BOLController::ctrTablaBOL($_SESSION['bol_reference']);

    # Contador pallets
    $contPallets = 0;
    foreach ($TablaBOL as $key => $value) {
        $contPallets += $value['Pallets'];
    }

    /* ===================================================
       CONSECUTIVOS DEL ARCHIVO
    ===================================================*/
    # Array con los consecutivos ya seleccionados para el bol_reference de la BD
    $arrConsecutivosSelec = array();
    foreach ($TablaBOL as $key => $value) {
        array_push($arrConsecutivosSelec, $value['Consecutive']);
    }
    # Array con las opciones que hay
    $arrConsecutivos = ['', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'];

    /* ===================================================
        OCULTAR TEXTO EN EL TITULO, AL IGUAL QUE CIERTA INFO QUE DEPENDE SI EXISTE LA VARIABLE DE bol_reference
    ===================================================*/
    $dnone = "";
} else {
    $dnone = "d-none";
    $bolreference = "";
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><button id="botonVolver" class="btn btn-secondary <?= $dnone ?>" type="button"><i class="fas fa-arrow-left"></i></button> Bill of Lading <span class="<?= $dnone ?>">#: <?= $bolreference ?></span></h1>
                    <h4 class="<?= $dnone ?> text-sm">Pallets: <?= $contPallets ?>/<?= $orderData['Total_Skids'] ?></h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">Bill of Lading</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php if (isset($_SESSION['bol_reference'])) : ?>
                <!-- ===================================================
                    VIENE EL VALOR DEL BOL REFERENCE POR SESSION
                =================================================== -->
                <!-- ===================================================
                BOTON PARA AGREGAR NUEVO BOL
            =================================================== -->
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarBOLModal">
                            <i class="fas fa-plus-circle"></i> New
                        </button>
                    </div>
                </div>
                <!-- /.row -->

                <!-- ===================== 
                TABLA DE BOL PARA FORMAR EL POD
            ========================= -->
                <div class="row mt-4">
                    <div class="col-sm-12">
                        <table class="table table-sm table-striped table-bordered table-hover tabla-bol w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th>BOL REFERENCE</th>
                                    <th>CUSTOMER PO</th>
                                    <th>LOT #</th>
                                    <th>REF C #</th>
                                    <th>FROM</th>
                                    <th>TO</th>
                                    <th>SHIPPING</th>
                                    <th>CARRIER</th>
                                    <th>PALLETS</th>
                                    <th>CS/BAGS</th>
                                    <th>DESCRIPTION</th>
                                    <th>WEIGHT/LB</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($TablaBOL as $key => $value) : ?>
                                    <?php
                                    $botonDescargarBOL = "<button class='btn btn-secondary btn-sm btn-descargarbol' type='button' id_bol='{$value['id_bol']}'><i class='fas fa-file-pdf'></i></button>";
                                    $btnBOLPDF = "<div class='row d-flex flex-nowrap justify-content-center m-1'>" . $botonDescargarBOL . "</div>";

                                    //$btnBOLPDF = "<button class='btn btn-secondary btn-sm m-1' type='button' id_bol='{$value['id_bol']}'><i class='fas fa-file-pdf'></i></button>";
                                    # DELETE BOL
                                    $btnDeleteBOL = "<button class='btn btn-danger btn-sm m-1 btn-deleteBOL' type='button' id_bol='{$value['id_bol']}'><i class='fas fa-trash-alt'></i></button>";
                                    # Btn Actions
                                    $btnActions = "<div class='row d-flex flex-nowrap justify-content-center'>" . $btnBOLPDF . $btnDeleteBOL . "</div>";

                                    // $btnDeleteOrder = "<button class='btn btn-danger btn-sm btnBorrarOrder m-1' id_orders='{$value['id_orders']}'><i class='fas fa-trash-alt'></i></button>";
                                    // $btnActions = "<div class='row d-flex flex-nowrap justify-content-center'>" . $btnDeleteOrder . "</div>";
                                    ?>
                                    <tr>
                                        <td><?= $value['PO_Reference'] . $value['Consecutive'] ?></td>
                                        <td><?= $value['Customer_PO'] ?></td>
                                        <td><?= $value['Lot'] ?></td>
                                        <td><?= $value['RefC'] ?></td>
                                        <td><?= $value['Cfrom'] ?></td>
                                        <td><?= $value['Cto'] ?></td>
                                        <td><?= $value['Shippingdate'] ?></td>
                                        <td><?= $value['Carrier'] ?></td>
                                        <td><?= $value['Pallets'] ?></td>
                                        <td><?= $value['Bags'] ?></td>
                                        <td><?= $value['Description'] ?></td>
                                        <td><?= $value['Weight'] ?></td>
                                        <td class="text-center"><?= $btnActions ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>


                    </div><!-- col-sm-12 -->



                </div>
                <!-- /.row -->

            <?php else : ?>
                <!-- ===================== 
                    DIGITAR BOL REFERENCE PARA MOSTRAR DETALLES
                ========================= -->
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-5 text-center">
                        <form method="post">
                            <div class="form-group">
                                <label>BOL REFERENCE</label> <br>
                                <input class="form-control" type="text" name="bol-reference" autofocus required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="far fa-check-square"></i>
                                    Continue
                                </button>
                            </div>
                        </form>
                        <?php BOLController::ctrValidarBOL(); ?>
                    </div>
                </div>
                <!-- /.row -->
            <?php endif ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div id="agregarBOLModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">BOL REFERENCE: <?= $_SESSION['bol_reference'] ?></h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- FORMULARIO -->
                <form id="formNewBol" method="post">
                    <div class="row pb-2">
                        <input type="hidden" id="bagsxpallet" value="<?= $bagsxpallet ?>">
                        <input type="hidden" id="WeightEaBag" value="<?= $WeightEaBag ?>">

                        <!-- ===================================================
                        BOL #
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group d-none">
                                <label>BOL #</label>
                                <input type="text" class="form-control" name="bolReference" data-placeholder="" style="width: 100%" maxlength="20" readonly value="<?= $orderData['PO_Reference'] ?>">
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label>BOL #</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="bolReference" data-placeholder="" style="width: 80%" maxlength="20" readonly value="<?= $orderData['PO_Reference'] ?>">
                                    <div class="input-group-append" style="width: 20%">
                                        <select id="filecons" class="form-control" name="consecutive">
                                            <?php foreach ($arrConsecutivos as $key => $value) : ?>
                                                <?php
                                                $key2 = array_search($value, $arrConsecutivosSelec);
                                                ?>
                                                <?php if (false === $key2) : ?>
                                                    <option><?= $value ?></option>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        PO. REF #
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>PO. REF #</label>
                                <input type="text" class="form-control" data-placeholder="" style="width: 100%" maxlength="20" readonly value="<?= $orderData['Customer_PO'] ?>">
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        FILE CONSECUTIVE
                    =================================================== -->
                        <!-- <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>File consecutive</label>
                                <select id="filecons" class="form-control" name="consecutive">
                                    <?php foreach ($arrConsecutivos as $key => $value) : ?>
                                        <?php
                                        $key2 = array_search($value, $arrConsecutivosSelec);
                                        ?>
                                        <?php if (false === $key2) : ?>
                                            <option><?= $value ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div> -->
                        <!-- /.col -->


                        <!-- ===================================================
                        LOT #
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>LOT #</label>
                                <input type="text" class="form-control" name="lot" data-placeholder="" style="width: 100%" maxlength="20">
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        REF C #
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>REF C #</label>
                                <input type="text" class="form-control" name="refC" data-placeholder="" style="width: 100%" maxlength="20">
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->


                        <!-- ===================================================
                        FROM
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>FROM</label>
                                        <select class="form-control from company" name="fromId" required>
                                            <option value=""></option>
                                            <?php foreach ($Companies as $key => $value) : ?>
                                                <option value="<?= $value['id_companies'] ?>"><?= $value['Name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-12 text-right from-details">
                                    <!-- <p class="text-monospace">275 Broad st</p>
                                <p class="text-monospace">Carlstadt, NJ, 07022</p> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        TO
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>TO</label>
                                        <select class="form-control to company" name="toId" required>
                                            <option value=""></option>
                                            <?php foreach ($Companies as $key => $value) : ?>
                                                <option value="<?= $value['id_companies'] ?>"><?= $value['Name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-12 text-right to-details">
                                    <!-- <p class="text-monospace">275 Broad st</p>
                                <p class="text-monospace">Carlstadt, NJ, 07022</p> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        SHIPPING DATE
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>SHIPPING DATE</label>
                                <input class="form-control" type="date" name="shippingDate" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->


                        <!-- ===================================================
                        CARRIER
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>CARRIER</label>
                                <input class="form-control" type="text" name="carrier" maxlength="20">
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <hr>
                    <div class="row pt-2">
                        <!-- ===================================================
                        PALLETS
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>PALLETS</label>
                                <input class="form-control pallets" type="number" name="pallets" min="1" max="<?= $orderData['Total_Skids'] - $contPallets ?>" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        CS/BAGS
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>CS/BAGS</label>
                                <input class="form-control bags" type="number" name="bags" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        DESCRIPTION
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>DESCRIPTION</label>
                                <input class="form-control" type="text" readonly value="<?= $orderData['productDescription'] ?>">
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <!-- ===================================================
                        WEIGHT/LB
                    =================================================== -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>WEIGHT/LB</label>
                                <input class="form-control weight" type="number" name="weight" step="0.01" required>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </form>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit" form="formNewBol"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
            <?php
            $guardarBOL = BOLController::ctrAgregarBOL();
            ?>
        </div>
    </div>
</div>
<!-- =================================================== MODAL PARA CERRAR SESIÓN =================================================== -->
<div class="modal fade" id="cerrarSesionModal" tabindex="-1" role="dialog" aria-labelledby="cerrarSesionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cerrarSesionModalLabel">Log Out</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="text-center">
                        Are you sure you want to log out?
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <a href="./logout" class="btn btn-danger">Log Out</a>
            </div>
        </div>
    </div>
</div>

<!-- ===================================================
    MODAL DOCS COA-POD
=================================================== -->
<div class="modal fade" id="modal-docs">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title docTitle">Certicate Of Analysis</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- ===================================================
                    ACA PUEDE IR CUALQUIERA DE LA SIGUIENTES OPCIONES SEGUN EL DOCUMENTO QUE HAYA SIDO CARGADO O NO: 
                =================================================== -->
                <!-- VISUALIZAR PDF COMO DOCUMENTO -->
                <div class="d-none" id="canvasPDF">
                </div>

                <!-- VISUALIZAR IMAGEN COMO DOCUMENTO -->
                <div class="row" id="containerImgDoc">
                    <div class="col-12">
                        <img class="img-fluid" id="imgDoc" src="">
                    </div>
                </div>

                <!-- FORMULARIO PARA CARGAR UN ARCHIVO -->
                <form method="post" enctype="multipart/form-data" id="frmSubirDocumento" class="d-none">
                    <input type="hidden" name="idorderDoc" class="idorder" value="">
                    <input type="hidden" name="tipoDoc" class="tipodoc" value="">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        </div>
                        <input name="docFile" type="file" class="form-control" required accept="image/png, image/jpeg, application/pdf">
                    </div>
                </form>
                <?php
                OrdersController::ctrLoadDoc();
                ?>
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-success" type="submit" form="frmSubirDocumento" id="btnGuardarArchivo"><i class="fas fa-save"></i> Save</button>
                <button class="btn btn-success" type="button" id="btnDescargarArchivo"><i class="fas fa-download"></i> Download</button>
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
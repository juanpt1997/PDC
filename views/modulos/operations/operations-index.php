<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        content here...

    </section>
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
                        <a href="salir" class="btn btn-danger"><i class="fas fa-times"></i> Cancelar </a>
                        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button> -->
                        <button type="submit" class="btn btn-success " disabled id="btnCambioPassword"><i class="fas fa-lock"></i> Cambiar</button>
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
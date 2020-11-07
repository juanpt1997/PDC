<?php if (!array_search('USERS', $_SESSION['options'])) : ?>
    <script>
        window.location = './';
    </script>
<?php endif ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                BOTON PARA AGREGAR NUEVO USUARIO
            =================================================== -->
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarUsuarioModal">
                        <i class="fas fa-user-plus"></i> New user
                    </button>
                </div>
            </div>
            <!-- /.row -->

            <!-- ===================== 
                TABLA DE USUARIOS
            ========================= -->
            <div class="row mt-3">
                <div class="col-sm-12">
                    <table class="table table-sm table-striped table-bordered table-hover tablaUsuarios dt-responsive w-100">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:10px;">#</th>
                                <th>Name</th>
                                <th>email</th>
                                <th>Profile</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $usuarios = UsersController::ctrShowUsers(null);

                            foreach ($usuarios as $key => $value) {
                                echo '
                                    <tr>
                                        <td>' . ($key + 1) . '</td>
                                        <td>' . $value['name'] . '</td>
                                        <td>' . $value['email'] . '</td>
                                        <td>' . $value['profile'] . '</td>
                                        ';

                                if ($value['status'] != 0) {
                                    echo '<td><button class="btn btn-sm btn-success btnActivar" idUsuario="' . $value["idUser"] . '" estadoUsuario="0">Active</button></td>';
                                } else {
                                    echo '<td><button class="btn btn-sm btn-danger btnActivar" idUsuario="' . $value["idUser"] . '" estadoUsuario="1">Inactive</button></td>';
                                }

                                /*  <button class="btn btn-sm btn-danger btnEliminarUsuario" tokenUsuario="' . $value["token"] . '" fotoUsuario="' . $value["foto"] . '" usuario="' . $value["cedula"] . '"><i class="fas fa-times"></i></button> */

                                echo  '<td>' . $value['last_login'] . '</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Button group">
                                                <button class="btn btn-sm btn-warning btnEditarUsuario" email="' . $value['email'] . '" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fas fa-edit"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                ';
                            }
                            ?>
                        </tbody>
                    </table>


                </div><!-- col-sm-12 -->



            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- ===================================================
    MODALS
=================================================== -->

<!--================================================ 
        MODAL PARA AGREGAR USUARIO      
================================================-->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form method="post" enctype="multipart/form-data">
                <!-- INICIO DEL FORMULARIO -->

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Usuario -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope-square"></i>
                                </span>
                            </div>
                            <input class="form-control" type="email" id="nuevoEmail" name="nuevoEmail" placeholder="Email" required>
                        </div>
                    </div>

                    <!-- CEDULA -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-address-card"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" min="0" id="nuevaIdentificacion" name="nuevaIdentificacion" placeholder="DNI" required>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" name="nuevoNombre" placeholder="Full Name" required>
                        </div>
                    </div>

                    <!-- CELULAR -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-mobile-alt"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" name="nuevoCelular" placeholder="Phone Number" required>
                        </div>
                    </div>

                    <!-- PERFIL -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-user-secret"></i>
                                </span>
                            </div>
                            <select class="form-control input-lg" name="nuevoPerfil" required>
                                <option disabled selected>Select a profile</option>
                                <?php
                                $perfiles = UsersController::ctrProfilesList();

                                foreach ($perfiles as $key => $value) {

                                    echo '<option value="' . $value['idProfile'] . '">' . $value['profile'] . '</option>';
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Guardar
                    </button>
                </div>

                <?php
                #Dentro del objeto de php, ejecutamos el objeto del controlador para enviar los datos a la db
                $crearUsuario = new UsersController();
                $crearUsuario->ctrNewUser();
                ?>
            </form> <!-- FIN FORMULARIO -->

        </div>
    </div>
</div>

<!--================================================ 
        MODAL PARA EDITAR USUARIO      
================================================-->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form method="post" enctype="multipart/form-data">
                <!-- INICIO DEL FORMULARIO -->

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Usuario -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope-square"></i>
                                </span>
                            </div>
                            <input class="form-control" type="email" id="editarEmail" name="editarEmail" placeholder="Email" required>
                        </div>
                    </div>

                    <!-- CEDULA -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-address-card"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" min="0" id="editarIdentificacion" name="editarIdentificacion" placeholder="DNI" required readonly>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="editarNombre" name="editarNombre" placeholder="Full Name" required>
                        </div>
                    </div>

                    <!-- CELULAR -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-mobile-alt"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="editarCelular" name="editarCelular" placeholder="Phone Number" required>
                        </div>
                    </div>

                    <!-- PERFIL -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-user-secret"></i>
                                </span>
                            </div>
                            <select class="form-control input-lg" name="editarPerfil" required>
                                <option disabled selected>Select a profile</option>
                                <?php
                                $perfiles = UsersController::ctrProfilesList();

                                foreach ($perfiles as $key => $value) {

                                    echo '<option value="' . $value['idProfile'] . '">' . $value['profile'] . '</option>';
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-warning" type="button" id="restablecerPswd" data-dismiss="modal"><i class="fas fa-lock-open"></i> Restablecer Contraseña</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Modificar usuario
                    </button>
                </div>

                <?php
                #Dentro del objeto de php, ejecutamos el objeto del controlador para enviar los datos a la db
                $editarUsuario = new UsersController();
                $editarUsuario->ctrEditUser();
                ?>



            </form> <!-- FIN FORMULARIO -->

        </div>
    </div>
</div>
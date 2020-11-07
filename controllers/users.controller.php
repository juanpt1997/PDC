<?php

class UsersController
{
    /*=============================================
        LOG IN
	=============================================*/
    public function ctrLogin()
    {
        # Check if there is post variable called email, that comes from the form
        if (isset($_POST["email"])) {
            if (
                preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $_POST["email"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["password"])
            ) {

                $valor = $_POST["email"];

                $respuesta = UsersModel::mdlShowUsers($valor);

                $encriptar = crypt($_POST["password"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                if ($respuesta["email"] == $_POST["email"] && $respuesta["password"] == $encriptar) {

                    #SI EL USUARIO ESTA ACTIVO EN EL SISTEMA
                    if ($respuesta['status'] == 1) {
                        /* ===================== 
							ACTUALIZAMOS  LA FECHA Y HORA PARA EL ULTIMO LOGIN 
						========================= */
                        date_default_timezone_set('America/Bogota');

                        $tabla = "L_Users";

                        $fecha = date('Y-m-d');
                        $hora = date('H:i:s');
                        $fechaActual = $fecha . " " . $hora;

                        $item1 = "last_login";
                        $valor1 = $fechaActual;

                        $item2 = "idUser";
                        $valor2 = $respuesta['idUser'];

                        $ultimoLogin = UsersModel::mdlUpdateSingleField($tabla, $item1, $valor1, $item2, $valor2);

                        if ($ultimoLogin == "ok") {
                            # Session variables
                            $_SESSION['logged_in'] = "ok";
                            $_SESSION['user_id'] = $respuesta['idUser'];
                            $_SESSION['name'] = $respuesta['name'];
                            $_SESSION['email'] = $respuesta['email'];


                            /* ===================== 
								CARGAMOS OPCIONES DISPONBLES PARA EL USUARIO 
							========================= */
                            $valorOpcion = $respuesta['idUser'];
                            $opciones = array();
                            $opciones = UsersModel::mdlShowProfileOption($valorOpcion);

                            # Dentro de un forech recorro y almaceno la opciones del 
                            foreach ($opciones as $key => $value) {
                                array_push($opciones, $value['option']);
                            }

                            # Creo sesión para almacenar las opciones 
                            $_SESSION['options'] = $opciones;

                            # Log in 
                            echo '<script>
                                window.location = "operations-index";
                            </script>';
                        } else {
                            echo "<script>
								Swal.fire({
									icon: 'error',
									showConfirmButton: true,
									text: 'There was a problem, please try again'
								});
							</script>";
                        }
                    } else {
                        echo "<script>
                            Swal.fire({
                                icon: 'error',
                                showConfirmButton: true,
                                text: 'User is not active'
                            });
                        </script>";
                    }
                } else {
                    echo "<script>
                            Swal.fire({
                                icon: 'warning',
                                showConfirmButton: true,
                                text: 'Incorrect username or password'
                            });
                        </script>";
                }
                echo "<script>
                            if(window.history.replaceState){
                                window.history.replaceState(null, null, window.location.href);
                            }
                        
                        </script>";
            } else {
                echo "<script>
                            Swal.fire({
                                icon: 'warning',
                                showConfirmButton: true,
                                text: 'Please enter the username and password correctly'
                            });
                        </script>";
            }
        }
    }

    /* ===================================================
        SHOW SYSTEM USERS
    ===================================================*/
    static public function ctrShowUsers($valor)
    {

        $respuesta = UsersModel::mdlShowUsers($valor);

        return $respuesta;
    }

    /* ===================================================
       PROFILES LIST
    ===================================================*/
    static public function ctrProfilesList()
    {
        $respuesta = UsersModel::mdlProfilesList();

        return $respuesta;
    }

    /* ===================================================
       NEW USER
    ===================================================*/
    static public function ctrNewUser()
    {
        if (isset($_POST['nuevaIdentificacion'])) {

            if (
                preg_match('/^[0-9]+$/', $_POST["nuevaIdentificacion"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $_POST["nuevoEmail"])

            ) {

                $encriptar = crypt($_POST['nuevaIdentificacion'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $datos = array(
                    "dni" => $_POST['nuevaIdentificacion'],
                    "name" => $_POST['nuevoNombre'],
                    "email" => $_POST['nuevoEmail'],
                    "status" => 1,
                    "phone" => $_POST['nuevoCelular'],
                    "password" => $encriptar
                );

                $respuesta = UsersModel::mdlRegisterUser($datos);

                if ($respuesta == 'ok') {

                    /* ===================== 
					  COSNSULTO EL ID DEL USUARIO PARA GENERAR EL INSERT DEL PERFIL 
					========================= */
                    $valor = $_POST['nuevoEmail'];
                    $usuarioID = UsersModel::mdlShowUsers($valor);
                    $idUsuario = $usuarioID['idUser'];
                    $nuevoPerfil = $_POST['nuevoPerfil'];

                    $datosUsuarioPerfil = array(
                        'idUser' => $idUsuario,
                        'idProfile' => $nuevoPerfil
                    );

                    $perfilUsuario = UsersModel::mdlRegisterUserProfile($datosUsuarioPerfil);

                    echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: '¡User created successfully!',					
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								
							}).then((result)=>{

								if(result.value){
									window.location = 'users';
								}

							})
						</script>
					";
                } else {
                    echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'There was a problem, please check your connection or maybe there is already a user with the same DNI or email',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
								
							})
						</script>
					";
                }
            } else {
                echo "
				<script>
					Swal.fire({
						icon: 'error',
						title: '¡The user cannot be empty or carry special characters!',						
						showConfirmButton: true,
						confirmButtonText: 'Cerrar',
						closeOnConfirm: false
						
					}).then((result)=>{

						if(result.value){
							window.location = 'users';
						}

					})
				</script>
				";
            }
        }
    }

    /* ===================================================
       EDIT USER
    ===================================================*/
    static public function ctrEditUser()
    {
        if (isset($_POST['editarIdentificacion'])) {

            if (
                preg_match('/^[0-9]+$/', $_POST["editarIdentificacion"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
                preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $_POST["editarEmail"])

            ) {


                $tabla = "L_Users";

                $datos = array(
                    "dni" => $_POST['editarIdentificacion'],
                    "name" => $_POST['editarNombre'],
                    "email" => $_POST['editarEmail'],
                    "phone" => $_POST['editarCelular']
                );

                # Actualizar tabla de usuarios
                $respuesta = UsersModel::mdlEditUser($tabla, $datos);

                # Asignar perfil
                if ($respuesta == 'ok') {

                    /* ===================== 
					  COSNSULTO EL ID DEL USUARIO PARA GENERAR EL INSERT DEL PERFIL 
					========================= */
                    $valor = $_POST['editarEmail'];
                    $usuarioID = UsersModel::mdlShowUsers($valor);
                    $idUsuario = $usuarioID['idUser'];
                    $editarPerfil = $_POST['editarPerfil'];

                    $tablaUsuarioPerfil = "L_User_Profile";
                    $item1 = "idProfile";
                    $valor1 =  $editarPerfil;

                    $item2 = "idUser";
                    $valor2 = $idUsuario;

                    $actualizarPerfilUsuario = UsersModel::mdlUpdateSingleField($tablaUsuarioPerfil, $item1, $valor1, $item2, $valor2);

                    echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: '¡User modified successfully!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								
							}).then((result)=>{

								if(result.value){
									window.location = 'users';
								}

							})
						</script>
					";
                } else {
                    echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'There was a problem, please check your connection or maybe there is already a user with the same DNI or email',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false								
							})
						</script>
					";
                }
            } else {
                echo "
				<script>
					Swal.fire({
						icon: 'error',
						title: '¡The user cannot be empty or carry special characters!',						
						showConfirmButton: true,
						confirmButtonText: 'Cerrar',
						closeOnConfirm: false
						
					}).then((result)=>{

						if(result.value){
							window.location = 'users';
						}

					})
				</script>
				";
            }
        }
    }

    /* ===================================================
	   RESTABLECER CONTRASEÑA
	===================================================*/
    static public function ctrRestablecerPswd($item, $value)
    {
        # Se encrita la cadena para luego actualizar el campo del usuario
        $encriptar = crypt($value, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

        $tabla = "L_Users";
        $item1 = "password";
        $valor1 = $encriptar;
        $item2 = $item;
        $valor2 = $value;
        # Actualizo la contraseña
        $actualizarPassword = UsersModel::mdlUpdateSingleField($tabla, $item1, $valor1, $item2, $valor2);

        # Actualizo el campo de cambiar contraseña a 1 para que pida cambiar la contraseña cuando inicie sesion
        $pedirCambiarPassword = UsersModel::mdlUpdateSingleField($tabla, "change_password", 1, $item2, $valor2);

        return $actualizarPassword;
    }

    /* ===================== 
	  CAMBIAR CONTRASEÑA 
	========================= */
    public function ctrCambioPassword()
    {

        if (isset($_POST['pass1'])) {


            if (
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["pass1"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["pass2"])
            ) {

                # Si las contraseñas son iguales
                if ($_POST['pass1'] === $_POST['pass2']) {
                    # Se encrita la cadena para luego actualizar el campo del usuario
                    $encriptar = crypt($_POST['pass1'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                    $tabla = "L_Users";
                    $item1 = "password";
                    $valor1 = $encriptar;
                    $item2 = "dni";
                    $valor2 = $_POST['cedulaUsuario'];
                    # Actualizo la contraseña
                    $actualizarPassword = UsersModel::mdlUpdateSingleField($tabla, $item1, $valor1, $item2, $valor2);

                    # Actualizo el campo de cambiar contraseña a 0 para que no pida volver a cambiarla
                    $cambiarPassword = UsersModel::mdlUpdateSingleField($tabla, "change_password", 0, $item2, $valor2);

                    if ($actualizarPassword == 'ok') {
                        echo "
							<script>
								Swal.fire({
									icon: 'success',
									title: 'Password successfully updated',						
									showConfirmButton: true,
									confirmButtonText: 'Cerrar',
									allowOutsideClick: false
									
								}).then((result)=>{

									if(result.value){
										window.location = './';
									}

								})
							</script>
						";
                    } else {
                        echo "
							<script>
								Swal.fire({
									icon: 'error',
									title: '¡There was a problem changing the password!',						
									showConfirmButton: true,
									confirmButtonText: 'Cerrar',
									closeOnConfirm: false,
									allowOutsideClick: false
									
								}).then((result)=>{

									if(result.value){
										window.location = './';
									}

								})
							</script>
						";
                    }
                } else {
                    echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: '¡Passwords do not match!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false,
								allowOutsideClick: false
								
							}).then((result)=>{

								if(result.value){
									window.location = './';
								}

							})
						</script>
						";
                }
            }
        }
    }
}

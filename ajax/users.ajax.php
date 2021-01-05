<?php 

# REQUERIMOS EL CONTROLADOR Y EL MODELO PARA QUE REALICE LA PETICION
require_once '../controllers/users.controller.php';
require_once '../models/users.model.php';

require_once '../controllers/mail.controller.php';

class UsersAjax
{
    /* =====================
      EDITAR USUARIO
    ======================= */
    static public function ajaxEditarUsuario($item, $value)
    {

        $respuesta = UsersController::ctrShowUsers($item, $value);

        echo json_encode($respuesta);
    }

    /* ===================================================
        RESTABLECER CONTRASEÑA
    ===================================================*/
    static public function ajaxRestablecerPswd($value)
    {
        $item = "dni";
        $respuesta = UsersController::ctrRestablecerPswd($item, $value);
        echo $respuesta;
    }

    /* ===================== 
      ACTIVAR USUARIO 
    ========================= */
    static public function ajaxActivarUsuario($iduser, $activarUsuario)
    {

        $tabla = "L_Users";

        $item1 = "status"; //columna de la base de datos
        $valor1 = $activarUsuario;

        $item2 = "idUser";
        $valor2 = $iduser;

        # SOLICITAMOS DIRECTAMENTE AL MODELO 
        $respuesta = UsersModel::mdlUpdateSingleField($tabla, $item1, $valor1, $item2, $valor2);

        echo $respuesta;
    }
}

if (isset($_POST['editarUsuario']) && $_POST['editarUsuario'] == "ok") {
    UsersAjax::ajaxEditarUsuario($_POST['item'], $_POST['value']);
}

/* ===================================================
   RESTABLECER CONTRASEÑA
===================================================*/
if (isset($_POST['RestablecerPswd']) && $_POST['RestablecerPswd'] == "ok"){
    UsersAjax::ajaxRestablecerPswd($_POST['idUsuario']);
}

if (isset($_POST['activarUsuario'])) {
    UsersAjax::ajaxActivarUsuario($_POST['iduser'], $_POST['activarUsuario']);
}
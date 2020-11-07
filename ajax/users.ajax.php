<?php 

# REQUERIMOS EL CONTROLADOR Y EL MODELO PARA QUE REALICE LA PETICION
require_once '../controllers/users.controller.php';
require_once '../models/users.model.php';

class UsersAjax
{
    /* =====================
      EDITAR USUARIO
    ======================= */
    static public function ajaxEditarUsuario($value)
    {

        $respuesta = UsersController::ctrShowUsers($value);

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
}

if (isset($_POST['editarUsuario']) && $_POST['editarUsuario'] == "ok") {
    UsersAjax::ajaxEditarUsuario($_POST['email']);
}

/* ===================================================
   RESTABLECER CONTRASEÑA
===================================================*/
if (isset($_POST['RestablecerPswd']) && $_POST['RestablecerPswd'] == "ok"){
    UsersAjax::ajaxRestablecerPswd($_POST['idUsuario']);
}
<?php

if (file_exists('./config/conexion.php')) {
    require_once './config/conexion.php';
} else {
    require_once '../config/conexion.php';
}

class UsersModel
{
    /* ===================================================
       SHOW USERS
    ===================================================*/
    static public function mdlShowUsers($value)
    {
        if ($value != null) {

            $stmt = Conexion::conectar()->prepare("SELECT *
                                                    FROM L_Users
                                                    WHERE email = :email");

            $stmt->bindParam(":email", $value, PDO::PARAM_STR);

            $stmt->execute();

            $retorno = $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT u.*, p.profile
                                                    FROM L_Users u 
                                                    INNER JOIN L_User_Profile up ON u.idUser = up.idUser
                                                    INNER JOIN L_Profiles p ON up.idProfile = p.idProfile
                                                    ORDER BY p.profile DESC");

            $stmt->execute();

            $retorno = $stmt->fetchAll();
        }


        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       UPDATE SINGLE USER FIELD
    ===================================================*/
    static public function mdlUpdateSingleField($tabla, $item1, $valor1, $item2, $valor2)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $retorno = "ok";
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;
        
        return $retorno;
    }

    /* ===================== 
      SHOW USER PROFILE AND OPTIONS
    ========================= */
    static public function mdlShowProfileOption($value)
    {

        $stmt = Conexion::conectar()->prepare("SELECT u.idUser, u.dni, u.name, u.email, p.profile, o.`option`
        FROM L_Users u 
        INNER JOIN L_User_Profile up ON u.idUser = up.idUser
        INNER JOIN L_Profiles p ON up.idProfile = p.idProfile
        INNER JOIN L_Profile_Option po ON p.idProfile = po.idProfile
        INNER JOIN L_Options o ON po.idOption = o.idOption
        WHERE u.idUser = :idUser");

        $stmt->bindParam(":idUser", $value, PDO::PARAM_INT);

        $stmt->execute();

        $retorno = $stmt->fetchAll();

        $stmt->closeCursor();
        $stmt = null;
        
        return $retorno;
    }

    /* ===================================================
        PROFILES LIST
    ===================================================*/
    static public function mdlProfilesList()
    {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM L_Profiles");

        $stmt->execute();

        $retorno = $stmt->fetchAll();

        $stmt->closeCursor();
        $stmt = null;
        
        return $retorno;
    }

    /* ===================================================
       NEW USER
    ===================================================*/
    static public function mdlRegisterUser($datos)
    {        
        $stmt = Conexion::conectar()->prepare("INSERT INTO L_Users(dni,name,email, `status`,phone, password, creation_date) 
                                                VALUES(:dni, :name, :email, :status, :phone, :password, CURDATE())");

        $stmt->bindParam(":dni", $datos["dni"], PDO::PARAM_INT);
        $stmt->bindParam(":name", $datos["name"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":status", $datos["status"], PDO::PARAM_INT);
        $stmt->bindParam(":phone", $datos["phone"], PDO::PARAM_INT);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);


        if ($stmt->execute()) {
            $retorno = "ok";
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;
        
        return $retorno;
    
    }

    /* ===================================================
       REGISTER USER PROFILE
    ===================================================*/
    static public function mdlRegisterUserProfile($datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO L_User_Profile (idUser, idProfile)
        VALUES (:idUser, :idProfile)");

        $stmt->bindParam(":idUser", $datos['idUser'], PDO::PARAM_INT);
        $stmt->bindParam(":idProfile", $datos['idProfile'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $retorno = "ok";
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;
        
        return $retorno;
    }

    /* ===================================================
       EDIT USER
    ===================================================*/
    static public function mdlEditUser($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE L_Users SET dni = :dni, name = :name, email = :email, phone = :phone WHERE dni = :dni");

        $stmt->bindParam(":dni", $datos["dni"], PDO::PARAM_INT);
        $stmt->bindParam(":name", $datos["name"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":phone", $datos["phone"], PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $retorno = "ok";
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;
        
        return $retorno;
    }
}

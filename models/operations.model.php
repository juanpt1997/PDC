<?php

if (file_exists('./config/conexion.php')){
    require_once './config/conexion.php';
}else{
    require_once '../config/conexion.php';
}

class CompaniesModel
{
    /* ===================================================
       SHOW ALL COMPANIES
    ===================================================*/
    static public function mdlShowCompanies()
    {
        $stmt = Conexion::conectar()->prepare("SELECT *
                                                FROM Companies");

        $stmt->execute();

        $retorno = $stmt->fetchAll();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       NEW COMPANY
    ===================================================*/
    static public function mdlNewCompany($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("INSERT INTO Companies 
 (Country, Name, ID, Address_Line1, Address_Line2, City, State_Province_Region, Zip_Code, Contact_Name, Phone_Number, Email, Comments) VALUES 
 (:Country, :Name, :ID, :Address_Line1, :Address_Line2, :City, :State_Province_Region, :Zip_Code, :Contact_Name, :Phone_Number, :Email, :Comments)");
        
        $stmt->bindParam(":Country", $datos['country'], PDO::PARAM_STR);
        $stmt->bindParam(":Name", $datos['company'], PDO::PARAM_STR);
        $stmt->bindParam(":ID", $datos['ID'], PDO::PARAM_STR);
        $stmt->bindParam(":Address_Line1", $datos['addrLine1'], PDO::PARAM_STR);
        $stmt->bindParam(":Address_Line2", $datos['addrLine2'], PDO::PARAM_STR);
        $stmt->bindParam(":City", $datos['city'], PDO::PARAM_STR);
        $stmt->bindParam(":State_Province_Region", $datos['state'], PDO::PARAM_STR);
        $stmt->bindParam(":Zip_Code", $datos['zipcode'], PDO::PARAM_STR);
        $stmt->bindParam(":Contact_Name", $datos['contact'], PDO::PARAM_STR);
        $stmt->bindParam(":Phone_Number", $datos['phone'], PDO::PARAM_STR);
        $stmt->bindParam(":Email", $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(":Comments", $datos['comments'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $id = $conexion->lastInsertId();
        } else {
            $id = "error";
        }
        $stmt->closeCursor();
        $conexion = null;
        return $id;
    }

    /* ===================================================
       SHOW ALL COMPANIES
    ===================================================*/
    static public function mdlCompanyInfo($value)
    {
        $stmt = Conexion::conectar()->prepare("SELECT *
                                                FROM Companies
                                                WHERE id_companies = :idcompany");
        $stmt->bindParam(":idcompany", $value, PDO::PARAM_INT);

        $stmt->execute();

        $retorno = $stmt->fetch();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }
}

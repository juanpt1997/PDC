<?php

if (file_exists('./config/conexion.php')) {
    require_once './config/conexion.php';
} else {
    require_once '../config/conexion.php';
}

/* ===================================================
   COMPANIES
===================================================*/
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
       SINGLE COMPANY INFORMATION
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

    /* ===================================================
       EDIT COMPANY INFO
    ===================================================*/
    static public function mdlUpdateCompany($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE Companies SET
                                    Country = :Country, Name = :Name, ID = :ID, Address_Line1 = :Address_Line1, Address_Line2 = :Address_Line2, City = :City, State_Province_Region = :State_Province_Region, Zip_Code = :Zip_Code, Contact_Name = :Contact_Name, Phone_Number = :Phone_Number, Email = :Email, Comments = :Comments
                                    WHERE id_companies = :id_companies");

        $stmt->bindParam(":id_companies", $datos['idcompany'], PDO::PARAM_INT);
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
}

/* ===================================================
   PRODUCTS
===================================================*/
class ProductsModel
{
    /* ===================================================
       SHOW ALL PRODUCTS
    ===================================================*/
    static public function mdlShowProducts()
    {
        $stmt = Conexion::conectar()->prepare("SELECT *
                                                FROM Products");

        $stmt->execute();

        $retorno = $stmt->fetchAll();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       NEW PRODUCT
    ===================================================*/
    static public function mdlNewProduct($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("INSERT INTO Products 
                                    (Name, Reference, Description, Weight, Unit, Price) VALUES 
                                    (:Name, :Reference, :Description, :Weight, :Unit, :Price)");

        $stmt->bindParam(":Name", $datos['Name'], PDO::PARAM_STR);
        $stmt->bindParam(":Reference", $datos['Reference'], PDO::PARAM_STR);
        $stmt->bindParam(":Description", $datos['Description'], PDO::PARAM_STR);
        $stmt->bindParam(":Weight", $datos['Weight'], PDO::PARAM_STR);
        $stmt->bindParam(":Unit", $datos['Unit'], PDO::PARAM_STR);
        $stmt->bindParam(":Price", $datos['Price'], PDO::PARAM_STR);

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
       UPDATE PRODUCT IMAGE ROUTE
    ===================================================*/
    static public function mdlUpdateProductImage($idproduct, $rutaImg)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE Products SET Image = :Image
                                        WHERE id_products = :id_products");

        $stmt->bindParam(":id_products", $idproduct, PDO::PARAM_INT);
        $stmt->bindParam(":Image", $rutaImg, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $retorno = "ok";
        } else {
            $retorno = "error";
        }
        $stmt->closeCursor();
        $conexion = null;
        return $retorno;
    }

    /* ===================================================
       SINGLE PRODUCT INFORMATION
    ===================================================*/
    static public function mdlProductInfo($value)
    {
        $stmt = Conexion::conectar()->prepare("SELECT *
                                                FROM Products
                                                WHERE id_products = :idproduct");
        $stmt->bindParam(":idproduct", $value, PDO::PARAM_INT);

        $stmt->execute();

        $retorno = $stmt->fetch();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       EDIT PRODUCT INFO
    ===================================================*/
    /* ===================================================
       NEW PRODUCT
    ===================================================*/
    static public function mdlUpdateProduct($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE Products SET
                                    Name = :Name, Reference = :Reference, Description = :Description, Weight = :Weight, Unit = :Unit, Price = :Price
                                    WHERE id_products = :idproduct");

        $stmt->bindParam(":idproduct", $datos['idproduct'], PDO::PARAM_INT);
        $stmt->bindParam(":Name", $datos['Name'], PDO::PARAM_STR);
        $stmt->bindParam(":Reference", $datos['Reference'], PDO::PARAM_STR);
        $stmt->bindParam(":Description", $datos['Description'], PDO::PARAM_STR);
        $stmt->bindParam(":Weight", $datos['Weight'], PDO::PARAM_STR);
        $stmt->bindParam(":Unit", $datos['Unit'], PDO::PARAM_STR);
        $stmt->bindParam(":Price", $datos['Price'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $id = $conexion->lastInsertId();
        } else {
            $id = "error";
        }
        $stmt->closeCursor();
        $conexion = null;
        return $id;
    }
}
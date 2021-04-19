<?php

if (file_exists('./config/conexion.php')) {
    require_once './config/conexion.php';
} else {
    require_once '../config/conexion.php';
}

/* ===================================================
   * COMPANIES
===================================================*/
class CompaniesModel
{
    /* ===================================================
       SHOW ALL COMPANIES
    ===================================================*/
    static public function mdlShowCompanies()
    {
        $stmt = Conexion::conectar()->prepare("SELECT *
                                                FROM Companies
                                                where Active = 1");

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
    static public function mdlCompanyInfo($item, $value)
    {
        $stmt = Conexion::conectar()->prepare("SELECT *
                                                FROM Companies
                                                WHERE $item = :$item");
        /* $stmt->bindParam(":idcompany", $value, PDO::PARAM_INT); */
        $stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);

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

    /* ===================================================
       ALLOWED PRODUCTS
    ===================================================*/
    static public function mdlAllowedProducts($value)
    {
        $stmt = Conexion::conectar()->prepare("SELECT p.*, c.Name AS Company
                                                FROM Companies c
                                                INNER JOIN re_Companies_Products cp ON c.id_companies = cp.id_companies
                                                INNER JOIN Products p ON p.id_products = cp.id_products
                                                WHERE c.id_companies = :id_companies AND p.Active = 1");
        $stmt->bindParam(":id_companies", $value, PDO::PARAM_INT);

        $stmt->execute();

        $retorno = $stmt->fetchAll();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       ELIMINAR REGISTROS DE LA TABLA ALLOWED PRODUCTS
    ===================================================*/
    static public function mdlEliminarRegistros($tabla, $value)
    {
        $stmt = Conexion::conectar()->prepare("DELETE
                                                FROM $tabla
                                                WHERE id_companies = :id_companies");
        $stmt->bindParam(":id_companies", $value, PDO::PARAM_INT);

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
           UPDATE ALLOWED PRODUCTS OF A COMPANY
        ===================================================*/
    static public function mdlUpdateAllowedProducts($datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO re_Companies_Products (id_companies, id_products)
                                                        VALUES (:id_companies, :id_products)");

        $stmt->bindParam(":id_companies", $datos['id_companies'], PDO::PARAM_INT);
        $stmt->bindParam(":id_products", $datos['id_products'], PDO::PARAM_INT);

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
       MODIFICAR SOLO UN CAMPO DE COMPANY (INICIALMENTE PARA DESHABILITARLO)
    ===================================================*/
    static public function mdlModificarCampo($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE Companies SET
                                    {$datos['item']} = :{$datos['item']}
                                    WHERE id_companies = :id_companies");
        $stmt->bindParam(":id_companies", $datos['id_companies'], PDO::PARAM_INT);
        $stmt->bindParam(":" . $datos['item'], $datos['value'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $retorno = "ok";
        } else {
            $retorno = "error";
        }
        $stmt->closeCursor();
        $conexion = null;
        return $retorno;
    }
}

/* ===================================================
    * PRODUCTS
===================================================*/
class ProductsModel
{
    /* ===================================================
       SHOW ALL PRODUCTS
    ===================================================*/
    static public function mdlShowProducts()
    {
        $stmt = Conexion::conectar()->prepare("SELECT *
                                                FROM Products
                                                where Active = 1");

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
                                    (Name, Reference, UpcCode, Description, Weight, Unit, Price) VALUES 
                                    (:Name, :Reference, :UpcCode, :Description, :Weight, :Unit, :Price)");

        $stmt->bindParam(":Name", $datos['Name'], PDO::PARAM_STR);
        $stmt->bindParam(":Reference", $datos['Reference'], PDO::PARAM_STR);
        $stmt->bindParam(":UpcCode", $datos['UpcCode'], PDO::PARAM_STR);
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
                                    Name = :Name, Reference = :Reference, UpcCode = :UpcCode, Description = :Description, Weight = :Weight, Unit = :Unit, Price = :Price
                                    WHERE id_products = :idproduct");

        $stmt->bindParam(":idproduct", $datos['idproduct'], PDO::PARAM_INT);
        $stmt->bindParam(":Name", $datos['Name'], PDO::PARAM_STR);
        $stmt->bindParam(":Reference", $datos['Reference'], PDO::PARAM_STR);
        $stmt->bindParam(":UpcCode", $datos['UpcCode'], PDO::PARAM_STR);
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
       MODIFICAR SOLO UN CAMPO DE PRODUCT (INICIALMENTE PARA DESHABILITARLO)
    ===================================================*/
    static public function mdlModificarCampo($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE Products SET
                                    {$datos['item']} = :{$datos['item']}
                                    WHERE id_products = :id_products");
        $stmt->bindParam(":id_products", $datos['id_products'], PDO::PARAM_INT);
        $stmt->bindParam(":" . $datos['item'], $datos['value'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $retorno = "ok";
        } else {
            $retorno = "error";
        }
        $stmt->closeCursor();
        $conexion = null;
        return $retorno;
    }
}

/* ===================================================
   * ORDERS
===================================================*/
class OrdersModel
{
    /* ===================================================
       SHOW ALL ORDERS
    ===================================================*/
    static public function mdlShowOrders($value, $status, $fechas)
    {
        switch ($status) {
                # Mostrar solo las ordenes con el estado Shipped
            case 'Shipped':
                # Ordenes de companies
                $stmt = Conexion::conectar()->prepare("SELECT p.Name AS Product, c.Name AS Company, o.*, DATE_FORMAT(o.Pickup_Date, '%m-%d-%Y') as Pickup_DateF, DATE_FORMAT(o.Delivery_Date, '%m-%d-%Y') as Delivery_DateF, DATE_FORMAT(o.Delivery_Real_Date, '%m-%d-%Y') as Delivery_Real_DateF
                                                        FROM Orders o
                                                        INNER JOIN Companies c ON c.id_companies = o.id_companies
                                                        INNER JOIN Products p ON p.id_products = o.id_products
                                                        WHERE o.id_companies = $value AND o.Status = '$status' AND o.active = 1");
                break;

                # Mostrar todas las ordenes con cualquier estado
            default:
                # Ordenes de operations
                if ($value == null && $fechas != null) {

                    $stmt = Conexion::conectar()->prepare("SELECT p.Name AS Product, c.Name AS Company, o.*, DATE_FORMAT(o.creation, '%m-%d-%Y') as creationF, DATE_FORMAT(o.Pickup_Date, '%m-%d-%Y') as Pickup_DateF, DATE_FORMAT(o.Delivery_Date, '%m-%d-%Y') as Delivery_DateF, DATE_FORMAT(o.Delivery_Real_Date, '%m-%d-%Y') as Delivery_Real_DateF
                                                        FROM Orders o
                                                        INNER JOIN Companies c ON c.id_companies = o.id_companies
                                                        INNER JOIN Products p ON p.id_products = o.id_products
                                                        WHERE DATE(o.Pickup_Date) BETWEEN '{$fechas['fecha1']}' AND '{$fechas['fecha2']}' AND o.active = 1");
                    //WHERE DATE(o.Pickup_Date) BETWEEN '2020-12-01' AND '2020-12-31'");
                    // $stmt = Conexion::conectar()->prepare("SELECT p.Name AS Product, c.Name AS Company, o.*, DATE_FORMAT(o.Pickup_Date, '%m-%d-%Y') as Pickup_DateF, DATE_FORMAT(o.Delivery_Date, '%m-%d-%Y') as Delivery_DateF, DATE_FORMAT(o.Delivery_Real_Date, '%m-%d-%Y') as Delivery_Real_DateF
                    //                                     FROM Orders o
                    //                                     INNER JOIN Companies c ON c.id_companies = o.id_companies
                    //                                     INNER JOIN Products p ON p.id_products = o.id_products");
                }
                # Ordenes de companies
                else {
                    if ($fechas != null) {
                        $stmt = Conexion::conectar()->prepare("SELECT p.Name AS Product, c.Name AS Company, o.*, DATE_FORMAT(o.Pickup_Date, '%m-%d-%Y') as Pickup_DateF, DATE_FORMAT(o.Delivery_Date, '%m-%d-%Y') as Delivery_DateF, DATE_FORMAT(o.Delivery_Real_Date, '%m-%d-%Y') as Delivery_Real_DateF
                                                            FROM Orders o
                                                            INNER JOIN Companies c ON c.id_companies = o.id_companies
                                                            INNER JOIN Products p ON p.id_products = o.id_products
                                                            WHERE o.id_companies = $value AND DATE(o.Pickup_Date) BETWEEN '{$fechas['fecha1']}' AND '{$fechas['fecha2']}' AND o.active = 1");
                        // $stmt = Conexion::conectar()->prepare("SELECT p.Name AS Product, c.Name AS Company, o.*, DATE_FORMAT(o.Pickup_Date, '%m-%d-%Y') as Pickup_DateF, DATE_FORMAT(o.Delivery_Date, '%m-%d-%Y') as Delivery_DateF, DATE_FORMAT(o.Delivery_Real_Date, '%m-%d-%Y') as Delivery_Real_DateF
                        //                                     FROM Orders o
                        //                                     INNER JOIN Companies c ON c.id_companies = o.id_companies
                        //                                     INNER JOIN Products p ON p.id_products = o.id_products
                        //                                     WHERE o.id_companies = $value");
                    }
                }
                break;
        }

        $stmt->execute();

        $retorno = $stmt->fetchAll();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       NEW ORDER
    ===================================================*/
    static public function mdlNewOrder($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("INSERT INTO Orders (id_companies, id_products, Weight_Each_Bag, Total_Bags, Total_Skids, Customer_PO, Arrange_Pickup, From_Release, Pickup_Date, PO_Reference, Delivery_Terms, Delivery_From_Name, Delivery_Address, Delivery_Address2, Delivery_Phone, Delivery_Contact, Delivery_City, Delivery_ZipCode, Delivery_Date, Delivery_Real_Date, Delivery_Destination_Name, Delivery_Destination_Address, Delivery_Destination_Address2, Delivery_Destination_Phone, Delivery_Destination_Contact, Delivery_Destination_City, Delivery_Destination_ZipCode, Delivery_Destination_Confirmed_Trucking_Charge, Delivery_Destination_Comments, audit_user) VALUES
                                        (:id_companies, :id_products, :Weight_Each_Bag, :Total_Bags, :Total_Skids, :Customer_PO, :Arrange_Pickup, :From_Release, :Pickup_Date, :PO_Reference, :Delivery_Terms, :Delivery_From_Name, :Delivery_Address, :Delivery_Address2, :Delivery_Phone, :Delivery_Contact, :Delivery_City, :Delivery_ZipCode, :Delivery_Date, :Delivery_Real_Date, :Delivery_Destination_Name, :Delivery_Destination_Address, :Delivery_Destination_Address2, :Delivery_Destination_Phone, :Delivery_Destination_Contact, :Delivery_Destination_City, :Delivery_Destination_ZipCode, :Delivery_Destination_Confirmed_Trucking_Charge, :Delivery_Destination_Comments, :audit_user)");

        $stmt->bindParam(":id_companies", $datos['id_companies'], PDO::PARAM_INT);
        $stmt->bindParam(":id_products", $datos['id_products'], PDO::PARAM_INT);
        $stmt->bindParam(":Weight_Each_Bag", $datos['Weight_Each_Bag'], PDO::PARAM_STR);
        $stmt->bindParam(":Total_Bags", $datos['Total_Bags'], PDO::PARAM_STR);
        $stmt->bindParam(":Total_Skids", $datos['Total_Skids'], PDO::PARAM_INT);
        $stmt->bindParam(":Customer_PO", $datos['Customer_PO'], PDO::PARAM_STR);
        $stmt->bindParam(":Arrange_Pickup", $datos['Arrange_Pickup'], PDO::PARAM_STR);
        $stmt->bindParam(":From_Release", $datos['From_Release'], PDO::PARAM_STR);
        $stmt->bindParam(":Pickup_Date", $datos['Pickup_Date'], PDO::PARAM_STR);
        $stmt->bindParam(":PO_Reference", $datos['PO_Reference'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Terms", $datos['Delivery_Terms'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_From_Name", $datos['Delivery_From_Name'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Address", $datos['Delivery_Address'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Address2", $datos['Delivery_Address2'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Phone", $datos['Delivery_Phone'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Contact", $datos['Delivery_Contact'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_City", $datos['Delivery_City'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_ZipCode", $datos['Delivery_ZipCode'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Date", $datos['Delivery_Date'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Real_Date", $datos['Delivery_Real_Date'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Name", $datos['Delivery_Destination_Name'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Address", $datos['Delivery_Destination_Address'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Address2", $datos['Delivery_Destination_Address2'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Phone", $datos['Delivery_Destination_Phone'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Contact", $datos['Delivery_Destination_Contact'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_City", $datos['Delivery_Destination_City'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_ZipCode", $datos['Delivery_Destination_ZipCode'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Confirmed_Trucking_Charge", $datos['Delivery_Destination_Confirmed_Trucking_Charge'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Comments", $datos['Delivery_Destination_Comments'], PDO::PARAM_STR);
        $stmt->bindParam(":audit_user", $datos['audit_user'], PDO::PARAM_INT);

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
       SINGLE ORDER INFORMATION
    ===================================================*/
    static public function mdlOrderInfo($value)
    {
        $stmt = Conexion::conectar()->prepare("SELECT p.Name AS Product, c.Name AS Company, c.Address_Line1 AS Company_Address1, c.Address_Line2 AS Company_Address2, c.Phone_Number AS Company_Phone, c.Contact_Name AS Company_Contact, o.*, u.name AS audituser, DATE_FORMAT(o.Delivery_Date, '%m-%d-%Y') as Delivery_DateF
                                                FROM Orders o
                                                INNER JOIN Companies c ON c.id_companies = o.id_companies
                                                INNER JOIN Products p ON p.id_products = o.id_products
                                                INNER JOIN L_Users u ON u.idUser = o.audit_user
                                                WHERE o.id_orders = :id_orders");
        $stmt->bindParam(":id_orders", $value, PDO::PARAM_INT);

        $stmt->execute();

        $retorno = $stmt->fetch();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       EDIT ORDER
    ===================================================*/
    static public function mdlEditOrder($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE Orders SET id_companies = :id_companies, id_products = :id_products
                                    , Weight_Each_Bag = :Weight_Each_Bag
                                    , Total_Bags = :Total_Bags
                                    , Total_Skids = :Total_Skids
                                    , Customer_PO = :Customer_PO
                                    , Arrange_Pickup = :Arrange_Pickup
                                    , From_Release = :From_Release
                                    , Pickup_Date = :Pickup_Date
                                    , PO_Reference = :PO_Reference
                                    , Delivery_Terms = :Delivery_Terms
                                    , Delivery_From_Name = :Delivery_From_Name
                                    , Delivery_Address = :Delivery_Address
                                    , Delivery_Address2 = :Delivery_Address2
                                    , Delivery_Phone = :Delivery_Phone
                                    , Delivery_Contact = :Delivery_Contact
                                    , Delivery_City = :Delivery_City
                                    , Delivery_ZipCode = :Delivery_ZipCode
                                    , Delivery_Date = :Delivery_Date
                                    , Delivery_Real_Date = :Delivery_Real_Date
                                    , Delivery_Destination_Name = :Delivery_Destination_Name
                                    , Delivery_Destination_Address = :Delivery_Destination_Address
                                    , Delivery_Destination_Address2 = :Delivery_Destination_Address2
                                    , Delivery_Destination_Phone = :Delivery_Destination_Phone
                                    , Delivery_Destination_Contact = :Delivery_Destination_Contact
                                    , Delivery_Destination_City = :Delivery_Destination_City
                                    , Delivery_Destination_ZipCode = :Delivery_Destination_ZipCode
                                    , Delivery_Destination_Confirmed_Trucking_Charge = :Delivery_Destination_Confirmed_Trucking_Charge
                                    , Delivery_Destination_Comments = :Delivery_Destination_Comments
                                    WHERE id_orders = :id_orders");

        $stmt->bindParam(":id_orders", $datos['id_orders'], PDO::PARAM_INT);
        $stmt->bindParam(":id_companies", $datos['id_companies'], PDO::PARAM_INT);
        $stmt->bindParam(":id_products", $datos['id_products'], PDO::PARAM_INT);
        $stmt->bindParam(":Weight_Each_Bag", $datos['Weight_Each_Bag'], PDO::PARAM_STR);
        $stmt->bindParam(":Total_Bags", $datos['Total_Bags'], PDO::PARAM_STR);
        $stmt->bindParam(":Total_Skids", $datos['Total_Skids'], PDO::PARAM_INT);
        $stmt->bindParam(":Customer_PO", $datos['Customer_PO'], PDO::PARAM_STR);
        $stmt->bindParam(":Arrange_Pickup", $datos['Arrange_Pickup'], PDO::PARAM_STR);
        $stmt->bindParam(":From_Release", $datos['From_Release'], PDO::PARAM_STR);
        $stmt->bindParam(":Pickup_Date", $datos['Pickup_Date'], PDO::PARAM_STR);
        $stmt->bindParam(":PO_Reference", $datos['PO_Reference'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Terms", $datos['Delivery_Terms'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_From_Name", $datos['Delivery_From_Name'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Address", $datos['Delivery_Address'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Address2", $datos['Delivery_Address2'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Phone", $datos['Delivery_Phone'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Contact", $datos['Delivery_Contact'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_City", $datos['Delivery_City'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_ZipCode", $datos['Delivery_ZipCode'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Date", $datos['Delivery_Date'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Real_Date", $datos['Delivery_Real_Date'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Name", $datos['Delivery_Destination_Name'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Address", $datos['Delivery_Destination_Address'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Address2", $datos['Delivery_Destination_Address2'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Phone", $datos['Delivery_Destination_Phone'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Contact", $datos['Delivery_Destination_Contact'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_City", $datos['Delivery_Destination_City'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_ZipCode", $datos['Delivery_Destination_ZipCode'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Confirmed_Trucking_Charge", $datos['Delivery_Destination_Confirmed_Trucking_Charge'], PDO::PARAM_STR);
        $stmt->bindParam(":Delivery_Destination_Comments", $datos['Delivery_Destination_Comments'], PDO::PARAM_STR);

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
       MODIFICAR SOLO UN CAMPO DE LA ORDEN
    ===================================================*/
    static public function mdlModificarCampo($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE Orders SET
                                    {$datos['item']} = :{$datos['item']}
                                    WHERE id_orders = :id_orders");
        $stmt->bindParam(":id_orders", $datos['id_orders'], PDO::PARAM_INT);
        $stmt->bindParam(":" . $datos['item'], $datos['value'], PDO::PARAM_STR);

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
       DATOS DE UN DOCUMENTO DE UNA ORDEN
    ===================================================*/
    static public function mdlDocumentoOrder($idorder)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * from Orders
                                    WHERE id_orders = :id_orders");
        $stmt->bindParam(":id_orders", $idorder, PDO::PARAM_INT);

        $stmt->execute();

        $retorno = $stmt->fetch();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       INSERT STATUS HISTORY
    ===================================================*/
    static public function mdlInsertStatusHistory($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("INSERT INTO Orders_Status_History (id_orders, Status, Date) VALUES
                                    (:id_orders, :Status, NOW())");

        $stmt->bindParam(":id_orders", $datos['id_orders'], PDO::PARAM_INT);
        $stmt->bindParam(":Status", $datos['Status'], PDO::PARAM_STR);

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
   CONTROLADOR DE BOL (BILL OF LADING)
===================================================*/
class BOLModel
{
    /* ===================================================
        Validar que BOL REFERENCE si exista
    ===================================================*/
    static public function mdlValidarBOL($bol)
    {
        $stmt = Conexion::conectar()->prepare("SELECT o.*, p.Description AS productDescription
                                                FROM Orders o
                                                INNER JOIN Products p ON p.id_products = o.id_products
                                                WHERE o.PO_Reference = :PO_Reference");
        $stmt->bindParam(":PO_Reference", $bol, PDO::PARAM_STR);

        $stmt->execute();

        $retorno = $stmt->fetch();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       TABLA CON LOS BOL
    ===================================================*/
    static public function mdlTablaBOL($bolreference)
    {
            $stmt = Conexion::conectar()->prepare("SELECT b.id_bol, o.PO_Reference, o.Customer_PO, b.Lot, b.RefC, f.Name AS Cfrom, t.Name AS Cto, b.Shippingdate, b.Carrier, b.Pallets, b.Bags, p.Description, b.Weight
                                                    FROM Orders o
                                                    INNER JOIN BOL b ON b.PO_Reference = o.PO_Reference
                                                    INNER JOIN Companies f ON f.id_companies = b.`From`
                                                    INNER JOIN Companies t ON t.id_companies = b.`To`
                                                    INNER JOIN Products p ON p.id_products = o.id_products
                                                    WHERE b.PO_Reference = :bolreference");
        $stmt->bindParam(":bolreference", $bolreference, PDO::PARAM_STR);
        $stmt->execute();

        $retorno = $stmt->fetchAll();

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       AGREGAR BOL
    ===================================================*/
    static public function mdlAgregarBOL($datos)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("INSERT INTO BOL 
                                    (PO_Reference, Lot, RefC, `FROM`, `TO`, Shippingdate, Carrier, Pallets, Bags, Weight) VALUES 
                                    (:bolReference, :lot, :refC, :fromId, :toId, :shippingDate, :carrier, :pallets, :bags, :weight)");

        $stmt->bindParam(":bolReference", $datos['bolReference'], PDO::PARAM_STR);
        $stmt->bindParam(":lot", $datos['lot'], PDO::PARAM_STR);
        $stmt->bindParam(":refC", $datos['refC'], PDO::PARAM_STR);
        $stmt->bindParam(":fromId", $datos['fromId'], PDO::PARAM_INT);
        $stmt->bindParam(":toId", $datos['toId'], PDO::PARAM_INT);
        $stmt->bindParam(":shippingDate", $datos['shippingDate'], PDO::PARAM_STR);
        $stmt->bindParam(":carrier", $datos['carrier'], PDO::PARAM_STR);
        $stmt->bindParam(":pallets", $datos['pallets'], PDO::PARAM_INT);
        $stmt->bindParam(":bags", $datos['bags'], PDO::PARAM_INT);
        $stmt->bindParam(":weight", $datos['weight'], PDO::PARAM_INT);

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
       DELETE BOL
    ===================================================*/
    static public function mdlDeleteBOL($id_bol)
    {
        $stmt = Conexion::conectar()->prepare("DELETE
                                                FROM BOL
                                                WHERE id_bol = :id_bol");
        $stmt->bindParam(":id_bol", $id_bol, PDO::PARAM_INT);

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

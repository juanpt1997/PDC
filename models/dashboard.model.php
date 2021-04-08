<?php

if (file_exists('./config/conexion.php')) {
    require_once './config/conexion.php';
} else {
    require_once '../config/conexion.php';
}

/* ===================================================
   MODELO DEL DASHBOARD
===================================================*/
class DashboardModel
{
    /* ===================================================
        NEW ORDERS TODAY
    ===================================================*/
    static public function mdlOrdersToday()
    {
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(id_orders) AS ordenes
                                                FROM Orders
                                                WHERE DATE_FORMAT(audit, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')");

        if ($stmt->execute()) {
            $responseDB = $stmt->fetch();
            $retorno = $responseDB['ordenes'];
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       ORDERS IN PROCESS
    ===================================================*/
    static public function mdlOrdersInProcess()
    {
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(id_orders) AS ordenes
                                                FROM Orders
                                                WHERE `Status` = 'In Process'");

        if ($stmt->execute()) {
            $responseDB = $stmt->fetch();
            $retorno = $responseDB['ordenes'];
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       ORDERS DELIVERED THIS WEEK
    ===================================================*/
    static public function mdlOrdersDeliveredThisWeek()
    {
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(id_orders) AS ordenes
                                                FROM Orders
                                                WHERE DATE_FORMAT(Delivery_Real_Date, '%Y-%v') = DATE_FORMAT(NOW(), '%Y-%v') AND Delivery_Real_Date <= NOW()");

        if ($stmt->execute()) {
            $responseDB = $stmt->fetch();
            $retorno = $responseDB['ordenes'];
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       PALLETS DELIVERED THIS MONTH
    ===================================================*/

    /* ===================================================
       ORDERS DELIVERED THIS MONTH
    ===================================================*/
    static public function mdlChartOrdersDeliveredThisMonth()
    {
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(id_orders) AS ordenesEntregadasMes, (SELECT COUNT(id_orders) FROM Orders WHERE DATE_FORMAT(Delivery_Real_Date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')) AS totalOrdenesMes
                                                FROM Orders
                                                WHERE DATE_FORMAT(Delivery_Real_Date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') AND Delivery_Real_Date <= NOW()");

        if ($stmt->execute()) {
            $retorno = $stmt->fetch();
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
       ORDERS SHIPPED
    ===================================================*/
    static public function mdlOrderShipped()
    {
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(id_orders) AS ordenes
                                                FROM Orders
                                                WHERE `Status` = 'Shipped'");

        if ($stmt->execute()) {
            $responseDB = $stmt->fetch();
            $retorno = $responseDB['ordenes'];
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }

    /* ===================================================
        TOTAL ORDERS DELIVERED BY MONTH
    ===================================================*/
    static public function mdlOrdersDeliverxMonth()
    {
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(DISTINCT(id_orders)) AS Cantidad, MONTHNAME(Delivery_Real_Date) AS mes, YEAR(Delivery_Real_Date) AS year
                                                FROM
                                                Orders o
                                                WHERE YEAR(Delivery_Real_Date) = YEAR(NOW()) AND Delivery_Real_Date <= NOW()
                                                GROUP BY YEAR(Delivery_Real_Date), MONTH(Delivery_Real_Date) ASC;");

        if ($stmt->execute()) {
            $retorno = $stmt->fetchAll();
        } else {
            $retorno = "error";
        }

        $stmt->closeCursor();
        $stmt = null;

        return $retorno;
    }
}

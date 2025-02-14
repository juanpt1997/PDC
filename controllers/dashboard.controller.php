<?php

/* ===================================================
   CONTROLADOR DEL DASHBOARD
===================================================*/
class DashboardController
{
    /* ===================================================
       NEW ORDERS TODAY
    ===================================================*/
    static public function ctrOrdersToday()
    {
        $respuesta = DashboardModel::mdlOrdersToday();
        return $respuesta;
    }

    /* ===================================================
       ORDERS IN PROCESS
    ===================================================*/
    static public function ctrOrdersInProcess()
    {
        $respuesta = DashboardModel::mdlOrdersInProcess();
        return $respuesta;
    }

    /* ===================================================
       ORDERS DELIVERED THIS WEEK
    ===================================================*/
    static public function ctrOrdersDeliveredThisWeek()
    {
        $respuesta = DashboardModel::mdlOrdersDeliveredThisWeek();
        return $respuesta;
    }

    /* ===================================================
       PALLETS DELIVERED BY RANGE OF DATES
    ===================================================*/
    static public function ctrPalletsDelivered($fecha1, $fecha2)
    {
        $respuesta = DashboardModel::mdlPalletsDelivered($fecha1, $fecha2);
        return $respuesta;
    }

    /* ===================================================
       PALLETS NEEDED BY RANGE OF DATES
    ===================================================*/
    static public function ctrPalletsNeeded($fecha1, $fecha2)
    {
        $respuesta = DashboardModel::mdlPalletsNeeded($fecha1, $fecha2);
        return $respuesta;
    }

    /* ===================================================
       ORDERS DELIVERED THIS MONTH
    ===================================================*/
    static public function ctrChartOrdersDeliveredThisMonth()
    {
        $respuesta = DashboardModel::mdlChartOrdersDeliveredThisMonth();
        return $respuesta;
    }

    /* ===================================================
       ORDERS SHIPPED
    ===================================================*/
    static public function ctrOrderShipped()
    {
        $respuesta = DashboardModel::mdlOrderShipped();
        return $respuesta;
    }

    /* ===================================================
       TOTAL ORDERS DELIVERED BY MONTH
    ===================================================*/
    static public function ctrOrdersDeliverxMonth()
    {
        $respuesta = DashboardModel::mdlOrdersDeliverxMonth();
        return $respuesta;
    }
}

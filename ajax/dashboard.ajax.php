<?php 

# REQUERIMOS EL CONTROLADOR Y EL MODELO PARA QUE REALICE LA PETICION
require_once '../controllers/dashboard.controller.php';
require_once '../models/dashboard.model.php';

/* ===================================================
   AJAX PARA EL DASHBOARD
===================================================*/
class DashboardAjax
{
    /* ===================================================
       TOTAL ORDERS DELIVERED BY MONTH
    ===================================================*/
    static public function ajaxOrdersDeliverxMonth()
    {
        $response = DashboardController::ctrOrdersDeliverxMonth();
        echo json_encode($response);
    }
}

if (isset($_POST['OrdenesxMes']) && $_POST['OrdenesxMes'] == "ok"){
    DashboardAjax::ajaxOrdersDeliverxMonth();
}
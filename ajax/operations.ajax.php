<?php 

    # REQUERIMOS EL CONTROLADOR Y EL MODELO PARA QUE REALICE LA PETICION
    require_once '../controllers/operations.controller.php';
    require_once '../models/operations.model.php';

class CompaniesAjax
{
    /* ===================================================
       SINGLE COMPANY INFORMATION
    ===================================================*/
    static public function ajaxCompanyInfo($value)
    {
        $response = CompaniesController::ctrCompanyInfo($value);
        echo json_encode($response);
    }
}

if (isset($_POST['CompanyInfo']) && $_POST['CompanyInfo'] == "ok") {
    CompaniesAjax::ajaxCompanyInfo($_POST['idcompany']);
}
<?php

/* if (!isset($_SESSION['logged_in'])) {
    header("Location: {$_SERVER['SERVER_NAME']}");
}
 */
# REQUERIMOS EL CONTROLADOR Y EL MODELO PARA QUE REALICE LA PETICION
require_once '../controllers/operations.controller.php';
require_once '../models/operations.model.php';

/* ===================================================
   * AJAX COMPANIES
===================================================*/
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

    /* ===================================================
       ALLOWED PRODUCTS
    ===================================================*/
    static public function ajaxAllowedProducts($value)
    {
        $response = CompaniesController::ctrAllowedProducts($value);
        echo json_encode($response);
    }
}

if (isset($_POST['CompanyInfo']) && $_POST['CompanyInfo'] == "ok") {
    CompaniesAjax::ajaxCompanyInfo($_POST['idcompany']);
}

if (isset($_POST['AllowedProducts']) && $_POST['AllowedProducts'] == "ok") {
    CompaniesAjax::ajaxAllowedProducts($_POST['idcompany']);
}

/* ===================================================
   * AJAX PRODUCTS
===================================================*/
class ProductsAjax
{
    /* ===================================================
       SINGLE PRODUCT INFORMATION
    ===================================================*/
    static public function ajaxProductInfo($value)
    {
        $response = ProductsController::ctrProductInfo($value);
        echo json_encode($response);
    }

    /* ===================================================
       SHOW PRODUCTS
    ===================================================*/
    static public function ajaxShowProducts()
    {
        $response = ProductsController::ctrShowProducts();
        echo json_encode($response);
    }
}

if (isset($_POST['ProductInfo']) && $_POST['ProductInfo'] == "ok") {
    ProductsAjax::ajaxProductInfo($_POST['idproduct']);
}
if (isset($_POST['ShowProducts']) && $_POST['ShowProducts'] == "ok") {
    ProductsAjax::ajaxShowProducts();
}

/* ===================================================
   * AJAX ORDERS
===================================================*/
class OrdersAjax
{
    /* ===================================================
       SINGLE ORDER INFORMATION
    ===================================================*/
    static public function ajaxOrderInfo($value)
    {
        $response = OrdersController::ctrOrderInfo($value);
        echo json_encode($response);
    }

    /* ===================================================
       UPDATE DE UN SOLO CAMPO EN LA ORDEN
    ===================================================*/
    static public function ajaxModificarCampo($datos)
    {
        $response = OrdersController::ctrModificarCampo($datos);
        echo $response;
    }

    /* ===================================================
        VERIFICAR SI EL DOCUMENTO ESTA CORRECTAMENTE SUBIDO
    ===================================================*/
    static public function ajaxVerificarDocumento($datos)
    {
        $response = OrdersController::ctrVerificarDocumento($datos);
        echo json_encode($response);
        //echo $response;
    }

    /* ===================================================
       DOWNLOAD FILE (POD OR COA)
    ===================================================*/
    static public function ajaxDownloadFile($datos)
    {
        $response = OrdersController::ctrDownloadFile($datos);
        //echo $response;
        echo json_encode($response);
    }
}

if (isset($_POST['OrderInfo']) && $_POST['OrderInfo'] == "ok") {
    OrdersAjax::ajaxOrderInfo($_POST['idorder']);
}

if (isset($_POST['UpdateCampo']) && $_POST['UpdateCampo'] == "ok") {
    $datos = array(
        'id_orders' => $_POST['idorder'],
        'item' => $_POST['item'],
        'value' => $_POST['value']
    );
    OrdersAjax::ajaxModificarCampo($datos);
}

if (isset($_POST['ExisteDoc']) && $_POST['ExisteDoc'] == "ok") {
    $datos = array(
        'id_orders' => $_POST['idorder'],
        'tipodoc' => $_POST['tipodoc']
    );
    OrdersAjax::ajaxVerificarDocumento($datos);
}

if (isset($_POST['DownloadFile']) && $_POST['DownloadFile'] == "ok") {
    $datos = array(
        'id_orders' => $_POST['idorder'],
        'tipodoc' => $_POST['tipodoc']
    );
    OrdersAjax::ajaxDownloadFile($datos);
}

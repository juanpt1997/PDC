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
       TABLA ORDERS
    ===================================================*/
    static public function mostrarTablaOrders($fecha1, $fecha2)
    {

        /* ===================================================
               El controlador retorna lo que se consultó desde el modelo
            ===================================================*/
        $fechas = array(
            'fecha1' => $fecha1,
            'fecha2' => $fecha2
        );
        $Orders = OrdersController::ctrShowOrders(null, null, $fechas);
        /* ===================================================
               Retornar en un JSON los datos de la consulta para mostrar correctamente el datatable y como deberian ir
            ===================================================*/
        $datosJson = '
            {
                "data": [';
        // $datosJson .= '
        //         [
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba",
        //             "prueba"
        //         ]';

        if ($Orders != null) {
            foreach ($Orders as $key => $value) {
                $BtnOrder = "<button type='button' idorder='{$value['id_orders']}' class='btn btn-default orderInfo' data-toggle='modal' data-target='#modal-vieworder'>{$value['id_orders']}</button>";

                $BtnCOA = "<button type='button' class='btn btn-default btn-docs' idorder='{$value['id_orders']}' tipodoc='COA' data-toggle='modal' data-target='#modal-docs'><i class='far fa-file-pdf'></i></button>";

                $BtnPOD = "<button type='button' class='btn btn-default btn-docs' idorder='{$value['id_orders']}' tipodoc='POD' data-toggle='modal' data-target='#modal-docs'><i class='far fa-file-pdf'></i></button>";

                switch ($value['Status']) {
                    case 'On Process':
                        $Status = "<span idorder='{$value['id_orders']}' class='badge badge-primary btnCambiarEstado' style='cursor: pointer;'>On Process</span>";
                        break;

                    case 'Shipped':
                        $Status = "<span idorder='{$value['id_orders']}' class='badge badge-secondary btnCambiarEstado' style='cursor: pointer;'>Shipped</span>";
                        break;

                    case 'Sent':
                        $Status = "<span idorder='{$value['id_orders']}' class='badge badge-warning text-white btnCambiarEstado' style='cursor: pointer;'>Sent</span>";
                        break;

                    case 'Canceled':
                        $Status = "<span idorder='{$value['id_orders']}' class='badge badge-danger btnCambiarEstado' style='cursor: pointer;'>Canceled</span>";
                        break;

                    default:
                        $Status = $value['Status'];
                        break;
                }
                //$onclickEventDescargar = `onclick="javascript:window.open('pdf/po.php?order=${value['id_orders']}','','width=1280,height=720,left=50,top=50,toolbar=yes');`;
                $botonDescargarOrder = "<button class='btn btn-secondary ml-2 btn-descargarorder' type='button' idorder='{$value['id_orders']}'><i class='fas fa-save'></i></button>";
                $botonAcciones = "<div class='row d-flex flex-nowrap justify-content-center'>" . $botonDescargarOrder . "</div>";

                $datosJson .= '
                    [
                        "' . $BtnOrder . '",
                        "' . $value['Company'] . '",
                        "' . $value['Customer_PO'] . '",
                        "' . $value['PO_Reference'] . '",
                        "' . $value['Pickup_DateF'] . '",
                        "' . $value['Delivery_DateF'] . '",
                        "' . $value['Delivery_Real_DateF'] . '",
                        "' . $value['Product'] . '",
                        "' . $value['Total_Bags'] . '",
                        "' . $Status . '",
                        "' . $BtnCOA . '",
                        "' . $BtnPOD . '",
                        "' . $botonAcciones . '"
                    ],';
            }
            #Eliminamos la ultima coma para no tener problema en el json    
            $datosJson = substr($datosJson, 0, -1);
        }

        $datosJson .= ']}';

        echo $datosJson;
        //echo json_encode($Orders);
    }

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

if (isset($_REQUEST['TablaOrders']) && $_REQUEST['TablaOrders'] == 'ok') {

    OrdersAjax::mostrarTablaOrders($_REQUEST["fecha1"], $_REQUEST['fecha2']);
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

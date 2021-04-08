<?php

session_start();

# REQUERIMOS EL CONTROLADOR Y EL MODELO PARA QUE REALICE LA PETICION
require_once '../controllers/operations.controller.php';
require_once '../models/operations.model.php';

class C_OrdersAjax
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
        $Orders = OrdersController::ctrShowOrders($_SESSION['idCompany'], null, $fechas);
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
                    case 'In Process':
                        $Status = "<span idorder='{$value['id_orders']}' class='badge badge-primary'>In Process</span>";
                        break;

                    case 'Shipped':
                        $Status = "<span idorder='{$value['id_orders']}' class='badge badge-warning'>Shipped</span>";
                        break;

                    case 'Delivered':
                        $Status = "<span idorder='{$value['id_orders']}' class='badge badge-secondary text-white'>Delivered</span>";
                        break;

                    case 'Canceled':
                        $Status = "<span idorder='{$value['id_orders']}' class='badge badge-danger'>Canceled</span>";
                        break;

                    default:
                        $Status = $value['Status'];
                        break;
                }
                //$onclickEventDescargar = `onclick="javascript:window.open('pdf/po.php?order=${value['id_orders']}','','width=1280,height=720,left=50,top=50,toolbar=yes');`;
                $botonDescargarOrder = "<button class='btn btn-secondary ml-2 btn-descargarorder' type='button' idorder='{$value['id_orders']}'><i class='fas fa-save'></i></button>";
                $BtnPDF = "<div class='row d-flex flex-nowrap justify-content-center'>" . $botonDescargarOrder . "</div>";

                // $btnDeleteOrder = "<button class='btn btn-danger btn-sm btnBorrarOrder m-1' id_orders='{$value['id_orders']}'><i class='fas fa-trash-alt'></i></button>";
                // $btnActions = "<div class='row d-flex flex-nowrap justify-content-center'>" . $btnDeleteOrder . "</div>";

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
                        "' . $BtnPDF . '"
                    ],';
            }
            #Eliminamos la ultima coma para no tener problema en el json    
            $datosJson = substr($datosJson, 0, -1);
        }

        $datosJson .= ']}';

        echo $datosJson;
        //echo json_encode($Orders);
    }
}

if (isset($_REQUEST['TablaOrders']) && $_REQUEST['TablaOrders'] == 'ok') {
    C_OrdersAjax::mostrarTablaOrders($_REQUEST["fecha1"], $_REQUEST['fecha2']);
}

<?php
/* ===================================================
       CONTROLADOR DE COMPANIES
    ===================================================*/
class CompaniesController
{
    /* ===================================================
            SHOW ALL COMPANIES
        ===================================================*/
    static public function ctrShowCompanies()
    {
        $response = CompaniesModel::mdlShowCompanies();

        return $response;
    }

    /* ===================================================
           NEW COMPANY
        ===================================================*/
    static public function ctrNewCompany()
    {
        if (isset($_POST['company'])) {
            if (
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["country"]) &&
                // /* preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["company"]) && */
                // preg_match('/^[a-zA-Z0-9]*$/', $_POST["ID"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ, ]+$/', $_POST["addrLine1"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ, ]*$/', $_POST["addrLine2"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["city"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["state"]) &&
                // preg_match('/^[0-9]+$/', $_POST["zipcode"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["contact"]) /* &&
                // preg_match('/^[0-9()+ ]+$/', $_POST["phone"]) */
                true
            ) {
                $datos = array(
                    'country' => $_POST['country'],
                    'company' => $_POST['company'],
                    'ID' => $_POST['ID'],
                    'addrLine1' => $_POST['addrLine1'],
                    'addrLine2' => $_POST['addrLine2'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'zipcode' => $_POST['zipcode'],
                    'contact' => $_POST['contact'],
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'],
                    'comments' => $_POST['comments']
                );

                $newCompany = CompaniesModel::mdlNewCompany($datos);

                if ($newCompany != "error") {
                    echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: '¡Company successfully created!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								allowOutsideClick: false,
							}).then((result)=>{
								if(result.value){
									window.location = 'operations-companies';
								}

							})
						</script>
					    ";
                } else {
                    echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'Oops, there was a problem, please try again later',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
                }
            } else {
                echo "
						<script>
							Swal.fire({
								icon: 'warning',
								title: 'some fields are empty or may have special characters',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
            }
        }
    }

    /* ===================================================
           SINGLE COMPANY INFORMATION
        ===================================================*/
    static public function ctrCompanyInfo($item, $value)
    {
        $response = CompaniesModel::mdlCompanyInfo($item, $value);

        return $response;
    }

    /* ===================================================
           EDIT COMPANY INFO
        ===================================================*/
    static public function ctrUpdateCompany()
    {
        if (isset($_POST['editcompany'])) {
            if (
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["country"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editcompany"]) &&
                // preg_match('/^[a-zA-Z0-9]*$/', $_POST["ID"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["addrLine1"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["addrLine2"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["city"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["state"]) &&
                // preg_match('/^[0-9]+$/', $_POST["zipcode"]) &&
                // preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["contact"]) &&
                // preg_match('/^[0-9()+ ]+$/', $_POST["phone"])
                true
            ) {
                $datos = array(
                    'idcompany' => $_POST['idcompany'],
                    'country' => $_POST['country'],
                    'company' => $_POST['editcompany'],
                    'ID' => $_POST['ID'],
                    'addrLine1' => $_POST['addrLine1'],
                    'addrLine2' => $_POST['addrLine2'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'zipcode' => $_POST['zipcode'],
                    'contact' => $_POST['contact'],
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'],
                    'comments' => $_POST['comments']
                );

                $updateCompany = CompaniesModel::mdlUpdateCompany($datos);

                if ($updateCompany != "error") {
                    echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: '¡Company successfully updated!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								allowOutsideClick: false,
							}).then((result)=>{
								if(result.value){
									window.location = 'operations-companies';
								}

							})
						</script>
					    ";
                } else {
                    echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'Oops, there was a problem, please try again later',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
                }
            } else {
                echo "
						<script>
							Swal.fire({
								icon: 'warning',
								title: 'some fields are empty or may have special characters',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
            }
        }
    }

    /* ===================================================
        ALLOWED PRODUCTS
    ===================================================*/
    static public function ctrAllowedProducts($value)
    {
        $response = CompaniesModel::mdlAllowedProducts($value);

        return $response;
    }

    /* ===================================================
       SAVE ALLOWED PRODUCTS
    ===================================================*/
    static public function ctrSaveAllowedProducts()
    {
        if (isset($_POST['allowedProducts'])) {
            /* Primero eliminamos los registros existentes de productos permitidos */
            $eliminarAllowedProducts = CompaniesModel::mdlEliminarRegistros("re_Companies_Products", $_POST['idCompany']);

            if ($eliminarAllowedProducts == "ok") {
                /* Seguido de esto agregamos los nuevos */
                $allowedProducts = $_POST['allowedProducts'];

                # Tamaño del arreglo
                $totalArreglo = $allowedProducts != '' ? sizeof($allowedProducts) : 0;

                # Por cada input del arreglo
                if ($totalArreglo > 0) {
                    for ($i = 0; $i < $totalArreglo; $i++) {
                        if ($allowedProducts[$i] != "") {
                            $datos = array(
                                'id_companies' => $_POST['idCompany'],
                                'id_products' => $allowedProducts[$i]
                            );
                            $agregarAllowedProduct = CompaniesModel::mdlUpdateAllowedProducts($datos);
                        }
                    }
                }

                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: '¡Allowed products updated successfully!',						
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        }).then((result)=>{
                            if(result.value){
                                window.location = 'operations-companies';
                            }
                        })
                    </script>
                ";
            } else {
                echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'Oops, there was a problem, please try again later',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
            }
        }
    }

    /* ===================================================
       MODIFICAR SOLO UN CAMPO DE COMPANY (INICIALMENTE PARA DESHABILITARLO)
    ===================================================*/
    static public function ctrModificarCampo($datos)
    {
        $response = CompaniesModel::mdlModificarCampo($datos);
        return $response;
    }
}

/* ===================================================
       CONTROLADOR DE PRODUCTS
    ===================================================*/
class ProductsController
{
    /* ===================================================
        SHOW ALL PRODUCTS
    ===================================================*/
    static public function ctrShowProducts()
    {
        $response = ProductsModel::mdlShowProducts();

        return $response;
    }

    /* ===================================================
           NEW PRODUCT
        ===================================================*/
    static public function ctrNewProduct()
    {
        if (isset($_POST['Name'])) {
            if (
                preg_match('/^[a-zA-Z0-9- ]+$/', $_POST["Name"]) &&
                preg_match('/^[a-zA-Z0-9- ]+$/', $_POST["Reference"]) &&
                preg_match('/^[a-zA-Z0-9- ]+$/', $_POST["UpcCode"]) &&
                preg_match('/^[a-zA-Z0-9,. ]+$/', $_POST["Weight"]) &&
                preg_match('/^[a-zA-Z0-9,. ]+$/', $_POST["Unit"]) &&
                preg_match('/^[a-zA-Z0-9,. ]+$/', $_POST["Price"])
            ) {
                $datos = array(
                    'Name' => $_POST['Name'],
                    'Reference' => $_POST['Reference'],
                    'UpcCode' => $_POST['UpcCode'],
                    'Weight' => $_POST['Weight'],
                    'Unit' => $_POST['Unit'],
                    'Price' => $_POST['Price'],
                    'Description' => $_POST['Description']
                );

                $newProduct = ProductsModel::mdlNewProduct($datos);

                if ($newProduct != "error") {


                    /* ===================== 
                        CREAMOS DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL PRODUCTO 
                    ========================= */
                    $anioActual = date("Y");

                    # Verificar Directorio Año
                    $directorioAnio = "./views/img/Products/{$anioActual}";
                    if (!is_dir($directorioAnio)) {
                        mkdir($directorioAnio, 0755);
                    }

                    $fecha = date('Y-m-d');
                    $hora = date('His');

                    /* ===================================================
                       GUARDAR LA IMAGEN EN EL SERVIDOR
                    ===================================================*/
                    $GuardarImagen = new FilesController();
                    $GuardarImagen->file = $_FILES['Image'];
                    $GuardarImagen->ruta = "./views/img/Products/{$anioActual}/{$_POST['Reference']}_{$fecha}_{$hora}";
                    $ruta = $GuardarImagen->ctrImages(500, 500);

                    /* ===================================================
                        ACTUALIZAR RUTA IMAGEN EN LA BD
                    ===================================================*/

                    if ($ruta != "") {
                        $rutaImg = str_replace("./views", "/views", $ruta);
                        $actualizarRutaImg = ProductsModel::mdlUpdateProductImage($newProduct, $rutaImg);
                    }

                    echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: 'Product successfully created!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								allowOutsideClick: false,
							}).then((result)=>{
								if(result.value){
									window.location = 'operations-products';
								}

							})
						</script>
					    ";
                } else {
                    echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'Oops, there was a problem, please try again later',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
                }
            } else {
                echo "
						<script>
							Swal.fire({
								icon: 'warning',
								title: 'some fields are empty or may have special characters',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
            }
        }
    }

    /* ===================================================
           SINGLE PRODUCT INFORMATION
        ===================================================*/
    static public function ctrProductInfo($value)
    {
        $response = ProductsModel::mdlProductInfo($value);

        return $response;
    }

    /* ===================================================
       EDIT PRODUCT INFO
    ===================================================*/
    static public function ctrUpdateProduct()
    {
        if (isset($_POST['editName'])) {
            if (
                preg_match('/^[a-zA-Z0-9- ]+$/', $_POST["editName"]) &&
                preg_match('/^[a-zA-Z0-9- ]+$/', $_POST["Reference"]) &&
                preg_match('/^[a-zA-Z0-9- ]+$/', $_POST["UpcCode"]) &&
                preg_match('/^[a-zA-Z0-9,. ]+$/', $_POST["Weight"]) &&
                preg_match('/^[0-9,.]+$/', $_POST["Unit"]) &&
                preg_match('/^[a-zA-Z0-9,. ]+$/', $_POST["Price"])
            ) {
                /* ===================== 
                    ? VALIDAR LA IMAGEN 
                ========================= */

                /* ===================== 
                        CREAMOS DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO 
                    ========================= */
                $anioActual = date("Y");

                # Verificar Directorio Año
                $directorioAnio = "./views/img/Products/{$anioActual}";
                if (!is_dir($directorioAnio)) {
                    mkdir($directorioAnio, 0755);
                }

                /* ===================== 
                        DE ACUERDO AL TIPO DE IMAGEN SE APLICA UNA FUNCION POR DEFECTO DE PHP 
                    ========================= */
                $fecha = date('Y-m-d');
                $hora = date('His');

                /* ===================================================
                    GUARDAR LA IMAGEN EN EL SERVIDOR
                ===================================================*/
                $GuardarImagen = new FilesController();
                $GuardarImagen->file = $_FILES['Image'];
                $GuardarImagen->ruta = "./views/img/Products/{$anioActual}/{$_POST['Reference']}_{$fecha}_{$hora}";
                $ruta = $GuardarImagen->ctrImages(500, 500);

                /* ===================================================
                    ACTUALIZAR RUTA IMAGEN EN LA BD
                ===================================================*/
                if ($ruta != "") {
                    $rutaImg = str_replace("./views", "/views", $ruta);
                    $actualizarRutaImg = ProductsModel::mdlUpdateProductImage($_POST['idproduct'], $rutaImg);
                }
                $datos = array(
                    'idproduct' => $_POST['idproduct'],
                    'Name' => $_POST['editName'],
                    'Reference' => $_POST['Reference'],
                    'UpcCode' => $_POST['UpcCode'],
                    'Weight' => $_POST['Weight'],
                    'Unit' => $_POST['Unit'],
                    'Price' => $_POST['Price'],
                    'Description' => $_POST['Description']
                );

                $updateProduct = ProductsModel::mdlUpdateProduct($datos);

                if ($updateProduct != "error") {


                    echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: 'Product successfully updated!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								allowOutsideClick: false,
							}).then((result)=>{
								if(result.value){
									window.location = 'operations-products';
								}

							})
						</script>
					    ";
                } else {
                    echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'Oops, there was a problem, please try again later',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
                }
            } else {
                echo "
						<script>
							Swal.fire({
								icon: 'warning',
								title: 'some fields are empty or may have special characters',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
            }
        }
    }

    /* ===================================================
       MODIFICAR SOLO UN CAMPO DE PRODUCT (INICIALMENTE PARA DESHABILITARLO)
    ===================================================*/
    static public function ctrModificarCampo($datos)
    {
        $response = ProductsModel::mdlModificarCampo($datos);
        return $response;
    }
}

/* ===================================================
    CONTROLADOR DE ORDERS
===================================================*/
class OrdersController
{
    /* ===================================================
       SHOW ALL ORDERS
    ===================================================*/
    static public function ctrShowOrders($value, $status, $fechas)
    {
        $response = OrdersModel::mdlShowOrders($value, $status, $fechas);

        return $response;
    }

    /* ===================================================
       NEW ORDER
    ===================================================*/
    static public function ctrNewOrder()
    {
        if (isset($_POST['client'])) {
            $datos = array(
                'id_companies' => $_POST['client'],
                'id_products' => $_POST['id_products'],
                'Weight_Each_Bag' => $_POST['Weight_Each_Bag'],
                'Total_Bags' => $_POST['Total_Bags'],
                'Total_Skids' => $_POST['Total_Skids'],
                'Customer_PO' => $_POST['Customer_PO'],
                'Arrange_Pickup' => $_POST['Arrange_Pickup'],
                'From_Release' => $_POST['From_Release'],
                'Pickup_Date' => $_POST['Pickup_Date'],
                'PO_Reference' => $_POST['PO_Reference'],
                'Delivery_Terms' => $_POST['Delivery_Terms'],
                'Delivery_From_Name' => $_POST['Delivery_From_Name'],
                'Delivery_Address' => $_POST['Delivery_Address'],
                'Delivery_Address2' => $_POST['Delivery_Address2'],
                'Delivery_Phone' => $_POST['Delivery_Phone'],
                'Delivery_Contact' => $_POST['Delivery_Contact'],
                'Delivery_City' => $_POST['Delivery_City'],
                'Delivery_ZipCode' => $_POST['Delivery_ZipCode'],
                'Delivery_Date' => $_POST['Delivery_Date'],
                'Delivery_Real_Date' => $_POST['Delivery_Real_Date'],
                'Delivery_Destination_Name' => $_POST['Delivery_Destination_Name'],
                'Delivery_Destination_Address' => $_POST['Delivery_Destination_Address'],
                'Delivery_Destination_Address2' => $_POST['Delivery_Destination_Address2'],
                'Delivery_Destination_Phone' => $_POST['Delivery_Destination_Phone'],
                'Delivery_Destination_Contact' => $_POST['Delivery_Destination_Contact'],
                'Delivery_Destination_City' => $_POST['Delivery_Destination_City'],
                'Delivery_Destination_ZipCode' => $_POST['Delivery_Destination_ZipCode'],
                'Delivery_Destination_Confirmed_Trucking_Charge' => $_POST['Delivery_Destination_Confirmed_Trucking_Charge'],
                'Delivery_Destination_Comments' => $_POST['Delivery_Destination_Comments'],
                'audit_user' => $_SESSION['user_id']
            );

            $newOrder = OrdersModel::mdlNewOrder($datos);

            if ($newOrder != "error") {
                $datos = array(
                    'id_orders' => $newOrder,
                    'Status' => 'In Process'
                );
                OrdersModel::mdlInsertStatusHistory($datos);
                echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: '¡Order successfully created!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								allowOutsideClick: false,
							}).then((result)=>{
								if(result.value){
									window.location = 'orders';
								}

							})
						</script>
					    ";
            } else {
                echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'Oops, there was a problem, please try again later',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
            }
        }
    }

    /* ===================================================
       EDIT ORDER
    ===================================================*/
    static public function ctrEditOrder()
    {
        if (isset($_POST['idorder'])) {
            $datos = array(
                'id_orders' => $_POST['idorder'],
                'id_companies' => $_POST['company'],
                'id_products' => $_POST['id_products'],
                'Weight_Each_Bag' => $_POST['Weight_Each_Bag'],
                'Total_Bags' => $_POST['Total_Bags'],
                'Total_Skids' => $_POST['Total_Skids'],
                'Customer_PO' => $_POST['Customer_PO'],
                'Arrange_Pickup' => $_POST['Arrange_Pickup'],
                'From_Release' => $_POST['From_Release'],
                'Pickup_Date' => $_POST['Pickup_Date'],
                'PO_Reference' => $_POST['PO_Reference'],
                'Delivery_Terms' => $_POST['Delivery_Terms'],
                'Delivery_From_Name' => $_POST['Delivery_From_Name'],
                'Delivery_Address' => $_POST['Delivery_Address'],
                'Delivery_Address2' => $_POST['Delivery_Address2'],
                'Delivery_Phone' => $_POST['Delivery_Phone'],
                'Delivery_Contact' => $_POST['Delivery_Contact'],
                'Delivery_City' => $_POST['Delivery_City'],
                'Delivery_ZipCode' => $_POST['Delivery_ZipCode'],
                'Delivery_Date' => $_POST['Delivery_Date'],
                'Delivery_Real_Date' => $_POST['Delivery_Real_Date'],
                'Delivery_Destination_Name' => $_POST['Delivery_Destination_Name'],
                'Delivery_Destination_Address' => $_POST['Delivery_Destination_Address'],
                'Delivery_Destination_Address2' => $_POST['Delivery_Destination_Address2'],
                'Delivery_Destination_Phone' => $_POST['Delivery_Destination_Phone'],
                'Delivery_Destination_Contact' => $_POST['Delivery_Destination_Contact'],
                'Delivery_Destination_City' => $_POST['Delivery_Destination_City'],
                'Delivery_Destination_ZipCode' => $_POST['Delivery_Destination_ZipCode'],
                'Delivery_Destination_Confirmed_Trucking_Charge' => $_POST['Delivery_Destination_Confirmed_Trucking_Charge'],
                'Delivery_Destination_Comments' => $_POST['Delivery_Destination_Comments']
            );

            $updateOrder = OrdersModel::mdlEditOrder($datos);

            if ($updateOrder != "error") {
                echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: '¡Order successfully updated!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								allowOutsideClick: false,
							}).then((result)=>{
								if(result.value){
									//window.location = 'orders';
									window.location.href = window.location.href;
								}

							})
						</script>
					    ";
            } else {
                echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'Oops, there was a problem, please try again later',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
            }
        }
    }

    /* ===================================================
           SINGLE ORDER INFORMATION
        ===================================================*/
    static public function ctrOrderInfo($value)
    {
        $response = OrdersModel::mdlOrderInfo($value);

        return $response;
    }

    /* ===================================================
       MODIFICAR SOLO UN CAMPO DE LA ORDEN
    ===================================================*/
    static public function ctrModificarCampo($datos)
    {
        $response = OrdersModel::mdlModificarCampo($datos);

        if ($datos['item'] == "Status") {
            $datosArray = array(
                'id_orders' => $datos['id_orders'],
                'Status' => $datos['value']
            );
            OrdersModel::mdlInsertStatusHistory($datosArray);
        }

        return $response;
    }

    /* ===================================================
       CARGAR DOCUMENTO DE LA ORDEN
    ===================================================*/
    static public function ctrLoadDoc()
    {
        $response = "";

        # Si viene algo del formulario
        if (isset($_POST['tipoDoc'])) {
            $tipoDoc = $_POST['tipoDoc'];

            /* ===================== 
                CREAMOS DIRECTORIO DONDE VAMOS A GUARDAR EL ARCHIVO
            ========================= */
            $anioActual = date("Y");

            # Verificar Directorio Año
            $directorioAnio = "./views/docs/$tipoDoc/{$anioActual}";
            if (!is_dir($directorioAnio)) {
                mkdir($directorioAnio, 0755);
            }

            $fecha = date('Y-m-d');
            $hora = date('His');

            /* ===================================================
               GUARDAMOS EL ARCHIVO
            ===================================================*/
            $GuardarArchivo = new FilesController();
            $GuardarArchivo->file = $_FILES['docFile'];
            $GuardarArchivo->ruta = $directorioAnio . "/{$_POST['idorderDoc']}_{$fecha}_{$hora}";

            # Si es pdf
            if ($_FILES['docFile']['type'] == "application/pdf") {
                $response = $GuardarArchivo->ctrPDFFiles();
            } else {
                # Si es una imagen
                if ($_FILES['docFile']['type'] == "image/jpeg" || $_FILES['docFile']['type'] == "image/png") {
                    $response = $GuardarArchivo->ctrImages(null, null);
                }
            }

            # Actualizar el campo de la base de datos donde queda la ruta del archivo
            if ($response != "") {
                $rutaDoc = str_replace("./views", "/views", $response);
                $datos = array(
                    'id_orders' => $_POST['idorderDoc'],
                    'item' => $tipoDoc,
                    'value' => $rutaDoc
                );
                $actualizarRutaDoc = self::ctrModificarCampo($datos);

                if ($actualizarRutaDoc == "ok") {
                    echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: '¡Document successfully uploaded!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								allowOutsideClick: false,
							}).then((result)=>{
								if(result.value){
									//window.location = 'orders';
                                    window.location.href = window.location.href;
								}

							})
						</script>
					    ";
                } else {
                    echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, there was a problem, please try again later',						
                                showConfirmButton: true,
                                confirmButtonText: 'Cerrar',
                                closeOnConfirm: false
                            })
                        </script>
                        ";
                }
            } else {
                echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, there was a problem, please check your file',						
                                showConfirmButton: true,
                                confirmButtonText: 'Cerrar',
                                closeOnConfirm: false
                            })
                        </script>
                        ";
            }
        }
    }

    /* ===================================================
        VERIFICAR SI EL DOCUMENTO ESTA CORRECTAMENTE SUBIDO
    ===================================================*/
    static public function ctrVerificarDocumento($datos)
    {
        $idorder = $datos['id_orders'];
        $tipodoc = $datos['tipodoc'];
        $datosDocumento = OrdersModel::mdlDocumentoOrder($idorder);

        $rutaDoc = $datosDocumento[$tipodoc];

        // Ver que el campo no este vacio
        if ($rutaDoc != "") {
            // Verificar que el archivo si se encuentre
            $rutaVerificar = ".." . $rutaDoc;
            if (file_exists($rutaVerificar)) {
                $tipoArchivo = strpos($rutaDoc, '.pdf') !== false ? "PDF" : "Image";
                $tipoArchivoArray = array(
                    'tipoArchivo' => $tipoArchivo,
                    'rutaDoc' => $rutaDoc
                );
                $response = array_merge($datosDocumento, $tipoArchivoArray);
                return $response;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /* ===================================================
       DOWNLOAD FILE (POD OR COA)
    ===================================================*/
    static public function ctrDownloadFile($datos)
    {
        $tipodoc = $datos['tipodoc'];
        $datosOrder = OrdersModel::mdlOrderInfo($datos['id_orders']);

        $datosResponse = array('url' => $datosOrder["{$tipodoc}"]);

        return $datosResponse;

        // //$url = $datosOrder["{$tipodoc}"];
        // $url = "C:/wamp64/www/PDC" . $datosOrder["{$tipodoc}"];
        // $file_name = basename($url);
        // /* return $_SERVER['SCRIPT_FILENAME'];
        // return $_SERVER['DOCUMENT_ROOT']; */

        // if (file_put_contents($file_name, file_get_contents($url))) {
        //     return "File downloaded successfully";
        // } else {
        //     return "File downloading failed.";
        // }
    }
}

/* ===================================================
    CONTROLADOR DE BOL (BILL OF LADING)
===================================================*/
class BOLController
{
    /* ===================================================
       VALIDAR BOL REFERENCE
    ===================================================*/
    static public function ctrValidarBOL()
    {
        if (isset($_POST['bol-reference'])) {
            $respuesta = BOLModel::mdlValidarBOL($_POST['bol-reference']);
            if (is_array($respuesta)) {
                $_SESSION['bol_reference'] = $_POST['bol-reference'];
                echo "<script>window.location.href = window.location.href</script>";
            } else {
                echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'THE BOL REFERENCE DOES NOT EXIST',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
            }
        }
    }

    /* ===================================================
       DATOS DE LA ORDEN CON EL BOL REFERENCE
    ===================================================*/
    static public function ctrOrderInfo($bol)
    {
        $respuesta = BOLModel::mdlValidarBOL($bol);
        return $respuesta;
    }

    /* ===================================================
       TABLA BOL
    ===================================================*/
    static public function ctrTablaBOL($bolreference)
    {
        $respuesta = BOLModel::mdlTablaBOL($bolreference);
        return $respuesta;
    }

    /* ===================================================
       AGREGAR BOL
    ===================================================*/
    static public function ctrAgregarBOL()
    {
        if (isset($_POST['bolReference'])) {
            $datos = array(
                'bolReference' => $_POST['bolReference'],
                'lot' => $_POST['lot'],
                'refC' => $_POST['refC'],
                'fromId' => $_POST['fromId'],
                'toId' => $_POST['toId'],
                'shippingDate' => $_POST['shippingDate'],
                'carrier' => $_POST['carrier'],
                'pallets' => $_POST['pallets'],
                'bags' => $_POST['bags'],
                'weight' => $_POST['weight']
            );
            $agregarBOL = BOLModel::mdlAgregarBOL($datos);
            if ($agregarBOL != "error") {
                if (!isset($_SESSION['bol_reference'])){
                    $_SESSION['bol_reference'] = $_POST['bolReference'];
                }
                echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: '¡BOL successfully added!',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								allowOutsideClick: false,
							}).then((result)=>{
								if(result.value){
									window.location = 'bol';
								}

							})
						</script>
					    ";
            } else {
                echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'Oops, there was a problem, please try again later',						
								showConfirmButton: true,
								confirmButtonText: 'Cerrar',
								closeOnConfirm: false
							})
						</script>
					    ";
            }
        }
    }

    /* ===================================================
       DELETE BOL
    ===================================================*/
    static public function ctrDeleteBOL($id_bol)
    {
        $response = BOLModel::mdlDeleteBOL($id_bol);
        return $response;
    }

    /* ===================================================
       DATOS BOL POR POSICION
    ===================================================*/
    static public function ctrBOLPosicion($id_bol)
    {
        $response = BOLModel::mdlBOLPosicion($id_bol);
        return $response;
    }

}

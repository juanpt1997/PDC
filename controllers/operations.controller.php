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
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["country"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["company"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ID"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ, ]+$/', $_POST["addrLine1"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ, ]+$/', $_POST["addrLine2"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["city"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["state"]) &&
                preg_match('/^[0-9]+$/', $_POST["zipcode"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["contact"]) &&
                preg_match('/^[0-9()+ ]+$/', $_POST["phone"])
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
    static public function ctrCompanyInfo($value)
    {
        $response = CompaniesModel::mdlCompanyInfo($value);

        return $response;
    }

    /* ===================================================
           EDIT COMPANY INFO
        ===================================================*/
    static public function ctrUpdateCompany()
    {
        if (isset($_POST['editcompany'])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["country"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editcompany"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ID"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["addrLine1"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["addrLine2"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["city"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["state"]) &&
                preg_match('/^[0-9]+$/', $_POST["zipcode"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["contact"]) &&
                preg_match('/^[0-9()+ ]+$/', $_POST["phone"])
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
                preg_match('/^[a-zA-Z0-9,. ]+$/', $_POST["Weight"]) &&
                preg_match('/^[0-9,.]+$/', $_POST["Unit"]) &&
                preg_match('/^[a-zA-Z0-9,. ]+$/', $_POST["Price"])
            ) {
                $datos = array(
                    'Name' => $_POST['Name'],
                    'Reference' => $_POST['Reference'],
                    'Weight' => $_POST['Weight'],
                    'Unit' => $_POST['Unit'],
                    'Price' => $_POST['Price'],
                    'Description' => $_POST['Description']
                );

                $newProduct = ProductsModel::mdlNewProduct($datos);

                if ($newProduct != "error") {
                    /* ===================== 
                        ? VALIDAR LA IMAGEN 
                    ========================= */
                    $imagenProducto = $_FILES['Image'];
                    $ruta = "";

                    if (is_array($imagenProducto) && $imagenProducto['tmp_name'] != "") {
                        /* list nos permite crear un nuevo array con los indices que se le asignen */
                        list($ancho, $alto) = getimagesize($imagenProducto['tmp_name']);

                        $nuevoAncho = 500;
                        $nuevoAlto = 500;

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
                        if ($imagenProducto['type'] == "image/jpeg") {
                            /* ===================== 
                                GUARDAMOS LA IMAGEN EN EL DIRECTORIO 
                            ========================= */
                            $ruta = "./views/img/Products/{$anioActual}/{$_POST['Reference']}_{$fecha}_{$hora}.jpg";

                            $origen = imagecreatefromjpeg($imagenProducto['tmp_name']);
                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagejpeg($destino, $ruta);
                        }

                        if ($imagenProducto['type'] == "image/png") {
                            /* ===================== 
                                GUARDAMOS LA IMAGEN EN EL DIRECTORIO 
                            ========================= */
                            $ruta = "./views/img/Products/{$anioActual}/{$_POST['Reference']}_{$fecha}_{$hora}.png";

                            $origen = imagecreatefrompng($imagenProducto['tmp_name']);
                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagepng($destino, $ruta);
                        }
                    }

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
    { {
            if (isset($_POST['editName'])) {
                if (
                    preg_match('/^[a-zA-Z0-9- ]+$/', $_POST["editName"]) &&
                    preg_match('/^[a-zA-Z0-9- ]+$/', $_POST["Reference"]) &&
                    preg_match('/^[a-zA-Z0-9,. ]+$/', $_POST["Weight"]) &&
                    preg_match('/^[0-9,.]+$/', $_POST["Unit"]) &&
                    preg_match('/^[a-zA-Z0-9,. ]+$/', $_POST["Price"])
                ) {
                    /* ===================== 
                        ? VALIDAR LA IMAGEN 
                    ========================= */
                    $imagenProducto = $_FILES['Image'];
                    $ruta = "";

                    if (is_array($imagenProducto) && $imagenProducto['tmp_name'] != "") {
                        /* list nos permite crear un nuevo array con los indices que se le asignen */
                        list($ancho, $alto) = getimagesize($imagenProducto['tmp_name']);

                        $nuevoAncho = 500;
                        $nuevoAlto = 500;

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
                        if ($imagenProducto['type'] == "image/jpeg") {
                            /* ===================== 
                                GUARDAMOS LA IMAGEN EN EL DIRECTORIO 
                            ========================= */
                            $ruta = "./views/img/Products/{$anioActual}/{$_POST['Reference']}_{$fecha}_{$hora}.jpg";

                            $origen = imagecreatefromjpeg($imagenProducto['tmp_name']);
                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagejpeg($destino, $ruta);
                        }

                        if ($imagenProducto['type'] == "image/png") {
                            /* ===================== 
                                GUARDAMOS LA IMAGEN EN EL DIRECTORIO 
                            ========================= */
                            $ruta = "./views/img/Products/{$anioActual}/{$_POST['Reference']}_{$fecha}_{$hora}.png";

                            $origen = imagecreatefrompng($imagenProducto['tmp_name']);
                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagepng($destino, $ruta);
                        }
                    }

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
    }
}

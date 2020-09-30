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
            if (isset($_POST['company'])){
                if (
                    preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["country"]) &&
                    preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["company"]) &&
                    preg_match('/^[a-zA-Z0-9]+$/', $_POST["ID"]) &&
                    preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["addrLine1"]) &&
                    preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["addrLine2"]) &&
                    preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["city"]) &&
                    preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["state"]) &&
                    preg_match('/^[0-9]+$/', $_POST["zipcode"]) &&
                    preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["contact"]) &&
                    preg_match('/^[0-9()+ ]+$/', $_POST["phone"])
                ){
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

                    if ($newCompany != "error"){
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
                    }else{
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
                else{
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
            if (isset($_POST['editcompany'])){
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
                ){
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

                    if ($updateCompany != "error"){
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
                    }else{
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
                else{
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

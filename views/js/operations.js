/* ===================================================
  * COMPANIES
===================================================*/
if (window.location.href.includes("operations-companies")) {
    $(document).ready(function () {
        /* ===================================================
        DATATABLE
        ===================================================*/
        $('.tablaCompanies').DataTable({
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });

        /* ===================================================
          VISUALIZAR DATOS DE UNA COMPANY
        ===================================================*/
        $(document).on("click", ".companyInfo", function () {
            $(".editCompany").val("");
            $(".companyTitle").html("");

            var idcompany = $(this).attr("idcompany");

            var datos = new FormData();
            datos.append('CompanyInfo', "ok");
            datos.append('idcompany', idcompany);
            $.ajax({
                type: 'post',
                url: 'ajax/operations.ajax.php',
                data: datos,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response != "") {
                        // Titulo modal
                        $(".companyTitle").html(response.Name);
                        // Inputs de la modal
                        $("#idcompany").val(response.id_companies);
                        $("#country").val(response.Country);
                        $("#company").val(response.Name);
                        $("#ID").val(response.ID);
                        $("#addrLine1").val(response.Address_Line1);
                        $("#addrLine2").val(response.Address_Line2);
                        $("#city").val(response.City);
                        $("#state").val(response.State_Province_Region);
                        $("#zipcode").val(response.Zip_Code);
                        $("#contact").val(response.Contact_Name);
                        $("#phone").val(response.Phone_Number);
                        $("#email").val(response.Email);
                        $("#comments").val(response.Comments);

                    }
                }
            });
        });

    });
}

/* ===================================================
  * PRODUCTS
===================================================*/
if (window.location.href.includes("operations-products")) {
    $(document).ready(function () {
        /* ===================================================
        DATATABLE
        ===================================================*/
        $('.tablaProducts').DataTable({
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });

        /* ===================================================
          VISUALIZAR DATOS DE UN PRODUCT
        ===================================================*/
        $(document).on("click", ".productInfo", function () {
            $(".editProduct").val("");
            $(".productTitle").html("");
            $("#Image").attr("src", "");

            var idproduct = $(this).attr("idproduct");

            var datos = new FormData();
            datos.append('ProductInfo', "ok");
            datos.append('idproduct', idproduct);
            $.ajax({
                type: 'post',
                url: 'ajax/operations.ajax.php',
                data: datos,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response != "") {
                        // Titulo modal
                        $(".productTitle").html(response.Name);
                        // Inputs de la modal
                        $("#idproduct").val(response.id_products);
                        $("#Name").val(response.Name);
                        $("#Reference").val(response.Reference);
                        $("#Weight").val(response.Weight);
                        $("#Unit").val(response.Unit);
                        $("#Price").val(response.Price);
                        $("#Description").val(response.Description);
                        $("#Image").attr("src", `./${response.Image}`);

                    }
                }
            });

        });

        /* ===================================================
          VISUALIZAR IMAGEN DE UN PRODUCT
        ===================================================*/
        $(document).on("click", ".btn-imgproduct", function () {
            $(".nameTitleImg").html("");
            $("#imgproduct").attr("src", "");

            var idproduct = $(this).attr("idproduct");

            var datos = new FormData();
            datos.append('ProductInfo', "ok");
            datos.append('idproduct', idproduct);
            $.ajax({
                type: 'post',
                url: 'ajax/operations.ajax.php',
                data: datos,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response != "") {
                        // Titulo modal
                        $(".nameTitleImg").html(response.Name);
                        // Image
                        $("#imgproduct").attr("src", `.${response.Image}`);
                    }
                }
            });

        });
    });
}

/* ===================================================
  * ORDERS
===================================================*/
if (window.location.href.includes("orders")) {
    $(document).ready(function () {
        /* ===================================================
              VISUALIZAR DATOS DE UNA ORDER
            ===================================================*/
        $(document).on("click", ".orderInfo", function () {
            $(".editOrder").val("");
            $(".orderTitle").html("");

            var idorder = $(this).attr("idorder");

            var datos = new FormData();
            datos.append('OrderInfo', "ok");
            datos.append('idorder', idorder);
            $.ajax({
                type: 'post',
                url: 'ajax/operations.ajax.php',
                data: datos,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response != "") {
                        // Titulo modal
                        $(".orderTitle").html(response.id_orders);
                        // Inputs de la modal
                        $("#idorder").val(response.id_orders);
                        $("#company").val(response.id_companies);
                        $("#id_products").val(response.id_products);
                        $("#Weight_Each_Bag").val(response.Weight_Each_Bag);
                        $("#Total_Bags").val(response.Total_Bags);
                        $("#Total_Skids").val(response.Total_Skids);
                        $("#Customer_PO").val(response.Customer_PO);
                        $("#Arrange_Pickup").val(response.Arrange_Pickup);
                        $("#From_Release").val(response.From_Release);
                        $("#Pickup_Date").val(response.Pickup_Date);
                        $("#PO_Reference").val(response.PO_Reference);
                        $("#Delivery_From_Name").val(response.Delivery_From_Name);
                        $("#Delivery_Address").val(response.Delivery_Address);
                        $("#Delivery_Phone").val(response.Delivery_Phone);
                        $("#Delivery_Contact").val(response.Delivery_Contact);
                        $("#Delivery_Date").val(response.Delivery_Date);
                        $("#Delivery_Real_Date").val(response.Delivery_Real_Date);
                        $("#Delivery_Destination_Name").val(response.Delivery_Destination_Name);
                        $("#Delivery_Destination_Address").val(response.Delivery_Destination_Address);
                        $("#Delivery_Destination_Phone").val(response.Delivery_Destination_Phone);
                        $("#Delivery_Destination_Contact").val(response.Delivery_Destination_Contact);
                        $("#Delivery_Destination_Confirmed_Trucking_Charge").val(response.Delivery_Destination_Confirmed_Trucking_Charge);
                        $("#Delivery_Destination_Comments").val(response.Delivery_Destination_Comments);

                    }
                }
            });
        });

        /* ===================================================
          CAMBIAR ESTADO DE LA ORDEN
        ===================================================*/
        $(document).on("click", ".btnCambiarEstado", function () {
            var idorder = $(this).attr("idorder");
            Swal.fire({
                title: `# Order: ${idorder}`,
                html:
                    `
                    <br>
                    <label for="">New Status</label>
                    <select id="swal_cambiarEstado" class="form-control" name="swal_cambiarEstado">
                        <option>On Process</option>
                        <option>Shipped</option>
                    </select>
                    `
                ,
                showCancelButton: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    var datos = new FormData();
                    datos.append('UpdateCampo', "ok");
                    datos.append('idorder', idorder);
                    datos.append('item', "Status");
                    datos.append('value', $("#swal_cambiarEstado").val());
                    $.ajax({
                        type: 'post',
                        url: 'ajax/operations.ajax.php',
                        data: datos,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response == "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Status updated successfully!',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    if (result.value) {
                                        window.location = 'orders';
                                    }
                                })
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops, there was a problem, please try again later',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Cerrar',
                                    closeOnConfirm: false
                                })
                            }
                        }
                    });
                }
            })
        });

        /* ===================================================
            CLICK EN EL BOTON PARA VISUALIZAR/SUBIR ARCHIVOS COA O POD
        ===================================================*/
        $(document).on("click", ".btn-docs", function () {
            var idorder = $(this).attr("idorder");
            var tipodoc = $(this).attr("tipodoc");

            //Titulo del tipo de documento
            if (tipodoc == "COA") {
                $(".docTitle").html("Certicate Of Analysis");
            }
            else {
                $(".docTitle").html("Probe of Delivery");
            }

            $("#canvasPDF").addClass("d-none");
            $("#containerImgDoc").addClass("d-none");
            $("#frmSubirDocumento").addClass("d-none");
            $("#btnGuardarArchivo").addClass("d-none");


            // Cambiar valor de hidden input
            $(".idorder").val(idorder);
            $(".tipodoc").val(tipodoc);

            // Despues de conocer el tipo de documento, consultamos si tiene correctamente subido el documento
            var datos = new FormData();
            datos.append('ExisteDoc', "ok");
            datos.append('idorder', idorder);
            datos.append('tipodoc', tipodoc);
            $.ajax({
                type: 'post',
                url: 'ajax/operations.ajax.php',
                data: datos,
                cache: false,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response != null) {
                        // EL DOC ES UN PDF
                        if (response.tipoArchivo == "PDF") {
                            $("#canvasPDF").removeClass("d-none");
                            VisualizarPDF(response.rutaDoc);
                        }
                        // EL DOC ES UNA IMAGEN
                        else {
                            $("#containerImgDoc").removeClass("d-none");
                            $("#imgDoc").attr("src", "." + response.rutaDoc);
                        }
                    }
                    // NO HAY DOCUMENTO, POR TANTO SE MUESTRA EL FORMULARIO PARA SUBIR UNO
                    else {
                        $("#frmSubirDocumento").removeClass("d-none");
                        $("#btnGuardarArchivo").removeClass("d-none");
                    }
                }
            });
        });
    });

}
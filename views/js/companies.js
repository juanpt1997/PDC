if (window.location.href.includes("c-orders") || window.location.href.includes("c-shippedorders")) {
    $(document).ready(function () {
        
        /* ===================================================
        DATATABLE
        ===================================================*/
        $('.tablaOrders').DataTable({
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });

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
                        $("#company").val(response.Company);
                        ShowAllowedProducts(response.id_companies, response.id_products);
                        $("#Weight_Each_Bag").val(response.Weight_Each_Bag);
                        $("#Total_Bags").val(response.Total_Bags);
                        $("#Total_Skids").val(response.Total_Skids);
                        $("#Customer_PO").val(response.Customer_PO);
                        $("#Arrange_Pickup").val(response.Arrange_Pickup);
                        $("#From_Release").val(response.From_Release);
                        $("#Pickup_Date").val(response.Pickup_Date);
                        $("#PO_Reference").val(response.PO_Reference);
                        $("#Delivery_Terms").val(response.Delivery_Terms);
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
                        <option>Sent</option>
                        <option>Canceled</option>
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
                                        window.location = 'c-orders';
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
          CLICK DESCARGAR PDF ORDER
        ===================================================*/
        $(document).on("click", ".btn-descargarorder", function () {
            var idorder = $(this).attr("idorder");
            window.open(`./pdf/pdforder.php?order=${idorder}`, '', 'width=1280,height=720,left=50,top=50,toolbar=yes')
        });

        /* ===================================================
            DETECTS CHANGE ON INPUT CLIENT TO SHOW ALLOWED PRODUCTS
        ===================================================*/
        $(document).on("change", ".clientInput", function () {
            var idcompany = $(this).val();

            ShowAllowedProducts(idcompany, null);

        });

        /* ===================================================
            SHOW ALLOWED PRODUCTS FOR AN SPECIFIC COMPANY
        ===================================================*/
        function ShowAllowedProducts(idcompany, idproduct) {
            $(".productsInput").html("");

            var datos = new FormData();
            datos.append('AllowedProducts', "ok");
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
                    var template = `<option value="" selected disabled>Choose an option</option>`;
                    if (response != "") {
                        response.forEach(element => {
                            template += `<option value="${element.id_products}">${element.Name}</option>`;
                        });
                    }

                    // Agregar el select
                    $(".productsInput").html(template);

                    if (idproduct != null) {
                        $("#id_products").val(idproduct);
                    }
                }
            });
        }
    });
}


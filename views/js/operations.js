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

        /* ===================================================
          MOSTRAR Y SELECCIONAR PRODUCTS PERMITIDOS
        ===================================================*/
        $(document).on("click", ".btn-productsAllowed", function () {
            var idcompany = $(this).attr("idcompany");
            var namecompany = $(this).attr("namecompany");

            // Titulo de la modal
            $("#title_ProductsAllowed").html(namecompany);

            // Id company del formulario
            $("#allowedProductsIdCompany").val(idcompany);

            // Eliminar el select existente
            $(".divAllowedProducts").html("");
            // Mostrar el spinner cargando
            $('.spinnerDuallistbox').removeClass("d-none");

            var datos = new FormData();
            datos.append('ShowProducts', "ok");
            $.ajax({
                type: 'post',
                url: 'ajax/operations.ajax.php',
                data: datos,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    var template = `<label>Select the allowed products for this company</label>
                                    <select class="duallistbox d-none" multiple="multiple" name="allowedProducts[]" required>`;
                    if (response != "") {
                        response.forEach(element => {
                            template += `<option value="${element.id_products}">${element.Name}</option>`;
                        });
                    }
                    template += `</select>`;
                    // Agregar el select al formulario
                    $(".divAllowedProducts").html(template);

                    // Traer la informacion de los productos que estan permitidos para dicho company
                    var datosAllowedProducts = new FormData();
                    datosAllowedProducts.append('AllowedProducts', "ok");
                    datosAllowedProducts.append('idcompany', idcompany);
                    $.ajax({
                        type: 'post',
                        url: 'ajax/operations.ajax.php',
                        data: datosAllowedProducts,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response != "") {
                                response.forEach(element => {
                                    $(`.duallistbox option[value="${element.id_products}"]`).attr("selected", "selected");
                                });
                            }
                            // INICIALIZAR DUALLISTBOX PARA ALLOWED PRODUCTS DE UN COMPANY
                            $('.duallistbox').bootstrapDualListbox();

                            // Mostrar duallistbox
                            $('.duallistbox').removeClass("d-none");
                            // Esconder spinner de cargando
                            $('.spinnerDuallistbox').addClass("d-none");
                        }
                    });
                }
            });

        });

        /* ===================================================
          DESHABILITAR UN COMPANY('BORRARLO')
        ===================================================*/
        $(document).on("click", ".btnBorrarCompany", function () {
            var nameCompany = $(this).attr("nameCompany");
            var id_companies = $(this).attr("id_companies");
            Swal.fire({
                title: `${nameCompany}`,
                html:
                    `
                    <p>Do you really want to <b>delete</b> this company's data?</p>
                    `
                ,
                /* text: 'Do you really want to delete this company?', */
                footer: 'You will not be able to reverse this action',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#0275d8',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sure!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    var datos = new FormData();
                    datos.append('UpdateCampoCompany', "ok");
                    datos.append('id_companies', id_companies);
                    datos.append('item', "Active");
                    datos.append('value', '0');
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
                                    title: '¡Company deleted successfully!',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Close',
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    if (result.value) {
                                        window.location = 'operations-companies';
                                    }
                                })
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops, there was a problem, please try again later',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Close',
                                    closeOnConfirm: false
                                })
                            }
                        }
                    });
                }
            })
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
                        $("#UpcCode").val(response.UpcCode);
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

        /* ===================================================
          DESHABILITAR UN PRODUCT('BORRARLO')
        ===================================================*/
        $(document).on("click", ".btnBorrarProduct", function () {
            var nameProduct = $(this).attr("nameProduct");
            var id_products = $(this).attr("id_products");
            Swal.fire({
                title: `${nameProduct}`,
                html:
                    `
                    <p>Do you really want to <b>delete</b> this product's data?</p>
                    `
                ,
                /* text: 'Do you really want to delete this Product?', */
                footer: 'You will not be able to reverse this action',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#0275d8',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sure!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    var datos = new FormData();
                    datos.append('UpdateCampoProduct', "ok");
                    datos.append('id_products', id_products);
                    datos.append('item', "Active");
                    datos.append('value', '0');
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
                                    title: '¡Product deleted successfully!',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Close',
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    if (result.value) {
                                        window.location = 'operations-products';
                                    }
                                })
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops, there was a problem, please try again later',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Close',
                                    closeOnConfirm: false
                                })
                            }
                        }
                    });
                }
            })
        });

    });
}

/* ===================================================
  * ORDERS
===================================================*/
if (window.location.href.includes("orders") && !window.location.href.includes("c-orders") && !window.location.href.includes("c-shippedorders")) {
    $(document).ready(function () {
        /* ===================================================
          ? PRUEBA AJAX
        ===================================================*/
        // var datos = new FormData();
        // datos.append('TablaOrders', "ok");
        // datos.append('fecha1', "2020-12-01");
        // datos.append('fecha2', "2020-12-31");
        // $.ajax({
        //     type: 'post',
        //     url: 'ajax/operations.ajax.php',
        //     data: datos,
        //     dataType: 'json',
        //     cache: false,
        //     contentType: false,
        //     processData: false,
        //     success: function (response) {
        //         console.log(response);
        //     }
        // });
        /* ===================================================
          DATE RANGE PICKER ORDERS
        ===================================================*/
        $("#rango-fechas").daterangepicker({
            showWeekNumbers: true,
            showDropdowns: true,
            autoApply: true,
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [
                    moment()
                        .subtract(1, "month")
                        .startOf("month"),
                    moment()
                        .subtract(1, "month")
                        .endOf("month")
                ],
                Everything: [moment().subtract(20, "years"), moment().subtract(-3, "years")]
            },
            alwaysShowCalendars: true,
            //startDate: moment().startOf("month"),
            startDate: moment().startOf("year"),
            endDate: moment().endOf("month"),
            opens: "center",
            cancelClass: "btn-danger"
        },
            function (start, end, label) {
                console.log(
                    "Rango desde: " +
                    start.format("YYYY-MM-DD") +
                    " hasta " +
                    end.format("YYYY-MM-DD") +
                    " (predefined range: " +
                    label +
                    ")"
                );

                fecha1 = start.format("YYYY-MM-DD");
                fecha2 = end.format("YYYY-MM-DD");

                mostrarDatatableOrders(fecha1, fecha2);
            }
        );

        /* ===================================================
          FUNCION DATATABLE
        ===================================================*/
        const mostrarDatatableOrders = (fecha1, fecha2) => {
            var $tabla = $(".tablaOrders").find("table");

            //Eliminamos la tabla actual
            $tabla.remove();

            let template = `  
                <table class="table table-sm">
                    <thead class="text-uppercase">
                        <tr>
                            <th>Order</th>
                            <th>Company</th>
                            <th>Customer PO</th>
                            <th>BOL REFERENCE</th>
                            <th>CREATED</th>
                            <th>DATE ENTERED</th>
                            <th>DELIVER BY</th>
                            <th>REAL DELIVERED</th>
                            <th>Product</th>
                            <th>Quanty</th>
                            <th>Status</th>
                            <th>COA</th>
                            <th>POD</th>
                            <th>PDF</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>      
                    </tbody>
                </table>`;
            //<th>Compromiso</th>
            //<th>Línea</th>

            //Creamos nuevamente la tabla
            $(".tablaOrders").html(template);

            $tabla = $(".tablaOrders").find("table");

            /* Inicializar datatable */
            var table = $tabla.DataTable({
                ajax: `ajax/operations.ajax.php?TablaOrders=ok&fecha1=${fecha1}&fecha2=${fecha2}`,
                processing: true,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: []
            })
                /* Cuando detecta la tabla vacia */
                .on('error.dt', function (e, settings, techNote, message) {
                    $('.spinner-border').removeClass("spinner-border float-left").html("No results found");
                    //console.log('An error has been reported by DataTables: ', message);
                });
        }
        //Ejecutar Funcion cuando cargue la pagina
        //let fechaInicio = moment().startOf("month").format("YYYY-MM-DD");
        let fechaInicio = moment().startOf("year").format("YYYY-MM-DD");
        let fechaFin = moment().endOf("month").format("YYYY-MM-DD");
        mostrarDatatableOrders(fechaInicio, fechaFin);

        // /* ===================================================
        // DATATABLE
        // ===================================================*/
        // $('.tablaOrders').DataTable({
        //     "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        // });

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
                        <option>In Process</option>
                        <option>Shipped</option>
                        <option>Delivered</option>
                        <option>Canceled</option>
                    </select>
                    `
                ,
                showCancelButton: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm!',
                cancelButtonText: 'Cancel'
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
                                    confirmButtonText: 'Ok',
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
                                    confirmButtonText: 'Ok',
                                    closeOnConfirm: false
                                })
                            }
                        }
                    });
                }
            })
        });

        /* ===================================================
          DESHABILITAR UNA ORDER('BORRARLA')
        ===================================================*/
        $(document).on("click", ".btnBorrarOrder", function () {
            var id_orders = $(this).attr("id_orders");
            Swal.fire({
                title: `Order: ${id_orders}`,
                html:
                    `
                    <p>Do you really want to <b>delete</b> this order's data?</p>
                    `
                ,
                /* text: 'Do you really want to delete this company?', */
                footer: 'You will not be able to reverse this action',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#0275d8',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sure!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    var datos = new FormData();
                    datos.append('UpdateCampo', "ok");
                    datos.append('idorder', id_orders);
                    datos.append('item', "active");
                    datos.append('value', '0');
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
                                    title: 'Order deleted successfully!',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Close',
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
                                    confirmButtonText: 'Close',
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

        /* ===================================================
            RESET SELECT CLIENT AND PRODUCT WHEN NEW ORDER MODAL IS OPENED
        ===================================================*/
        $(document).on("click", "#btnPlaceNewOrder", function () {
            $(".clientInput").val("");
            $(".productsInput").val("");
            $(".productsInput").html("");
            $(".weight").val("");
        });

        /* ===================================================
          DETECTS CHANGE ON INPUT PRODUCT TO SHOW WEIGHT FROM DB
        ===================================================*/
        $(document).on("change", ".productsInput", function () {
            $(".weight").val("");
            var idproduct = $(this).val();

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
                        $(".weight").val(response.Weight);
                    }
                }
            });
        });

    });

}